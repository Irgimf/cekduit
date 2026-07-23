<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\PremiumController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\PaymentAdminController;
use Illuminate\Support\Facades\Route;

// Landing Page
Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('dashboard');
    }
    return view('landing');
})->name('landing');

// Dashboard User
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Rute Pengguna Terautentikasi (General Auth)
Route::middleware('auth')->group(function () {
    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/profile/avatar', [ProfileController::class, 'updateAvatar'])->name('profile.avatar');
    
    // Resources Management
    Route::resource('accounts', AccountController::class)->except('show');
    Route::resource('categories', CategoryController::class)->except('show');
    
    // Transactions
    Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions.index');
    Route::post('/transactions/income', [TransactionController::class, 'storeIncome'])->name('transactions.store-income');
    Route::post('/transactions/expense', [TransactionController::class, 'storeExpense'])->name('transactions.store-expense');
    Route::post('/transactions/transfer', [TransactionController::class, 'storeTransfer'])->name('transactions.transfer');
    Route::get('/transactions/{transaction}/edit', [TransactionController::class, 'edit'])->name('transactions.edit');
    Route::put('/transactions/{transaction}', [TransactionController::class, 'update'])->name('transactions.update');
    Route::delete('/transactions/{transaction}', [TransactionController::class, 'destroy'])->name('transactions.destroy');
    
    // Reports
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/export-pdf', [ReportController::class, 'exportPdf'])->name('reports.export-pdf');
    Route::get('/reports/export-excel', [ReportController::class, 'exportExcel'])->name('reports.export-excel');
    
    // Premium Landing
    Route::get('/premium/upgrade', [PremiumController::class, 'upgrade'])->name('premium.upgrade');
    
    // Rute Pembayaran Baru (User)
    Route::get('/payment/history', [\App\Http\Controllers\PaymentController::class, 'index'])
         ->name('payment.history');
    Route::post('/payment/order', [\App\Http\Controllers\PaymentController::class, 'createOrder'])
         ->name('payment.order');
    Route::get('/payment/pending', [\App\Http\Controllers\PaymentController::class, 'pending'])
         ->name('payment.pending');
});

// Rute Khusus Admin
Route::prefix('admin')
    ->middleware(['auth', 'admin'])
    ->name('admin.')
    ->group(function () {
        Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');

        // User management
        Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
        Route::get('/users/{user}', [AdminUserController::class, 'show'])->name('users.show');
        Route::patch('/users/{user}/role', [AdminUserController::class, 'updateRole'])->name('users.update-role');
        Route::delete('/users/{user}', [AdminUserController::class, 'destroy'])->name('users.destroy');

        // Payment management
        Route::get('/payments', [PaymentAdminController::class, 'index'])->name('payments');
        Route::delete('/payments/{payment}', [PaymentAdminController::class, 'destroy'])->name('payments.destroy');
    });

// Konfirmasi pembayaran (dari PaymentController, bukan admin namespace)
Route::patch('/payment/{payment}/confirm', [\App\Http\Controllers\PaymentController::class, 'confirm'])
    ->middleware(['auth', 'admin'])
    ->name('payment.confirm');

require __DIR__.'/auth.php';