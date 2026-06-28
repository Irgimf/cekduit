<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Pemasukan
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-800 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Filter & Search --}}
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
                    <a href="{{ route('incomes.index') }}" class="px-4 py-2 text-sm text-gray-600">Reset</a>
                    <button type="submit" class="px-4 py-2 text-sm bg-gray-700 text-white rounded-lg hover:bg-gray-800">
                        Filter
                    </button>
                </div>
            </form>

            <div class="mb-4 flex justify-end">
                <a href="{{ route('incomes.create') }}"
                   class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                    + Tambah Pemasukan
                </a>
            </div>

            <div class="bg-white shadow-sm rounded-lg overflow-hidden">
                <table class="w-full text-left">
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
                        @forelse ($incomes as $income)
                            <tr>
                                <td class="px-6 py-4">{{ $income->transaction_date->format('d/m/Y') }}</td>
                                <td class="px-6 py-4">{{ $income->account->name }}</td>
                                <td class="px-6 py-4">{{ $income->category->name }}</td>
                                <td class="px-6 py-4">{{ $income->description ?: '-' }}</td>
                                <td class="px-6 py-4 text-green-600 font-medium">
                                    +Rp {{ number_format($income->amount, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4 text-right space-x-2">
                                    <a href="{{ route('incomes.edit', $income) }}"
                                       class="text-indigo-600 hover:underline">Edit</a>
                                    <form action="{{ route('incomes.destroy', $income) }}" method="POST"
                                          class="inline" onsubmit="return confirm('Hapus pemasukan ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:underline">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                                    Belum ada data pemasukan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $incomes->links() }}
            </div>
        </div>
    </div>
</x-app-layout>