<x-app-layout>
    <x-slot name="header">Upgrade ke Premium</x-slot>

    <div style="max-width:680px;margin:0 auto;">

        @if (session('warning'))
            <div style="background:#FEF9C3;border:1px solid #FDE68A;color:#92400E;padding:12px 16px;border-radius:8px;margin-bottom:16px;font-size:14px;">
                ⚠️ {{ session('warning') }}
            </div>
        @endif

        {{-- Status saat ini --}}
        <div class="cd-card" style="padding:24px;margin-bottom:20px;background:linear-gradient(135deg,#014BAA,#0166E8);color:#fff;">
            <div style="display:flex;align-items:center;gap:14px;">
                <div style="width:52px;height:52px;background:rgba(255,255,255,0.15);border-radius:14px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                    <svg xmlns="http://www.w3.org/2000/svg" style="width:26px;height:26px;" fill="none" viewBox="0 0 24 24" stroke="white">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                </div>
                <div>
                    <div style="font-size:13px;opacity:0.8;margin-bottom:2px;">Status Akun Kamu</div>
                    <div style="font-size:18px;font-weight:700;">{{ auth()->user()->subscriptionLabel() }}</div>
                </div>
                @if (auth()->user()->isPremium())
                    <div style="margin-left:auto;">
                        <div style="background:rgba(34,197,94,0.2);padding:8px 14px;border-radius:10px;font-size:13px;font-weight:600;color:#4ade80;">
                            ✓ Aktif
                        </div>
                    </div>
                @endif
            </div>
        </div>

        {{-- Tabel perbandingan fitur --}}
        <div class="cd-card" style="overflow:hidden;margin-bottom:20px;">
            <div style="padding:20px;border-bottom:1px solid var(--border);">
                <h2 style="font-size:18px;font-weight:700;color:var(--dark);">Bandingkan Paket</h2>
            </div>
            <table style="width:100%;border-collapse:collapse;">
                <thead>
                    <tr style="background:#FAFBFC;">
                        <th style="padding:12px 20px;text-align:left;font-size:12px;font-weight:600;color:var(--muted);border-bottom:1px solid var(--border);">Fitur</th>
                        <th style="padding:12px 20px;text-align:center;font-size:12px;font-weight:600;color:var(--muted);border-bottom:1px solid var(--border);">Gratis</th>
                        <th style="padding:12px 20px;text-align:center;font-size:12px;font-weight:700;color:var(--blue);border-bottom:1px solid var(--border);background:var(--blue-light);">Premium ⭐</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                    $features = [
                        ['Rekening',            '2 rekening',   'Tidak terbatas'],
                        ['Kategori',            '5 kategori',   'Tidak terbatas'],
                        ['Riwayat Transaksi',   '30 hari',      'Selamanya'],
                        ['Transfer Rekening',   '✓',            '✓'],
                        ['Export PDF & Excel',  '✗',            '✓'],
                        ['Laporan Lengkap',     '✗',            '✓'],
                        ['Budget per Kategori', '✗',            '✓ Segera'],
                        ['Target Tabungan',     '✗',            '✓ Segera'],
                    ];
                    @endphp
                    @foreach ($features as $i => [$label, $free, $premium])
                    <tr style="{{ $i % 2 === 0 ? '' : 'background:#FAFBFC;' }}">
                        <td style="padding:11px 20px;font-size:14px;color:var(--dark);border-bottom:1px solid var(--border);">{{ $label }}</td>
                        <td style="padding:11px 20px;text-align:center;font-size:13px;color:{{ $free === '✗' ? '#94A3B8' : 'var(--muted)' }};border-bottom:1px solid var(--border);">{{ $free }}</td>
                        <td style="padding:11px 20px;text-align:center;font-size:13px;font-weight:600;color:var(--blue);border-bottom:1px solid var(--border);background:rgba(232,240,251,0.4);">
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

        {{-- Pilihan Paket --}}
        @if (! auth()->user()->isPremium())
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:16px;">

            {{-- Bulanan --}}
            <div class="cd-card" style="padding:24px;border:2px solid var(--border);transition:all 0.2s;cursor:pointer;"
                 id="card-monthly"
                 onclick="selectPlan('monthly')"
                 onmouseover="this.style.borderColor='var(--blue)'"
                 onmouseout="if(selectedPlan !== 'monthly') this.style.borderColor='var(--border)'">
                <div style="font-size:12px;font-weight:700;color:var(--muted);text-transform:uppercase;letter-spacing:.05em;margin-bottom:8px;">Bulanan</div>
                <div style="font-size:32px;font-weight:900;color:var(--dark);line-height:1;">Rp 15.000</div>
                <div style="font-size:13px;color:var(--muted);margin-bottom:16px;">/bulan</div>
                <div style="font-size:13px;color:var(--muted);">Bayar setiap bulan, batalkan kapan saja.</div>
            </div>

            {{-- Tahunan --}}
            <div class="cd-card" style="padding:24px;border:2px solid var(--blue);background:var(--blue-light);position:relative;cursor:pointer;"
                 id="card-yearly"
                 onclick="selectPlan('yearly')">
                <div style="position:absolute;top:-12px;left:50%;transform:translateX(-50%);background:var(--green);color:#fff;font-size:11px;font-weight:700;padding:3px 12px;border-radius:99px;white-space:nowrap;">
                    Hemat Rp 60.000
                </div>
                <div style="font-size:12px;font-weight:700;color:var(--blue);text-transform:uppercase;letter-spacing:.05em;margin-bottom:8px;">Tahunan</div>
                <div style="font-size:32px;font-weight:900;color:var(--dark);line-height:1;">Rp 120.000</div>
                <div style="font-size:13px;color:var(--muted);margin-bottom:16px;">/tahun</div>
                <div style="font-size:13px;color:#16a34a;font-weight:600;">= Rp 10.000/bulan — hemat 33%!</div>
            </div>
        </div>

        {{-- Tombol Bayar --}}
        <button id="btn-pay" onclick="startPayment()"
                class="cd-btn cd-btn-primary"
                style="width:100%;justify-content:center;padding:14px;font-size:16px;margin-bottom:12px;">
            <svg xmlns="http://www.w3.org/2000/svg" style="width:18px;height:18px;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
            </svg>
            <span id="btn-pay-text">Bayar Sekarang — Rp 120.000/tahun</span>
        </button>

        <p style="text-align:center;font-size:12px;color:var(--muted);">
            Pembayaran aman via Midtrans · QRIS · Transfer Bank · GoPay · OVO · Dana
        </p>

        {{-- Riwayat Pembayaran --}}
        <div style="text-align:center;margin-top:12px;">
            <a href="{{ route('payment.history') }}" style="font-size:13px;color:var(--blue);font-weight:500;">
                Lihat riwayat pembayaran →
            </a>
        </div>

        @else
        {{-- Sudah premium --}}
        <div class="cd-card" style="padding:28px;text-align:center;background:var(--green-bg);">
            <div style="font-size:40px;margin-bottom:12px;">🎉</div>
            <div style="font-size:18px;font-weight:700;color:#15803d;margin-bottom:6px;">Kamu sudah Premium!</div>
            <div style="font-size:14px;color:var(--muted);margin-bottom:16px;">{{ auth()->user()->subscriptionLabel() }}</div>
            @if (auth()->user()->daysUntilExpiry() <= 7)
                <a href="#" onclick="selectPlan('monthly'); document.getElementById('btn-pay').click();"
                   class="cd-btn cd-btn-primary" style="display:inline-flex;">
                    Perpanjang Sekarang
                </a>
            @endif
        </div>
        @endif
    </div>

    {{-- Midtrans Snap JS --}}
    <script src="{{ config('midtrans.snap_url') }}"
            data-client-key="{{ config('midtrans.client_key') }}"></script>

    <script>
        let selectedPlan = 'yearly'; // default

        function selectPlan(plan) {
            selectedPlan = plan;

            // Update visual card
            document.getElementById('card-monthly').style.borderColor =
                plan === 'monthly' ? 'var(--blue)' : 'var(--border)';
            document.getElementById('card-yearly').style.borderColor =
                plan === 'yearly' ? 'var(--blue)' : 'var(--border)';

            // Update teks tombol
            const labels = {
                monthly: 'Bayar Sekarang — Rp 15.000/bulan',
                yearly:  'Bayar Sekarang — Rp 120.000/tahun',
            };
            document.getElementById('btn-pay-text').textContent = labels[plan];
        }

        function startPayment() {
            const btn = document.getElementById('btn-pay');
            btn.disabled = true;
            btn.innerHTML = `
                <svg style="width:18px;height:18px;animation:spin 1s linear infinite;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                </svg>
                Memproses...
            `;

            // Request snap token ke server
            fetch('{{ route('payment.create') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
                body: JSON.stringify({ plan: selectedPlan }),
            })
            .then(res => res.json())
            .then(data => {
                if (data.error) {
                    alert('Terjadi kesalahan: ' + data.error);
                    resetBtn();
                    return;
                }

                // Buka Midtrans Snap popup
                window.snap.pay(data.snap_token, {
                    onSuccess: function(result) {
                        window.location.href = '{{ route('payment.finish') }}?order_id=' + result.order_id + '&transaction_status=' + result.transaction_status;
                    },
                    onPending: function(result) {
                        alert('Pembayaran pending. Silakan selesaikan pembayaran kamu.');
                        resetBtn();
                    },
                    onError: function(result) {
                        alert('Pembayaran gagal. Silakan coba lagi.');
                        resetBtn();
                    },
                    onClose: function() {
                        resetBtn();
                    }
                });
            })
            .catch(err => {
                alert('Gagal terhubung ke server. Periksa koneksi internet kamu.');
                resetBtn();
            });
        }

        function resetBtn() {
            const btn = document.getElementById('btn-pay');
            btn.disabled = false;
            btn.innerHTML = `
                <svg xmlns="http://www.w3.org/2000/svg" style="width:18px;height:18px;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                </svg>
                <span id="btn-pay-text">Bayar Sekarang — Rp 120.000/tahun</span>
            `;
        }

        // CSS animasi loading
        const style = document.createElement('style');
        style.textContent = `@keyframes spin { from { transform: rotate(0deg); } to { transform: rotate(360deg); } }`;
        document.head.appendChild(style);
    </script>
</x-app-layout>