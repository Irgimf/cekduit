<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Tambah Pengeluaran
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-md mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('expenses.store') }}" method="POST" class="bg-white shadow-sm rounded-lg p-6 space-y-4">
                @csrf

                <div>
                    <label class="block text-sm font-medium text-gray-700">Rekening</label>
                        <select name="account_id" id="account_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            <option value="">-- Pilih Rekening --</option>
                            @foreach ($accounts as $account)
                                <option value="{{ $account->id }}" data-balance="{{ $account->balance }}"
                                        @selected(old('account_id') == $account->id)>
                                    {{ $account->name }} (Rp {{ number_format($account->balance, 0, ',', '.') }})
                                </option>
                            @endforeach
                        </select>
                    @error('account_id') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Kategori</label>
                    <select name="category_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        <option value="">-- Pilih Kategori --</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" @selected(old('category_id') == $category->id)>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                    @if ($categories->isEmpty())
                        <p class="text-amber-600 text-sm mt-1">
                            Belum ada kategori pengeluaran. <a href="{{ route('categories.create') }}" class="underline">Buat dulu di sini</a>.
                        </p>
                    @endif
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Jumlah</label>
                    <input type="number" step="0.01" name="amount" value="{{ old('amount') }}"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    @error('amount') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Tanggal</label>
                    <input type="date" name="transaction_date" value="{{ old('transaction_date', date('Y-m-d')) }}"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    @error('transaction_date') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Deskripsi (opsional)</label>
                    <input type="text" name="description" value="{{ old('description') }}"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    @error('description') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="flex justify-end gap-2">
                    <a href="{{ route('expenses.index') }}" class="px-4 py-2 text-gray-600">Batal</a>
                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>