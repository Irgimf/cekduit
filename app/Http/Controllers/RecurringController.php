<?php

namespace App\Http\Controllers;

use App\Models\RecurringTransaction;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\View\View;

class RecurringController extends Controller
{
    public function index(): View|RedirectResponse
    {
        if (auth()->user()->isFree()) {
            return redirect()->route('premium.upgrade')
                ->with('upgrade_required', 'Fitur Transaksi Berulang hanya tersedia untuk pengguna Premium.');
        }

        $user      = auth()->user();
        $recurrings = $user->recurringTransactions()
            ->with(['account', 'category'])
            ->orderBy('next_run_at')
            ->get();

        $accounts          = $user->accounts;
        $incomeCategories  = $user->categories()->where('type', 'income')->get();
        $expenseCategories = $user->categories()->where('type', 'expense')->get();

        if (config('is_mobile')) {
            return view('mobile.recurring', compact(
                'recurrings', 'accounts', 'incomeCategories', 'expenseCategories'
            ));
        }

        return view('recurring.index', compact(
            'recurrings', 'accounts', 'incomeCategories', 'expenseCategories'
        ));
    }

    public function store(Request $request): RedirectResponse
    {
        if (auth()->user()->isFree()) {
            return redirect()->route('premium.upgrade')
                ->with('upgrade_required', 'Fitur Transaksi Berulang hanya tersedia untuk pengguna Premium.');
        }

        $data = $request->validate([
            'account_id'   => ['required', 'exists:accounts,id'],
            'category_id'  => ['required', 'exists:categories,id'],
            'type'         => ['required', 'in:income,expense'],
            'amount'       => ['required', 'numeric', 'min:1'],
            'description'  => ['nullable', 'string', 'max:255'],
            'frequency'    => ['required', 'in:daily,weekly,monthly'],
            'day_of_month' => ['nullable', 'integer', 'min:1', 'max:28'],
            'start_date'   => ['required', 'date'],
            'end_date'     => ['nullable', 'date', 'after:start_date'],
        ]);

        // Hitung next_run_at pertama
        $startDate   = Carbon::parse($data['start_date']);
        $data['next_run_at']  = $startDate->toDateString();
        $data['user_id']      = auth()->id();

        if ($data['frequency'] === 'monthly') {
            $data['day_of_month'] = $startDate->day;
        }

        auth()->user()->recurringTransactions()->create($data);

        return redirect()->route('recurring.index')
            ->with('success', 'Transaksi berulang berhasil ditambahkan.');
    }

    public function toggle(RecurringTransaction $recurring): RedirectResponse
    {
        abort_if($recurring->user_id !== auth()->id(), 403);

        $recurring->update(['is_active' => ! $recurring->is_active]);

        return back()->with('success',
            $recurring->is_active ? 'Transaksi berulang diaktifkan.' : 'Transaksi berulang dijeda.');
    }

    public function destroy(RecurringTransaction $recurring): RedirectResponse
    {
        abort_if($recurring->user_id !== auth()->id(), 403);

        $recurring->delete();

        return back()->with('success', 'Transaksi berulang dihapus.');
    }
}