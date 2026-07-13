<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UserController extends Controller
{
    public function index(Request $request): View
    {
        $query = User::query();

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        if ($request->filled('plan')) {
            $query->where('subscription_plan', $request->plan);
        }

        $users = $query->latest()->paginate(15)->withQueryString();

        return view('admin.users.index', compact('users'));
    }

    public function show(User $user): View
    {
        $transactionCount = $user->transactions()->count();
        $accountCount     = $user->accounts()->count();
        $categoryCount    = $user->categories()->count();
        $totalIncome      = $user->transactions()->where('type', 'income')->where('is_transfer', false)->sum('amount');
        $totalExpense     = $user->transactions()->where('type', 'expense')->where('is_transfer', false)->sum('amount');

        return view('admin.users.show', compact(
            'user', 'transactionCount', 'accountCount',
            'categoryCount', 'totalIncome', 'totalExpense'
        ));
    }

    public function updateRole(Request $request, User $user): RedirectResponse
    {
        // Admin tidak bisa ubah role dirinya sendiri
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Kamu tidak bisa mengubah role akunmu sendiri.');
        }

        $request->validate([
            'role' => ['required', 'in:user,premium,admin'],
            'subscription_plan'       => ['nullable', 'in:free,monthly,yearly'],
            'subscription_expires_at' => ['nullable', 'date'],
        ]);

        $data = ['role' => $request->role];

        if ($request->role === 'premium') {
            $data['subscription_plan']       = $request->subscription_plan ?? 'monthly';
            $data['subscription_expires_at'] = $request->subscription_expires_at
                ?? now()->addMonth()->toDateTimeString();
        } elseif ($request->role === 'user') {
            $data['subscription_plan']       = 'free';
            $data['subscription_expires_at'] = null;
        }

        $user->update($data);

        return back()->with('success', "Role user {$user->name} berhasil diubah menjadi {$request->role}.");
    }

    public function destroy(User $user): RedirectResponse
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Kamu tidak bisa menghapus akunmu sendiri.');
        }

        $name = $user->name;
        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', "Akun {$name} berhasil dihapus.");
    }
}