<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-xl text-gray-900">Kategori</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-4 flex justify-end">
                <a href="{{ route('categories.create') }}" class="nb-btn nb-btn-primary px-4 py-2 text-sm">
                    + Tambah Kategori
                </a>
            </div>

            <div class="nb-card overflow-x-auto">
                <table class="nb-table w-full text-left min-w-[400px]">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Jenis</th>
                            <th class="text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($categories as $category)
                            <tr>
                                <td class="font-bold">{{ $category->name }}</td>
                                <td>
                                    <span class="{{ $category->type === 'income' ? 'nb-badge-income' : 'nb-badge-expense' }}">
                                        {{ $category->type === 'income' ? 'Pemasukan' : 'Pengeluaran' }}
                                    </span>
                                </td>
                                <td class="text-right">
                                    <div class="flex justify-end gap-2">
                                        <a href="{{ route('categories.edit', $category) }}"
                                           class="nb-btn nb-btn-primary px-3 py-1 text-xs">Edit</a>
                                        <form action="{{ route('categories.destroy', $category) }}" method="POST"
                                              class="inline" onsubmit="return confirm('Hapus kategori ini?')">
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
                                <td colspan="3" class="text-center text-gray-500 py-8 font-bold">
                                    Belum ada kategori.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>