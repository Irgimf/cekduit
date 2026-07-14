<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\Notification;

class PaymentController extends Controller
{
    public function __construct()
    {
        // Konfigurasi Midtrans
        Config::$serverKey    = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized  = true;
        Config::$is3ds        = true;
    }

    // Halaman riwayat pembayaran user
    public function index(): View
    {
        $payments = auth()->user()->payments()->latest()->paginate(10);
        return view('payment.history', compact('payments'));
    }

    // Proses buat transaksi baru → dapat Snap Token
    public function createTransaction(Request $request): JsonResponse
    {
        $request->validate([
            'plan' => ['required', 'in:monthly,yearly'],
        ]);

        $user   = auth()->user();
        $plan   = $request->plan;
        $amount = config("midtrans.prices.{$plan}");

        // Buat order ID unik
        $orderId = 'CEKDUIT-' . strtoupper($user->id) . '-' . time();

        // Simpan payment dengan status pending
        $payment = Payment::create([
            'user_id'  => $user->id,
            'order_id' => $orderId,
            'plan'     => $plan,
            'amount'   => $amount,
            'status'   => 'pending',
        ]);

        // Update user dengan order ID terbaru
        $user->update(['midtrans_order_id' => $orderId]);

        // Parameter untuk Midtrans Snap
        $params = [
            'transaction_details' => [
                'order_id'     => $orderId,
                'gross_amount' => $amount,
            ],
            'customer_details' => [
                'first_name' => $user->name,
                'email'      => $user->email,
            ],
            'item_details' => [
                [
                    'id'       => "PREMIUM-{$plan}",
                    'price'    => $amount,
                    'quantity' => 1,
                    'name'     => 'CekDuit Premium ' . ($plan === 'monthly' ? 'Bulanan' : 'Tahunan'),
                ],
            ],
            'callbacks' => [
                'finish' => route('payment.finish'),
            ],
        ];

        try {
            $snapToken = Snap::getSnapToken($params);
            return response()->json([
                'snap_token' => $snapToken,
                'order_id'   => $orderId,
            ]);
        } catch (\Exception $e) {
            $payment->update(['status' => 'failed']);
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    // Halaman setelah payment selesai (redirect dari Midtrans)
    public function finish(Request $request): View|RedirectResponse
    {
        $orderId           = $request->order_id;
        $transactionStatus = $request->transaction_status;

        $payment = Payment::where('order_id', $orderId)->first();

        if ($payment && in_array($transactionStatus, ['capture', 'settlement'])) {
            $this->activatePremium($payment);
            return view('payment.success', compact('payment'));
        }

        return redirect()->route('premium.upgrade')
            ->with('warning', 'Pembayaran belum selesai atau dibatalkan. Silakan coba lagi.');
    }

    // Webhook dari Midtrans — update status otomatis
    public function webhook(Request $request): JsonResponse
    {
        try {
            $notification = new Notification();

            $orderId           = $notification->order_id;
            $transactionStatus = $notification->transaction_status;
            $fraudStatus       = $notification->fraud_status;
            $paymentType       = $notification->payment_type;
            $transactionId     = $notification->transaction_id;

            $payment = Payment::where('order_id', $orderId)->first();

            if (! $payment) {
                return response()->json(['status' => 'order not found'], 404);
            }

            // Tentukan status berdasarkan response Midtrans
            if ($transactionStatus === 'capture') {
                $status = $fraudStatus === 'challenge' ? 'pending' : 'success';
            } elseif ($transactionStatus === 'settlement') {
                $status = 'success';
            } elseif (in_array($transactionStatus, ['cancel', 'deny', 'expire'])) {
                $status = $transactionStatus === 'expire' ? 'expired' : 'failed';
            } elseif ($transactionStatus === 'pending') {
                $status = 'pending';
            } else {
                $status = 'pending';
            }

            $payment->update([
                'status'         => $status,
                'payment_type'   => $paymentType,
                'transaction_id' => $transactionId,
                'paid_at'        => $status === 'success' ? now() : null,
            ]);

            // Kalau sukses, aktifkan premium
            if ($status === 'success') {
                $this->activatePremium($payment);
            }

            return response()->json(['status' => 'ok']);

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    // Helper: aktifkan premium user
    private function activatePremium(Payment $payment): void
    {
        $user = $payment->user;

        // Hitung tanggal expired
        $expiresAt = $payment->plan === 'yearly'
            ? now()->addYear()
            : now()->addMonth();

        // Kalau user sudah premium dan belum expired, extend dari tanggal yang ada
        if ($user->isPremium() && $user->subscription_expires_at?->isFuture()) {
            $expiresAt = $payment->plan === 'yearly'
                ? $user->subscription_expires_at->addYear()
                : $user->subscription_expires_at->addMonth();
        }

        $user->update([
            'role'                    => 'premium',
            'subscription_plan'       => $payment->plan,
            'subscription_expires_at' => $expiresAt,
        ]);

        $payment->update([
            'status'  => 'success',
            'paid_at' => now(),
        ]);
    }
}