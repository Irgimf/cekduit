<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAccountRequest;
use App\Http\Requests\UpdateAccountRequest;
use App\Models\Account;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AccountController extends Controller
{
    public function index(): View
    {
        $accounts = auth()->user()->accounts()->latest()->get();
        
        // Cek kondisi jika diakses via mobile
        if (config('is_mobile')) {
            return view('mobile.accounts', compact('accounts'));
        }
        
        return view('accounts.index', compact('accounts'));
    }

    public function create(): View|RedirectResponse
    {
        $user = auth()->user();

        if ($user->isFree() && $user->accounts()->count() >= \App\Models\User::FREE_MAX_ACCOUNTS) {
            return redirect()->route('accounts.index')
                ->with('upgrade_required', 'Batas rekening tercapai. Upgrade ke Premium untuk menambah lebih banyak rekening.');
        }

        if (config('is_mobile')) {
            return view('mobile.account-form');
        }
        return view('accounts.create');
    }

    public function store(StoreAccountRequest $request): RedirectResponse
    {
        $user = auth()->user();

        // Cek batas rekening untuk user free
        if ($user->isFree()) {
            $accountCount = $user->accounts()->count();
            if ($accountCount >= \App\Models\User::FREE_MAX_ACCOUNTS) {
                return redirect()->route('accounts.index')
                    ->with('upgrade_required', 'Akun gratis hanya bisa membuat ' . \App\Models\User::FREE_MAX_ACCOUNTS . ' rekening. Upgrade ke Premium untuk rekening tidak terbatas.');
            }
        }

        $user->accounts()->create(array_merge(
            $request->validated(),
            ['balance' => 0]
        ));

        return redirect()->route('accounts.index')
            ->with('success', 'Rekening berhasil ditambahkan.');
    }

    public function edit(Account $account): View
    {
        $this->authorize('update', $account);

        if (config('is_mobile')) {
            return view('mobile.account-form', compact('account'));
        }

        return view('accounts.edit', compact('account'));
    }

    public function update(UpdateAccountRequest $request, Account $account): RedirectResponse
    {
        $this->authorize('update', $account);
        $account->update($request->validated());
        // Sengaja tidak update balance di sini

        return redirect()->route('accounts.index')
            ->with('success', 'Rekening berhasil diperbarui.');
    }

    public function destroy(Account $account): RedirectResponse
    {
        $this->authorize('delete', $account);
        $account->delete();

        return redirect()->route('accounts.index')
            ->with('success', 'Rekening berhasil dihapus.');
    }
}