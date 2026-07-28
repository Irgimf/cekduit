<x-app-layout>
    <x-slot name="header">
        <h1 class="cd-page-title">Dashboard</h1>
    </x-slot>

    <div style="display:flex;flex-direction:column;gap:20px;">

        {{-- Stat Cards --}}
        <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:16px;">
            <div class="stat-card">
                <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:10px;">
                    <span style="font-size:13px;font-weight:600;color:var(--muted);">Total Saldo</span>
                    <div style="width:34px;height:34px;background:var(--blue-light);border-radius:8px;display:flex;align-items:center;justify-content:center;">
                        <svg xmlns="http://www.w3.org/2000/svg" style="width:18px;height:18px;color:var(--blue);" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
                <p style="font-size:22px;font-weight:800;color:var(--dark);">
                    Rp {{ number_format($totalBalance, 0, ',', '.') }}
                </p>
            </div>

            <div class="stat-card">
                <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:10px;">
                    <span style="font-size:13px;font-weight:600;color:var(--muted);">Pemasukan Bulan Ini</span>
                    <div style="width:34px;height:34px;background:var(--green-bg);border-radius:8px;display:flex;align-items:center;justify-content:center;">
                        <svg xmlns="http://www.w3.org/2000/svg" style="width:18px;height:18px;color:var(--green);" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                        </svg>
                    </div>
                </div>
                <p style="font-size:22px;font-weight:800;color:var(--green);">
                    Rp {{ number_format($monthlyIncome, 0, ',', '.') }}
                </p>
            </div>

            <div class="stat-card">
                <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:10px;">
                    <span style="font-size:13px;font-weight:600;color:var(--muted);">Pengeluaran Bulan Ini</span>
                    <div style="width:34px;height:34px;background:var(--red-bg);border-radius:8px;display:flex;align-items:center;justify-content:center;">
                        <svg xmlns="http://www.w3.org/2000/svg" style="width:18px;height:18px;color:var(--red);" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6"/>
                        </svg>
                    </div>
                </div>
                <p style="font-size:22px;font-weight:800;color:var(--red);">
                    Rp {{ number_format($monthlyExpense, 0, ',', '.') }}
                </p>
            </div>
        </div>

        {{-- --- WIDGET WARNING BUDGET --- --}}
        @if (!empty($budgetWarnings))
            <div class="cd-card" style="padding:16px 20px;border-left:4px solid #EAB308;">
                <div style="font-size:14px;font-weight:700;color:var(--dark);margin-bottom:12px;display:flex;align-items:center;gap:6px;">
                    <svg xmlns="http://www.w3.org/2000/svg" style="width:16px;height:16px;color:#EAB308;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                    Peringatan Anggaran
                </div>
                <div style="display:flex;flex-direction:column;gap:10px;">
                    @foreach ($budgetWarnings as $w)
                        <div style="display:flex;flex-direction:column;gap:4px;">
                            <div style="display:flex;align-items:center;justify-content:space-between;font-size:13px;">
                                <span style="color:var(--dark);font-weight:600;">{{ $w['name'] }}</span>
                                <span style="color:{{ $w['status'] === 'exceeded' ? 'var(--red)' : '#EAB308' }};font-weight:700;">
                                    {{ $w['status'] === 'exceeded' ? 'Melebihi limit!' : round($w['percent']) . '% terpakai' }}
                                </span>
                            </div>
                            {{-- Progress bar tambahan opsional untuk mempercantik UI --}}
                            <div style="width:100%;height:6px;background:var(--border);border-radius:4px;overflow:hidden;">
                                <div style="width:{{ min($w['percent'], 100) }}%;height:100%;background:{{ $w['status'] === 'exceeded' ? 'var(--red)' : '#EAB308' }};"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <a href="{{ route('budgets.index') }}"
                   style="display:inline-block;margin-top:14px;font-size:13px;color:var(--blue);font-weight:600;text-decoration:none;">
                    Kelola budget →
                </a>
            </div>
        @endif

        {{-- Charts --}}
        <div style="display:grid;grid-template-columns:2fr 1fr;gap:16px;" class="max-lg:grid-cols-1">
            <!-- Sisanya tetap sama seperti kode awal kamu -->
            <div class="cd-card" style="padding:24px;">
                <h3 style="font-size:15px;font-weight:700;color:var(--dark);margin-bottom:16px;">Tren 6 Bulan Terakhir</h3>
                <canvas id="trendChart" height="120"
                        data-labels="{{ json_encode($chartLabels) }}"
                        data-income="{{ json_encode($chartIncome) }}"
                        data-expense="{{ json_encode($chartExpense) }}"></canvas>
            </div>
            <!-- ... dan seterusnya ... -->
        </div>
    </div>
</x-app-layout>