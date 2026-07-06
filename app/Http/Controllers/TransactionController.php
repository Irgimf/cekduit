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
            ->where('is_transfer', false)   // ← tambahkan ini
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
            ->where('is_transfer', false)
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

        if (config('is_mobile')) {
            return view('mobile.transactions', compact(
                'transactions', 'accounts', 'incomeCategories',
                'expenseCategories', 'activeTab', 'summary'
            ));
        }
        return view('transactions.index', compact(
            'transactions', 'accounts', 'incomeCategories',
            'expenseCategories', 'activeTab', 'summary'
        ));
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
        public function storeTransfer(Request $request): RedirectResponse
    {
        $request->validate([
            'from_account_id' => ['required', 'exists:accounts,id'],
            'to_account_id'   => ['required', 'exists:accounts,id', 'different:from_account_id'],
            'amount'          => ['required', 'numeric', 'min:0.01'],
            'transaction_date'=> ['required', 'date'],
            'description'     => ['nullable', 'string', 'max:255'],
        ]);

        $fromAccount = auth()->user()->accounts()->findOrFail($request->from_account_id);
        $toAccount   = auth()->user()->accounts()->findOrFail($request->to_account_id);

        if ($fromAccount->balance < $request->amount) {
            return back()->withErrors(['amount' => 'Saldo rekening asal tidak cukup. Saldo: Rp ' . number_format($fromAccount->balance, 0, ',', '.')])->withInput();
        }

        // Cari atau buat kategori "Transfer" otomatis
        $transferCategory = auth()->user()->categories()->firstOrCreate(
            ['name' => 'Transfer', 'type' => 'expense'],
            ['name' => 'Transfer', 'type' => 'expense']
        );

        DB::transaction(function () use ($request, $fromAccount, $toAccount, $transferCategory) {
            // Catat sebagai pengeluaran dari rekening asal
            auth()->user()->transactions()->create([
                'account_id'       => $fromAccount->id,
                'to_account_id'    => $toAccount->id,
                'category_id'      => $transferCategory->id,
                'type'             => 'expense',
                'is_transfer'      => true,
                'amount'           => $request->amount,
                'description'      => $request->description ?: 'Transfer ke ' . $toAccount->name,
                'transaction_date' => $request->transaction_date,
            ]);

            // Catat sebagai pemasukan ke rekening tujuan
            $incomeCategory = auth()->user()->categories()->firstOrCreate(
                ['name' => 'Transfer', 'type' => 'income'],
                ['name' => 'Transfer', 'type' => 'income']
            );

            auth()->user()->transactions()->create([
                'account_id'       => $toAccount->id,
                'to_account_id'    => $fromAccount->id,
                'category_id'      => $incomeCategory->id,
                'type'             => 'income',
                'is_transfer'      => true,
                'amount'           => $request->amount,
                'description'      => $request->description ?: 'Transfer dari ' . $fromAccount->name,
                'transaction_date' => $request->transaction_date,
            ]);

            $fromAccount->decrement('balance', $request->amount);
            $toAccount->increment('balance', $request->amount);
        });

        return redirect()->route('transactions.index', ['type' => 'expense'])
            ->with('success', 'Transfer berhasil dari ' . $fromAccount->name . ' ke ' . $toAccount->name . '.');
    }
}