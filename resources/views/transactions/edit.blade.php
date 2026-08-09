<x-app-layout>
    <x-slot name="header">Edit Transaksi</x-slot>

    <div style="max-width:600px;">
        <div class="cd-card" style="padding:28px;">
            <form action="{{ route('transactions.update', $transaction) }}" method="POST"
                  style="display:flex;flex-direction:column;gap:16px;"
                  x-data="{ type: '{{ $transaction->type }}' }">
                @csrf
                @method('PUT')

                {{-- Jenis --}}
                <div>
                    <label class="cd-label">Jenis Transaksi</label>
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px;">
                        <label style="cursor:pointer;">
                            <input type="radio" name="type" value="income"
                                   x-model="type" style="display:none;">
                            <div :style="type === 'income'
                                    ? 'padding:12px;border:2px solid #16a34a;border-radius:10px;text-align:center;font-size:14px;font-weight:700;color:#16a34a;background:#DCFCE7;cursor:pointer;'
                                    : 'padding:12px;border:2px solid #E2E8F0;border-radius:10px;text-align:center;font-size:14px;font-weight:700;color:#64748B;background:#fff;cursor:pointer;'">
                                📈 Pemasukan
                            </div>
                        </label>
                        <label style="cursor:pointer;">
                            <input type="radio" name="type" value="expense"
                                   x-model="type" style="display:none;">
                            <div :style="type === 'expense'
                                    ? 'padding:12px;border:2px solid #dc2626;border-radius:10px;text-align:center;font-size:14px;font-weight:700;color:#dc2626;background:#FEE2E2;cursor:pointer;'
                                    : 'padding:12px;border:2px solid #E2E8F0;border-radius:10px;text-align:center;font-size:14px;font-weight:700;color:#64748B;background:#fff;cursor:pointer;'">
                                📉 Pengeluaran
                            </div>
                        </label>
                    </div>
                    @error('type') <p class="cd-error">{{ $message }}</p> @enderror
                </div>

                {{-- Rekening --}}
                <div>
                    <label class="cd-label">Rekening</label>
                    <select name="account_id" class="cd-input">
                        @foreach ($accounts as $acc)
                            <option value="{{ $acc->id }}"
                                    @selected($acc->id === $transaction->account_id)>
                                {{ $acc->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('account_id') <p class="cd-error">{{ $message }}</p> @enderror
                </div>

                {{-- Kategori --}}
                <div>
                    <label class="cd-label">Kategori</label>
                    <select name="category_id" class="cd-input">
                        <optgroup label="Pemasukan">
                            @foreach ($incomeCategories as $cat)
                                <option value="{{ $cat->id }}"
                                        @selected($cat->id === $transaction->category_id)>
                                    {{ $cat->name }}
                                </option>
                            @endforeach
                        </optgroup>
                        <optgroup label="Pengeluaran">
                            @foreach ($expenseCategories as $cat)
                                <option value="{{ $cat->id }}"
                                        @selected($cat->id === $transaction->category_id)>
                                    {{ $cat->name }}
                                </option>
                            @endforeach
                        </optgroup>
                    </select>
                    @error('category_id') <p class="cd-error">{{ $message }}</p> @enderror
                </div>

                {{-- Jumlah --}}
                <div>
                    <label class="cd-label">Jumlah</label>
                    <div style="position:relative;">
                        <span style="position:absolute;left:12px;top:50%;transform:translateY(-50%);
                                     font-size:13px;color:var(--muted);font-weight:500;">Rp</span>
                        <input type="number" name="amount" min="1" step="1"
                               value="{{ $transaction->amount }}"
                               class="cd-input" style="padding-left:36px;">
                    </div>
                    @error('amount') <p class="cd-error">{{ $message }}</p> @enderror
                </div>

                {{-- Tanggal --}}
                <div>
                    <label class="cd-label">Tanggal</label>
                    <input type="date" name="transaction_date"
                           value="{{ $transaction->transaction_date->format('Y-m-d') }}"
                           class="cd-input">
                    @error('transaction_date') <p class="cd-error">{{ $message }}</p> @enderror
                </div>

                {{-- Deskripsi --}}
                <div>
                    <label class="cd-label">
                        Catatan
                        <span style="color:var(--muted);font-weight:400;">(opsional)</span>
                    </label>
                    <input type="text" name="description"
                           value="{{ $transaction->description }}"
                           class="cd-input" placeholder="Tulis catatan...">
                </div>

                {{-- Aksi --}}
                <div style="display:flex;gap:10px;padding-top:4px;">
                    <a href="{{ route('transactions.index', ['type' => $transaction->type]) }}"
                       class="cd-btn cd-btn-white" style="flex:1;justify-content:center;">
                        Batal
                    </a>
                    <button type="submit" class="cd-btn cd-btn-primary"
                            style="flex:2;justify-content:center;">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                             viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/>
                        </svg>
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>