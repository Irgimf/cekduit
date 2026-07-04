<x-app-layout>
    <x-slot name="header">
        <div style="display:flex;align-items:center;gap:12px;">
            <a href="{{ route('transactions.index', ['type' => $transaction->type]) }}"
               class="cd-btn cd-btn-white cd-btn-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>
            <h1 class="cd-page-title">
                Edit {{ $transaction->type === 'income' ? 'Pemasukan' : 'Pengeluaran' }}
            </h1>
        </div>
    </x-slot>

    <div style="max-width:520px;">
        <div class="cd-card" style="padding:28px;">

            {{-- Badge jenis transaksi --}}
            <div style="margin-bottom:20px;">
                <span class="cd-badge {{ $transaction->type === 'income' ? 'cd-badge-income' : 'cd-badge-expense' }}"
                      style="font-size:13px;padding:5px 12px;">
                    {{ $transaction->type === 'income' ? 'Pemasukan' : 'Pengeluaran' }}
                </span>
            </div>

            <form action="{{ route('transactions.update', $transaction) }}" method="POST"
                  style="display:flex;flex-direction:column;gap:18px;">
                @csrf
                @method('PUT')

                <div>
                    <label class="cd-label">Rekening</label>
                    <select name="account_id" class="cd-input">
                        @foreach ($accounts as $account)
                            <option value="{{ $account->id }}"
                                    @selected(old('account_id', $transaction->account_id) == $account->id)>
                                {{ $account->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('account_id')
                        <p class="cd-error">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="cd-label">Kategori</label>
                    <select name="category_id" class="cd-input">
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}"
                                    @selected(old('category_id', $transaction->category_id) == $category->id)>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <p class="cd-error">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="cd-label">Jumlah</label>
                    <div style="position:relative;">
                        <span style="position:absolute;left:12px;top:50%;transform:translateY(-50%);font-size:13px;color:var(--muted);font-weight:500;pointer-events:none;">Rp</span>
                        <input type="number" step="0.01" min="0.01" name="amount"
                               value="{{ old('amount', $transaction->amount) }}"
                               class="cd-input" style="padding-left:36px;">
                    </div>
                    @error('amount')
                        <p class="cd-error">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="cd-label">Tanggal</label>
                    <input type="date" name="transaction_date"
                           value="{{ old('transaction_date', $transaction->transaction_date->format('Y-m-d')) }}"
                           class="cd-input">
                    @error('transaction_date')
                        <p class="cd-error">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="cd-label">
                        Deskripsi
                        <span style="color:var(--muted);font-weight:400;">(opsional)</span>
                    </label>
                    <input type="text" name="description"
                           value="{{ old('description', $transaction->description) }}"
                           class="cd-input" placeholder="Catatan singkat">
                    @error('description')
                        <p class="cd-error">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Info saldo kalau pengeluaran --}}
                @if ($transaction->type === 'expense')
                    <div style="background:var(--blue-light);border-radius:8px;padding:12px 14px;">
                        <p style="font-size:12px;color:var(--blue);font-weight:600;margin-bottom:2px;">
                            Saldo rekening saat ini
                        </p>
                        <p style="font-size:16px;font-weight:700;color:var(--dark);">
                            Rp {{ number_format($transaction->account->balance, 0, ',', '.') }}
                        </p>
                        <p style="font-size:11px;color:var(--muted);margin-top:2px;">
                            Pastikan jumlah tidak melebihi saldo yang tersedia
                        </p>
                    </div>
                @endif

                <div style="display:flex;gap:10px;justify-content:flex-end;padding-top:4px;border-top:1px solid var(--border);margin-top:4px;">
                    <a href="{{ route('transactions.index', ['type' => $transaction->type]) }}"
                       class="cd-btn cd-btn-white">Batal</a>
                    <button type="submit"
                            class="cd-btn {{ $transaction->type === 'income' ? 'cd-btn-green' : 'cd-btn-red' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/>
                        </svg>
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>