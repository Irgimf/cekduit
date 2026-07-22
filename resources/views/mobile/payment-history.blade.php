<x-mobile-layout>
    <div style="background:linear-gradient(135deg,#014BAA,#0166E8);padding-top:max(20px,calc(env(safe-area-inset-top,0px) + 16px));padding-left:20px;padding-right:20px;padding-bottom:24px;">
        <div style="font-size:13px;color:rgba(255,255,255,0.75);margin-bottom:2px;">Histori transaksi kamu</div>
        <div style="font-size:20px;font-weight:700;color:#fff;">Riwayat Pembayaran</div>
    </div>

    <div style="padding:16px;display:flex;flex-direction:column;gap:10px;">

        @forelse ($payments as $payment)
            @php
                $colors = [
                    'success' => ['bg'=>'#DCFCE7','color'=>'#15803d'],
                    'pending' => ['bg'=>'#FEF9C3','color'=>'#92400E'],
                    'failed'  => ['bg'=>'#FEE2E2','color'=>'#dc2626'],
                    'expired' => ['bg'=>'#F1F5F9','color'=>'#64748B'],
                ];
                $c = $colors[$payment->status] ?? $colors['pending'];
            @endphp
            <div style="background:#fff;border-radius:14px;padding:16px;">
                <div style="display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:10px;">
                    <div>
                        <div style="font-size:14px;font-weight:700;color:#1E293B;">
                            Premium {{ $payment->planLabel() }}
                        </div>
                        <div style="font-size:11px;color:#94A3B8;margin-top:2px;">
                            {{ $payment->created_at->format('d M Y · H:i') }}
                        </div>
                    </div>
                    <span style="background:{{ $c['bg'] }};color:{{ $c['color'] }};padding:4px 10px;border-radius:99px;font-size:11px;font-weight:700;">
                        {{ ucfirst($payment->status) }}
                    </span>
                </div>
                <div style="display:flex;justify-content:space-between;align-items:center;padding-top:10px;border-top:1px solid #F1F5F9;">
                    <div style="font-size:12px;color:#94A3B8;">{{ $payment->order_id }}</div>
                    <div style="font-size:15px;font-weight:800;color:#014BAA;">
                        Rp {{ number_format($payment->amount, 0, ',', '.') }}
                    </div>
                </div>
            </div>
        @empty
            <div style="text-align:center;padding:40px 20px;color:#94A3B8;">
                <svg xmlns="http://www.w3.org/2000/svg" style="width:40px;height:40px;margin:0 auto 10px;opacity:0.3;display:block;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                </svg>
                <div style="font-size:15px;font-weight:600;margin-bottom:4px;">Belum ada riwayat</div>
                <div style="font-size:13px;">Belum ada transaksi premium</div>
            </div>
        @endforelse

        @if ($payments->hasPages())
            <div style="display:flex;justify-content:center;gap:8px;padding:8px 0;">
                @if (!$payments->onFirstPage())
                    <a href="{{ $payments->previousPageUrl() }}"
                       style="padding:8px 16px;border-radius:8px;background:#014BAA;color:#fff;font-size:13px;font-weight:600;text-decoration:none;">← Prev</a>
                @endif
                <span style="padding:8px 14px;border-radius:8px;background:#fff;color:#1E293B;font-size:13px;font-weight:600;">
                    {{ $payments->currentPage() }}/{{ $payments->lastPage() }}
                </span>
                @if ($payments->hasMorePages())
                    <a href="{{ $payments->nextPageUrl() }}"
                       style="padding:8px 16px;border-radius:8px;background:#014BAA;color:#fff;font-size:13px;font-weight:600;text-decoration:none;">Next →</a>
                @endif
            </div>
        @endif

        <a href="{{ route('premium.upgrade') }}"
           style="display:flex;align-items:center;justify-content:center;gap:8px;padding:14px;background:#014BAA;color:#fff;border-radius:12px;font-size:14px;font-weight:700;text-decoration:none;margin-top:4px;">
            ⭐ Upgrade / Perpanjang Premium
        </a>
    </div>

    <div style="height:16px;"></div>
</x-mobile-layout>