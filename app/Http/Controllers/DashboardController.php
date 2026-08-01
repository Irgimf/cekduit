<?php

namespace App\Http\Controllers;

use Illuminate\Support\Carbon;
use Illuminate\View\View;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{
    public function index(): View
    {
        $user = auth()->user();

        // Total saldo tetap dari rekening
        $totalBalance = $user->accounts()->sum('balance');

        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth   = Carbon::now()->endOfMonth();

        // Exclude transfer dari pemasukan/pengeluaran bulan ini
        $monthlyIncome = $user->transactions()
            ->where('type', 'income')
            ->where('is_transfer', false)
            ->whereBetween('transaction_date', [$startOfMonth, $endOfMonth])
            ->sum('amount');

        $monthlyExpense = $user->transactions()
            ->where('type', 'expense')
            ->where('is_transfer', false)
            ->whereBetween('transaction_date', [$startOfMonth, $endOfMonth])
            ->sum('amount');

        // Transaksi terbaru (exclude transfer)
        $recentTransactions = $user->transactions()
            ->where('is_transfer', false)
            ->with(['account', 'category'])
            ->latest('transaction_date')
            ->take(5)
            ->get();

        // Grafik tren 6 bulan (exclude transfer)
        $chartLabels  = [];
        $chartIncome  = [];
        $chartExpense = [];

        for ($i = 5; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $chartLabels[] = $month->translatedFormat('M Y');

            $chartIncome[] = (float) $user->transactions()
                ->where('type', 'income')
                ->where('is_transfer', false)
                ->whereYear('transaction_date', $month->year)
                ->whereMonth('transaction_date', $month->month)
                ->sum('amount');

            $chartExpense[] = (float) $user->transactions()
                ->where('type', 'expense')
                ->where('is_transfer', false)
                ->whereYear('transaction_date', $month->year)
                ->whereMonth('transaction_date', $month->month)
                ->sum('amount');
        }

        // Pie chart pengeluaran per kategori (exclude transfer)
        $expenseByCategory = $user->transactions()
            ->where('type', 'expense')
            ->where('is_transfer', false)
            ->whereBetween('transaction_date', [$startOfMonth, $endOfMonth])
            ->with('category')
            ->get()
            ->groupBy('category.name')
            ->map(fn ($items) => $items->sum('amount'));

        // Data tambahan untuk kebutuhan view mobile
        $accounts          = $user->accounts()->get();
        $incomeCategories  = $user->categories()->where('type', 'income')->get();
        $expenseCategories = $user->categories()->where('type', 'expense')->get();

        // --- FIX DEFENSIVE: BUDGET WARNINGS ---
        $budgetWarnings = collect();
        if ($user->isPremium() && method_exists($user, 'budgets')) {
            try {
                $budgetWarnings = $user->budgets()->with('category')->get()
                    ->filter(fn($b) => in_array($b->status(), ['warning', 'exceeded']))
                    ->map(fn($b) => [
                        'name'    => $b->category->name ?? 'Tanpa Kategori',
                        'status'  => $b->status(),
                        'spent'   => $b->spentThisMonth(),
                        'amount'  => (float) $b->amount,
                        'percent' => $b->spentPercent(),
                    ])->values();
            } catch (\Exception $e) {
                Log::error('Gagal mengambil data budget di Dashboard: ' . $e->getMessage());
                $budgetWarnings = collect();
            }
        }

        // --- FIX DEFENSIVE: SAVINGS WIDGET ---
        $activeSavings = collect();
        if ($user->isPremium() && method_exists($user, 'savingsGoals')) {
            try {
                $activeSavings = $user->savingsGoals()
                    ->where('is_completed', false)
                    ->latest()
                    ->take(3)
                    ->get();
            } catch (\Exception $e) {
                Log::error('Gagal mengambil data savings goals di Dashboard: ' . $e->getMessage());
                $activeSavings = collect();
            }
        }

        // Konversi ke array untuk menjaga kompatibilitas struktur lama di view mobile
        $budgetWarningsArray = $budgetWarnings->toArray();

        // Return untuk Mobile View
        if (config('is_mobile')) {
            return view('mobile.dashboard', [
                'totalBalance'       => $totalBalance,
                'monthlyIncome'      => $monthlyIncome,
                'monthlyExpense'     => $monthlyExpense,
                'recentTransactions' => $recentTransactions,
                'accounts'           => $accounts,
                'incomeCategories'   => $incomeCategories,
                'expenseCategories'  => $expenseCategories,
                'budgetWarnings'     => $budgetWarningsArray,
                'activeSavings'      => $activeSavings,
            ]);
        }

        // Return untuk Desktop View
        return view('dashboard', [
            'totalBalance'          => $totalBalance,
            'monthlyIncome'         => $monthlyIncome,
            'monthlyExpense'        => $monthlyExpense,
            'recentTransactions'    => $recentTransactions,
            'chartLabels'           => $chartLabels,
            'chartIncome'           => $chartIncome,
            'chartExpense'          => $chartExpense,
            'expenseCategoryLabels' => $expenseByCategory->keys(),
            'expenseCategoryData'   => $expenseByCategory->values(),
            'budgetWarnings'        => $budgetWarningsArray,
            'activeSavings'         => $activeSavings,
        ]);
    }
}