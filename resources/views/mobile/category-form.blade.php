<x-mobile-layout>
    {{-- Header --}}
    <div style="background:linear-gradient(135deg,#014BAA,#0166E8);padding-top:max(16px, calc(env(safe-area-inset-top, 0px) + 14px));padding-left:20px;padding-right:20px;padding-bottom:20px;display:flex;align-items:center;gap:12px;">
        <a href="{{ route('categories.index') }}"
           style="width:36px;height:36px;background:rgba(255,255,255,0.2);border-radius:10px;display:flex;align-items:center;justify-content:center;text-decoration:none;flex-shrink:0;">
            <svg xmlns="http://www.w3.org/2000/svg" style="width:18px;height:18px;" fill="none" viewBox="0 0 24 24" stroke="white">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
        </a>
        <div style="font-size:18px;font-weight:700;color:#fff;">
            {{ isset($category) ? 'Edit Kategori' : 'Tambah Kategori' }}
        </div>
    </div>

    <div style="padding:16px;">
        <div style="background:#fff;border-radius:16px;padding:20px;">
            <form action="{{ isset($category) ? route('categories.update', $category) : route('categories.store') }}"
                  method="POST" style="display:flex;flex-direction:column;gap:16px;">
                @csrf
                @if (isset($category)) @method('PUT') @endif

                <div>
                    <label style="display:block;font-size:13px;font-weight:600;color:#1E293B;margin-bottom:6px;">Nama Kategori</label>
                    <input type="text" name="name"
                           value="{{ old('name', isset($category) ? $category->name : '') }}"
                           placeholder="Contoh: Gaji, Makan, Transportasi"
                           style="width:100%;padding:12px 14px;border:1.5px solid #E2E8F0;border-radius:10px;font-size:14px;color:#1E293B;background:#fff;outline:none;font-family:inherit;">
                    @error('name')
                        <div style="font-size:12px;color:#EF4444;margin-top:4px;">{{ $message }}</div>
                    @enderror
                </div>

                <div>
                    <label style="display:block;font-size:13px;font-weight:600;color:#1E293B;margin-bottom:10px;">Jenis Kategori</label>
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px;">
                        <label style="cursor:pointer;">
                            <input type="radio" name="type" value="income"
                                   {{ old('type', isset($category) ? $category->type : '') === 'income' ? 'checked' : '' }}
                                   style="display:none;" class="type-radio">
                            <div class="type-option" data-value="income"
                                 style="padding:14px;border-radius:12px;border:2px solid #E2E8F0;text-align:center;transition:all 0.15s;
                                        {{ old('type', isset($category) ? $category->type : '') === 'income' ? 'border-color:#16a34a;background:#DCFCE7;' : '' }}">
                                <div style="font-size:22px;margin-bottom:6px;">📈</div>
                                <div style="font-size:13px;font-weight:700;color:#16a34a;">Pemasukan</div>
                            </div>
                        </label>
                        <label style="cursor:pointer;">
                            <input type="radio" name="type" value="expense"
                                   {{ old('type', isset($category) ? $category->type : '') === 'expense' ? 'checked' : '' }}
                                   style="display:none;" class="type-radio">
                            <div class="type-option" data-value="expense"
                                 style="padding:14px;border-radius:12px;border:2px solid #E2E8F0;text-align:center;transition:all 0.15s;
                                        {{ old('type', isset($category) ? $category->type : '') === 'expense' ? 'border-color:#dc2626;background:#FEE2E2;' : '' }}">
                                <div style="font-size:22px;margin-bottom:6px;">📉</div>
                                <div style="font-size:13px;font-weight:700;color:#dc2626;">Pengeluaran</div>
                            </div>
                        </label>
                    </div>
                    @error('type')
                        <div style="font-size:12px;color:#EF4444;margin-top:4px;">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit"
                        style="width:100%;padding:14px;background:#014BAA;color:#fff;border:none;border-radius:12px;font-size:15px;font-weight:700;cursor:pointer;font-family:inherit;margin-top:4px;">
                    {{ isset($category) ? 'Simpan Perubahan' : 'Tambah Kategori' }}
                </button>

                <a href="{{ route('categories.index') }}"
                   style="display:block;text-align:center;padding:12px;background:#F0F4F8;border-radius:12px;font-size:14px;font-weight:600;color:#64748B;text-decoration:none;">
                    Batal
                </a>
            </form>
        </div>
    </div>

    @push('scripts')
    <script>
        // Visual feedback saat pilih jenis
        document.querySelectorAll('.type-radio').forEach(radio => {
            radio.addEventListener('change', () => {
                // Reset semua
                document.querySelectorAll('.type-option').forEach(opt => {
                    opt.style.borderColor = '#E2E8F0';
                    opt.style.background = '';
                });
                // Highlight yang dipilih
                const selected = radio.nextElementSibling;
                if (radio.value === 'income') {
                    selected.style.borderColor = '#16a34a';
                    selected.style.background = '#DCFCE7';
                } else {
                    selected.style.borderColor = '#dc2626';
                    selected.style.background = '#FEE2E2';
                }
            });
        });
    </script>
    @endpush
</x-mobile-layout>