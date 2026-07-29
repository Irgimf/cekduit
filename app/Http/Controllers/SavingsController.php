<?php

namespace App\Http\Controllers;

use App\Models\SavingsGoal;
use App\Models\SavingsDeposit;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SavingsController extends Controller
{
    public function index(): View|RedirectResponse
    {
        if (auth()->user()->isFree()) {
            return redirect()->route('premium.upgrade')
                ->with('upgrade_required', 'Fitur Target Tabungan hanya tersedia untuk pengguna Premium.');
        }

        $goals    = auth()->user()->savingsGoals()
            ->withCount('deposits')
            ->orderBy('is_completed')
            ->latest()
            ->get();
        $accounts = auth()->user()->accounts;

        if (config('is_mobile')) {
            return view('mobile.savings', compact('goals', 'accounts'));
        }

        return view('savings.index', compact('goals', 'accounts'));
    }

    public function store(Request $request): RedirectResponse
    {
        if (auth()->user()->isFree()) {
            return redirect()->route('premium.upgrade')
                ->with('upgrade_required', 'Fitur Target Tabungan hanya tersedia untuk pengguna Premium.');
        }

        $request->validate([
            'name'          => ['required', 'string', 'max:100'],
            'icon'          => ['nullable', 'string', 'max:10'],
            'target_amount' => ['required', 'numeric', 'min:1000'],
            'deadline'      => ['nullable', 'date', 'after:today'],
        ]);

        auth()->user()->savingsGoals()->create([
            'name'          => $request->name,
            'icon'          => $request->icon ?: '🎯',
            'target_amount' => $request->target_amount,
            'deadline'      => $request->deadline,
        ]);

        return redirect()->route('savings.index')
            ->with('success', 'Target tabungan berhasil dibuat!');
    }

    // Setor dana ke goal
    public function deposit(Request $request, SavingsGoal $goal): RedirectResponse
    {
        abort_if($goal->user_id !== auth()->id(), 403);

        $request->validate([
            'account_id'   => ['required', 'exists:accounts,id'],
            'amount'       => ['required', 'numeric', 'min:1000'],
            'note'         => ['nullable', 'string', 'max:255'],
            'deposited_at' => ['required', 'date'],
        ]);

        $account = auth()->user()->accounts()->findOrFail($request->account_id);

        if ($account->balance < $request->amount) {
            return back()->withErrors(['amount' => 'Saldo rekening tidak cukup. Saldo: Rp ' . number_format($account->balance, 0, ',', '.')]);
        }

        // Simpan deposit
        $deposit = SavingsDeposit::create([
            'savings_goal_id' => $goal->id,
            'account_id'      => $account->id,
            'amount'          => $request->amount,
            'note'            => $request->note,
            'deposited_at'    => $request->deposited_at,
        ]);

        // Kurangi saldo rekening
        $account->decrement('balance', $request->amount);

        // Update current_amount di goal
        $newAmount = $goal->current_amount + $request->amount;
        $isCompleted = $newAmount >= $goal->target_amount;

        $goal->update([
            'current_amount' => $newAmount,
            'is_completed'   => $isCompleted,
        ]);

        $message = $isCompleted
            ? '🎉 Selamat! Target tabungan kamu sudah tercapai!'
            : 'Setoran berhasil ditambahkan.';

        return redirect()->route('savings.index')->with('success', $message);
    }

    // Hapus goal
    public function destroy(SavingsGoal $goal): RedirectResponse
    {
        abort_if($goal->user_id !== auth()->id(), 403);

        // Kembalikan dana ke rekening untuk setiap deposit
        foreach ($goal->deposits as $deposit) {
            $deposit->account->increment('balance', $deposit->amount);
        }

        $goal->delete();

        return redirect()->route('savings.index')
            ->with('success', 'Target tabungan dihapus. Dana dikembalikan ke rekening.');
    }

    // Detail goal + riwayat setoran
    public function show(SavingsGoal $goal): View
    {
        abort_if($goal->user_id !== auth()->id(), 403);

        $deposits = $goal->deposits()->with('account')->latest()->get();
        $accounts = auth()->user()->accounts;

        if (config('is_mobile')) {
            return view('mobile.savings-detail', compact('goal', 'deposits', 'accounts'));
        }

        return view('savings.show', compact('goal', 'deposits', 'accounts'));
    }
}