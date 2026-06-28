<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreExpenseRequest;
use App\Http\Requests\UpdateExpenseRequest;
use App\Models\Transaction;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class ExpenseController extends Controller
{
    public function index(Request $request): View
    {
        $query = auth()->user()->transactions()
            ->where('type', 'expense')
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

        $expenses = $query->latest('transaction_date')->paginate(10)->withQueryString();

        $accounts = auth()->user()->accounts;
        $categories = auth()->user()->categories()->where('type', 'expense')->get();

        return view('expenses.index', compact('expenses', 'accounts', 'categories'));
    }

    public function create(): View
    {
        $accounts = auth()->user()->accounts;
        $categories = auth()->user()->categories()->where('type', 'expense')->get();

        return view('expenses.create', compact('accounts', 'categories'));
    }

    public function store(StoreExpenseRequest $request): RedirectResponse
    {
        DB::transaction(function () use ($request) {
            $transaction = auth()->user()->transactions()->create([
                ...$request->validated(),
                'type' => 'expense',
            ]);

            $transaction->account->decrement('balance', $transaction->amount);
        });

        return redirect()->route('expenses.index')
            ->with('success', 'Pengeluaran berhasil ditambahkan.');
    }

    public function edit(Transaction $expense): View
    {
        $this->authorize('update', $expense);

        $accounts = auth()->user()->accounts;
        $categories = auth()->user()->categories()->where('type', 'expense')->get();

        return view('expenses.edit', ['expense' => $expense, 'accounts' => $accounts, 'categories' => $categories]);
    }

    public function update(UpdateExpenseRequest $request, Transaction $expense): RedirectResponse
    {
        $this->authorize('update', $expense);

        DB::transaction(function () use ($request, $expense) {
            // Kembalikan saldo lama dulu (tambahkan balik karena sebelumnya dikurangi)
            $expense->account->increment('balance', $expense->amount);

            $expense->update($request->validated());

            $expense->account()->first()->decrement('balance', $expense->amount);
        });

        return redirect()->route('expenses.index')
            ->with('success', 'Pengeluaran berhasil diperbarui.');
    }

    public function destroy(Transaction $expense): RedirectResponse
    {
        $this->authorize('delete', $expense);

        DB::transaction(function () use ($expense) {
            $expense->account->increment('balance', $expense->amount);
            $expense->delete();
        });

        return redirect()->route('expenses.index')
            ->with('success', 'Pengeluaran berhasil dihapus.');
    }
}