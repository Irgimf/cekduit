<x-app-layout>
    <x-slot name="header">
        <div style="display:flex;align-items:center;gap:12px;">
            <a href="{{ route('categories.index') }}" class="cd-btn cd-btn-white cd-btn-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>
            <h1 class="cd-page-title">Tambah Kategori</h1>
        </div>
    </x-slot>

    <div style="max-width:480px;">
        <div class="cd-card" style="padding:28px;">
            <form action="{{ route('categories.store') }}" method="POST"
                  style="display:flex;flex-direction:column;gap:18px;">
                @csrf
                <div>
                    <label class="cd-label">Nama Kategori</label>
                    <input type="text" name="name" value="{{ old('name') }}"
                           class="cd-input" placeholder="Contoh: Gaji, Makan, Transportasi">
                    @error('name') <p class="cd-error">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="cd-label">Jenis</label>
                    <select name="type" class="cd-input">
                        <option value="income" @selected(old('type') == 'income')>Pemasukan</option>
                        <option value="expense" @selected(old('type') == 'expense')>Pengeluaran</option>
                    </select>
                    @error('type') <p class="cd-error">{{ $message }}</p> @enderror
                </div>
                <div style="display:flex;gap:10px;justify-content:flex-end;">
                    <a href="{{ route('categories.index') }}" class="cd-btn cd-btn-white">Batal</a>
                    <button type="submit" class="cd-btn cd-btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>