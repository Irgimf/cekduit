<x-mobile-layout>
    <div class="mobile-page-header" style="padding-top:max(16px, calc(env(safe-area-inset-top, 0px) + 14px));">
        <div class="mobile-page-title">Laporan Keuangan</div>
    </div>

    {{-- Filter --}}
    <div style="padding:12px 16px;">
        <form method="GET" style="background:#fff;border-radius:14px;padding:14px;">
            <div class="mobile-form-group" style="margin-bottom:12px;">
                <label class="mobile-label">Periode</label>
                <select name="period_type" class="mobile-select" onchange="this.form.submit()">
                    <option value="monthly" @selected($periodType === 'monthly')>Bulanan</option>
                    <option value="yearly" @selected($periodType === 'yearly')>Tahunan</option>
                    <option value="custom" @selected($periodType === 'custom')>Rentang Tanggal</option>
                </select>
            </div>

            @if ($periodType === 'monthly')
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:8px;margin-bottom:12px;">
                    <div>
                        <label class="mobile-label">Bulan</label>
                        <select name="month" class="mobile-select">
                            @foreach (range(1, 12) as $m)
                                <option value="{{ $m }}" @selected($start->month == $m)>
                                    {{ \Carbon\Carbon::create()->month($m)->translatedFormat('F') }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="mobile-label">Tahun</label>
                        <input type="number" name="year" value="{{ $start->year }}" class="mobile-input">
                    </div>
                </div>
            @elseif ($periodType === 'yearly')
                <div class="mobile-form-group" style="margin-bottom:12px;">
                    <label class="mobile-label">Tahun</label>
                    <input type="number" name="year" value="{{ $start->year }}" class="mobile-input">
                </div>
            @else
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:8px;margin-bottom:12px;">
                    <div>
                        <label class="mobile-label">Dari</label>
                        <input type="date" name="from_date" value="{{ $start->format('Y-m-d') }}" class="mobile-input">
                    </div>
                    <div>
                        <label class="mobile-label">Sampai</label>
                        <input type="date" name="to_date" value="{{ $end->format('Y-m-d') }}" class="mobile-input">
                    </div>
                </div>
            @endif

            <button type="submit" class="mobile-btn mobile-btn-primary" style="padding:11px;">
                Tampilkan
            </button>
        </form>
    </div>

    {{-- Summary Cards --}}
    <div style="padding:0 16px 12px;display:grid;grid-template-columns:1fr 1fr;gap:10px;">
        <div class="mobile-stat-card">
            <div class="mobile-stat-label" style="color:#16a34a;">Pemasukan</div>
            <div class="mobile-stat-value" style="color:#16a34a;font-size:15px;">
                Rp {{ number_format($summary['total_income'], 0, ',', '.') }}
            </div>
        </div>
        <div class="mobile-stat-card">
            <div class="mobile-stat-label" style="color:#dc2626;">Pengeluaran</div>
            <div class="mobile-stat-value" style="color:#dc2626;font-size:15px;">
                Rp {{ number_format($summary['total_expense'], 0, ',', '.') }}
            </div>
        </div>
    </div>

    <div style="padding:0 16px 12px;">
        <div class="mobile-stat-card" style="background:{{ $summary['net'] >= 0 ? '#DCFCE7' : '#FEE2E2' }};">
            <div class="mobile-stat-label">Selisih (Net)</div>
            <div style="font-size:20px;font-weight:800;color:{{ $summary['net'] >= 0 ? '#16a34a' : '#dc2626' }};">
                Rp {{ number_format($summary['net'], 0, ',', '.') }}
            </div>
        </div>
    </div>

    {{-- Export --}}
    <div style="padding:0 16px 12px;display:grid;grid-template-columns:1fr 1fr;gap:10px;">
        <a href="{{ route('reports.export-pdf', request()->query()) }}"
        target="_blank"
        style="display:flex;align-items:center;justify-content:center;gap:6px;padding:11px;background:#fff;border-radius:12px;border:1.5px solid #E2E8F0;font-size:13px;font-weight:600;color:#1E293B;text-decoration:none;flex:1;">
            <svg xmlns="http://www.w3.org/2000/svg" style="width:16px;height:16px;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
            Export PDF
        </a>
        <a href="{{ route('reports.export-excel', request()->query()) }}"
           class="mobile-btn mobile-btn-primary" style="padding:11px;font-size:13px;">
            <svg xmlns="http://www.w3.org/2000/svg" style="width:16px;height:16px;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
            Export Excel
        </a>
    </div>

    {{-- Tabel Transaksi --}}
    <div class="mobile-section" style="margin-top:0;">
        <div class="mobile-section-header">
            <span class="mobile-section-title">{{ $periodLabel }}</span>
        </div>

        @forelse ($transactions as $tx)
            <div class="mobile-tx-card">
                <div class="mobile-tx-icon"
                     style="background:{{ $tx->type === 'income' ? '#DCFCE7' : '#FEE2E2' }};">
                    <svg xmlns="http://www.w3.org/2000/svg"
                         style="width:18px;height:18px;color:{{ $tx->type === 'income' ? '#16a34a' : '#dc2626' }};"
                         fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        @if ($tx->type === 'income')
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                        @else
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6"/>
                        @endif
                    </svg>
                </div>
                <div class="mobile-tx-info">
                    <div class="mobile-tx-name">{{ $tx->category->name }}</div>
                    <div class="mobile-tx-sub">{{ $tx->account->name }} · {{ $tx->transaction_date->format('d M Y') }}</div>
                </div>
                <div class="mobile-tx-amount"
                     style="color:{{ $tx->type === 'income' ? '#16a34a' : '#dc2626' }};">
                    {{ $tx->type === 'income' ? '+' : '-' }}Rp {{ number_format($tx->amount, 0, ',', '.') }}
                </div>
            </div>
        @empty
            <div class="mobile-empty">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                </svg>
                <div class="mobile-empty-title">Tidak ada transaksi</div>
                <div class="mobile-empty-sub">Coba ubah periode laporan</div>
            </div>
        @endforelse

        {{-- Pagination --}}
        @if ($transactions->hasPages())
            <div style="display:flex;justify-content:center;gap:8px;padding:16px 0;">
                @if (!$transactions->onFirstPage())
                    <a href="{{ $transactions->previousPageUrl() }}"
                       style="padding:8px 16px;border-radius:8px;background:#014BAA;color:#fff;font-size:13px;text-decoration:none;">← Prev</a>
                @endif
                <span style="padding:8px 14px;border-radius:8px;background:#fff;color:#1E293B;font-size:13px;font-weight:600;">
                    {{ $transactions->currentPage() }}/{{ $transactions->lastPage() }}
                </span>
                @if ($transactions->hasMorePages())
                    <a href="{{ $transactions->nextPageUrl() }}"
                       style="padding:8px 16px;border-radius:8px;background:#014BAA;color:#fff;font-size:13px;text-decoration:none;">Next →</a>
                @endif
            </div>
        @endif
    </div>

    <div style="height:16px;"></div>
</x-mobile-layout>