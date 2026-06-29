<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Laporan Keuangan
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Filter --}}
            <form method="GET" class="bg-white shadow-sm rounded-lg p-4">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-3" x-data="{ periodType: '{{ $periodType }}' }">
                    <select name="period_type" x-model="periodType"
                            class="rounded-md border-gray-300 shadow-sm text-sm">
                        <option value="monthly" @selected($periodType === 'monthly')>Bulanan</option>
                        <option value="yearly" @selected($periodType === 'yearly')>Tahunan</option>
                        <option value="custom" @selected($periodType === 'custom')>Rentang Tanggal</option>
                    </select>

                    <div x-show="periodType === 'monthly'" class="flex gap-2">
                        <select name="month" class="rounded-md border-gray-300 shadow-sm text-sm w-full">
                            @foreach (range(1, 12) as $m)
                                <option value="{{ $m }}" @selected($start->month == $m)>
                                    {{ \Carbon\Carbon::create()->month($m)->translatedFormat('F') }}
                                </option>
                            @endforeach
                        </select>
                        <input type="number" name="year" value="{{ $start->year }}"
                               class="rounded-md border-gray-300 shadow-sm text-sm w-24">
                    </div>

                    <div x-show="periodType === 'yearly'">
                        <input type="number" name="year" value="{{ $start->year }}"
                               class="rounded-md border-gray-300 shadow-sm text-sm w-full">
                    </div>

                    <div x-show="periodType === 'custom'" class="flex gap-2 md:col-span-2">
                        <input type="date" name="from_date" value="{{ $start->format('Y-m-d') }}"
                               class="rounded-md border-gray-300 shadow-sm text-sm w-full">
                        <input type="date" name="to_date" value="{{ $end->format('Y-m-d') }}"
                               class="rounded-md border-gray-300 shadow-sm text-sm w-full">
                    </div>

                    <button type="submit" class="px-4 py-2 text-sm bg-gray-700 text-white rounded-lg hover:bg-gray-800">
                        Tampilkan
                    </button>
                </div>
            </form>

            {{-- Summary --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="bg-white shadow-sm rounded-lg p-6">
                    <p class="text-sm text-gray-500">Total Pemasukan</p>
                    <p class="text-2xl font-bold text-green-600 mt-1">
                        Rp {{ number_format($summary['total_income'], 0, ',', '.') }}
                    </p>
                </div>
                <div class="bg-white shadow-sm rounded-lg p-6">
                    <p class="text-sm text-gray-500">Total Pengeluaran</p>
                    <p class="text-2xl font-bold text-red-600 mt-1">
                        Rp {{ number_format($summary['total_expense'], 0, ',', '.') }}
                    </p>
                </div>
                <div class="bg-white shadow-sm rounded-lg p-6">
                    <p class="text-sm text-gray-500">Selisih (Net)</p>
                    <p class="text-2xl font-bold {{ $summary['net'] >= 0 ? 'text-green-600' : 'text-red-600' }} mt-1">
                        Rp {{ number_format($summary['net'], 0, ',', '.') }}
                    </p>
                </div>
            </div>

            {{-- Export buttons --}}
            <div class="flex justify-end gap-2">
                <a href="{{ route('reports.export-pdf', request()->query()) }}"
                   class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 text-sm">
                    Export PDF
                </a>
                <a href="{{ route('reports.export-excel', request()->query()) }}"
                   class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 text-sm">
                    Export Excel
                </a>
            </div>

            {{-- Detail table --}}
            <div class="bg-white shadow-sm rounded-lg overflow-x-auto">
                <div class="px-6 py-4 border-b border-gray-100">
                    <h3 class="font-medium text-gray-700">Detail Transaksi — {{ $periodLabel }}</h3>
                </div>
                <table class="w-full text-left min-w-[600px]">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-sm font-medium text-gray-600">Tanggal</th>
                            <th class="px-6 py-3 text-sm font-medium text-gray-600">Jenis</th>
                            <th class="px-6 py-3 text-sm font-medium text-gray-600">Kategori</th>
                            <th class="px-6 py-3 text-sm font-medium text-gray-600">Rekening</th>
                            <th class="px-6 py-3 text-sm font-medium text-gray-600">Deskripsi</th>
                            <th class="px-6 py-3 text-sm font-medium text-gray-600 text-right">Jumlah</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($transactions as $transaction)
                            <tr>
                                <td class="px-6 py-3 text-sm">{{ $transaction->transaction_date->format('d/m/Y') }}</td>
                                <td class="px-6 py-3 text-sm">
                                    {{ $transaction->type === 'income' ? 'Pemasukan' : 'Pengeluaran' }}
                                </td>
                                <td class="px-6 py-3 text-sm">{{ $transaction->category->name }}</td>
                                <td class="px-6 py-3 text-sm">{{ $transaction->account->name }}</td>
                                <td class="px-6 py-3 text-sm">{{ $transaction->description ?: '-' }}</td>
                                <td class="px-6 py-3 text-sm text-right font-medium
                                    {{ $transaction->type === 'income' ? 'text-green-600' : 'text-red-600' }}">
                                    {{ $transaction->type === 'income' ? '+' : '-' }}Rp {{ number_format($transaction->amount, 0, ',', '.') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-4 text-center text-gray-500 text-sm">
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