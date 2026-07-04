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
        $now = now();

        // Period filter
        $period = $request->get('period', 'this_month');
        $query = auth()->user()->transactions()
            ->where('type', $activeTab)
            ->with(['account', 'category']);

        match($period) {
            'last_month' => $query->whereYear('transaction_date', $now->copy()->subMonth()->year)
                                ->whereMonth('transaction_date', $now->copy()->subMonth()->month),
            'this_year'  => $query->whereYear('transaction_date', $now->year),
            'all'        => $query,
            default      => $query->whereYear('transaction_date', $now->year)
                                ->whereMonth('transaction_date', $now->month),
        };

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // Sort
        $sort = $request->get('sort', 'latest');
        match($sort) {
            'oldest'  => $query->oldest('transaction_date'),
            'highest' => $query->orderByDesc('amount'),
            'lowest'  => $query->orderBy('amount'),
            default   => $query->latest('transaction_date'),
        };

        $transactions = $query->paginate(5)->withQueryString();

        // Summary stats (bulan ini selalu)
        $summaryQuery = auth()->user()->transactions()
            ->where('type', $activeTab)
            ->whereYear('transaction_date', $now->year)
            ->whereMonth('transaction_date', $now->month);

        $totalThisMonth = (clone $summaryQuery)->sum('amount');

        $highestTx = (clone $summaryQuery)->with('category')->orderByDesc('amount')->first();

        $daysInLast30 = 30;
        $dailyAvg = auth()->user()->transactions()
            ->where('type', $activeTab)
            ->where('transaction_date', '>=', $now->copy()->subDays(30))
            ->sum('amount') / $daysInLast30;

        $summary = [
            'total'             => $totalThisMonth,
            'highest'           => $highestTx?->amount ?? 0,
            'highest_category'  => $highestTx?->category?->name,
            'daily_avg'         => $dailyAvg,
        ];

        $accounts          = auth()->user()->accounts;
        $incomeCategories  = auth()->user()->categories()->where('type', 'income')->get();
        $expenseCategories = auth()->user()->categories()->where('type', 'expense')->get();

        return view('transactions.index', compact(
            'transactions', 'accounts', 'incomeCategories', 'expenseCategories', 'activeTab', 'summary'
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