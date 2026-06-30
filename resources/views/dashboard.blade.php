<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-xl text-gray-900">Dashboard</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="nb-card p-6" style="background: #FBBF24;">
                    <p class="text-xs font-black uppercase">Total Saldo</p>
                    <p class="text-3xl font-black mt-1">
                        Rp {{ number_format($totalBalance, 0, ',', '.') }}
                    </p>
                </div>
                <div class="nb-card p-6" style="background: #4ADE80;">
                    <p class="text-xs font-black uppercase">Pemasukan Bulan Ini</p>
                    <p class="text-3xl font-black mt-1">
                        Rp {{ number_format($monthlyIncome, 0, ',', '.') }}
                    </p>
                </div>
                <div class="nb-card p-6" style="background: #F87171;">
                    <p class="text-xs font-black uppercase">Pengeluaran Bulan Ini</p>
                    <p class="text-3xl font-black mt-1">
                        Rp {{ number_format($monthlyExpense, 0, ',', '.') }}
                    </p>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
                <div class="lg:col-span-2 nb-card p-6">
                    <h3 class="font-black mb-4 uppercase text-sm">📈 Tren 6 Bulan Terakhir</h3>
                    <canvas id="trendChart" height="120"
                            data-labels="{{ json_encode($chartLabels) }}"
                            data-income="{{ json_encode($chartIncome) }}"
                            data-expense="{{ json_encode($chartExpense) }}"></canvas>
                </div>
                <div class="nb-card p-6">
                    <h3 class="font-black mb-4 uppercase text-sm">🍩 Pengeluaran per Kategori</h3>
                    @if ($expenseCategoryLabels->isEmpty())
                        <p class="text-sm font-bold text-gray-500">Belum ada data pengeluaran bulan ini.</p>
                    @else
                        <canvas id="categoryChart" height="200"
                                data-labels="{{ json_encode($expenseCategoryLabels) }}"
                                data-data="{{ json_encode($expenseCategoryData) }}"></canvas>
                    @endif
                </div>
            </div>

            <div class="nb-card overflow-hidden">
                <div class="px-6 py-4 flex justify-between items-center"
                     style="border-bottom: 2px solid #000; background: #FBBF24;">
                    <h3 class="font-black uppercase text-sm">🕐 Transaksi Terbaru</h3>
                    <a href="{{ route('incomes.index') }}"
                       class="nb-btn nb-btn-dark px-3 py-1 text-xs">Lihat Semua</a>
                </div>
                <table class="nb-table w-full text-left">
                    <tbody>
                        @forelse ($recentTransactions as $transaction)
                            <tr>
                                <td class="text-sm text-gray-500">
                                    {{ $transaction->transaction_date->format('d/m/Y') }}
                                </td>
                                <td class="text-sm font-bold">{{ $transaction->category->name }}</td>
                                <td class="text-sm text-gray-500">{{ $transaction->account->name }}</td>
                                <td class="text-sm font-black text-right"
                                    style="color: {{ $transaction->type === 'income' ? '#16a34a' : '#dc2626' }}">
                                    {{ $transaction->type === 'income' ? '+' : '-' }}Rp {{ number_format($transaction->amount, 0, ',', '.') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-gray-500 py-8 font-bold">
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