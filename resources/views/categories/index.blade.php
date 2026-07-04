<x-app-layout>
    <x-slot name="header">Kategori</x-slot>

    <div style="display:flex;flex-direction:column;gap:16px;">

        {{-- Header row --}}
        <div style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:12px;">
            <div>
                <p style="font-size:13px;color:var(--muted);">Kelola kategori pemasukan dan pengeluaran kamu</p>
            </div>
            <a href="{{ route('categories.create') }}" class="cd-btn cd-btn-primary">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Tambah Kategori
            </a>
        </div>

        {{-- Filter tab income/expense --}}
        <div style="display:flex;gap:8px;">
            <span style="display:inline-flex;align-items:center;gap:6px;padding:6px 14px;border-radius:99px;font-size:13px;font-weight:600;background:var(--green-bg);color:#15803d;">
                <svg xmlns="http://www.w3.org/2000/svg" style="width:14px;height:14px;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                </svg>
                {{ $categories->where('type', 'income')->count() }} Pemasukan
            </span>
            <span style="display:inline-flex;align-items:center;gap:6px;padding:6px 14px;border-radius:99px;font-size:13px;font-weight:600;background:var(--red-bg);color:#dc2626;">
                <svg xmlns="http://www.w3.org/2000/svg" style="width:14px;height:14px;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6"/>
                </svg>
                {{ $categories->where('type', 'expense')->count() }} Pengeluaran
            </span>
        </div>

        {{-- Tabel --}}
        <div class="cd-card" style="overflow:hidden;">
            <table class="cd-table">
                <thead>
                    <tr>
                        <th>Nama Kategori</th>
                        <th>Jenis</th>
                        <th style="text-align:right;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($categories as $category)
                        <tr>
                            <td style="font-weight:600;font-size:14px;">{{ $category->name }}</td>
                            <td>
                                <span class="cd-badge {{ $category->type === 'income' ? 'cd-badge-income' : 'cd-badge-expense' }}">
                                    {{ $category->type === 'income' ? 'Pemasukan' : 'Pengeluaran' }}
                                </span>
                            </td>
                            <td style="text-align:right;">
                                <div style="display:flex;justify-content:flex-end;gap:6px;">
                                    <a href="{{ route('categories.edit', $category) }}"
                                       class="cd-btn cd-btn-white cd-btn-sm">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                        Edit
                                    </a>
                                    <form action="{{ route('categories.destroy', $category) }}" method="POST"
                                          onsubmit="return confirm('Hapus kategori ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="cd-btn cd-btn-red cd-btn-sm">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" style="text-align:center;padding:48px;color:var(--muted);">
                                <svg xmlns="http://www.w3.org/2000/svg" style="width:40px;height:40px;margin:0 auto 10px;opacity:0.3;display:block;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                </svg>
                                Belum ada kategori
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>