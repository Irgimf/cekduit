<x-mobile-layout>

    {{-- Header --}}
    <div class="mobile-header" style="padding-top:max(20px, calc(env(safe-area-inset-top, 0px) + 16px));">
        <div class="mobile-header-top">
            <div>
                <div class="mobile-header-greeting">
                    @php
                        $hour = now()->hour;
                        $greeting = $hour < 11 ? 'Selamat Pagi' : ($hour < 15 ? 'Selamat Siang' : ($hour < 18 ? 'Selamat Sore' : 'Selamat Malam'));
                    @endphp
                    {{ $greeting }}, <x-heroicon-o-hand-raised class="w-6 h-6 inline text-yellow-500" />
                </div>
                <div class="mobile-header-name">{{ Auth::user()->name }}</div>
                
                @if (auth()->user()->isFree())
                    <a href="{{ route('premium.upgrade') }}" 
                       style="display:inline-flex;align-items:center;gap:4px;padding:4px 10px;background:rgba(255,255,255,0.2);border-radius:99px;font-size:11px;font-weight:600;color:#fff;text-decoration:none;margin-top:6px;">
                        <x-heroicon-o-bolt class="w-5 h-5 inline text-yellow-500" /> Upgrade Premium
                    </a>
                @else
                    <span style="display:inline-flex;align-items:center;gap:4px;padding:4px 10px;background:rgba(34,197,94,0.2);border-radius:99px;font-size:11px;font-weight:600;color:#fff;margin-top:6px;">
                        ⭐ Premium
                    </span>
                @endif
            </div>
            <a href="{{ route('profile.edit') }}">
                <img src="{{ Auth::user()->avatar_url }}" alt="Avatar" class="mobile-header-avatar">
            </a>
        </div>

        {{-- Saldo --}}
        <div class="mobile-balance-section" x-data="{ show: true }">
            <div class="mobile-balance-label">
                Total Saldo
                <button class="mobile-balance-toggle" @click="show = !show">
                    <svg xmlns="http://www.w3.org/2000/svg" style="width:16px;height:16px;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path x-show="show" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        <path x-show="!show" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                    </svg>
                </button>
            </div>
            <div class="mobile-balance-amount">
                <span x-show="show">Rp {{ number_format($totalBalance, 0, ',', '.') }}</span>
                <span x-show="!show">Rp ••••••••</span>
            </div>
        </div>
    </div>

    {{-- Shortcut Menu (Fix 5 Integrasi Penuh) --}}
    <div class="mobile-shortcuts">
        {{-- Baris 1: Transaksi --}}
        <div style="font-size:11px;font-weight:700;color:#94A3B8;text-transform:uppercase;letter-spacing:.05em;margin-bottom:10px;">Catat Transaksi</div>
        <div class="mobile-shortcut-grid" style="margin-bottom:16px;">
            <button class="mobile-shortcut-item" onclick="openSheet('sheet-income')">
                <div class="mobile-shortcut-icon" style="background:#DCFCE7;">
                    <svg xmlns="http://www.w3.org/2000/svg" style="width:22px;height:22px;color:#16a34a;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                </div>
                <span class="mobile-shortcut-label">Pemasukan</span>
            </button>

            <button class="mobile-shortcut-item" onclick="openSheet('sheet-expense')">
                <div class="mobile-shortcut-icon" style="background:#FEE2E2;">
                    <svg xmlns="http://www.w3.org/2000/svg" style="width:22px;height:22px;color:#dc2626;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/>
                    </svg>
                </div>
                <span class="mobile-shortcut-label">Pengeluaran</span>
            </button>

            <button class="mobile-shortcut-item" onclick="openSheet('sheet-transfer')">
                <div class="mobile-shortcut-icon" style="background:#E0E7FF;">
                    <svg xmlns="http://www.w3.org/2000/svg" style="width:22px;height:22px;color:#4338ca;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/>
                    </svg>
                </div>
                <span class="mobile-shortcut-label">Transfer</span>
            </button>

            <a href="{{ route('accounts.index') }}" class="mobile-shortcut-item">
                <div class="mobile-shortcut-icon" style="background:#FEF9C3;">
                    <svg xmlns="http://www.w3.org/2000/svg" style="width:22px;height:22px;color:#ca8a04;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                    </svg>
                </div>
                <span class="mobile-shortcut-label">Rekening</span>
            </a>
        </div>

        {{-- Baris 2: Fitur Premium --}}
        <div style="font-size:11px;font-weight:700;color:#94A3B8;text-transform:uppercase;letter-spacing:.05em;margin-bottom:10px;">
            Fitur ⭐
            @if (auth()->user()->isFree())
                <span style="font-size:10px;color:#EAB308;font-weight:600;margin-left:4px;">(Premium)</span>
            @endif
        </div>
        <div class="mobile-shortcut-grid">
            <a href="{{ auth()->user()->isPremium() ? route('budgets.index') : route('premium.upgrade') }}"
               class="mobile-shortcut-item">
                <div class="mobile-shortcut-icon"
                     style="background:{{ auth()->user()->isPremium() ? '#E0F2FE' : '#F1F5F9' }};">
                    <svg xmlns="http://www.w3.org/2000/svg"
                         style="width:22px;height:22px;color:{{ auth()->user()->isPremium() ? '#0284c7' : '#94A3B8' }};"
                         fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 11h.01M12 11h.01M15 11h.01M4 19h16a2 2 0 002-2V7a2 2 0 00-2-2H4a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                </div>
                <span class="mobile-shortcut-label" style="color:{{ auth()->user()->isPremium() ? '#1E293B' : '#94A3B8' }};">
                    Budget
                </span>
            </a>

            <a href="{{ auth()->user()->isPremium() ? route('recurring.index') : route('premium.upgrade') }}"
               class="mobile-shortcut-item">
                <div class="mobile-shortcut-icon"
                     style="background:{{ auth()->user()->isPremium() ? '#F0FDF4' : '#F1F5F9' }};">
                    <svg xmlns="http://www.w3.org/2000/svg"
                         style="width:22px;height:22px;color:{{ auth()->user()->isPremium() ? '#16a34a' : '#94A3B8' }};"
                         fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                    </svg>
                </div>
                <span class="mobile-shortcut-label" style="color:{{ auth()->user()->isPremium() ? '#1E293B' : '#94A3B8' }};">
                    Berulang
                </span>
            </a>

            <a href="{{ auth()->user()->isPremium() ? route('savings.index') : route('premium.upgrade') }}"
               class="mobile-shortcut-item">
                <div class="mobile-shortcut-icon"
                     style="background:{{ auth()->user()->isPremium() ? '#FFF7ED' : '#F1F5F9' }};">
                    <svg xmlns="http://www.w3.org/2000/svg"
                         style="width:22px;height:22px;color:{{ auth()->user()->isPremium() ? '#ea580c' : '#94A3B8' }};"
                         fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                </div>
                <span class="mobile-shortcut-label" style="color:{{ auth()->user()->isPremium() ? '#1E293B' : '#94A3B8' }};">
                    Tabungan
                </span>
            </a>

            <a href="{{ route('premium.upgrade') }}" class="mobile-shortcut-item">
                <div class="mobile-shortcut-icon" style="background:#FEF9C3;">
                    <svg xmlns="http://www.w3.org/2000/svg" style="width:22px;height:22px;color:#ca8a04;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3l14 9-14 9V3z"/>
                    </svg>
                </div>
                <span class="mobile-shortcut-label">
                    {{ auth()->user()->isPremium() ? 'Premium ⭐' : 'Upgrade' }}
                </span>
            </a>
        </div>
    </div>

    {{-- Summary Bulan Ini --}}
    <div class="mobile-section">
        <div class="mobile-section-header">
            <span class="mobile-section-title">Bulan Ini</span>
            <a href="{{ route('reports.index') }}" class="mobile-section-link">Lihat Laporan</a>
        </div>
        <div class="mobile-stat-row">
            <div class="mobile-stat-card">
                <div class="mobile-stat-label" style="color:#16a34a;">Pemasukan</div>
                <div class="mobile-stat-value" style="color:#16a34a;font-size:14px;">
                    Rp {{ number_format($monthlyIncome, 0, ',', '.') }}
                </div>
            </div>
            <div class="mobile-stat-card">
                <div class="mobile-stat-label" style="color:#dc2626;">Pengeluaran</div>
                <div class="mobile-stat-value" style="color:#dc2626;font-size:14px;">
                    Rp {{ number_format($monthlyExpense, 0, ',', '.') }}
                </div>
            </div>
        </div>
    </div>

    {{-- Transaksi Terbaru --}}
    <div class="mobile-section">
        <div class="mobile-section-header">
            <span class="mobile-section-title">Transaksi Terbaru</span>
            <a href="{{ route('transactions.index', ['type' => 'income']) }}" class="mobile-section-link">Lihat Semua</a>
        </div>

        @forelse ($recentTransactions as $tx)
            <div class="mobile-tx-card">
                <div class="mobile-tx-icon"
                     style="background:{{ $tx->type === 'income' ? '#DCFCE7' : '#FEE2E2' }};">
                    <svg xmlns="http://www.w3.org/2000/svg"
                         style="width:20px;height:20px;color:{{ $tx->type === 'income' ? '#16a34a' : '#dc2626' }};"
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
                    <div class="mobile-tx-sub">{{ $tx->account->name }} · {{ $tx->transaction_date->format('d M') }}</div>
                </div>
                <div class="mobile-tx-amount"
                     style="color:{{ $tx->type === 'income' ? '#16a34a' : '#dc2626' }};">
                    {{ $tx->type === 'income' ? '+' : '-' }}Rp {{ number_format($tx->amount, 0, ',', '.') }}
                </div>
            </div>
        @empty
            <div class="mobile-empty">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
                <div class="mobile-empty-title">Belum ada transaksi</div>
                <div class="mobile-empty-sub">Mulai catat pemasukan atau pengeluaran kamu</div>
            </div>
        @endforelse
    </div>

    {{-- Bottom spacing --}}
    <div style="height:16px;"></div>

    {{-- Sheet: Tambah Pemasukan --}}
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
                <button type="button" onclick="closeSheet('sheet-income')"
                        class="mobile-btn mobile-btn-white" style="margin-top:8px;">Batal</button>
            </form>
        </div>
    </div>

    {{-- Sheet: Tambah Pengeluaran --}}
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
                <button type="button" onclick="closeSheet('sheet-expense')"
                        class="mobile-btn mobile-btn-white" style="margin-top:8px;">Batal</button>
            </form>
        </div>
    </div>

    {{-- Sheet: Transfer --}}
    <div id="sheet-transfer" class="mobile-modal-overlay">
        <div class="mobile-modal-sheet">
            <div class="mobile-modal-handle"></div>
            <h3 style="font-size:17px;font-weight:700;color:#1E293B;margin-bottom:20px;">Transfer Rekening</h3>
            <form action="{{ route('transactions.transfer') }}" method="POST">
                @csrf
                <div class="mobile-form-group">
                    <label class="mobile-label">Dari Rekening</label>
                    <select name="from_account_id" class="mobile-select">
                        <option value="">-- Pilih --</option>
                        @foreach ($accounts as $account)
                            <option value="{{ $account->id }}">
                                {{ $account->name }} — Rp {{ number_format($account->balance, 0, ',', '.') }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="mobile-form-group">
                    <label class="mobile-label">Ke Rekening</label>
                    <select name="to_account_id" class="mobile-select">
                        <option value="">-- Pilih --</option>
                        @foreach ($accounts as $account)
                            <option value="{{ $account->id }}">{{ $account->name }}</option>
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
                <button type="submit" class="mobile-btn mobile-btn-primary">Proses Transfer</button>
                <button type="button" onclick="closeSheet('sheet-transfer')"
                        class="mobile-btn mobile-btn-white" style="margin-top:8px;">Batal</button>
            </form>
        </div>
    </div>

    @push('scripts')
    <script>
        function openSheet(id) {
            const el = document.getElementById(id);
            el.style.display = 'flex';
        }
        function closeSheet(id) {
            document.getElementById(id).style.display = 'none';
        }
        // Tutup sheet kalau tap overlay
        document.querySelectorAll('.mobile-modal-overlay').forEach(el => {
            el.addEventListener('click', e => {
                if (e.target === el) closeSheet(el.id);
            });
        });
    </script>
    @endpush
</x-mobile-layout>
