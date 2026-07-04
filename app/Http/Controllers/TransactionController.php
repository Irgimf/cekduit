<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreIncomeRequest;
use App\Http\Requests\StoreExpenseRequest;
use App\Http\Requests\UpdateIncomeRequest;
use App\Http\Requests\UpdateExpenseRequest;
use App\Models\Transaction;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class TransactionController extends Controller
{
    public function index(Request $request): View
    {
        $activeTab = $request->get('type', 'income');

        $query = auth()->user()->transactions()
            ->where('type', $activeTab)  // selalu filter
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

        $transactions = $query->latest('transaction_date')->paginate(15)->withQueryString();

        $accounts = auth()->user()->accounts;
        $incomeCategories = auth()->user()->categories()->where('type', 'income')->get();
        $expenseCategories = auth()->user()->categories()->where('type', 'expense')->get();

        return view('transactions.index', compact(
            'transactions', 'accounts', 'incomeCategories', 'expenseCategories', 'activeTab'
        ));
    }

    public function storeIncome(StoreIncomeRequest $request): RedirectResponse
    {
        DB::transaction(function () use ($request) {
            $transaction = auth()->user()->transactions()->create([
                ...$request->validated(),
                'type' => 'income',
            ]);
            $transaction->account->increment('balance', $transaction->amount);
        });

        return redirect()->route('transactions.index', ['type' => 'income'])
            ->with('success', 'Pemasukan berhasil ditambahkan.');
    }

    public function storeExpense(StoreExpenseRequest $request): RedirectResponse
    {
        DB::transaction(function () use ($request) {
            $transaction = auth()->user()->transactions()->create([
                ...$request->validated(),
                'type' => 'expense',
            ]);
            $transaction->account->decrement('balance', $transaction->amount);
        });

        return redirect()->route('transactions.index', ['type' => 'expense'])
            ->with('success', 'Pengeluaran berhasil ditambahkan.');
    }

    public function edit(Transaction $transaction): View
    {
        $this->authorize('update', $transaction);

        $accounts = auth()->user()->accounts;
        $categories = auth()->user()->categories()
            ->where('type', $transaction->type)->get();

        return view('transactions.edit', compact('transaction', 'accounts', 'categories'));
    }

    public function update(Request $request, Transaction $transaction): RedirectResponse
    {
        $this->authorize('update', $transaction);

        if ($transaction->type === 'income') {
            $formRequest = app(UpdateIncomeRequest::class);
        } else {
            $formRequest = app(UpdateExpenseRequest::class);
        }

        $validated = $request->validate($formRequest->rules());

        DB::transaction(function () use ($validated, $transaction) {
            if ($transaction->type === 'income') {
                $transaction->account->decrement('balance', $transaction->amount);
                $transaction->update($validated);
                $transaction->account()->first()->increment('balance', $transaction->amount);
            } else {
                $transaction->account->increment('balance', $transaction->amount);
                $transaction->update($validated);
                $transaction->account()->first()->decrement('balance', $transaction->amount);
            }
        });

        return redirect()->route('transactions.index', ['type' => $transaction->type])
            ->with('success', 'Transaksi berhasil diperbarui.');
    }

    public function destroy(Transaction $transaction): RedirectResponse
    {
        $this->authorize('delete', $transaction);

        DB::transaction(function () use ($transaction) {
            if ($transaction->type === 'income') {
                $transaction->account->decrement('balance', $transaction->amount);
            } else {
                $transaction->account->increment('balance', $transaction->amount);
            }
            $transaction->delete();
        });

        return redirect()->route('transactions.index', ['type' => $transaction->type])
            ->with('success', 'Transaksi berhasil dihapus.');
    }
}