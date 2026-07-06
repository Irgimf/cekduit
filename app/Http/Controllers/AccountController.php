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

    public function create(): View
    {
        return view('accounts.create');
    }

    public function store(StoreAccountRequest $request): RedirectResponse
    {
        auth()->user()->accounts()->create(array_merge(
            $request->validated(),
            ['balance' => 0] // saldo awal selalu 0
        ));

        return redirect()->route('accounts.index')
            ->with('success', 'Rekening berhasil ditambahkan.');
    }

    public function edit(Account $account): View
    {
        $this->authorize('update', $account);
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