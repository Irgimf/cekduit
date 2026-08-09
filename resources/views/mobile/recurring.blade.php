<x-mobile-layout>
    <div style="background:linear-gradient(135deg,#014BAA,#0166E8);padding-top:max(20px,calc(env(safe-area-inset-top,0px) + 16px));padding-left:20px;padding-right:20px;padding-bottom:24px;">
        <div style="font-size:13px;color:rgba(255,255,255,0.75);margin-bottom:2px;">⭐ Fitur Premium</div>
        <div style="font-size:20px;font-weight:700;color:#fff;">Transaksi Berulang</div>
    </div>

    <div style="padding:16px;display:flex;flex-direction:column;gap:14px;">

        {{-- Form tambah --}}
        <div style="background:#fff;border-radius:14px;padding:16px;">
            <div style="font-size:14px;font-weight:700;color:#1E293B;margin-bottom:14px;">Tambah Baru</div>
            <form action="{{ route('recurring.store') }}" method="POST"
                  style="display:flex;flex-direction:column;gap:12px;">
                @csrf

                <div>
                    <label style="display:block;font-size:13px;font-weight:600;color:#1E293B;margin-bottom:5px;">Jenis</label>
                    <select name="type" id="mobile-type" class="mobile-select" onchange="updateMobileCategories()">
                        <option value="income">Pemasukan</option>
                        <option value="expense">Pengeluaran</option>
                    </select>
                </div>

                <div>
                    <label style="display:block;font-size:13px;font-weight:600;color:#1E293B;margin-bottom:5px;">Rekening</label>
                    <select name="account_id" class="mobile-select">
                        <option value="">-- Pilih --</option>
                        @foreach ($accounts as $acc)
                            <option value="{{ $acc->id }}">{{ $acc->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label style="display:block;font-size:13px;font-weight:600;color:#1E293B;margin-bottom:5px;">Kategori</label>
                    <select name="category_id" id="mobile-category" class="mobile-select">
                        <optgroup label="Pemasukan" id="income-cats">
                            @foreach ($incomeCategories as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                            @endforeach
                        </optgroup>
                        <optgroup label="Pengeluaran" id="expense-cats" style="display:none;">
                            @foreach ($expenseCategories as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                            @endforeach
                        </optgroup>
                    </select>
                </div>

                <div>
                    <label style="display:block;font-size:13px;font-weight:600;color:#1E293B;margin-bottom:5px;">Jumlah</label>
                    <div style="position:relative;">
                        <span style="position:absolute;left:12px;top:50%;transform:translateY(-50%);font-size:13px;color:#94A3B8;font-weight:500;">Rp</span>
                        <input type="number" name="amount" min="1" class="mobile-input"
                               style="padding-left:36px;" placeholder="500.000">
                    </div>
                </div>

                <div>
                    <label style="display:block;font-size:13px;font-weight:600;color:#1E293B;margin-bottom:5px;">Deskripsi (opsional)</label>
                    <input type="text" name="description" class="mobile-input" placeholder="Gaji, tagihan listrik, dll">
                </div>

                <div>
                    <label style="display:block;font-size:13px;font-weight:600;color:#1E293B;margin-bottom:5px;">Frekuensi</label>
                    <select name="frequency" class="mobile-select">
                        <option value="daily">Setiap Hari</option>
                        <option value="weekly">Setiap Minggu</option>
                        <option value="monthly" selected>Setiap Bulan</option>
                    </select>
                </div>

                <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px;">
                    <div>
                        <label style="display:block;font-size:13px;font-weight:600;color:#1E293B;margin-bottom:5px;">Mulai</label>
                        <input type="date" name="start_date" value="{{ date('Y-m-d') }}" class="mobile-input">
                    </div>
                    <div>
                        <label style="display:block;font-size:13px;font-weight:600;color:#1E293B;margin-bottom:5px;">Berakhir</label>
                        <input type="date" name="end_date" class="mobile-input">
                    </div>
                </div>

                <button type="submit"
                        style="width:100%;padding:14px;background:#014BAA;color:#fff;border:none;border-radius:12px;font-size:14px;font-weight:700;cursor:pointer;font-family:inherit;">
                    + Tambah Transaksi Berulang
                </button>
            </form>
        </div>

        {{-- Daftar --}}
        @forelse ($recurrings as $item)
        <div style="background:#fff;border-radius:14px;padding:16px;{{ ! $item->is_active ? 'opacity:0.6;' : '' }}">
            <div style="display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:10px;">
                <div style="flex:1;min-width:0;">
                    <div style="font-size:14px;font-weight:700;color:#1E293B;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                        {{ $item->description ?: $item->category->name }}
                    </div>
                    <div style="font-size:12px;color:#94A3B8;margin-top:2px;">
                        {{ $item->account->name }} · {{ $item->frequencyLabel() }}
                    </div>
                </div>
                <div style="text-align:right;flex-shrink:0;margin-left:10px;">
                    <div style="font-size:15px;font-weight:800;color:{{ $item->type === 'income' ? '#16a34a' : '#dc2626' }};">
                        {{ $item->type === 'income' ? '+' : '-' }}Rp {{ number_format($item->amount, 0, ',', '.') }}
                    </div>
                    <div style="font-size:11px;color:#94A3B8;margin-top:2px;">
                        Berikutnya: {{ $item->next_run_at->format('d M') }}
                    </div>
                </div>
            </div>

            <div style="display:flex;gap:8px;">
                <form action="{{ route('recurring.toggle', $item) }}" method="POST" style="flex:1;">
                    @csrf @method('PATCH')
                    <button type="submit"
                            style="width:100%;padding:8px;background:#E8F0FB;color:#014BAA;border:none;border-radius:8px;font-size:12px;font-weight:700;cursor:pointer;font-family:inherit;">
                        {{ $item->is_active ? '⏸ Jeda' : '▶ Aktifkan' }}
                    </button>
                </form>
                <form action="{{ route('recurring.destroy', $item) }}" method="POST"
                      onsubmit="cdConfirm('Hapus transaksi berulang ini?', this); return false;" style="flex:1;">
                    @csrf @method('DELETE')
                    <button type="submit"
                            style="width:100%;padding:8px;background:#FEE2E2;color:#dc2626;border:none;border-radius:8px;font-size:12px;font-weight:700;cursor:pointer;font-family:inherit;">
                        Hapus
                    </button>
                </form>
            </div>
        </div>
        @empty
        <div style="text-align:center;padding:40px 20px;color:#94A3B8;">
            <div style="font-size:40px;margin-bottom:12px;"><x-heroicon-o-arrow-path class="w-5 h-5 inline text-blue-500" /></div>
            <div style="font-size:15px;font-weight:600;margin-bottom:4px;color:#64748B;">Belum ada transaksi berulang</div>
            <div style="font-size:13px;">Tambahkan di atas untuk transaksi rutin otomatis</div>
        </div>
        @endforelse

    </div>
    <div style="height:16px;"></div>

    @push('scripts')
    <script>
        function updateMobileCategories() {
            const type = document.getElementById('mobile-type').value;
            document.getElementById('income-cats').style.display  = type === 'income'  ? '' : 'none';
            document.getElementById('expense-cats').style.display = type === 'expense' ? '' : 'none';
        }
    </script>
    @endpush
</x-mobile-layout>