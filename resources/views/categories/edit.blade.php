<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Kategori
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-md mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('categories.update', $category) }}" method="POST" class="bg-white shadow-sm rounded-lg p-6 space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-sm font-medium text-gray-700">Nama Kategori</label>
                    <input type="text" name="name" value="{{ old('name', $category->name) }}"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    @error('name') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Jenis</label>
                    <select name="type" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        <option value="income" @selected(old('type', $category->type) == 'income')>Pemasukan</option>
                        <option value="expense" @selected(old('type', $category->type) == 'expense')>Pengeluaran</option>
                    </select>
                    @error('type') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="flex justify-end gap-2">
                    <a href="{{ route('categories.index') }}" class="px-4 py-2 text-gray-600">Batal</a>
                    <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">
                        Update
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>