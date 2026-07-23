<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PaymentAdminController extends Controller
{
    public function index(Request $request): View
    {
        $query = Payment::with('user')->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('order_id', 'like', '%' . $request->search . '%')
                  ->orWhereHas('user', fn($u) =>
                      $u->where('name', 'like', '%' . $request->search . '%')
                        ->orWhere('email', 'like', '%' . $request->search . '%')
                  );
            });
        }

        $payments = $query->paginate(20)->withQueryString();

        return view('admin.payments', compact('payments'));
    }

    public function destroy(Payment $payment): RedirectResponse
    {
        $orderId = $payment->order_id;
        $payment->delete();

        return back()->with('success', "Order {$orderId} berhasil dihapus.");
    }
}