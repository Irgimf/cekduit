<x-mobile-layout>
    <div style="background:linear-gradient(135deg,#014BAA,#0166E8);padding-top:max(20px,calc(env(safe-area-inset-top,0px) + 16px));padding-left:20px;padding-right:20px;padding-bottom:24px;">
        <div style="font-size:13px;color:rgba(255,255,255,0.75);margin-bottom:2px;">Tingkatkan akun kamu</div>
        <div style="font-size:20px;font-weight:700;color:#fff;">Upgrade Premium</div>
    </div>

    <div style="padding:16px;display:flex;flex-direction:column;gap:14px;">

        {{-- Status akun --}}
        <div style="background:#fff;border-radius:14px;padding:16px;display:flex;align-items:center;gap:12px;">
            <div style="width:44px;height:44px;background:#E8F0FB;border-radius:12px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                <svg xmlns="http://www.w3.org/2000/svg" style="width:22px;height:22px;color:#014BAA;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
            </div>
            <div>
                <div style="font-size:12px;color:#94A3B8;font-weight:500;margin-bottom:2px;">Status Akun</div>
                <div style="font-size:15px;font-weight:700;color:#1E293B;">{{ auth()->user()->subscriptionLabel() }}</div>
            </div>
        </div>

        @if (session('info'))
            <div style="background:#FEF9C3;border-radius:12px;padding:14px;font-size:13px;color:#92400E;font-weight:500;">
                ⚠️ {{ session('info') }}
            </div>
        @endif

        @if (! auth()->user()->isPremium())

            {{-- Fitur comparison --}}
            <div style="background:#fff;border-radius:14px;overflow:hidden;">
                <div style="padding:14px 16px;border-bottom:1px solid #F1F5F9;font-size:14px;font-weight:700;color:#1E293B;">Perbandingan Fitur</div>
                @php
                $features = [
                    ['Rekening',          '2',        '∞'],
                    ['Kategori',          '5',        '∞'],
                    ['Riwayat',           '30 hari',  'Selamanya'],
                    ['Export PDF/Excel',  '✗',        '✓'],
                    ['Laporan Lengkap',   '✗',        '✓'],
                    ['Budget Kategori',   '✗',        '✓ Segera'],
                ];
                @endphp
                @foreach ($features as $i => [$label, $free, $premium])
                <div style="display:grid;grid-template-columns:1fr 1fr 1fr;padding:11px 16px;border-bottom:{{ $i < count($features)-1 ? '1px solid #F8FAFC' : 'none' }};background:{{ $i%2===0 ? '#fff' : '#FAFBFC' }};">
                    <div style="font-size:13px;color:#1E293B;font-weight:500;">{{ $label }}</div>
                    <div style="font-size:12px;color:{{ $free === '✗' ? '#CBD5E1' : '#64748B' }};text-align:center;">{{ $free }}</div>
                    <div style="font-size:12px;font-weight:700;color:#014BAA;text-align:center;">
                        @if (str_contains($premium, 'Segera'))
                            <span style="font-size:10px;background:#FEF9C3;color:#92400E;padding:1px 6px;border-radius:99px;">Segera</span>
                        @else
                            {{ $premium }}
                        @endif
                    </div>
                </div>
                @endforeach
            </div>

            {{-- Pilih paket --}}
            <div style="font-size:13px;font-weight:700;color:#1E293B;">Pilih Paket:</div>

            <form action="{{ route('payment.order') }}" method="POST" id="payment-form">
                @csrf
                <input type="hidden" name="plan" id="selected-plan" value="yearly">

                <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px;margin-bottom:14px;">
                    {{-- Bulanan --}}
                    <div onclick="selectPlan('monthly')" id="card-monthly"
                         style="background:#fff;border-radius:14px;padding:16px;border:2px solid #E2E8F0;cursor:pointer;transition:all 0.15s;">
                        <div style="font-size:10px;font-weight:700;color:#94A3B8;text-transform:uppercase;letter-spacing:.05em;margin-bottom:6px;">Bulanan</div>
                        <div style="font-size:22px;font-weight:900;color:#1E293B;line-height:1;">Rp 15rb</div>
                        <div style="font-size:11px;color:#94A3B8;margin-top:3px;">/bulan</div>
                    </div>

                    {{-- Tahunan --}}
                    <div onclick="selectPlan('yearly')" id="card-yearly"
                         style="background:#E8F0FB;border-radius:14px;padding:16px;border:2px solid #014BAA;cursor:pointer;position:relative;">
                        <div style="position:absolute;top:-10px;left:50%;transform:translateX(-50%);background:#22C55E;color:#fff;font-size:9px;font-weight:700;padding:2px 8px;border-radius:99px;white-space:nowrap;">
                            Hemat 33%
                        </div>
                        <div style="font-size:10px;font-weight:700;color:#014BAA;text-transform:uppercase;letter-spacing:.05em;margin-bottom:6px;">Tahunan</div>
                        <div style="font-size:22px;font-weight:900;color:#1E293B;line-height:1;">Rp 120rb</div>
                        <div style="font-size:11px;color:#22C55E;font-weight:600;margin-top:3px;">=Rp 10rb/bulan</div>
                    </div>
                </div>

                <button type="submit"
                        style="width:100%;padding:14px;background:#25D366;color:#fff;border:none;border-radius:12px;font-size:15px;font-weight:700;cursor:pointer;display:flex;align-items:center;justify-content:center;gap:8px;font-family:inherit;margin-bottom:8px;">
                    <svg xmlns="http://www.w3.org/2000/svg" style="width:18px;height:18px;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                    </svg>
                    <span id="btn-text">Pesan via WhatsApp — Rp 120rb/tahun</span>
                </button>
            </form>

            <p style="text-align:center;font-size:12px;color:#94A3B8;">
                💬 Kamu akan diarahkan ke WhatsApp untuk konfirmasi pembayaran
            </p>

            <a href="{{ route('payment.history') }}"
               style="text-align:center;font-size:13px;color:#014BAA;font-weight:600;text-decoration:none;display:block;">
                Lihat riwayat pembayaran →
            </a>

        @else
            <div style="background:#DCFCE7;border-radius:14px;padding:28px;text-align:center;">
                <div style="font-size:36px;margin-bottom:10px;">🎉</div>
                <div style="font-size:17px;font-weight:700;color:#15803d;margin-bottom:4px;">Kamu sudah Premium!</div>
                <div style="font-size:13px;color:#64748B;">{{ auth()->user()->subscriptionLabel() }}</div>
            </div>
        @endif

    </div>

    <div style="height:16px;"></div>

    @push('scripts')
    <script>
        let selectedPlan = 'yearly';

        function selectPlan(plan) {
            selectedPlan = plan;
            document.getElementById('selected-plan').value = plan;

            document.getElementById('card-monthly').style.borderColor = plan === 'monthly' ? '#014BAA' : '#E2E8F0';
            document.getElementById('card-monthly').style.background  = plan === 'monthly' ? '#E8F0FB' : '#fff';
            document.getElementById('card-yearly').style.borderColor  = plan === 'yearly'  ? '#014BAA' : '#E2E8F0';
            document.getElementById('card-yearly').style.background   = plan === 'yearly'  ? '#E8F0FB' : '#fff';

            const labels = {
                monthly: 'Pesan via WhatsApp — Rp 15rb/bulan',
                yearly:  'Pesan via WhatsApp — Rp 120rb/tahun',
            };
            document.getElementById('btn-text').textContent = labels[plan];
        }
    </script>
    @endpush
</x-mobile-layout>