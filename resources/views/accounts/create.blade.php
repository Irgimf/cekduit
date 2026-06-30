<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-xl text-gray-900">Tambah Rekening</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-md mx-auto sm:px-6 lg:px-8">
            <div class="nb-card p-6">
                <form action="{{ route('accounts.store') }}" method="POST" class="space-y-4">
                    @csrf

                    <div>
                        <label class="block text-sm font-black mb-1">Nama Rekening</label>
                        <input type="text" name="name" value="{{ old('name') }}"
                               class="nb-input w-full px-3 py-2 text-sm">
                        @error('name') <p class="text-red-600 text-sm mt-1 font-bold">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-black mb-1">Jenis</label>
                        <select name="type" class="nb-input w-full px-3 py-2 text-sm">
                            <option value="cash" @selected(old('type') == 'cash')>Cash</option>
                            <option value="bank" @selected(old('type') == 'bank')>Bank</option>
                            <option value="e_wallet" @selected(old('type') == 'e_wallet')>E-Wallet</option>
                        </select>
                        @error('type') <p class="text-red-600 text-sm mt-1 font-bold">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-black mb-1">Saldo Awal</label>
                        <input type="number" step="0.01" min="0" name="balance" value="{{ old('balance', 0) }}"
                               class="nb-input w-full px-3 py-2 text-sm">
                        @error('balance') <p class="text-red-600 text-sm mt-1 font-bold">{{ $message }}</p> @enderror
                    </div>

                    <div class="flex justify-end gap-2 pt-2">
                        <a href="{{ route('accounts.index') }}"
                           class="nb-btn nb-btn-white px-4 py-2 text-sm">Batal</a>
                        <button type="submit"
                                class="nb-btn nb-btn-primary px-4 py-2 text-sm">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>