<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PaymentController extends Controller
{
    // Harga paket
    const PRICES = [
        'monthly' => 15000,
        'yearly'  => 120000,
    ];

    // No WA admin
    const ADMIN_WA = '6282317179877';

    /**
     * Tampilkan halaman intermediate yang otomatis membuka WhatsApp, 
     * kemudian mengarahkan user ke halaman pending.
     */
    public function createOrder(Request $request): View
    {
        $request->validate([
            'plan' => ['required', 'in:monthly,yearly'],
        ]);

        $user    = auth()->user();
        $plan    = $request->plan;
        $amount  = self::PRICES[$plan];
        $orderId = 'CEKDUIT-' . $user->id . '-' . time();

        // Simpan transaksi baru dengan status pending
        Payment::create([
            'user_id'  => $user->id,
            'order_id' => $orderId,
            'plan'     => $plan,
            'amount'   => $amount,
            'status'   => 'pending',
        ]);

        $user->update(['midtrans_order_id' => $orderId]);

        // Format pesan teks untuk WhatsApp
        $planLabel  = $plan === 'monthly' ? 'Bulanan (1 bulan)' : 'Tahunan (12 bulan)';
        $amountText = 'Rp ' . number_format($amount, 0, ',', '.');

        $waMessage = "Halo Admin CekDuit 👋\n\n"
            . "Saya ingin berlangganan *CekDuit Premium*.\n\n"
            . "📋 *Detail Pesanan:*\n"
            . "• Nama      : {$user->name}\n"
            . "• Email     : {$user->email}\n"
            . "• Paket     : Premium {$planLabel}\n"
            . "• Total     : {$amountText}\n"
            . "• Order ID  : {$orderId}\n\n"
            . "Mohon konfirmasi pembayaran dan informasi rekening/QRIS untuk transfer. Terima kasih! 🙏";

        $waUrl = 'https://wa.me/' . self::ADMIN_WA . '?text=' . rawurlencode($waMessage);

        // Melempar ke view pembantu redirect
        return view('payment.redirect-wa', compact('waUrl'));
    }

    /**
     * Halaman tunggu konfirmasi pembayaran manual oleh user
     */
    public function pending(): View
    {
        return view('payment.pending');
    }

    /**
     * Riwayat pembayaran milik user terautentikasi
     */
    public function history(): View
    {
        $payments = auth()->user()->payments()->latest()->paginate(10);
        return view('payment.history', compact('payments'));
    }

    /**
     * Admin melakukan konfirmasi pembayaran manual via dashboard admin
     */
    public function confirm(Request $request, Payment $payment): RedirectResponse
    {
        if (! auth()->user()->isAdmin()) {
            abort(403);
        }

        $request->validate([
            'plan' => ['required', 'in:monthly,yearly'],
        ]);

        $this->activatePremium($payment, $request->plan);

        return redirect()->route('admin.users.show', $payment->user)
            ->with('success', "Pembayaran {$payment->order_id} berhasil dikonfirmasi. User sekarang Premium.");
    }

    /**
     * Logic internal untuk mengaktifkan status premium & akumulasi masa aktif
     */
    private function activatePremium(Payment $payment, ?string $plan = null): void
    {
        $user = $payment->user;
        $plan = $plan ?? $payment->plan;

        $expiresAt = $plan === 'yearly'
            ? now()->addYear()
            : now()->addMonth();

        // Jika user masih memiliki masa aktif premium, akumulasikan tanggal kedaluwarsanya
        if ($user->isPremium() && $user->subscription_expires_at?->isFuture()) {
            $expiresAt = $plan === 'yearly'
                ? $user->subscription_expires_at->addYear()
                : $user->subscription_expires_at->addMonth();
        }

        $user->update([
            'role'                    => 'premium',
            'subscription_plan'       => $plan,
            'subscription_expires_at' => $expiresAt,
        ]);

        $payment->update([
            'plan'    => $plan,
            'status'  => 'success',
            'paid_at' => now(),
        ]);
    }
}