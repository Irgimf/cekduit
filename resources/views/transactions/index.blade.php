<x-app-layout>
    <x-slot name="header">
        <h1 class="cd-page-title">Transaksi</h1>
    </x-slot>

    <div style="display:flex;flex-direction:column;gap:16px;">

        {{-- Tab --}}
        <div class="cd-tab-container" style="max-width:320px;">
            <a href="{{ route('transactions.index', array_merge(request()->except('type'), ['type' => 'income'])) }}"
               class="cd-tab {{ $activeTab === 'income' ? 'active' : '' }}">
                Pemasukan
            </a>
            <a href="{{ route('transactions.index', array_merge(request()->except('type'), ['type' => 'expense'])) }}"
               class="cd-tab {{ $activeTab === 'expense' ? 'active' : '' }}">
                Pengeluaran
            </a>
        </div>

        {{-- Filter --}}
        <div class="cd-card" style="padding:16px;">
            <form method="GET" style="display:flex;flex-wrap:wrap;gap:10px;align-items:flex-end;">
                <input type="hidden" name="type" value="{{ $activeTab }}">
                <input type="text" name="search" value="{{ request('search') }}"
                       class="cd-input" style="max-width:200px;" placeholder="Cari deskripsi...">
                <select name="account_id" class="cd-input" style="max-width:160px;">
                    <option value="">Semua Rekening</option>
                    @foreach ($accounts as $account)
                        <option value="{{ $account->id }}" @selected(request('account_id') == $account->id)>
                            {{ $account->name }}
                        </option>
                    @endforeach
                </select>
                <select name="category_id" class="cd-input" style="max-width:160px;">
                    <option value="">Semua Kategori</option>
                    @foreach ($activeTab === 'income' ? $incomeCategories : $expenseCategories as $category)
                        <option value="{{ $category->id }}" @selected(request('category_id') == $category->id)>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                <input type="date" name="from_date" value="{{ request('from_date') }}"
                       class="cd-input" style="max-width:160px;">
                <input type="date" name="to_date" value="{{ request('to_date') }}"
                       class="cd-input" style="max-width:160px;">
                <div style="display:flex;gap:8px;">
                    <a href="{{ route('transactions.index', ['type' => $activeTab]) }}"
                       class="cd-btn cd-btn-white cd-btn-sm">Reset</a>
                    <button type="submit" class="cd-btn cd-btn-primary cd-btn-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                        </svg>
                        Filter
                    </button>
                </div>
            </form>
        </div>

        {{-- Tombol Tambah --}}
        <div style="display:flex;justify-content:flex-end;">
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

        {{-- Tabel --}}
        <div class="cd-card" style="overflow-x:auto;">
            <table class="cd-table" style="min-width:640px;">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Rekening</th>
                        <th>Kategori</th>
                        <th>Deskripsi</th>
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
                            <td style="font-size:14px;">{{ $transaction->account->name }}</td>
                            <td>
                                <span class="cd-badge {{ $transaction->type === 'income' ? 'cd-badge-income' : 'cd-badge-expense' }}">
                                    {{ $transaction->category->name }}
                                </span>
                            </td>
                            <td style="font-size:13px;color:var(--muted);">{{ $transaction->description ?: '-' }}</td>
                            <td style="text-align:right;font-weight:700;font-size:14px;white-space:nowrap;color:{{ $transaction->type === 'income' ? 'var(--green)' : 'var(--red)' }}">
                                {{ $transaction->type === 'income' ? '+' : '-' }}Rp {{ number_format($transaction->amount, 0, ',', '.') }}
                            </td>
                            <td style="text-align:right;">
                                <div style="display:flex;justify-content:flex-end;gap:6px;">
                                    <a href="{{ route('transactions.edit', $transaction) }}"
                                       class="cd-btn cd-btn-white cd-btn-sm">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                        Edit
                                    </a>
                                    <form action="{{ route('transactions.destroy', $transaction) }}" method="POST"
                                          onsubmit="return confirm('Hapus transaksi ini?')">
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
                            <td colspan="6" style="text-align:center;padding:48px;color:var(--muted);">
                                Belum ada data {{ $activeTab === 'income' ? 'pemasukan' : 'pengeluaran' }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div>{{ $transactions->links() }}</div>
    </div>

    {{-- Modal Pemasukan --}}
    <div id="modal-income"
         style="display:none;position:fixed;inset:0;background:rgba(15,23,42,0.6);backdrop-filter:blur(4px);z-index:9999;align-items:center;justify-content:center;padding:16px;">
        <div class="cd-modal">
            <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:20px;">
                <h3 style="font-size:17px;font-weight:700;color:var(--dark);">Tambah Pemasukan</h3>
                <button onclick="closeModal('modal-income')"
                        style="background:none;border:none;cursor:pointer;color:var(--muted);padding:4px;">
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
                    @if ($incomeCategories->isEmpty())
                        <p style="font-size:12px;color:orange;margin-top:4px;">
                            Belum ada kategori pemasukan.
                            <a href="{{ route('categories.create') }}" style="color:var(--blue);">Buat dulu</a>
                        </p>
                    @endif
                </div>
                <div>
                    <label class="cd-label">Jumlah</label>
                    <div style="position:relative;">
                        <span style="position:absolute;left:12px;top:50%;transform:translateY(-50%);font-size:13px;color:var(--muted);font-weight:500;">Rp</span>
                        <input type="number" step="0.01" min="0.01" name="amount"
                               value="{{ old('amount') }}"
                               class="cd-input" style="padding-left:36px;" placeholder="0">
                    </div>
                    @error('amount') <p class="cd-error">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="cd-label">Tanggal</label>
                    <input type="date" name="transaction_date"
                           value="{{ old('transaction_date', date('Y-m-d')) }}"
                           class="cd-input">
                    @error('transaction_date') <p class="cd-error">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="cd-label">Deskripsi <span style="color:var(--muted);font-weight:400;">(opsional)</span></label>
                    <input type="text" name="description" value="{{ old('description') }}"
                           class="cd-input" placeholder="Catatan singkat">
                </div>
                <div style="display:flex;gap:10px;justify-content:flex-end;padding-top:4px;">
                    <button type="button" onclick="closeModal('modal-income')"
                            class="cd-btn cd-btn-white">Batal</button>
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
                <button onclick="closeModal('modal-expense')"
                        style="background:none;border:none;cursor:pointer;color:var(--muted);padding:4px;">
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
                    @if ($expenseCategories->isEmpty())
                        <p style="font-size:12px;color:orange;margin-top:4px;">
                            Belum ada kategori pengeluaran.
                            <a href="{{ route('categories.create') }}" style="color:var(--blue);">Buat dulu</a>
                        </p>
                    @endif
                </div>
                <div>
                    <label class="cd-label">Jumlah</label>
                    <div style="position:relative;">
                        <span style="position:absolute;left:12px;top:50%;transform:translateY(-50%);font-size:13px;color:var(--muted);font-weight:500;">Rp</span>
                        <input type="number" step="0.01" min="0.01" name="amount"
                               value="{{ old('amount') }}"
                               class="cd-input" style="padding-left:36px;" placeholder="0">
                    </div>
                    @error('amount') <p class="cd-error">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="cd-label">Tanggal</label>
                    <input type="date" name="transaction_date"
                           value="{{ old('transaction_date', date('Y-m-d')) }}"
                           class="cd-input">
                    @error('transaction_date') <p class="cd-error">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="cd-label">Deskripsi <span style="color:var(--muted);font-weight:400;">(opsional)</span></label>
                    <input type="text" name="description" value="{{ old('description') }}"
                           class="cd-input" placeholder="Catatan singkat">
                </div>
                <div style="display:flex;gap:10px;justify-content:flex-end;padding-top:4px;">
                    <button type="button" onclick="closeModal('modal-expense')"
                            class="cd-btn cd-btn-white">Batal</button>
                    <button type="submit" class="cd-btn cd-btn-red">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openModal(id) {
            const el = document.getElementById(id);
            el.style.display = 'flex';
        }

        function closeModal(id) {
            const el = document.getElementById(id);
            el.style.display = 'none';
        }

        // Tutup modal kalau klik backdrop
        ['modal-income', 'modal-expense'].forEach(id => {
            const el = document.getElementById(id);
            if (el) {
                el.addEventListener('click', (e) => {
                    if (e.target === el) closeModal(id);
                });
            }
        });

        document.addEventListener('DOMContentLoaded', () => {
            // Tombol buka modal
            const btnIncome = document.getElementById('btn-open-income');
            const btnExpense = document.getElementById('btn-open-expense');

            if (btnIncome) btnIncome.addEventListener('click', () => openModal('modal-income'));
            if (btnExpense) btnExpense.addEventListener('click', () => openModal('modal-expense'));

            // Buka modal otomatis hanya kalau ada error validasi
            @if ($errors->any())
                @if (old('_modal') === 'income')
                    openModal('modal-income');
                @elseif (old('_modal') === 'expense')
                    openModal('modal-expense');
                @endif
            @endif
        });
    </script>
</x-app-layout>