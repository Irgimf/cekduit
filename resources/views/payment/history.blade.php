<x-app-layout>
    <x-slot name="header">Riwayat Pembayaran</x-slot>

    <div style="max-width:700px;">
        <div class="cd-card" style="overflow:hidden;">
            <div style="padding:16px 20px;border-bottom:1px solid var(--border);">
                <h2 style="font-size:16px;font-weight:700;color:var(--dark);">Riwayat Transaksi Premium</h2>
            </div>

            <table class="cd-table">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Paket</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($payments as $payment)
                    <tr>
                        <td style="font-size:12px;color:var(--muted);">{{ $payment->order_id }}</td>
                        <td style="font-weight:600;">{{ $payment->planLabel() }}</td>
                        <td>Rp {{ number_format($payment->amount, 0, ',', '.') }}</td>
                        <td>
                            @php
                                $colors = [
                                    'success' => ['bg'=>'#DCFCE7','color'=>'#15803d'],
                                    'pending' => ['bg'=>'#FEF9C3','color'=>'#92400E'],
                                    'failed'  => ['bg'=>'#FEE2E2','color'=>'#dc2626'],
                                    'expired' => ['bg'=>'#F1F5F9','color'=>'#64748B'],
                                ];
                                $c = $colors[$payment->status] ?? $colors['pending'];
                            @endphp
                            <span style="background:{{ $c['bg'] }};color:{{ $c['color'] }};padding:3px 10px;border-radius:99px;font-size:12px;font-weight:600;">
                                {{ ucfirst($payment->status) }}
                            </span>
                        </td>
                        <td style="font-size:13px;color:var(--muted);">{{ $payment->created_at->format('d M Y') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" style="text-align:center;padding:40px;color:var(--muted);">
                            Belum ada riwayat pembayaran
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

            @if ($payments->hasPages())
            <div style="padding:12px 16px;border-top:1px solid var(--border);">
                {{ $payments->links() }}
            </div>
            @endif
        </div>

        <div style="text-align:center;margin-top:16px;">
            <a href="{{ route('premium.upgrade') }}" class="cd-btn cd-btn-primary" style="display:inline-flex;">
                ⭐ Upgrade / Perpanjang Premium
            </a>
        </div>
    </div>
</x-app-layout>