<x-app-layout>
    <x-slot name="header">Upgrade ke Premium</x-slot>

    <div style="max-width:680px;margin:0 auto;">

        {{-- Status saat ini --}}
        <div class="cd-card" style="padding:24px;margin-bottom:20px;background:linear-gradient(135deg,#014BAA,#0166E8);color:#fff;">
            <div style="display:flex;align-items:center;gap:14px;">
                <div style="width:52px;height:52px;background:rgba(255,255,255,0.15);border-radius:14px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                    <svg xmlns="http://www.w3.org/2000/svg" style="width:26px;height:26px;" fill="none" viewBox="0 0 24 24" stroke="white">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                </div>
                <div>
                    <div style="font-size:13px;opacity:0.8;margin-bottom:2px;">Status Akun</div>
                    <div style="font-size:18px;font-weight:700;">{{ auth()->user()->subscriptionLabel() }}</div>
                </div>
            </div>
        </div>

        {{-- Perbandingan fitur --}}
        <div class="cd-card" style="overflow:hidden;margin-bottom:20px;">
            <div style="padding:20px;border-bottom:1px solid var(--border);">
                <h2 style="font-size:18px;font-weight:700;color:var(--dark);">Bandingkan Paket</h2>
            </div>
            <table style="width:100%;border-collapse:collapse;">
                <thead>
                    <tr style="background:#FAFBFC;">
                        <th style="padding:14px 20px;text-align:left;font-size:13px;font-weight:600;color:var(--muted);border-bottom:1px solid var(--border);">Fitur</th>
                        <th style="padding:14px 20px;text-align:center;font-size:13px;font-weight:600;color:var(--muted);border-bottom:1px solid var(--border);">Gratis</th>
                        <th style="padding:14px 20px;text-align:center;font-size:13px;font-weight:700;color:var(--blue);border-bottom:1px solid var(--border);background:var(--blue-light);">Premium ⭐</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                    $features = [
                        ['Jumlah Rekening',     '2 rekening',   'Tidak terbatas'],
                        ['Jumlah Kategori',     '5 kategori',   'Tidak terbatas'],
                        ['Riwayat Transaksi',   '30 hari',      'Selamanya'],
                        ['Transfer Rekening',   '✓',            '✓'],
                        ['Dashboard & Grafik',  'Dasar',        'Lengkap'],
                        ['Laporan Bulanan',     '✗',            '✓'],
                        ['Export PDF & Excel',  '✗',            '✓'],
                        ['Budget per Kategori', '✗',            '✓ Segera hadir'],
                        ['Target Tabungan',     '✗',            '✓ Segera hadir'],
                        ['Prioritas Support',   '✗',            '✓'],
                    ];
                    @endphp
                    @foreach ($features as $i => [$label, $free, $premium])
                    <tr style="{{ $i % 2 === 0 ? '' : 'background:#FAFBFC;' }}">
                        <td style="padding:12px 20px;font-size:14px;color:var(--dark);border-bottom:1px solid var(--border);">{{ $label }}</td>
                        <td style="padding:12px 20px;text-align:center;font-size:13px;color:var(--muted);border-bottom:1px solid var(--border);">
                            {{ $free === '✗' ? '—' : $free }}
                        </td>
                        <td style="padding:12px 20px;text-align:center;font-size:13px;font-weight:600;color:var(--blue);border-bottom:1px solid var(--border);background:rgba(232,240,251,0.4);">
                            @if (str_contains($premium, 'Segera'))
                                <span style="font-size:11px;background:#FEF9C3;color:#92400E;padding:2px 8px;border-radius:99px;">{{ $premium }}</span>
                            @else
                                {{ $premium }}
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Pilihan paket --}}
        @if (! auth()->user()->isPremium())
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:20px;">

            {{-- Bulanan --}}
            <div class="cd-card" style="padding:24px;border:2px solid var(--border);cursor:pointer;transition:all 0.2s;"
                 onmouseover="this.style.borderColor='var(--blue)'"
                 onmouseout="this.style.borderColor='var(--border)'">
                <div style="font-size:13px;font-weight:700;color:var(--muted);text-transform:uppercase;letter-spacing:.05em;margin-bottom:8px;">Bulanan</div>
                <div style="font-size:32px;font-weight:900;color:var(--dark);">Rp 15rb</div>
                <div style="font-size:13px;color:var(--muted);margin-bottom:20px;">/bulan</div>
                <a href="#" onclick="alert('Midtrans payment coming soon!')"
                   class="cd-btn cd-btn-white" style="width:100%;justify-content:center;">
                    Pilih Bulanan
                </a>
            </div>

            {{-- Tahunan --}}
            <div class="cd-card" style="padding:24px;border:2px solid var(--blue);background:var(--blue-light);position:relative;">
                <div style="position:absolute;top:-12px;left:50%;transform:translateX(-50%);background:var(--green);color:#fff;font-size:11px;font-weight:700;padding:3px 12px;border-radius:99px;white-space:nowrap;">
                    Hemat 33%
                </div>
                <div style="font-size:13px;font-weight:700;color:var(--blue);text-transform:uppercase;letter-spacing:.05em;margin-bottom:8px;">Tahunan</div>
                <div style="font-size:32px;font-weight:900;color:var(--dark);">Rp 120rb</div>
                <div style="font-size:13px;color:var(--muted);margin-bottom:4px;">/tahun</div>
                <div style="font-size:12px;color:var(--green);font-weight:600;margin-bottom:16px;">Hemat Rp 60.000</div>
                <a href="#" onclick="alert('Midtrans payment coming soon!')"
                   class="cd-btn cd-btn-primary" style="width:100%;justify-content:center;">
                    Pilih Tahunan
                </a>
            </div>
        </div>

        <p style="text-align:center;font-size:13px;color:var(--muted);">
            Pembayaran via QRIS, transfer bank, GoPay, OVO, Dana — powered by Midtrans (segera hadir)
        </p>

        @else
        {{-- Sudah premium --}}
        <div class="cd-card" style="padding:24px;text-align:center;background:var(--green-bg);">
            <div style="font-size:32px;margin-bottom:8px;">🎉</div>
            <div style="font-size:16px;font-weight:700;color:#15803d;margin-bottom:4px;">Kamu sudah Premium!</div>
            <div style="font-size:14px;color:var(--muted);">{{ auth()->user()->subscriptionLabel() }}</div>
        </div>
        @endif
    </div>
</x-app-layout>