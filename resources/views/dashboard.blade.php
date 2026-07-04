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

        {{-- Charts --}}
        <div style="display:grid;grid-template-columns:2fr 1fr;gap:16px;" class="max-lg:grid-cols-1">
            <div class="cd-card" style="padding:24px;">
                <h3 style="font-size:15px;font-weight:700;color:var(--dark);margin-bottom:16px;">Tren 6 Bulan Terakhir</h3>
                <canvas id="trendChart" height="120"
                        data-labels="{{ json_encode($chartLabels) }}"
                        data-income="{{ json_encode($chartIncome) }}"
                        data-expense="{{ json_encode($chartExpense) }}"></canvas>
            </div>

            <div class="cd-card" style="padding:24px;">
                <h3 style="font-size:15px;font-weight:700;color:var(--dark);margin-bottom:16px;">Pengeluaran per Kategori</h3>
                @if ($expenseCategoryLabels->isEmpty())
                    <div style="display:flex;flex-direction:column;align-items:center;justify-content:center;height:160px;color:var(--muted);">
                        <svg xmlns="http://www.w3.org/2000/svg" style="width:40px;height:40px;margin-bottom:8px;opacity:0.3;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                        <p style="font-size:13px;">Belum ada data</p>
                    </div>
                @else
                    <canvas id="categoryChart" height="200"
                            data-labels="{{ json_encode($expenseCategoryLabels) }}"
                            data-data="{{ json_encode($expenseCategoryData) }}"></canvas>
                @endif
            </div>
        </div>

        {{-- Recent Transactions --}}
        <div class="cd-card" style="overflow:hidden;">
            <div style="padding:16px 20px;border-bottom:1px solid var(--border);display:flex;align-items:center;justify-content:space-between;">
                <h3 style="font-size:15px;font-weight:700;color:var(--dark);">Transaksi Terbaru</h3>
                <a href="{{ route('reports.index') }}" class="cd-btn cd-btn-ghost cd-btn-sm">
                    Lihat semua
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
            </div>
            <table class="cd-table">
                <tbody>
                    @forelse ($recentTransactions as $transaction)
                        <tr>
                            <td style="color:var(--muted);font-size:13px;white-space:nowrap;">
                                {{ $transaction->transaction_date->format('d M Y') }}
                            </td>
                            <td>
                                <div style="font-weight:600;font-size:14px;">{{ $transaction->category->name }}</div>
                                <div style="font-size:12px;color:var(--muted);">{{ $transaction->account->name }}</div>
                            </td>
                            <td style="text-align:right;font-weight:700;font-size:14px;white-space:nowrap;color:{{ $transaction->type === 'income' ? 'var(--green)' : 'var(--red)' }}">
                                {{ $transaction->type === 'income' ? '+' : '-' }}Rp {{ number_format($transaction->amount, 0, ',', '.') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" style="text-align:center;padding:40px;color:var(--muted);font-size:14px;">
                                Belum ada transaksi
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>