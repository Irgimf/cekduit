<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Transaction;
use Illuminate\Support\Carbon;
use Illuminate\View\View;

class AdminController extends Controller
{
    public function dashboard(): View
    {
        $totalUsers     = User::count();
        $premiumUsers   = User::where('role', 'premium')
                              ->where('subscription_expires_at', '>', now())
                              ->count();
        $freeUsers      = $totalUsers - $premiumUsers - User::where('role', 'admin')->count();
        $newUsersToday  = User::whereDate('created_at', today())->count();
        $newUsersMonth  = User::whereMonth('created_at', now()->month)
                              ->whereYear('created_at', now()->year)
                              ->count();

        $totalTransactions = Transaction::count();
        $transactionsMonth = Transaction::whereMonth('transaction_date', now()->month)
                                        ->whereYear('transaction_date', now()->year)
                                        ->count();

        // Grafik user baru per bulan (6 bulan terakhir)
        $userGrowth = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $userGrowth[] = [
                'label' => $month->translatedFormat('M Y'),
                'count' => User::whereYear('created_at', $month->year)
                               ->whereMonth('created_at', $month->month)
                               ->count(),
            ];
        }

        // User terbaru
        $recentUsers = User::latest()->take(8)->get();

        return view('admin.dashboard', compact(
            'totalUsers', 'premiumUsers', 'freeUsers',
            'newUsersToday', 'newUsersMonth',
            'totalTransactions', 'transactionsMonth',
            'userGrowth', 'recentUsers'
        ));
    }
}