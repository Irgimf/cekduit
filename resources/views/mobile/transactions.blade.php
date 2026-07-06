<x-mobile-layout>
    {{-- Header --}}
    <div class="mobile-page-header">
        <div style="flex:1;">
            <div style="color:rgba(255,255,255,0.75);font-size:12px;font-weight:500;margin-bottom:2px;">Kelola keuangan kamu</div>
            <div class="mobile-page-title">Transaksi</div>
        </div>
    </div>

    {{-- Tab --}}
    <div style="background:#fff;padding:12px 16px 0;">
        <div class="mobile-tab-bar" style="margin:0;">
            <a href="{{ route('transactions.index', ['type' => 'income']) }}"
               class="mobile-tab {{ $activeTab === 'income' ? 'active' : '' }}">
                Pemasukan
            </a>
            <a href="{{ route('transactions.index', ['type' => 'expense']) }}"
               class="mobile-tab {{ $activeTab === 'expense' ? 'active' : '' }}">
                Pengeluaran
            </a>
        </div>
    </div>

    {{-- Summary Card --}}
    <div style="padding:12px 16px;">
        <div style="background:linear-gradient(135deg,#014BAA,#0166E8);border-radius:16px;padding:16px;color:#fff;display:flex;justify-content:space-between;align-items:center;">
            <div>
                <div style="font-size:11px;opacity:0.75;font-weight:500;margin-bottom:4px;">
                    Total {{ $activeTab === 'income' ? 'Pemasukan' : 'Pengeluaran' }} Bulan Ini
                </div>
                <div style="font-size:22px;font-weight:800;">
                    Rp {{ number_format($summary['total'], 0, ',', '.') }}
                </div>
            </div>
            <div style="width:44px;height:44px;background:rgba(255,255,255,0.15);border-radius:12px;display:flex;align-items:center;justify-content:center;">
                <svg xmlns="http://www.w3.org/2000/svg" style="width:22px;height:22px;" fill="none" viewBox="0 0 24 24" stroke="white">
                    @if ($activeTab === 'income')
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                    @else
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6"/>
                    @endif
                </svg>
            </div>
        </div>
    </div>

    {{-- Mini Stats --}}
    <div style="padding:0 16px 12px;display:grid;grid-template-columns:1fr 1fr;gap:10px;">
        <div class="mobile-stat-card">
            <div class="mobile-stat-label" style="color:#ca8a04;">Tertinggi</div>
            <div class="mobile-stat-value" style="font-size:14px;">
                Rp {{ number_format($summary['highest'], 0, ',', '.') }}
            </div>
            @if ($summary['highest_category'])
                <div style="font-size:11px;color:#94A3B8;margin-top:2px;">{{ $summary['highest_category'] }}</div>
            @endif
        </div>
        <div class="mobile-stat-card">
            <div class="mobile-stat-label" style="color:#014BAA;">Rata-rata/Hari</div>
            <div class="mobile-stat-value" style="font-size:14px;">
                Rp {{ number_format($summary['daily_avg'], 0, ',', '.') }}
            </div>
            <div style="font-size:11px;color:#94A3B8;margin-top:2px;">30 hari terakhir</div>
        </div>
    </div>

    {{-- Tombol Tambah --}}
    <div style="padding:0 16px 12px;">
        @if ($activeTab === 'income')
            <button onclick="openSheet('sheet-income')" class="mobile-btn mobile-btn-green">
                <svg xmlns="http://www.w3.org/2000/svg" style="width:18px;height:18px;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Tambah Pemasukan
            </button>
        @else
            <button onclick="openSheet('sheet-expense')" class="mobile-btn mobile-btn-red">
                <svg xmlns="http://www.w3.org/2000/svg" style="width:18px;height:18px;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Tambah Pengeluaran
            </button>
        @endif
    </div>

    {{-- List Transaksi --}}
    <div class="mobile-section" style="margin-top:0;">
        <div class="mobile-section-header">
            <span class="mobile-section-title">Riwayat</span>
            <span style="font-size:12px;color:#94A3B8;">{{ $transactions->total() }} transaksi</span>
        </div>

        @forelse ($transactions as $tx)
            <div class="mobile-tx-card" style="position:relative;">
                <div class="mobile-tx-icon"
                     style="background:{{ $tx->type === 'income' ? '#DCFCE7' : '#FEE2E2' }};">
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
                <div class="mobile-tx-info">
                    <div class="mobile-tx-name">{{ $tx->category->name }}</div>
                    <div class="mobile-tx-sub">
                        {{ $tx->account->name }}
                        @if ($tx->description) · {{ $tx->description }} @endif
                        · {{ $tx->transaction_date->format('d M') }}
                    </div>
                </div>
                <div>
                    <div class="mobile-tx-amount"
                         style="color:{{ $tx->type === 'income' ? '#16a34a' : '#dc2626' }};text-align:right;">
                        {{ $tx->type === 'income' ? '+' : '-' }}Rp {{ number_format($tx->amount, 0, ',', '.') }}
                    </div>
                    
                    {{-- Aksi Transaksi Compact --}}
                    <div style="display:flex;gap:6px;justify-content:flex-end;margin-top:6px;">
                        <a href="{{ route('transactions.edit', $tx) }}"
                           style="font-size:11px;color:#014BAA;font-weight:700;text-decoration:none;padding:4px 10px;background:#E8F0FB;border-radius:6px;">
                            Edit
                        </a>
                        <form action="{{ route('transactions.destroy', $tx) }}" method="POST"
                              onsubmit="return confirm('Hapus?')" style="display:inline;">
                            @csrf @method('DELETE')
                            <button type="submit"
                                    style="font-size:11px;color:#EF4444;font-weight:700;background:#FEE2E2;border:none;cursor:pointer;padding:4px 10px;border-radius:6px;">
                                Hapus
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="mobile-empty">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
                <div class="mobile-empty-title">Belum ada transaksi</div>
                <div class="mobile-empty-sub">Tap tombol di atas untuk mulai mencatat</div>
            </div>
        @endforelse

        {{-- Pagination --}}
        @if ($transactions->hasPages())
            <div style="display:flex;justify-content:center;gap:8px;padding:16px 0;">
                @if ($transactions->onFirstPage())
                    <span style="padding:8px 14px;border-radius:8px;background:#F0F4F8;color:#94A3B8;font-size:13px;">←</span>
                @else
                    <a href="{{ $transactions->previousPageUrl() }}"
                       style="padding:8px 14px;border-radius:8px;background:#014BAA;color:#fff;font-size:13px;text-decoration:none;">←</a>
                @endif

                <span style="padding:8px 14px;border-radius:8px;background:#fff;color:#1E293B;font-size:13px;font-weight:600;">
                    {{ $transactions->currentPage() }} / {{ $transactions->lastPage() }}
                </span>

                @if ($transactions->hasMorePages())
                    <a href="{{ $transactions->nextPageUrl() }}"
                       style="padding:8px 14px;border-radius:8px;background:#014BAA;color:#fff;font-size:13px;text-decoration:none;">→</a>
                @else
                    <span style="padding:8px 14px;border-radius:8px;background:#F0F4F8;color:#94A3B8;font-size:13px;">→</span>
                @endif
            </div>
        @endif
    </div>

    {{-- Sheet Pemasukan --}}
    <div id="sheet-income" class="mobile-modal-overlay">
        <div class="mobile-modal-sheet">
            <div class="mobile-modal-handle"></div>
            <h3 style="font-size:17px;font-weight:700;color:#1E293B;margin-bottom:20px;">Catat Pemasukan</h3>
            <form action="{{ route('transactions.store-income') }}" method="POST">
                @csrf
                <div class="mobile-form-group">
                    <label class="mobile-label">Rekening</label>
                    <select name="account_id" class="mobile-select">
                        <option value="">-- Pilih Rekening --</option>
                        @foreach ($accounts as $account)
                            <option value="{{ $account->id }}">{{ $account->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mobile-form-group">
                    <label class="mobile-label">Kategori</label>
                    <select name="category_id" class="mobile-select">
                        <option value="">-- Pilih Kategori --</option>
                        @foreach ($incomeCategories as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mobile-form-group">
                    <label class="mobile-label">Jumlah</label>
                    <input type="number" name="amount" class="mobile-input" placeholder="Rp 0" min="1">
                </div>
                <div class="mobile-form-group">
                    <label class="mobile-label">Tanggal</label>
                    <input type="date" name="transaction_date" class="mobile-input" value="{{ date('Y-m-d') }}">
                </div>
                <div class="mobile-form-group">
                    <label class="mobile-label">Catatan (opsional)</label>
                    <input type="text" name="description" class="mobile-input" placeholder="Tulis catatan...">
                </div>
                <button type="submit" class="mobile-btn mobile-btn-green">Simpan Pemasukan</button>
                <button type="button" onclick="closeSheet('sheet-income')" class="mobile-btn mobile-btn-white">Batal</button>
            </form>
        </div>
    </div>

    {{-- Sheet Pengeluaran --}}
    <div id="sheet-expense" class="mobile-modal-overlay">
        <div class="mobile-modal-sheet">
            <div class="mobile-modal-handle"></div>
            <h3 style="font-size:17px;font-weight:700;color:#1E293B;margin-bottom:20px;">Catat Pengeluaran</h3>
            <form action="{{ route('transactions.store-expense') }}" method="POST">
                @csrf
                <div class="mobile-form-group">
                    <label class="mobile-label">Rekening</label>
                    <select name="account_id" class="mobile-select">
                        <option value="">-- Pilih Rekening --</option>
                        @foreach ($accounts as $account)
                            <option value="{{ $account->id }}">{{ $account->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mobile-form-group">
                    <label class="mobile-label">Kategori</label>
                    <select name="category_id" class="mobile-select">
                        <option value="">-- Pilih Kategori --</option>
                        @foreach ($expenseCategories as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mobile-form-group">
                    <label class="mobile-label">Jumlah</label>
                    <input type="number" name="amount" class="mobile-input" placeholder="Rp 0" min="1">
                </div>
                <div class="mobile-form-group">
                    <label class="mobile-label">Tanggal</label>
                    <input type="date" name="transaction_date" class="mobile-input" value="{{ date('Y-m-d') }}">
                </div>
                <div class="mobile-form-group">
                    <label class="mobile-label">Catatan (opsional)</label>
                    <input type="text" name="description" class="mobile-input" placeholder="Tulis catatan...">
                </div>
                <button type="submit" class="mobile-btn mobile-btn-red">Simpan Pengeluaran</button>
                <button type="button" onclick="closeSheet('sheet-expense')" class="mobile-btn mobile-btn-white">Batal</button>
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
        document.querySelectorAll('.mobile-modal-overlay').forEach(el => {
            el.addEventListener('click', e => {
                if (e.target === el) closeSheet(el.id);
            });
        });
    </script>
    @endpush
</x-mobile-layout>