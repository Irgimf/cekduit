<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-xl text-gray-900">Laporan Keuangan</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 space-y-4">

            <form method="GET" class="nb-card p-4">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-3" x-data="{ periodType: '{{ $periodType }}' }">
                    <select name="period_type" x-model="periodType" class="nb-input px-3 py-2 text-sm">
                        <option value="monthly" @selected($periodType === 'monthly')>Bulanan</option>
                        <option value="yearly" @selected($periodType === 'yearly')>Tahunan</option>
                        <option value="custom" @selected($periodType === 'custom')>Rentang Tanggal</option>
                    </select>

                    <div x-show="periodType === 'monthly'" class="flex gap-2">
                        <select name="month" class="nb-input px-3 py-2 text-sm w-full">
                            @foreach (range(1, 12) as $m)
                                <option value="{{ $m }}" @selected($start->month == $m)>
                                    {{ \Carbon\Carbon::create()->month($m)->translatedFormat('F') }}
                                </option>
                            @endforeach
                        </select>
                        <input type="number" name="year" value="{{ $start->year }}"
                               class="nb-input px-3 py-2 text-sm w-24">
                    </div>

                    <div x-show="periodType === 'yearly'">
                        <input type="number" name="year" value="{{ $start->year }}"
                               class="nb-input px-3 py-2 text-sm w-full">
                    </div>

                    <div x-show="periodType === 'custom'" class="flex gap-2 md:col-span-2">
                        <input type="date" name="from_date" value="{{ $start->format('Y-m-d') }}"
                               class="nb-input px-3 py-2 text-sm w-full">
                        <input type="date" name="to_date" value="{{ $end->format('Y-m-d') }}"
                               class="nb-input px-3 py-2 text-sm w-full">
                    </div>

                    <button type="submit" class="nb-btn nb-btn-dark px-4 py-2 text-sm">
                        Tampilkan
                    </button>
                </div>
            </form>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="nb-card p-6">
                    <p class="text-xs font-black uppercase text-gray-500">Total Pemasukan</p>
                    <p class="text-2xl font-black mt-1" style="color: #16a34a;">
                        Rp {{ number_format($summary['total_income'], 0, ',', '.') }}
                    </p>
                </div>
                <div class="nb-card p-6">
                    <p class="text-xs font-black uppercase text-gray-500">Total Pengeluaran</p>
                    <p class="text-2xl font-black mt-1" style="color: #dc2626;">
                        Rp {{ number_format($summary['total_expense'], 0, ',', '.') }}
                    </p>
                </div>
                <div class="nb-card p-6" style="background: {{ $summary['net'] >= 0 ? '#dcfce7' : '#fee2e2' }};">
                    <p class="text-xs font-black uppercase text-gray-500">Selisih (Net)</p>
                    <p class="text-2xl font-black mt-1">
                        Rp {{ number_format($summary['net'], 0, ',', '.') }}
                    </p>
                </div>
            </div>

            <div class="flex justify-end gap-2">
                <a href="{{ route('reports.export-pdf', request()->query()) }}"
                   class="nb-btn nb-btn-red px-4 py-2 text-sm">📄 Export PDF</a>
                <a href="{{ route('reports.export-excel', request()->query()) }}"
                   class="nb-btn nb-btn-green px-4 py-2 text-sm">📊 Export Excel</a>
            </div>

            <div class="nb-card overflow-x-auto">
                <div class="px-6 py-4" style="border-bottom: 2px solid #000; background: #FBBF24;">
                    <h3 class="font-black">Detail Transaksi — {{ $periodLabel }}</h3>
                </div>
                <table class="nb-table w-full text-left min-w-[700px]">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Jenis</th>
                            <th>Kategori</th>
                            <th>Rekening</th>
                            <th>Deskripsi</th>
                            <th class="text-right">Jumlah</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($transactions as $transaction)
                            <tr>
                                <td>{{ $transaction->transaction_date->format('d/m/Y') }}</td>
                                <td>
                                    <span class="{{ $transaction->type === 'income' ? 'nb-badge-income' : 'nb-badge-expense' }}">
                                        {{ $transaction->type === 'income' ? 'Pemasukan' : 'Pengeluaran' }}
                                    </span>
                                </td>
                                <td>{{ $transaction->category->name }}</td>
                                <td>{{ $transaction->account->name }}</td>
                                <td>{{ $transaction->description ?: '-' }}</td>
                                <td class="text-right font-black"
                                    style="color: {{ $transaction->type === 'income' ? '#16a34a' : '#dc2626' }}">
                                    {{ $transaction->type === 'income' ? '+' : '-' }}Rp {{ number_format($transaction->amount, 0, ',', '.') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-gray-500 py-8 font-bold">
                                    Tidak ada transaksi pada periode ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>