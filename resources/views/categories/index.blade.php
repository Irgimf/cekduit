<x-app-layout>
    <x-slot name="header">
        <div style="display:flex;align-items:center;justify-content:space-between;">
            <h1 class="cd-page-title">Kategori</h1>
            <a href="{{ route('categories.create') }}" class="cd-btn cd-btn-primary">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Tambah Kategori
            </a>
        </div>
    </x-slot>

    <div class="cd-card" style="overflow:hidden;">
        <table class="cd-table">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Jenis</th>
                    <th style="text-align:right;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($categories as $category)
                    <tr>
                        <td style="font-weight:600;">{{ $category->name }}</td>
                        <td>
                            <span class="cd-badge {{ $category->type === 'income' ? 'cd-badge-income' : 'cd-badge-expense' }}">
                                {{ $category->type === 'income' ? 'Pemasukan' : 'Pengeluaran' }}
                            </span>
                        </td>
                        <td style="text-align:right;">
                            <div style="display:flex;justify-content:flex-end;gap:6px;">
                                <a href="{{ route('categories.edit', $category) }}"
                                   class="cd-btn cd-btn-white cd-btn-sm">Edit</a>
                                <form action="{{ route('categories.destroy', $category) }}" method="POST"
                                      onsubmit="return confirm('Hapus kategori ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="cd-btn cd-btn-red cd-btn-sm">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" style="text-align:center;padding:48px;color:var(--muted);">
                            Belum ada kategori
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-app-layout>