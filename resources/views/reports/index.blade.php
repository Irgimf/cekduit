<x-app-layout>
    <x-slot name="header">
        <h1 class="cd-page-title">Laporan Keuangan</h1>
    </x-slot>

    <div style="display:flex;flex-direction:column;gap:20px;">

        {{-- Filter --}}
        <div class="cd-card" style="padding:20px;">
            <form method="GET" x-data="{ periodType: '{{ $periodType }}' }">
                <div style="display:flex;flex-wrap:wrap;gap:12px;align-items:flex-end;">

                    {{-- Dropdown Periode --}}
                    <div>
                        <label class="cd-label">Periode</label>
                        <select name="period_type" x-model="periodType"
                                class="cd-input" style="width:160px;">
                            <option value="monthly" @selected($periodType === 'monthly')>Bulanan</option>
                            <option value="yearly" @selected($periodType === 'yearly')>Tahunan</option>
                            <option value="custom" @selected($periodType === 'custom')>Rentang Tanggal</option>
                        </select>
                    </div>

                    {{-- Input Bulanan --}}
                    <template x-if="periodType === 'monthly'">
                        <div style="display:flex;gap:8px;">
                            <div>
                                <label class="cd-label">Bulan</label>
                                <select name="month" class="cd-input" style="width:130px;">
                                    @foreach (range(1, 12) as $m)
                                        <option value="{{ $m }}" @selected($start->month == $m)>
                                            {{ \Carbon\Carbon::create()->month($m)->translatedFormat('F') }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="cd-label">Tahun</label>
                                <input type="number" name="year" value="{{ $start->year }}"
                                       class="cd-input" style="width:90px;">
                            </div>
                        </div>
                    </template>

                    {{-- Input Tahunan --}}
                    <template x-if="periodType === 'yearly'">
                        <div>
                            <label class="cd-label">Tahun</label>
                            <input type="number" name="year" value="{{ $start->year }}"
                                   class="cd-input" style="width:90px;">
                        </div>
                    </template>

                    {{-- Input Rentang --}}
                    <template x-if="periodType === 'custom'">
                        <div style="display:flex;gap:8px;">
                            <div>
                                <label class="cd-label">Dari</label>
                                <input type="date" name="from_date" value="{{ $start->format('Y-m-d') }}"
                                       class="cd-input" style="width:160px;">
                            </div>
                            <div>
                                <label class="cd-label">Sampai</label>
                                <input type="date" name="to_date" value="{{ $end->format('Y-m-d') }}"
                                       class="cd-input" style="width:160px;">
                            </div>
                        </div>
                    </template>

                    {{-- Tombol Tampilkan --}}
                    <div>
                        <label class="cd-label" style="opacity:0;">_</label>
                        <button type="submit" class="cd-btn cd-btn-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                            Tampilkan
                        </button>
                    </div>

                </div>
            </form>
        </div>

        {{-- Summary Cards --}}
        <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:16px;">
            <div class="stat-card">
                <p style="font-size:12px;font-weight:600;color:var(--muted);text-transform:uppercase;letter-spacing:.05em;margin-bottom:8px;">Total Pemasukan</p>
                <p style="font-size:24px;font-weight:800;color:var(--green);">
                    Rp {{ number_format($summary['total_income'], 0, ',', '.') }}
                </p>
            </div>
            <div class="stat-card">
                <p style="font-size:12px;font-weight:600;color:var(--muted);text-transform:uppercase;letter-spacing:.05em;margin-bottom:8px;">Total Pengeluaran</p>
                <p style="font-size:24px;font-weight:800;color:var(--red);">
                    Rp {{ number_format($summary['total_expense'], 0, ',', '.') }}
                </p>
            </div>
            <div class="stat-card" style="background:{{ $summary['net'] >= 0 ? 'var(--green-bg)' : 'var(--red-bg)' }};">
                <p style="font-size:12px;font-weight:600;color:var(--muted);text-transform:uppercase;letter-spacing:.05em;margin-bottom:8px;">Selisih (Net)</p>
                <p style="font-size:24px;font-weight:800;color:{{ $summary['net'] >= 0 ? 'var(--green)' : 'var(--red)' }};">
                    Rp {{ number_format($summary['net'], 0, ',', '.') }}
                </p>
            </div>
        </div>

        {{-- Export --}}
        <div style="display:flex;justify-content:flex-end;gap:10px;">
            <a href="{{ route('reports.export-pdf', request()->query()) }}" class="cd-btn cd-btn-white">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                Export PDF
            </a>
            <a href="{{ route('reports.export-excel', request()->query()) }}" class="cd-btn cd-btn-primary">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                Export Excel
            </a>
        </div>

        {{-- Tabel Detail --}}
        <div class="cd-card" style="overflow:hidden;">
            <div style="padding:16px 20px;border-bottom:1px solid var(--border);background:#FAFBFC;">
                <h3 style="font-size:15px;font-weight:700;color:var(--dark);">
                    Detail Transaksi — {{ $periodLabel }}
                </h3>
            </div>
            <div style="overflow-x:auto;">
                <table class="cd-table" style="min-width:640px;">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Jenis</th>
                            <th>Kategori</th>
                            <th>Rekening</th>
                            <th>Deskripsi</th>
                            <th style="text-align:right;">Jumlah</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($transactions as $transaction)
                            <tr>
                                <td style="font-size:13px;color:var(--muted);white-space:nowrap;">
                                    {{ $transaction->transaction_date->format('d M Y') }}
                                </td>
                                <td>
                                    <span class="cd-badge {{ $transaction->type === 'income' ? 'cd-badge-income' : 'cd-badge-expense' }}">
                                        {{ $transaction->type === 'income' ? 'Pemasukan' : 'Pengeluaran' }}
                                    </span>
                                </td>
                                <td style="font-size:14px;">{{ $transaction->category->name }}</td>
                                <td style="font-size:14px;">{{ $transaction->account->name }}</td>
                                <td style="font-size:13px;color:var(--muted);">{{ $transaction->description ?: '-' }}</td>
                                <td style="text-align:right;font-weight:700;white-space:nowrap;color:{{ $transaction->type === 'income' ? 'var(--green)' : 'var(--red)' }}">
                                    {{ $transaction->type === 'income' ? '+' : '-' }}Rp {{ number_format($transaction->amount, 0, ',', '.') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" style="text-align:center;padding:48px;color:var(--muted);">
                                    Tidak ada transaksi pada periode ini
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Bagian Pagination yang Benar (Di luar tabel, di dalam kartu) --}}
            @if ($transactions->total() > 0)
                <div style="padding:12px 16px;border-top:1px solid var(--border);display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:8px;">
                    <p style="font-size:13px;color:var(--muted);">
                        Menampilkan {{ $transactions->firstItem() }}–{{ $transactions->lastItem() }} dari {{ $transactions->total() }} transaksi
                    </p>
                    {{ $transactions->appends(request()->query())->links() }}
                </div>
            @endif
        </div>

    </div>
</x-app-layout>