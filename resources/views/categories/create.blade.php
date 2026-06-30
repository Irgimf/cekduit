<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-xl text-gray-900">Tambah Kategori</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-md mx-auto sm:px-6 lg:px-8">
            <div class="nb-card p-6">
                <form action="{{ route('categories.store') }}" method="POST" class="space-y-4">
                    @csrf

                    <div>
                        <label class="block text-sm font-black mb-1">Nama Kategori</label>
                        <input type="text" name="name" value="{{ old('name') }}"
                               class="nb-input w-full px-3 py-2 text-sm">
                        @error('name') <p class="text-red-600 text-sm mt-1 font-bold">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-black mb-1">Jenis</label>
                        <select name="type" class="nb-input w-full px-3 py-2 text-sm">
                            <option value="income" @selected(old('type') == 'income')>Pemasukan</option>
                            <option value="expense" @selected(old('type') == 'expense')>Pengeluaran</option>
                        </select>
                        @error('type') <p class="text-red-600 text-sm mt-1 font-bold">{{ $message }}</p> @enderror
                    </div>

                    <div class="flex justify-end gap-2 pt-2">
                        <a href="{{ route('categories.index') }}"
                           class="nb-btn nb-btn-white px-4 py-2 text-sm">Batal</a>
                        <button type="submit"
                                class="nb-btn nb-btn-primary px-4 py-2 text-sm">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>