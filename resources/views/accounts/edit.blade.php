<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Rekening
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-md mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('accounts.update', $account) }}" method="POST" class="bg-white shadow-sm rounded-lg p-6 space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-sm font-medium text-gray-700">Nama Rekening</label>
                    <input type="text" name="name" value="{{ old('name', $account->name) }}"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    @error('name') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Jenis</label>
                    <select name="type" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        <option value="cash" @selected(old('type', $account->type) == 'cash')>Cash</option>
                        <option value="bank" @selected(old('type', $account->type) == 'bank')>Bank</option>
                        <option value="e_wallet" @selected(old('type', $account->type) == 'e_wallet')>E-Wallet</option>
                    </select>
                    @error('type') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Saldo</label>
                    <input type="number" step="0.01" name="balance" value="{{ old('balance', $account->balance) }}"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    @error('balance') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="flex justify-end gap-2">
                    <a href="{{ route('accounts.index') }}" class="px-4 py-2 text-gray-600">Batal</a>
                    <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">
                        Update
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>