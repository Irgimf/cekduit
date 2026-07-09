<x-mobile-layout>
    {{-- Header --}}
    <div style="background:linear-gradient(135deg,#014BAA,#0166E8);padding-top:max(20px, calc(env(safe-area-inset-top, 0px) + 14px));padding-left:20px;padding-right:20px;padding-bottom:24px;display:flex;align-items:center;justify-content:space-between;">
        <div>
            <div style="font-size:13px;color:rgba(255,255,255,0.75);margin-bottom:2px;">Kelola transaksi kamu</div>
            <div style="font-size:20px;font-weight:700;color:#fff;">Kategori</div>
        </div>
        <a href="{{ route('categories.create') }}"
           style="width:36px;height:36px;background:rgba(255,255,255,0.2);border-radius:10px;display:flex;align-items:center;justify-content:center;text-decoration:none;flex-shrink:0;">
            <svg xmlns="http://www.w3.org/2000/svg" style="width:18px;height:18px;" fill="none" viewBox="0 0 24 24" stroke="white">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
        </a>
    </div>

    {{-- Ringkasan --}}
    <div style="padding:12px 16px;">
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px;">
            <div style="background:#fff;border-radius:12px;padding:14px;">
                <div style="font-size:10px;font-weight:600;color:#16a34a;text-transform:uppercase;letter-spacing:.04em;margin-bottom:4px;">Pemasukan</div>
                <div style="font-size:20px;font-weight:800;color:#1E293B;">{{ $categories->where('type','income')->count() }}</div>
                <div style="font-size:11px;color:#94A3B8;margin-top:2px;">kategori</div>
            </div>
            <div style="background:#fff;border-radius:12px;padding:14px;">
                <div style="font-size:10px;font-weight:600;color:#dc2626;text-transform:uppercase;letter-spacing:.04em;margin-bottom:4px;">Pengeluaran</div>
                <div style="font-size:20px;font-weight:800;color:#1E293B;">{{ $categories->where('type','expense')->count() }}</div>
                <div style="font-size:11px;color:#94A3B8;margin-top:2px;">kategori</div>
            </div>
        </div>
    </div>

    {{-- Tombol Tambah --}}
    <div style="padding:0 16px 12px;">
        <a href="{{ route('categories.create') }}"
           style="display:flex;align-items:center;gap:10px;padding:14px 16px;background:#fff;border-radius:14px;border:2px dashed #E2E8F0;text-decoration:none;">
            <div style="width:36px;height:36px;background:#E8F0FB;border-radius:10px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                <svg xmlns="http://www.w3.org/2000/svg" style="width:18px;height:18px;color:#014BAA;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
            </div>
            <div>
                <div style="font-size:14px;font-weight:700;color:#014BAA;">Tambah Kategori Baru</div>
                <div style="font-size:12px;color:#94A3B8;margin-top:1px;">Pemasukan atau Pengeluaran</div>
            </div>
        </a>
    </div>

    {{-- List Pemasukan --}}
    @if ($categories->where('type','income')->count() > 0)
    <div style="padding:0 16px 12px;">
        <div style="font-size:13px;font-weight:700;color:#16a34a;margin-bottom:8px;display:flex;align-items:center;gap:6px;">
            <svg xmlns="http://www.w3.org/2000/svg" style="width:14px;height:14px;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
            </svg>
            PEMASUKAN
        </div>

        @foreach ($categories->where('type','income') as $category)
        <div style="background:#fff;border-radius:12px;padding:14px 16px;margin-bottom:8px;display:flex;align-items:center;gap:12px;">
            <div style="width:40px;height:40px;background:#DCFCE7;border-radius:11px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                <svg xmlns="http://www.w3.org/2000/svg" style="width:18px;height:18px;color:#16a34a;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                </svg>
            </div>
            <div style="flex:1;">
                <div style="font-size:14px;font-weight:600;color:#1E293B;">{{ $category->name }}</div>
            </div>
            <div style="display:flex;gap:6px;">
                <a href="{{ route('categories.edit', $category) }}"
                   style="padding:6px 12px;background:#E8F0FB;border-radius:8px;font-size:12px;font-weight:600;color:#014BAA;text-decoration:none;">
                    Edit
                </a>
                <form action="{{ route('categories.destroy', $category) }}" method="POST"
                      onsubmit="return confirm('Hapus kategori {{ $category->name }}?')" style="display:inline;">
                    @csrf @method('DELETE')
                    <button type="submit"
                            style="padding:6px 12px;background:#FEE2E2;border-radius:8px;font-size:12px;font-weight:600;color:#dc2626;border:none;cursor:pointer;font-family:inherit;">
                        Hapus
                    </button>
                </form>
            </div>
        </div>
        @endforeach
    </div>
    @endif

    {{-- List Pengeluaran --}}
    @if ($categories->where('type','expense')->count() > 0)
    <div style="padding:0 16px 12px;">
        <div style="font-size:13px;font-weight:700;color:#dc2626;margin-bottom:8px;display:flex;align-items:center;gap:6px;">
            <svg xmlns="http://www.w3.org/2000/svg" style="width:14px;height:14px;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6"/>
            </svg>
            PENGELUARAN
        </div>

        @foreach ($categories->where('type','expense') as $category)
        <div style="background:#fff;border-radius:12px;padding:14px 16px;margin-bottom:8px;display:flex;align-items:center;gap:12px;">
            <div style="width:40px;height:40px;background:#FEE2E2;border-radius:11px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                <svg xmlns="http://www.w3.org/2000/svg" style="width:18px;height:18px;color:#dc2626;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                </svg>
            </div>
            <div style="flex:1;">
                <div style="font-size:14px;font-weight:600;color:#1E293B;">{{ $category->name }}</div>
            </div>
            <div style="display:flex;gap:6px;">
                <a href="{{ route('categories.edit', $category) }}"
                   style="padding:6px 12px;background:#E8F0FB;border-radius:8px;font-size:12px;font-weight:600;color:#014BAA;text-decoration:none;">
                    Edit
                </a>
                <form action="{{ route('categories.destroy', $category) }}" method="POST"
                      onsubmit="return confirm('Hapus kategori {{ $category->name }}?')" style="display:inline;">
                    @csrf @method('DELETE')
                    <button type="submit"
                            style="padding:6px 12px;background:#FEE2E2;border-radius:8px;font-size:12px;font-weight:600;color:#dc2626;border:none;cursor:pointer;font-family:inherit;">
                        Hapus
                    </button>
                </form>
            </div>
        </div>
        @endforeach
    </div>
    @endif

    @if ($categories->isEmpty())
    <div style="text-align:center;padding:40px 20px;color:#94A3B8;">
        <svg xmlns="http://www.w3.org/2000/svg" style="width:40px;height:40px;margin:0 auto 10px;opacity:0.3;display:block;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
        </svg>
        <div style="font-size:15px;font-weight:600;margin-bottom:4px;">Belum ada kategori</div>
        <div style="font-size:13px;">Tap tombol di atas untuk menambahkan</div>
    </div>
    @endif

    <div style="height:16px;"></div>
</x-mobile-layout>