<x-app-layout>
    <x-slot name="header">Pembayaran Berhasil</x-slot>

    <div style="max-width:480px;margin:0 auto;text-align:center;">
        <div class="cd-card" style="padding:40px 32px;">
            <div style="width:72px;height:72px;background:#DCFCE7;border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 20px;">
                <svg xmlns="http://www.w3.org/2000/svg" style="width:36px;height:36px;color:#16a34a;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>

            <h2 style="font-size:22px;font-weight:800;color:var(--dark);margin-bottom:8px;">
                Pembayaran Berhasil!
            </h2>
            <p style="font-size:14px;color:var(--muted);margin-bottom:24px;">
                Akun kamu sekarang sudah aktif sebagai <strong>Premium</strong>.
                Nikmati semua fitur tanpa batas!
            </p>

            <div style="background:var(--blue-light);border-radius:12px;padding:16px;margin-bottom:24px;text-align:left;">
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;">
                    <div>
                        <div style="font-size:11px;color:var(--muted);font-weight:600;text-transform:uppercase;letter-spacing:.04em;margin-bottom:3px;">Order ID</div>
                        <div style="font-size:13px;font-weight:600;color:var(--dark);">{{ $payment->order_id }}</div>
                    </div>
                    <div>
                        <div style="font-size:11px;color:var(--muted);font-weight:600;text-transform:uppercase;letter-spacing:.04em;margin-bottom:3px;">Paket</div>
                        <div style="font-size:13px;font-weight:600;color:var(--dark);">{{ $payment->planLabel() }}</div>
                    </div>
                    <div>
                        <div style="font-size:11px;color:var(--muted);font-weight:600;text-transform:uppercase;letter-spacing:.04em;margin-bottom:3px;">Total</div>
                        <div style="font-size:13px;font-weight:600;color:var(--dark);">Rp {{ number_format($payment->amount, 0, ',', '.') }}</div>
                    </div>
                    <div>
                        <div style="font-size:11px;color:var(--muted);font-weight:600;text-transform:uppercase;letter-spacing:.04em;margin-bottom:3px;">Aktif Hingga</div>
                        <div style="font-size:13px;font-weight:600;color:var(--blue);">
                            {{ auth()->user()->subscription_expires_at?->format('d M Y') }}
                        </div>
                    </div>
                </div>
            </div>

            <a href="{{ route('dashboard') }}" class="cd-btn cd-btn-primary" style="width:100%;justify-content:center;padding:13px;">
                Mulai Gunakan Premium →
            </a>
        </div>
    </div>
</x-app-layout>