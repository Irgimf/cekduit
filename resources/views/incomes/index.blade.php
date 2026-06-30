<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-xl text-gray-900">Pemasukan</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 space-y-4">

            <form method="GET" class="nb-card p-4 grid grid-cols-1 md:grid-cols-5 gap-3">
                <input type="text" name="search" value="{{ request('search') }}"
                       placeholder="Cari deskripsi..."
                       class="nb-input px-3 py-2 text-sm">
                <select name="account_id" class="nb-input px-3 py-2 text-sm">
                    <option value="">Semua Rekening</option>
                    @foreach ($accounts as $account)
                        <option value="{{ $account->id }}" @selected(request('account_id') == $account->id)>
                            {{ $account->name }}
                        </option>
                    @endforeach
                </select>
                <select name="category_id" class="nb-input px-3 py-2 text-sm">
                    <option value="">Semua Kategori</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" @selected(request('category_id') == $category->id)>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                <input type="date" name="from_date" value="{{ request('from_date') }}"
                       class="nb-input px-3 py-2 text-sm">
                <input type="date" name="to_date" value="{{ request('to_date') }}"
                       class="nb-input px-3 py-2 text-sm">
                <div class="md:col-span-5 flex justify-end gap-2">
                    <a href="{{ route('incomes.index') }}"
                       class="nb-btn nb-btn-white px-4 py-2 text-sm">Reset</a>
                    <button type="submit"
                            class="nb-btn nb-btn-dark px-4 py-2 text-sm">Filter</button>
                </div>
            </form>

            <div class="flex justify-end">
                <a href="{{ route('incomes.create') }}"
                   class="nb-btn nb-btn-green px-4 py-2 text-sm">+ Tambah Pemasukan</a>
            </div>

            <div class="nb-card overflow-x-auto">
                <table class="nb-table w-full text-left min-w-[700px]">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Rekening</th>
                            <th>Kategori</th>
                            <th>Deskripsi</th>
                            <th>Jumlah</th>
                            <th class="text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($incomes as $income)
                            <tr>
                                <td>{{ $income->transaction_date->format('d/m/Y') }}</td>
                                <td>{{ $income->account->name }}</td>
                                <td>{{ $income->category->name }}</td>
                                <td>{{ $income->description ?: '-' }}</td>
                                <td class="font-black" style="color: #16a34a;">
                                    +Rp {{ number_format($income->amount, 0, ',', '.') }}
                                </td>
                                <td class="text-right">
                                    <div class="flex justify-end gap-2">
                                        <a href="{{ route('incomes.edit', $income) }}"
                                           class="nb-btn nb-btn-primary px-3 py-1 text-xs">Edit</a>
                                        <form action="{{ route('incomes.destroy', $income) }}" method="POST"
                                              class="inline" onsubmit="return confirm('Hapus pemasukan ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="nb-btn nb-btn-red px-3 py-1 text-xs">Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-gray-500 py-8 font-bold">
                                    Belum ada data pemasukan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div>{{ $incomes->links() }}</div>
        </div>
    </div>
</x-app-layout>