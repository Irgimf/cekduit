<x-app-layout>
    <x-slot name="header">Transaksi</x-slot>

    <div style="display:flex;flex-direction:column;gap:16px;">

        {{-- Tab --}}
        <div class="cd-tab-container" style="max-width:300px;">
            <a href="{{ route('transactions.index', array_merge(request()->except('type','page'), ['type' => 'income'])) }}"
               class="cd-tab {{ $activeTab === 'income' ? 'active' : '' }}">
                Pemasukan
            </a>
            <a href="{{ route('transactions.index', array_merge(request()->except('type','page'), ['type' => 'expense'])) }}"
               class="cd-tab {{ $activeTab === 'expense' ? 'active' : '' }}">
                Pengeluaran
            </a>
        </div>

        {{-- Header row --}}
        <div style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:10px;">
            <div>
                <h2 style="font-size:20px;font-weight:700;color:var(--dark);margin:0;">
                    Riwayat {{ $activeTab === 'income' ? 'Pemasukan' : 'Pengeluaran' }}
                </h2>
                <p style="font-size:13px;color:var(--muted);margin:2px 0 0;">
                    Pantau dan kelola semua {{ $activeTab === 'income' ? 'sumber pendapatan' : 'pengeluaran' }} Anda
                </p>
            </div>
            <div style="display:flex;gap:8px;flex-wrap:wrap;">
                {{-- Tombol Transfer selalu tampil --}}
                <button id="btn-open-transfer" class="cd-btn cd-btn-white">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/>
                    </svg>
                    Transfer
                </button>

                @if ($activeTab === 'income')
                    <button id="btn-open-income" class="cd-btn cd-btn-green">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Tambah Pemasukan
                    </button>
                @else
                    <button id="btn-open-expense" class="cd-btn cd-btn-red">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Tambah Pengeluaran
                    </button>
                @endif
            </div>
        </div>

        {{-- Filter bar --}}
        <div class="cd-card" style="padding:14px 16px;">
            <form method="GET" style="display:flex;flex-wrap:wrap;gap:10px;align-items:center;">
                <input type="hidden" name="type" value="{{ $activeTab }}">

                <div style="display:flex;align-items:center;gap:6px;">
                    <label style="font-size:13px;font-weight:600;color:var(--muted);white-space:nowrap;">Urutkan:</label>
                    <select name="sort" class="cd-input" style="width:110px;padding:6px 10px;font-size:13px;">
                        <option value="latest" @selected(request('sort','latest') === 'latest')>Terbaru</option>
                        <option value="oldest" @selected(request('sort') === 'oldest')>Terlama</option>
                        <option value="highest" @selected(request('sort') === 'highest')>Tertinggi</option>
                        <option value="lowest" @selected(request('sort') === 'lowest')>Terendah</option>
                    </select>
                </div>

                <div style="display:flex;align-items:center;gap:6px;">
                    <label style="font-size:13px;font-weight:600;color:var(--muted);white-space:nowrap;">Kategori:</label>
                    <select name="category_id" class="cd-input" style="width:140px;padding:6px 10px;font-size:13px;">
                        <option value="">Semua Kategori</option>
                        @foreach ($activeTab === 'income' ? $incomeCategories : $expenseCategories as $category)
                            <option value="{{ $category->id }}" @selected(request('category_id') == $category->id)>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div style="display:flex;align-items:center;gap:6px;">
                    <label style="font-size:13px;font-weight:600;color:var(--muted);white-space:nowrap;">Periode:</label>
                    <select name="period" class="cd-input" style="width:120px;padding:6px 10px;font-size:13px;">
                        <option value="this_month" @selected(request('period','this_month') === 'this_month')>Bulan Ini</option>
                        <option value="last_month" @selected(request('period') === 'last_month')>Bulan Lalu</option>
                        <option value="this_year" @selected(request('period') === 'this_year')>Tahun Ini</option>
                        <option value="all" @selected(request('period') === 'all')>Semua</option>
                    </select>
                </div>

                <button type="submit" class="cd-btn cd-btn-white cd-btn-sm" style="font-size:13px;">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                    </svg>
                    Reset Filter
                </button>
            </form>
        </div>

        {{-- Tabel --}}
        <div class="cd-card" style="overflow:hidden;">
            <table class="cd-table" style="min-width:600px;">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Deskripsi</th>
                        <th>Kategori</th>
                        <th>Rekening</th>
                        <th style="text-align:right;">Jumlah</th>
                        <th style="text-align:right;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($transactions as $transaction)
                        <tr>
                            <td style="color:var(--muted);font-size:13px;white-space:nowrap;">
                                {{ $transaction->transaction_date->format('d M Y') }}
                            </td>
                            <td>
                                <div style="font-weight:600;font-size:14px;color:var(--dark);">
                                    {{ $transaction->category->name }}
                                </div>
                                @if ($transaction->description)
                                    <div style="font-size:12px;color:var(--muted);">{{ $transaction->description }}</div>
                                @endif
                            </td>
                            <td>
                                <span class="cd-badge {{ $transaction->type === 'income' ? 'cd-badge-income' : 'cd-badge-expense' }}">
                                    {{ $transaction->category->name }}
                                </span>
                            </td>
                            <td style="font-size:14px;">{{ $transaction->account->name }}</td>
                            <td style="text-align:right;font-weight:700;font-size:14px;white-space:nowrap;color:{{ $transaction->type === 'income' ? 'var(--green)' : 'var(--red)' }}">
                                {{ $transaction->type === 'income' ? '+' : '-' }}Rp {{ number_format($transaction->amount, 0, ',', '.') }}
                            </td>
                            <td style="text-align:right;">
                                <div style="display:flex;justify-content:flex-end;gap:4px;">
                                    <a href="{{ route('transactions.edit', $transaction) }}"
                                       class="cd-btn cd-btn-white cd-btn-sm">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                    </a>
                                    <form action="{{ route('transactions.destroy', $transaction) }}" method="POST"
                                          onsubmit="return confirm('Hapus transaksi ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="cd-btn cd-btn-red cd-btn-sm">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="text-align:center;padding:48px;color:var(--muted);">
                                <svg xmlns="http://www.w3.org/2000/svg" style="width:40px;height:40px;margin:0 auto 10px;opacity:0.3;display:block;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                </svg>
                                Belum ada data {{ $activeTab === 'income' ? 'pemasukan' : 'pengeluaran' }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            {{-- Pagination info + links --}}
            @if ($transactions->total() > 0)
                <div style="padding:12px 16px;border-top:1px solid var(--border);display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:8px;">
                    <p style="font-size:13px;color:var(--muted);">
                        Menampilkan {{ $transactions->firstItem() }}–{{ $transactions->lastItem() }} dari {{ $transactions->total() }} transaksi
                    </p>
                    {{ $transactions->appends(request()->query())->links() }}
                </div>
            @endif
        </div>

        {{-- 3 Summary Cards --}}
        <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:16px;">
            {{-- Total --}}
            <div class="stat-card" style="display:flex;align-items:center;gap:14px;">
                <div style="width:44px;height:44px;border-radius:12px;display:flex;align-items:center;justify-content:center;flex-shrink:0;background:{{ $activeTab === 'income' ? 'var(--green-bg)' : 'var(--red-bg)' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" style="width:22px;height:22px;color:{{ $activeTab === 'income' ? 'var(--green)' : 'var(--red)' }};" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        @if ($activeTab === 'income')
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                        @else
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6"/>
                        @endif
                    </svg>
                </div>
                <div>
                    <p style="font-size:12px;font-weight:600;color:var(--muted);margin-bottom:3px;">
                        Total {{ $activeTab === 'income' ? 'Pemasukan' : 'Pengeluaran' }} Bulan Ini
                    </p>
                    <p style="font-size:20px;font-weight:800;color:{{ $activeTab === 'income' ? 'var(--green)' : 'var(--red)' }};">
                        Rp {{ number_format($summary['total'], 0, ',', '.') }}
                    </p>
                </div>
            </div>

            {{-- Tertinggi --}}
            <div class="stat-card" style="display:flex;align-items:center;gap:14px;">
                <div style="width:44px;height:44px;border-radius:12px;display:flex;align-items:center;justify-content:center;flex-shrink:0;background:#FEF9C3;">
                    <svg xmlns="http://www.w3.org/2000/svg" style="width:22px;height:22px;color:#CA8A04;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                    </svg>
                </div>
                <div>
                    <p style="font-size:12px;font-weight:600;color:var(--muted);margin-bottom:3px;">
                        {{ $activeTab === 'income' ? 'Pemasukan' : 'Pengeluaran' }} Tertinggi
                    </p>
                    <p style="font-size:20px;font-weight:800;color:var(--dark);">
                        Rp {{ number_format($summary['highest'], 0, ',', '.') }}
                    </p>
                    @if ($summary['highest_category'])
                        <p style="font-size:11px;color:var(--muted);">Kategori: {{ $summary['highest_category'] }}</p>
                    @endif
                </div>
            </div>

            {{-- Rata-rata harian --}}
            <div class="stat-card" style="display:flex;align-items:center;gap:14px;">
                <div style="width:44px;height:44px;border-radius:12px;display:flex;align-items:center;justify-content:center;flex-shrink:0;background:var(--blue-light);">
                    <svg xmlns="http://www.w3.org/2000/svg" style="width:22px;height:22px;color:var(--blue);" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                </div>
                <div>
                    <p style="font-size:12px;font-weight:600;color:var(--muted);margin-bottom:3px;">Rata-rata Harian</p>
                    <p style="font-size:20px;font-weight:800;color:var(--blue);">
                        Rp {{ number_format($summary['daily_avg'], 0, ',', '.') }}
                    </p>
                    <p style="font-size:11px;color:var(--muted);">Berdasarkan 30 hari terakhir</p>
                </div>
            </div>
        </div>

    </div>

    {{-- Modal Pemasukan --}}
    <div id="modal-income"
         style="display:none;position:fixed;inset:0;background:rgba(15,23,42,0.6);backdrop-filter:blur(4px);z-index:9999;align-items:center;justify-content:center;padding:16px;">
        <div class="cd-modal">
            <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:20px;">
                <h3 style="font-size:17px;font-weight:700;color:var(--dark);">Tambah Pemasukan</h3>
                <button onclick="closeModal('modal-income')" style="background:none;border:none;cursor:pointer;color:var(--muted);padding:4px;">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            <form action="{{ route('transactions.store-income') }}" method="POST"
                  style="display:flex;flex-direction:column;gap:14px;">
                @csrf
                <input type="hidden" name="_modal" value="income">
                <div>
                    <label class="cd-label">Rekening</label>
                    <select name="account_id" class="cd-input">
                        <option value="">-- Pilih Rekening --</option>
                        @foreach ($accounts as $account)
                            <option value="{{ $account->id }}" @selected(old('account_id') == $account->id)>
                                {{ $account->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('account_id') <p class="cd-error">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="cd-label">Kategori</label>
                    <select name="category_id" class="cd-input">
                        <option value="">-- Pilih Kategori --</option>
                        @foreach ($incomeCategories as $category)
                            <option value="{{ $category->id }}" @selected(old('category_id') == $category->id)>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id') <p class="cd-error">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="cd-label">Jumlah</label>
                    <div style="position:relative;">
                        <span style="position:absolute;left:12px;top:50%;transform:translateY(-50%);font-size:13px;color:var(--muted);font-weight:500;">Rp</span>
                        <input type="number" step="0.01" min="0.01" name="amount"
                               value="{{ old('amount') }}" class="cd-input" style="padding-left:36px;" placeholder="0">
                    </div>
                    @error('amount') <p class="cd-error">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="cd-label">Tanggal</label>
                    <input type="date" name="transaction_date"
                           value="{{ old('transaction_date', date('Y-m-d')) }}" class="cd-input">
                    @error('transaction_date') <p class="cd-error">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="cd-label">Deskripsi <span style="color:var(--muted);font-weight:400;">(opsional)</span></label>
                    <input type="text" name="description" value="{{ old('description') }}"
                           class="cd-input" placeholder="Catatan singkat">
                </div>
                <div style="display:flex;gap:10px;justify-content:flex-end;padding-top:4px;">
                    <button type="button" onclick="closeModal('modal-income')" class="cd-btn cd-btn-white">Batal</button>
                    <button type="submit" class="cd-btn cd-btn-green">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Modal Pengeluaran --}}
    <div id="modal-expense"
         style="display:none;position:fixed;inset:0;background:rgba(15,23,42,0.6);backdrop-filter:blur(4px);z-index:9999;align-items:center;justify-content:center;padding:16px;">
        <div class="cd-modal">
            <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:20px;">
                <h3 style="font-size:17px;font-weight:700;color:var(--dark);">Tambah Pengeluaran</h3>
                <button onclick="closeModal('modal-expense')" style="background:none;border:none;cursor:pointer;color:var(--muted);padding:4px;">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            <form action="{{ route('transactions.store-expense') }}" method="POST"
                  style="display:flex;flex-direction:column;gap:14px;">
                @csrf
                <input type="hidden" name="_modal" value="expense">
                <div>
                    <label class="cd-label">Rekening</label>
                    <select name="account_id" class="cd-input">
                        <option value="">-- Pilih Rekening --</option>
                        @foreach ($accounts as $account)
                            <option value="{{ $account->id }}" @selected(old('account_id') == $account->id)>
                                {{ $account->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('account_id') <p class="cd-error">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="cd-label">Kategori</label>
                    <select name="category_id" class="cd-input">
                        <option value="">-- Pilih Kategori --</option>
                        @foreach ($expenseCategories as $category)
                            <option value="{{ $category->id }}" @selected(old('category_id') == $category->id)>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id') <p class="cd-error">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="cd-label">Jumlah</label>
                    <div style="position:relative;">
                        <span style="position:absolute;left:12px;top:50%;transform:translateY(-50%);font-size:13px;color:var(--muted);font-weight:500;">Rp</span>
                        <input type="number" step="0.01" min="0.01" name="amount"
                               value="{{ old('amount') }}" class="cd-input" style="padding-left:36px;" placeholder="0">
                    </div>
                    @error('amount') <p class="cd-error">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="cd-label">Tanggal</label>
                    <input type="date" name="transaction_date"
                           value="{{ old('transaction_date', date('Y-m-d')) }}" class="cd-input">
                    @error('transaction_date') <p class="cd-error">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="cd-label">Deskripsi <span style="color:var(--muted);font-weight:400;">(opsional)</span></label>
                    <input type="text" name="description" value="{{ old('description') }}"
                           class="cd-input" placeholder="Catatan singkat">
                </div>
                <div style="display:flex;gap:10px;justify-content:flex-end;padding-top:4px;">
                    <button type="button" onclick="closeModal('modal-expense')" class="cd-btn cd-btn-white">Batal</button>
                    <button type="submit" class="cd-btn cd-btn-red">Simpan</button>
                </div>
            </form>
        </div>
    </div>

        {{-- Modal Transfer --}}
    <div id="modal-transfer"
        style="display:none;position:fixed;inset:0;background:rgba(15,23,42,0.6);backdrop-filter:blur(4px);z-index:9999;align-items:center;justify-content:center;padding:16px;">
        <div class="cd-modal">
            <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:20px;">
                <div>
                    <h3 style="font-size:17px;font-weight:700;color:var(--dark);margin:0;">Transfer Antar Rekening</h3>
                    <p style="font-size:13px;color:var(--muted);margin-top:2px;">Pindahkan saldo dari satu rekening ke rekening lain</p>
                </div>
                <button onclick="closeModal('modal-transfer')" style="background:none;border:none;cursor:pointer;color:var(--muted);padding:4px;">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <form action="{{ route('transactions.transfer') }}" method="POST"
                style="display:flex;flex-direction:column;gap:14px;">
                @csrf

                {{-- Dari & Ke Rekening --}}
                <div style="display:grid;grid-template-columns:1fr auto 1fr;gap:8px;align-items:end;">
                    <div>
                        <label class="cd-label">Dari Rekening</label>
                        <select name="from_account_id" id="from_account" class="cd-input" onchange="updateToOptions()">
                            <option value="">-- Pilih --</option>
                            @foreach ($accounts as $account)
                                <option value="{{ $account->id }}" data-balance="{{ $account->balance }}">
                                    {{ $account->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div style="padding-bottom:2px;display:flex;align-items:center;justify-content:center;">
                        <div style="width:32px;height:32px;background:var(--blue-light);border-radius:50%;display:flex;align-items:center;justify-content:center;">
                            <svg xmlns="http://www.w3.org/2000/svg" style="width:16px;height:16px;color:var(--blue);" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                            </svg>
                        </div>
                    </div>

                    <div>
                        <label class="cd-label">Ke Rekening</label>
                        <select name="to_account_id" id="to_account" class="cd-input">
                            <option value="">-- Pilih --</option>
                            @foreach ($accounts as $account)
                                <option value="{{ $account->id }}">
                                    {{ $account->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- Info saldo rekening asal --}}
                <div id="balance-info" style="display:none;background:var(--blue-light);border-radius:8px;padding:10px 14px;">
                    <p style="font-size:12px;color:var(--blue);font-weight:600;">Saldo tersedia</p>
                    <p id="balance-text" style="font-size:16px;font-weight:700;color:var(--dark);"></p>
                </div>

                <div>
                    <label class="cd-label">Jumlah Transfer</label>
                    <div style="position:relative;">
                        <span style="position:absolute;left:12px;top:50%;transform:translateY(-50%);font-size:13px;color:var(--muted);font-weight:500;">Rp</span>
                        <input type="number" step="0.01" min="0.01" name="amount"
                            class="cd-input" style="padding-left:36px;" placeholder="0">
                    </div>
                    @error('amount') <p class="cd-error">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="cd-label">Tanggal</label>
                    <input type="date" name="transaction_date"
                        value="{{ date('Y-m-d') }}" class="cd-input">
                </div>

                <div>
                    <label class="cd-label">Catatan <span style="color:var(--muted);font-weight:400;">(opsional)</span></label>
                    <input type="text" name="description" class="cd-input" placeholder="Contoh: Bayar utang, Top up">
                </div>

                <div style="display:flex;gap:10px;justify-content:flex-end;padding-top:4px;border-top:1px solid var(--border);">
                    <button type="button" onclick="closeModal('modal-transfer')" class="cd-btn cd-btn-white">Batal</button>
                    <button type="submit" class="cd-btn cd-btn-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/>
                        </svg>
                        Proses Transfer
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openModal(id) { document.getElementById(id).style.display = 'flex'; }
        function closeModal(id) { document.getElementById(id).style.display = 'none'; }

        ['modal-income','modal-expense','modal-transfer'].forEach(id => {
            const el = document.getElementById(id);
            if (el) el.addEventListener('click', e => { if (e.target === el) closeModal(id); });
        });

        document.addEventListener('DOMContentLoaded', () => {
            const btnI = document.getElementById('btn-open-income');
            const btnE = document.getElementById('btn-open-expense');
            const btnT = document.getElementById('btn-open-transfer');

            if (btnI) btnI.addEventListener('click', () => openModal('modal-income'));
            if (btnE) btnE.addEventListener('click', () => openModal('modal-expense'));
            if (btnT) btnT.addEventListener('click', () => openModal('modal-transfer'));

            @if ($errors->any())
                @if (old('_modal') === 'income')
                    openModal('modal-income');
                @elseif (old('_modal') === 'expense')
                    openModal('modal-expense');
                @endif
            @endif
        });

        // Update info saldo saat pilih rekening asal
        function updateToOptions() {
            const fromSelect  = document.getElementById('from_account');
            const toSelect    = document.getElementById('to_account');
            const balanceInfo = document.getElementById('balance-info');
            const balanceText = document.getElementById('balance-text');
            const fromId      = fromSelect.value;

            // Sembunyikan option yang sama di rekening tujuan
            Array.from(toSelect.options).forEach(opt => {
                opt.disabled = opt.value === fromId;
                if (opt.disabled && toSelect.value === fromId) toSelect.value = '';
            });

            // Tampilkan saldo
            const selected = fromSelect.options[fromSelect.selectedIndex];
            if (fromId && selected.dataset.balance !== undefined) {
                const balance = parseFloat(selected.dataset.balance);
                balanceText.textContent = 'Rp ' + balance.toLocaleString('id-ID');
                balanceInfo.style.display = 'block';
            } else {
                balanceInfo.style.display = 'none';
            }
        }
    </script>
</x-app-layout>