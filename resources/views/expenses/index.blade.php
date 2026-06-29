<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Pengeluaran
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-800 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            <form method="GET" class="bg-white shadow-sm rounded-lg p-4 mb-4 grid grid-cols-1 md:grid-cols-5 gap-3">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari deskripsi..."
                       class="rounded-md border-gray-300 shadow-sm text-sm">

                <select name="account_id" class="rounded-md border-gray-300 shadow-sm text-sm">
                    <option value="">Semua Rekening</option>
                    @foreach ($accounts as $account)
                        <option value="{{ $account->id }}" @selected(request('account_id') == $account->id)>
                            {{ $account->name }}
                        </option>
                    @endforeach
                </select>

                <select name="category_id" class="rounded-md border-gray-300 shadow-sm text-sm">
                    <option value="">Semua Kategori</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" @selected(request('category_id') == $category->id)>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>

                <input type="date" name="from_date" value="{{ request('from_date') }}"
                       class="rounded-md border-gray-300 shadow-sm text-sm">
                <input type="date" name="to_date" value="{{ request('to_date') }}"
                       class="rounded-md border-gray-300 shadow-sm text-sm">

                <div class="md:col-span-5 flex justify-end gap-2">
                    <a href="{{ route('expenses.index') }}" class="px-4 py-2 text-sm text-gray-600">Reset</a>
                    <button type="submit" class="px-4 py-2 text-sm bg-gray-700 text-white rounded-lg hover:bg-gray-800">
                        Filter
                    </button>
                </div>
            </form>

            <div class="mb-4 flex justify-end">
                <a href="{{ route('expenses.create') }}"
                   class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                    + Tambah Pengeluaran
                </a>
            </div>

            <div class="bg-white shadow-sm rounded-lg overflow-x-auto">
                 <table class="w-full text-left min-w-[600px]">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-sm font-medium text-gray-600">Tanggal</th>
                            <th class="px-6 py-3 text-sm font-medium text-gray-600">Rekening</th>
                            <th class="px-6 py-3 text-sm font-medium text-gray-600">Kategori</th>
                            <th class="px-6 py-3 text-sm font-medium text-gray-600">Deskripsi</th>
                            <th class="px-6 py-3 text-sm font-medium text-gray-600">Jumlah</th>
                            <th class="px-6 py-3 text-sm font-medium text-gray-600 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($expenses as $expense)
                            <tr>
                                <td class="px-6 py-4">{{ $expense->transaction_date->format('d/m/Y') }}</td>
                                <td class="px-6 py-4">{{ $expense->account->name }}</td>
                                <td class="px-6 py-4">{{ $expense->category->name }}</td>
                                <td class="px-6 py-4">{{ $expense->description ?: '-' }}</td>
                                <td class="px-6 py-4 text-red-600 font-medium">
                                    -Rp {{ number_format($expense->amount, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4 text-right space-x-2">
                                    <a href="{{ route('expenses.edit', $expense) }}"
                                       class="text-indigo-600 hover:underline">Edit</a>
                                    <form action="{{ route('expenses.destroy', $expense) }}" method="POST"
                                          class="inline" onsubmit="return confirm('Hapus pengeluaran ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:underline">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                                    Belum ada data pengeluaran.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $expenses->links() }}
            </div>
        </div>
    </div>
</x-app-layout>