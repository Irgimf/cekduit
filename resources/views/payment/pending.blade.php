<x-app-layout>
    <x-slot name="header">Menunggu Konfirmasi</x-slot>

    <div style="max-width:480px;margin:0 auto;">
        <div class="cd-card" style="padding:40px 32px;text-align:center;">

            {{-- Animasi loading --}}
            <div style="width:72px;height:72px;background:#E8F0FB;border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 20px;animation:pulse 2s infinite;">
                <svg xmlns="http://www.w3.org/2000/svg" style="width:36px;height:36px;color:#014BAA;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>

            <h2 style="font-size:22px;font-weight:800;color:var(--dark);margin-bottom:10px;">
                Mohon Tunggu Konfirmasi Admin
            </h2>

            <p style="font-size:14px;color:var(--muted);line-height:1.7;margin-bottom:24px;">
                Pesanan kamu sudah kami terima melalui WhatsApp.<br>
                Admin akan membalas dan mengirimkan informasi pembayaran <strong>dalam waktu 1×24 jam</strong>.
            </p>

            <div style="background:#F8F3F0;border-radius:12px;padding:16px;margin-bottom:24px;text-align:left;">
                <div style="font-size:13px;font-weight:600;color:var(--dark);margin-bottom:10px;">Yang perlu kamu lakukan:</div>
                <div style="display:flex;flex-direction:column;gap:8px;">
                    <div style="display:flex;align-items:flex-start;gap:10px;font-size:13px;color:var(--muted);">
                        <span style="width:22px;height:22px;background:#014BAA;color:#fff;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:700;flex-shrink:0;">1</span>
                        Tunggu balasan WhatsApp dari admin CekDuit
                    </div>
                    <div style="display:flex;align-items:flex-start;gap:10px;font-size:13px;color:var(--muted);">
                        <span style="width:22px;height:22px;background:#014BAA;color:#fff;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:700;flex-shrink:0;">2</span>
                        Lakukan pembayaran sesuai instruksi yang dikirim admin
                    </div>
                    <div style="display:flex;align-items:flex-start;gap:10px;font-size:13px;color:var(--muted);">
                        <span style="width:22px;height:22px;background:#014BAA;color:#fff;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:700;flex-shrink:0;">3</span>
                        Kirim bukti transfer ke WhatsApp admin
                    </div>
                    <div style="display:flex;align-items:flex-start;gap:10px;font-size:13px;color:var(--muted);">
                        <span style="width:22px;height:22px;background:#22C55E;color:#fff;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:700;flex-shrink:0;">✓</span>
                        Akun Premium kamu akan aktif dalam hitungan menit
                    </div>
                </div>
            </div>

            <div style="display:flex;flex-direction:column;gap:10px;">
                <a href="https://wa.me/6282317179877"
                   target="_blank"
                   class="cd-btn"
                   style="background:#25D366;color:#fff;width:100%;justify-content:center;padding:13px;">
                    <svg xmlns="http://www.w3.org/2000/svg" style="width:18px;height:18px;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                    </svg>
                    Chat Admin WhatsApp
                </a>

                <a href="{{ route('dashboard') }}"
                   class="cd-btn cd-btn-white"
                   style="width:100%;justify-content:center;padding:13px;">
                    ← Kembali ke Dashboard
                </a>
            </div>
        </div>
    </div>

    <style>
        @keyframes pulse {
            0%, 100% { transform: scale(1); opacity: 1; }
            50%       { transform: scale(1.05); opacity: 0.85; }
        }
    </style>
</x-app-layout>