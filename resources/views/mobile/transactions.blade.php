<x-mobile-layout>
    {{-- Header biru --}}
    <div style="background:linear-gradient(135deg,#014BAA,#0166E8);padding-top:max(20px, calc(env(safe-area-inset-top, 0px) + 14px));padding-left:20px;padding-right:20px;padding-bottom:24px;">
        <div style="font-size:13px;color:rgba(255,255,255,0.75);margin-bottom:2px;">Kelola keuangan kamu</div>
        <div style="font-size:20px;font-weight:700;color:#fff;">Transaksi</div>
    </div>

    {{-- Tab --}}
    <div style="background:#fff;padding:12px 16px;border-bottom:1px solid #F0F4F8;">
        <div style="display:flex;background:#E8F0FB;border-radius:12px;padding:4px;">
            <a href="{{ route('transactions.index', ['type' => 'income']) }}"
               style="flex:1;text-align:center;padding:9px;border-radius:9px;font-size:13px;font-weight:600;text-decoration:none;
                      {{ $activeTab === 'income' ? 'background:#014BAA;color:#fff;box-shadow:0 2px 8px rgba(1,75,170,0.25);' : 'color:#64748B;' }}">
                Pemasukan
            </a>
            <a href="{{ route('transactions.index', ['type' => 'expense']) }}"
               style="flex:1;text-align:center;padding:9px;border-radius:9px;font-size:13px;font-weight:600;text-decoration:none;
                      {{ $activeTab === 'expense' ? 'background:#014BAA;color:#fff;box-shadow:0 2px 8px rgba(1,75,170,0.25);' : 'color:#64748B;' }}">
                Pengeluaran
            </a>
        </div>
    </div>

    {{-- Summary --}}
    <div style="padding:12px 16px;">
        <div style="background:#fff;border-radius:14px;padding:14px;display:flex;justify-content:space-between;align-items:center;margin-bottom:10px;">
            <div>
                <div style="font-size:11px;font-weight:600;color:#94A3B8;text-transform:uppercase;letter-spacing:.04em;margin-bottom:4px;">
                    Total {{ $activeTab === 'income' ? 'Pemasukan' : 'Pengeluaran' }} Bulan Ini
                </div>
                <div style="font-size:20px;font-weight:800;color:{{ $activeTab === 'income' ? '#16a34a' : '#dc2626' }};">
                    Rp {{ number_format($summary['total'], 0, ',', '.') }}
                </div>
            </div>
        </div>

        <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px;margin-bottom:12px;">
            <div style="background:#fff;border-radius:12px;padding:12px;">
                <div style="font-size:10px;font-weight:600;color:#ca8a04;text-transform:uppercase;letter-spacing:.04em;margin-bottom:4px;">Tertinggi</div>
                <div style="font-size:14px;font-weight:700;color:#1E293B;">Rp {{ number_format($summary['highest'], 0, ',', '.') }}</div>
                @if ($summary['highest_category'])
                    <div style="font-size:11px;color:#94A3B8;margin-top:2px;">{{ $summary['highest_category'] }}</div>
                @endif
            </div>
            <div style="background:#fff;border-radius:12px;padding:12px;">
                <div style="font-size:10px;font-weight:600;color:#014BAA;text-transform:uppercase;letter-spacing:.04em;margin-bottom:4px;">Rata-rata/Hari</div>
                <div style="font-size:14px;font-weight:700;color:#1E293B;">Rp {{ number_format($summary['daily_avg'], 0, ',', '.') }}</div>
                <div style="font-size:11px;color:#94A3B8;margin-top:2px;">30 hari terakhir</div>
            </div>
        </div>

        {{-- Tombol tambah --}}
        @if ($activeTab === 'income')
            <button id="btn-open-income"
                    style="width:100%;padding:13px;background:#22C55E;color:#fff;border:none;border-radius:12px;font-size:14px;font-weight:700;cursor:pointer;display:flex;align-items:center;justify-content:center;gap:8px;font-family:inherit;">
                <svg xmlns="http://www.w3.org/2000/svg" style="width:18px;height:18px;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Tambah Pemasukan
            </button>
        @else
            <button id="btn-open-expense"
                    style="width:100%;padding:13px;background:#EF4444;color:#fff;border:none;border-radius:12px;font-size:14px;font-weight:700;cursor:pointer;display:flex;align-items:center;justify-content:center;gap:8px;font-family:inherit;">
                <svg xmlns="http://www.w3.org/2000/svg" style="width:18px;height:18px;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Tambah Pengeluaran
            </button>
        @endif
    </div>

    {{-- List transaksi --}}
    <div style="padding:0 16px;">
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:10px;">
            <div style="font-size:15px;font-weight:700;color:#1E293B;">Riwayat</div>
            <div style="font-size:12px;color:#94A3B8;">{{ $transactions->total() }} transaksi</div>
        </div>

        @forelse ($transactions as $tx)
            <div style="background:#fff;border-radius:12px;padding:14px;display:flex;align-items:flex-start;gap:12px;margin-bottom:8px;">
                <div style="width:40px;height:40px;border-radius:11px;display:flex;align-items:center;justify-content:center;flex-shrink:0;background:{{ $tx->type === 'income' ? '#DCFCE7' : '#FEE2E2' }};">
                    <svg xmlns="http://www.w3.org/2000/svg"
                         style="width:18px;height:18px;color:{{ $tx->type === 'income' ? '#16a34a' : '#dc2626' }};"
                         fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        @if ($tx->type === 'income')
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                        @else
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6"/>
                        @endif
                    </svg>
                </div>
                <div style="flex:1;min-width:0;">
                    <div style="font-size:14px;font-weight:600;color:#1E293B;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                        {{ $tx->category->name }}
                    </div>
                    <div style="font-size:12px;color:#94A3B8;margin-top:2px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                        {{ $tx->account->name }}@if ($tx->description) · {{ $tx->description }}@endif · {{ $tx->transaction_date->format('d M') }}
                    </div>
                    <div style="display:flex;gap:6px;margin-top:6px;">
                        <a href="{{ route('transactions.edit', $tx) }}"
                           style="font-size:11px;color:#014BAA;font-weight:700;text-decoration:none;padding:3px 10px;background:#E8F0FB;border-radius:6px;">
                            Edit
                        </a>
                        <form action="{{ route('transactions.destroy', $tx) }}" method="POST"
                              onsubmit="return confirm('Hapus transaksi ini?')" style="display:inline;">
                            @csrf @method('DELETE')
                            <button type="submit"
                                    style="font-size:11px;color:#EF4444;font-weight:700;background:#FEE2E2;border:none;cursor:pointer;padding:3px 10px;border-radius:6px;font-family:inherit;">
                                Hapus
                            </button>
                        </form>
                    </div>
                </div>
                <div style="font-size:14px;font-weight:700;color:{{ $tx->type === 'income' ? '#16a34a' : '#dc2626' }};flex-shrink:0;text-align:right;">
                    {{ $tx->type === 'income' ? '+' : '-' }}Rp {{ number_format($tx->amount, 0, ',', '.') }}
                </div>
            </div>
        @empty
            <div style="text-align:center;padding:40px 20px;color:#94A3B8;">
                <svg xmlns="http://www.w3.org/2000/svg" style="width:40px;height:40px;margin:0 auto 10px;opacity:0.3;display:block;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
                <div style="font-size:15px;font-weight:600;margin-bottom:4px;">Belum ada transaksi</div>
                <div style="font-size:13px;">Tap tombol di atas untuk mulai mencatat</div>
            </div>
        @endforelse

        {{-- Pagination --}}
        @if ($transactions->hasPages())
            <div style="display:flex;justify-content:center;align-items:center;gap:10px;padding:16px 0;">
                @if (!$transactions->onFirstPage())
                    <a href="{{ $transactions->previousPageUrl() }}"
                       style="padding:8px 16px;border-radius:8px;background:#014BAA;color:#fff;font-size:13px;font-weight:600;text-decoration:none;">
                        ← Prev
                    </a>
                @else
                    <span style="padding:8px 16px;border-radius:8px;background:#F0F4F8;color:#94A3B8;font-size:13px;">← Prev</span>
                @endif

                <span style="font-size:13px;font-weight:600;color:#1E293B;">
                    {{ $transactions->currentPage() }}/{{ $transactions->lastPage() }}
                </span>

                @if ($transactions->hasMorePages())
                    <a href="{{ $transactions->nextPageUrl() }}"
                       style="padding:8px 16px;border-radius:8px;background:#014BAA;color:#fff;font-size:13px;font-weight:600;text-decoration:none;">
                        Next →
                    </a>
                @else
                    <span style="padding:8px 16px;border-radius:8px;background:#F0F4F8;color:#94A3B8;font-size:13px;">Next →</span>
                @endif
            </div>
        @endif
    </div>

    <div style="height:16px;"></div>

    {{-- Sheet Pemasukan --}}
    <div id="sheet-income"
         style="display:none;position:fixed;inset:0;background:rgba(15,23,42,0.6);z-index:9999;align-items:flex-end;justify-content:center;">
        <div style="background:#fff;border-radius:24px 24px 0 0;padding:12px 20px 40px;width:100%;max-height:90vh;overflow-y:auto;">
            <div style="width:40px;height:4px;background:#E2E8F0;border-radius:99px;margin:0 auto 16px;"></div>
            <h3 style="font-size:17px;font-weight:700;color:#1E293B;margin-bottom:20px;">Catat Pemasukan</h3>
            <form action="{{ route('transactions.store-income') }}" method="POST">
                @csrf
                <div style="margin-bottom:14px;">
                    <label style="display:block;font-size:13px;font-weight:600;color:#1E293B;margin-bottom:6px;">Rekening</label>
                    <select name="account_id" style="width:100%;padding:12px 14px;border:1.5px solid #E2E8F0;border-radius:10px;font-size:14px;color:#1E293B;background:#fff;outline:none;font-family:inherit;">
                        <option value="">-- Pilih Rekening --</option>
                        @foreach ($accounts as $account)
                            <option value="{{ $account->id }}">{{ $account->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div style="margin-bottom:14px;">
                    <label style="display:block;font-size:13px;font-weight:600;color:#1E293B;margin-bottom:6px;">Kategori</label>
                    <select name="category_id" style="width:100%;padding:12px 14px;border:1.5px solid #E2E8F0;border-radius:10px;font-size:14px;color:#1E293B;background:#fff;outline:none;font-family:inherit;">
                        <option value="">-- Pilih Kategori --</option>
                        @foreach ($incomeCategories as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div style="margin-bottom:14px;">
                    <label style="display:block;font-size:13px;font-weight:600;color:#1E293B;margin-bottom:6px;">Jumlah</label>
                    <input type="number" name="amount" placeholder="Rp 0" min="1"
                           style="width:100%;padding:12px 14px;border:1.5px solid #E2E8F0;border-radius:10px;font-size:14px;color:#1E293B;background:#fff;outline:none;font-family:inherit;">
                </div>
                <div style="margin-bottom:14px;">
                    <label style="display:block;font-size:13px;font-weight:600;color:#1E293B;margin-bottom:6px;">Tanggal</label>
                    <input type="date" name="transaction_date" value="{{ date('Y-m-d') }}"
                           style="width:100%;padding:12px 14px;border:1.5px solid #E2E8F0;border-radius:10px;font-size:14px;color:#1E293B;background:#fff;outline:none;font-family:inherit;">
                </div>
                <div style="margin-bottom:20px;">
                    <label style="display:block;font-size:13px;font-weight:600;color:#1E293B;margin-bottom:6px;">Catatan (opsional)</label>
                    <input type="text" name="description" placeholder="Tulis catatan..."
                           style="width:100%;padding:12px 14px;border:1.5px solid #E2E8F0;border-radius:10px;font-size:14px;color:#1E293B;background:#fff;outline:none;font-family:inherit;">
                </div>
                <button type="submit"
                        style="width:100%;padding:14px;background:#22C55E;color:#fff;border:none;border-radius:12px;font-size:15px;font-weight:700;cursor:pointer;font-family:inherit;margin-bottom:8px;">
                    Simpan Pemasukan
                </button>
                <button type="button" onclick="closeSheet('sheet-income')"
                        style="width:100%;padding:13px;background:#fff;color:#1E293B;border:1.5px solid #E2E8F0;border-radius:12px;font-size:14px;font-weight:600;cursor:pointer;font-family:inherit;">
                    Batal
                </button>
            </form>
        </div>
    </div>

    {{-- Sheet Pengeluaran --}}
    <div id="sheet-expense"
         style="display:none;position:fixed;inset:0;background:rgba(15,23,42,0.6);z-index:9999;align-items:flex-end;justify-content:center;">
        <div style="background:#fff;border-radius:24px 24px 0 0;padding:12px 20px 40px;width:100%;max-height:90vh;overflow-y:auto;">
            <div style="width:40px;height:4px;background:#E2E8F0;border-radius:99px;margin:0 auto 16px;"></div>
            <h3 style="font-size:17px;font-weight:700;color:#1E293B;margin-bottom:20px;">Catat Pengeluaran</h3>
            <form action="{{ route('transactions.store-expense') }}" method="POST">
                @csrf
                <div style="margin-bottom:14px;">
                    <label style="display:block;font-size:13px;font-weight:600;color:#1E293B;margin-bottom:6px;">Rekening</label>
                    <select name="account_id" style="width:100%;padding:12px 14px;border:1.5px solid #E2E8F0;border-radius:10px;font-size:14px;color:#1E293B;background:#fff;outline:none;font-family:inherit;">
                        <option value="">-- Pilih Rekening --</option>
                        @foreach ($accounts as $account)
                            <option value="{{ $account->id }}">{{ $account->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div style="margin-bottom:14px;">
                    <label style="display:block;font-size:13px;font-weight:600;color:#1E293B;margin-bottom:6px;">Kategori</label>
                    <select name="category_id" style="width:100%;padding:12px 14px;border:1.5px solid #E2E8F0;border-radius:10px;font-size:14px;color:#1E293B;background:#fff;outline:none;font-family:inherit;">
                        <option value="">-- Pilih Kategori --</option>
                        @foreach ($expenseCategories as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div style="margin-bottom:14px;">
                    <label style="display:block;font-size:13px;font-weight:600;color:#1E293B;margin-bottom:6px;">Jumlah</label>
                    <input type="number" name="amount" placeholder="Rp 0" min="1"
                           style="width:100%;padding:12px 14px;border:1.5px solid #E2E8F0;border-radius:10px;font-size:14px;color:#1E293B;background:#fff;outline:none;font-family:inherit;">
                </div>
                <div style="margin-bottom:14px;">
                    <label style="display:block;font-size:13px;font-weight:600;color:#1E293B;margin-bottom:6px;">Tanggal</label>
                    <input type="date" name="transaction_date" value="{{ date('Y-m-d') }}"
                           style="width:100%;padding:12px 14px;border:1.5px solid #E2E8F0;border-radius:10px;font-size:14px;color:#1E293B;background:#fff;outline:none;font-family:inherit;">
                </div>
                <div style="margin-bottom:20px;">
                    <label style="display:block;font-size:13px;font-weight:600;color:#1E293B;margin-bottom:6px;">Catatan (opsional)</label>
                    <input type="text" name="description" placeholder="Tulis catatan..."
                           style="width:100%;padding:12px 14px;border:1.5px solid #E2E8F0;border-radius:10px;font-size:14px;color:#1E293B;background:#fff;outline:none;font-family:inherit;">
                </div>
                <button type="submit"
                        style="width:100%;padding:14px;background:#EF4444;color:#fff;border:none;border-radius:12px;font-size:15px;font-weight:700;cursor:pointer;font-family:inherit;margin-bottom:8px;">
                    Simpan Pengeluaran
                </button>
                <button type="button" onclick="closeSheet('sheet-expense')"
                        style="width:100%;padding:13px;background:#fff;color:#1E293B;border:1.5px solid #E2E8F0;border-radius:12px;font-size:14px;font-weight:600;cursor:pointer;font-family:inherit;">
                    Batal
                </button>
            </form>
        </div>
    </div>

    @push('scripts')
    <script>
        function openSheet(id) {
            const el = document.getElementById(id);
            el.style.display = 'flex';
            document.body.style.overflow = 'hidden';
        }

        function closeSheet(id) {
            document.getElementById(id).style.display = 'none';
            document.body.style.overflow = '';
        }

        // Tutup kalau tap overlay
        ['sheet-income', 'sheet-expense'].forEach(id => {
            const el = document.getElementById(id);
            if (el) {
                el.addEventListener('click', e => {
                    if (e.target === el) closeSheet(id);
                });
            }
        });

        // Bind tombol
        document.addEventListener('DOMContentLoaded', () => {
            const btnI = document.getElementById('btn-open-income');
            const btnE = document.getElementById('btn-open-expense');
            if (btnI) btnI.addEventListener('click', () => openSheet('sheet-income'));
            if (btnE) btnE.addEventListener('click', () => openSheet('sheet-expense'));
        });
    </script>
    @endpush
</x-mobile-layout>