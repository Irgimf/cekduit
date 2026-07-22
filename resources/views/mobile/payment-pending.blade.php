<x-mobile-layout>
    <div style="background:linear-gradient(135deg,#014BAA,#0166E8);padding-top:max(20px,calc(env(safe-area-inset-top,0px) + 16px));padding-left:20px;padding-right:20px;padding-bottom:24px;">
        <div style="font-size:13px;color:rgba(255,255,255,0.75);margin-bottom:2px;">Status pesanan</div>
        <div style="font-size:20px;font-weight:700;color:#fff;">Menunggu Konfirmasi</div>
    </div>

    <div style="padding:16px;display:flex;flex-direction:column;gap:14px;">

        @if (session('info'))
            <div style="background:#FEF9C3;border-radius:12px;padding:14px;font-size:13px;color:#92400E;font-weight:500;">
                ⚠️ {{ session('info') }}
            </div>
        @endif

        {{-- Animasi ikon --}}
        <div style="background:#fff;border-radius:16px;padding:28px;text-align:center;">
            <div style="width:64px;height:64px;background:#E8F0FB;border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 16px;animation:pulse 2s infinite;">
                <svg xmlns="http://www.w3.org/2000/svg" style="width:32px;height:32px;color:#014BAA;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div style="font-size:18px;font-weight:800;color:#1E293B;margin-bottom:8px;">Mohon Tunggu Konfirmasi Admin</div>
            <div style="font-size:13px;color:#94A3B8;line-height:1.7;">
                Pesanan kamu sudah kami terima melalui WhatsApp.<br>
                Admin akan membalas dalam waktu <strong style="color:#014BAA;">1×24 jam</strong>.
            </div>
        </div>

        {{-- Langkah-langkah --}}
        <div style="background:#fff;border-radius:14px;padding:16px;">
            <div style="font-size:14px;font-weight:700;color:#1E293B;margin-bottom:14px;">Yang perlu kamu lakukan:</div>
            <div style="display:flex;flex-direction:column;gap:12px;">
                @foreach ([
                    ['1', '#014BAA', 'Tunggu balasan WhatsApp dari admin CekDuit'],
                    ['2', '#014BAA', 'Lakukan pembayaran sesuai instruksi yang dikirim admin'],
                    ['3', '#014BAA', 'Kirim bukti transfer ke WhatsApp admin'],
                    ['✓', '#22C55E', 'Akun Premium kamu akan aktif dalam hitungan menit'],
                ] as [$num, $bg, $text])
                <div style="display:flex;align-items:flex-start;gap:12px;">
                    <div style="width:26px;height:26px;background:{{ $bg }};color:#fff;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:12px;font-weight:700;flex-shrink:0;margin-top:1px;">
                        {{ $num }}
                    </div>
                    <div style="font-size:13px;color:#64748B;line-height:1.5;flex:1;">{{ $text }}</div>
                </div>
                @endforeach
            </div>
        </div>

        {{-- Tombol --}}
        <a href="https://wa.me/6282317179877" target="_blank"
           style="display:flex;align-items:center;justify-content:center;gap:8px;padding:14px;background:#25D366;color:#fff;border-radius:12px;font-size:15px;font-weight:700;text-decoration:none;">
            <svg xmlns="http://www.w3.org/2000/svg" style="width:18px;height:18px;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
            </svg>
            Chat Admin WhatsApp
        </a>

        <a href="{{ route('dashboard') }}"
           style="display:flex;align-items:center;justify-content:center;padding:13px;background:#F1F5F9;color:#64748B;border-radius:12px;font-size:14px;font-weight:600;text-decoration:none;">
            ← Kembali ke Dashboard
        </a>

    </div>

    <div style="height:16px;"></div>

    <style>
        @keyframes pulse {
            0%,100% { transform:scale(1); }
            50%      { transform:scale(1.06); }
        }
    </style>
</x-mobile-layout>