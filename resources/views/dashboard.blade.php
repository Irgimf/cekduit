<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Summary Cards --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="bg-white shadow-sm rounded-lg p-6">
                    <p class="text-sm text-gray-500">Total Saldo</p>
                    <p class="text-2xl font-bold text-gray-800 mt-1">
                        Rp {{ number_format($totalBalance, 0, ',', '.') }}
                    </p>
                </div>

                <div class="bg-white shadow-sm rounded-lg p-6">
                    <p class="text-sm text-gray-500">Pemasukan Bulan Ini</p>
                    <p class="text-2xl font-bold text-green-600 mt-1">
                        Rp {{ number_format($monthlyIncome, 0, ',', '.') }}
                    </p>
                </div>

                <div class="bg-white shadow-sm rounded-lg p-6">
                    <p class="text-sm text-gray-500">Pengeluaran Bulan Ini</p>
                    <p class="text-2xl font-bold text-red-600 mt-1">
                        Rp {{ number_format($monthlyExpense, 0, ',', '.') }}
                    </p>
                </div>
            </div>

            {{-- Charts --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
                <div class="lg:col-span-2 bg-white shadow-sm rounded-lg p-6">
                    <h3 class="font-medium text-gray-700 mb-4">Tren 6 Bulan Terakhir</h3>
                        <canvas id="trendChart" height="120"
                            data-labels="{{ json_encode($chartLabels) }}"
                            data-income="{{ json_encode($chartIncome) }}"
                            data-expense="{{ json_encode($chartExpense) }}"></canvas>
                </div>

                <div class="bg-white shadow-sm rounded-lg p-6">
                    <h3 class="font-medium text-gray-700 mb-4">Pengeluaran per Kategori (Bulan Ini)</h3>
                    @if ($expenseCategoryLabels->isEmpty())
                        <p class="text-sm text-gray-500">Belum ada data pengeluaran bulan ini.</p>
                    @else
                        <canvas id="categoryChart" height="120"
                            data-labels="{{ json_encode($expenseCategoryLabels) }}"
                            data-data="{{ json_encode($expenseCategoryData) }}"></canvas>
                    @endif
                </div>
            </div>

            {{-- Recent Transactions --}}
            <div class="bg-white shadow-sm rounded-lg overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                    <h3 class="font-medium text-gray-700">Transaksi Terbaru</h3>
                    <a href="{{ route('incomes.index') }}" class="text-sm text-indigo-600 hover:underline">Lihat semua</a>
                </div>
                <table class="w-full text-left">
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($recentTransactions as $transaction)
                            <tr>
                                <td class="px-6 py-3 text-sm text-gray-500">
                                    {{ $transaction->transaction_date->format('d/m/Y') }}
                                </td>
                                <td class="px-6 py-3 text-sm">{{ $transaction->category->name }}</td>
                                <td class="px-6 py-3 text-sm text-gray-500">{{ $transaction->account->name }}</td>
                                <td class="px-6 py-3 text-sm font-medium text-right
                                    {{ $transaction->type === 'income' ? 'text-green-600' : 'text-red-600' }}">
                                    {{ $transaction->type === 'income' ? '+' : '-' }}Rp {{ number_format($transaction->amount, 0, ',', '.') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-4 text-center text-gray-500 text-sm">
                                    Belum ada transaksi.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>