<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OnboardingController extends Controller
{
    // Step yang tersedia
    const STEPS = ['welcome', 'account', 'category', 'transaction', 'done'];

    public function index(): View|RedirectResponse
    {
        if (auth()->user()->onboarding_completed) {
            return redirect()->route('dashboard');
        }

        return view('onboarding.index');
    }

    // Step 1: Selesai welcome, lanjut ke buat rekening
    public function storeAccount(Request $request): RedirectResponse
    {
        $request->validate([
            'name'           => ['required', 'string', 'max:100'],
            'type'           => ['required', 'in:cash,bank,e_wallet'],
            'account_number' => ['nullable', 'string', 'max:30'],
            'admin_fee'      => ['nullable', 'numeric', 'min:0'],
        ]);

        auth()->user()->accounts()->create([
            'name'           => $request->name,
            'type'           => $request->type,
            'account_number' => $request->account_number,
            'admin_fee'      => $request->admin_fee ?? 0,
            'balance'        => 0,
        ]);

        return redirect()->route('onboarding.step', 'category');
    }

    // Step 2: Simpan beberapa kategori default
    public function storeCategories(Request $request): RedirectResponse
    {
        $user = auth()->user();

        // Tambahkan kategori yang dipilih user
        $incomeCategories  = $request->income_categories  ?? [];
        $expenseCategories = $request->expense_categories ?? [];

        foreach ($incomeCategories as $name) {
            if (trim($name)) {
                $user->categories()->firstOrCreate(
                    ['name' => trim($name), 'type' => 'income'],
                );
            }
        }

        foreach ($expenseCategories as $name) {
            if (trim($name)) {
                $user->categories()->firstOrCreate(
                    ['name' => trim($name), 'type' => 'expense'],
                );
            }
        }

        return redirect()->route('onboarding.step', 'transaction');
    }

    // Step 3: Catat transaksi pertama (opsional — bisa skip)
    public function storeTransaction(Request $request): RedirectResponse
    {
        if ($request->filled('amount') && $request->filled('account_id')) {
            $request->validate([
                'account_id'       => ['required', 'exists:accounts,id'],
                'category_id'      => ['required', 'exists:categories,id'],
                'type'             => ['required', 'in:income,expense'],
                'amount'           => ['required', 'numeric', 'min:1'],
                'transaction_date' => ['required', 'date'],
                'description'      => ['nullable', 'string', 'max:255'],
            ]);

            $account = auth()->user()->accounts()->findOrFail($request->account_id);

            auth()->user()->transactions()->create([
                'account_id'       => $account->id,
                'category_id'      => $request->category_id,
                'type'             => $request->type,
                'amount'           => $request->amount,
                'description'      => $request->description,
                'transaction_date' => $request->transaction_date,
                'is_transfer'      => false,
            ]);

            // Update saldo
            if ($request->type === 'income') {
                $account->increment('balance', $request->amount);
            } else {
                $account->decrement('balance', $request->amount);
            }
        }

        return redirect()->route('onboarding.step', 'done');
    }

    // Tampilkan step tertentu
    public function step(string $step): View|RedirectResponse
    {
        if (! in_array($step, self::STEPS)) {
            return redirect()->route('onboarding.index');
        }

        if (auth()->user()->onboarding_completed) {
            return redirect()->route('dashboard');
        }

        $user      = auth()->user();
        $accounts  = $user->accounts;
        $incomeCategories  = $user->categories()->where('type', 'income')->get();
        $expenseCategories = $user->categories()->where('type', 'expense')->get();

        return view("onboarding.{$step}", compact(
            'user', 'accounts', 'incomeCategories', 'expenseCategories'
        ));
    }

    // Selesaikan onboarding
    public function complete(): RedirectResponse
    {
        auth()->user()->update(['onboarding_completed' => true]);

        return redirect()->route('dashboard')
            ->with('success', '🎉 Selamat datang di CekDuit! Akun kamu sudah siap digunakan.');
    }

    // Skip onboarding
    public function skip(): RedirectResponse
    {
        auth()->user()->update(['onboarding_completed' => true]);

        return redirect()->route('dashboard');
    }
}