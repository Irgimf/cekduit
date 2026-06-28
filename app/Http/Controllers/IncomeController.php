<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreIncomeRequest;
use App\Http\Requests\UpdateIncomeRequest;
use App\Models\Transaction;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class IncomeController extends Controller
{
    public function index(Request $request): View
    {
        $query = auth()->user()->transactions()
            ->where('type', 'income')
            ->with(['account', 'category']);

        if ($request->filled('search')) {
            $query->where('description', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('account_id')) {
            $query->where('account_id', $request->account_id);
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->filled('from_date')) {
            $query->whereDate('transaction_date', '>=', $request->from_date);
        }

        if ($request->filled('to_date')) {
            $query->whereDate('transaction_date', '<=', $request->to_date);
        }

        $incomes = $query->latest('transaction_date')->paginate(10)->withQueryString();

        $accounts = auth()->user()->accounts;
        $categories = auth()->user()->categories()->where('type', 'income')->get();

        return view('incomes.index', compact('incomes', 'accounts', 'categories'));
    }

    public function create(): View
    {
        $accounts = auth()->user()->accounts;
        $categories = auth()->user()->categories()->where('type', 'income')->get();

        return view('incomes.create', compact('accounts', 'categories'));
    }

    public function store(StoreIncomeRequest $request): RedirectResponse
    {
        DB::transaction(function () use ($request) {
            $transaction = auth()->user()->transactions()->create([
                ...$request->validated(),
                'type' => 'income',
            ]);

            $transaction->account->increment('balance', $transaction->amount);
        });

        return redirect()->route('incomes.index')
            ->with('success', 'Pemasukan berhasil ditambahkan.');
    }

    public function edit(Transaction $income): View
    {
        $this->authorize('update', $income);

        $accounts = auth()->user()->accounts;
        $categories = auth()->user()->categories()->where('type', 'income')->get();

        return view('incomes.edit', ['income' => $income, 'accounts' => $accounts, 'categories' => $categories]);
    }

    public function update(UpdateIncomeRequest $request, Transaction $income): RedirectResponse
    {
        $this->authorize('update', $income);

        DB::transaction(function () use ($request, $income) {
            // Kembalikan saldo lama dulu sebelum apply yang baru
            $income->account->decrement('balance', $income->amount);

            $income->update($request->validated());

            $income->account()->first()->increment('balance', $income->amount);
        });

        return redirect()->route('incomes.index')
            ->with('success', 'Pemasukan berhasil diperbarui.');
    }

    public function destroy(Transaction $income): RedirectResponse
    {
        $this->authorize('delete', $income);

        DB::transaction(function () use ($income) {
            $income->account->decrement('balance', $income->amount);
            $income->delete();
        });

        return redirect()->route('incomes.index')
            ->with('success', 'Pemasukan berhasil dihapus.');
    }
}