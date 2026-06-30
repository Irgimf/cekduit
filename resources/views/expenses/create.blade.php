<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-xl text-gray-900">Tambah Pengeluaran</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-md mx-auto sm:px-6 lg:px-8">
            <div class="nb-card p-6">
                <form action="{{ route('expenses.store') }}" method="POST" class="space-y-4">
                    @csrf

                    <div>
                        <label class="block text-sm font-black mb-1">Rekening</label>
                        <select name="account_id" class="nb-input w-full px-3 py-2 text-sm">
                            <option value="">-- Pilih Rekening --</option>
                            @foreach ($accounts as $account)
                                <option value="{{ $account->id }}" @selected(old('account_id') == $account->id)>
                                    {{ $account->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('account_id') <p class="text-red-600 text-sm mt-1 font-bold">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-black mb-1">Kategori</label>
                        <select name="category_id" class="nb-input w-full px-3 py-2 text-sm">
                            <option value="">-- Pilih Kategori --</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" @selected(old('category_id') == $category->id)>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id') <p class="text-red-600 text-sm mt-1 font-bold">{{ $message }}</p> @enderror
                        @if ($categories->isEmpty())
                            <p class="text-amber-600 text-sm mt-1 font-bold">
                                Belum ada kategori pengeluaran.
                                <a href="{{ route('categories.create') }}" class="underline">Buat dulu</a>.
                            </p>
                        @endif
                    </div>

                    <div>
                        <label class="block text-sm font-black mb-1">Jumlah</label>
                        <input type="number" step="0.01" min="0.01" name="amount" value="{{ old('amount') }}"
                               class="nb-input w-full px-3 py-2 text-sm">
                        @error('amount') <p class="text-red-600 text-sm mt-1 font-bold">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-black mb-1">Tanggal</label>
                        <input type="date" name="transaction_date"
                               value="{{ old('transaction_date', date('Y-m-d')) }}"
                               class="nb-input w-full px-3 py-2 text-sm">
                        @error('transaction_date') <p class="text-red-600 text-sm mt-1 font-bold">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-black mb-1">Deskripsi (opsional)</label>
                        <input type="text" name="description" value="{{ old('description') }}"
                               class="nb-input w-full px-3 py-2 text-sm">
                        @error('description') <p class="text-red-600 text-sm mt-1 font-bold">{{ $message }}</p> @enderror
                    </div>

                    <div class="flex justify-end gap-2 pt-2">
                        <a href="{{ route('expenses.index') }}"
                           class="nb-btn nb-btn-white px-4 py-2 text-sm">Batal</a>
                        <button type="submit"
                                class="nb-btn nb-btn-red px-4 py-2 text-sm">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>