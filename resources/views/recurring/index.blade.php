<x-app-layout>
    <x-slot name="header">Transaksi Berulang</x-slot>

    <div style="max-width:900px;display:flex;flex-direction:column;gap:20px;">

        <div class="cd-card" style="padding:20px;background:linear-gradient(135deg,#014BAA,#0166E8);color:#fff;">
            <div style="font-size:15px;font-weight:700;margin-bottom:4px;">⭐ Fitur Premium — Transaksi Berulang</div>
            <div style="font-size:13px;opacity:0.85;">
                Set transaksi yang otomatis dicatat setiap hari, minggu, atau bulan. Cocok untuk gaji, tagihan, atau pengeluaran rutin.
            </div>
        </div>

        {{-- Form tambah --}}
        <div class="cd-card" style="padding:24px;">
            <h3 style="font-size:16px;font-weight:700;color:var(--dark);margin-bottom:18px;">Tambah Transaksi Berulang</h3>
            <form action="{{ route('recurring.store') }}" method="POST"
                  style="display:flex;flex-direction:column;gap:14px;"
                  x-data="{ type: 'income', freq: 'monthly' }">
                @csrf

                <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;">
                    <div>
                        <label class="cd-label">Jenis</label>
                        <select name="type" x-model="type" class="cd-input">
                            <option value="income">Pemasukan</option>
                            <option value="expense">Pengeluaran</option>
                        </select>
                    </div>
                    <div>
                        <label class="cd-label">Rekening</label>
                        <select name="account_id" class="cd-input">
                            <option value="">-- Pilih --</option>
                            @foreach ($accounts as $acc)
                                <option value="{{ $acc->id }}">{{ $acc->name }}</option>
                            @endforeach
                        </select>
                        @error('account_id') <p class="cd-error">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;">
                    <div>
                        <label class="cd-label">Kategori</label>
                        <select name="category_id" class="cd-input">
                            <option value="">-- Pilih --</option>
                            <template x-if="type === 'income'">
                                <optgroup label="Pemasukan">
                                    @foreach ($incomeCategories as $cat)
                                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                    @endforeach
                                </optgroup>
                            </template>
                            <template x-if="type === 'expense'">
                                <optgroup label="Pengeluaran">
                                    @foreach ($expenseCategories as $cat)
                                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                    @endforeach
                                </optgroup>
                            </template>
                        </select>
                        @error('category_id') <p class="cd-error">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="cd-label">Jumlah (Rp)</label>
                        <div style="position:relative;">
                            <span style="position:absolute;left:10px;top:50%;transform:translateY(-50%);font-size:12px;color:var(--muted);">Rp</span>
                            <input type="number" name="amount" min="1000" step="1"
                                   class="cd-input" style="padding-left:30px;" placeholder="500000">
                        </div>
                        @error('amount') <p class="cd-error">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div>
                    <label class="cd-label">Deskripsi (opsional)</label>
                    <input type="text" name="description" class="cd-input" placeholder="Contoh: Gaji bulanan, Tagihan listrik">
                </div>

                <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:12px;">
                    <div>
                        <label class="cd-label">Frekuensi</label>
                        <select name="frequency" x-model="freq" class="cd-input">
                            <option value="daily">Setiap Hari</option>
                            <option value="weekly">Setiap Minggu</option>
                            <option value="monthly">Setiap Bulan</option>
                        </select>
                    </div>
                    <div>
                        <label class="cd-label">Mulai Tanggal</label>
                        <input type="date" name="start_date" value="{{ date('Y-m-d') }}" class="cd-input">
                        @error('start_date') <p class="cd-error">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="cd-label">Berakhir (opsional)</label>
                        <input type="date" name="end_date" class="cd-input">
                    </div>
                </div>

                <div style="display:flex;justify-content:flex-end;">
                    <button type="submit" class="cd-btn cd-btn-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Tambah Transaksi Berulang
                    </button>
                </div>
            </form>
        </div>

        {{-- Daftar transaksi berulang --}}
        @if ($recurrings->isEmpty())
            <div class="cd-card" style="padding:48px;text-align:center;">
                <svg xmlns="http://www.w3.org/2000/svg" style="width:48px;height:48px;color:var(--border);margin:0 auto 12px;display:block;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                </svg>
                <p style="color:var(--muted);font-size:15px;font-weight:500;">Belum ada transaksi berulang</p>
            </div>
        @else
            <div class="cd-card" style="overflow:hidden;">
                <div style="padding:16px 20px;border-bottom:1px solid var(--border);font-size:15px;font-weight:700;color:var(--dark);">
                    Daftar Transaksi Berulang
                </div>
                <table class="cd-table">
                    <thead>
                        <tr>
                            <th>Nama / Deskripsi</th>
                            <th>Rekening</th>
                            <th>Frekuensi</th>
                            <th>Jumlah</th>
                            <th>Berikutnya</th>
                            <th>Status</th>
                            <th style="text-align:right;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($recurrings as $item)
                        <tr style="{{ ! $item->is_active ? 'opacity:0.5;' : '' }}">
                            <td>
                                <div style="font-weight:600;">{{ $item->description ?: $item->category->name }}</div>
                                <div style="font-size:12px;color:var(--muted);">
                                    <span class="cd-badge {{ $item->type === 'income' ? 'cd-badge-income' : 'cd-badge-expense' }}">
                                        {{ $item->type === 'income' ? 'Pemasukan' : 'Pengeluaran' }}
                                    </span>
                                </div>
                            </td>
                            <td style="font-size:13px;color:var(--muted);">{{ $item->account->name }}</td>
                            <td style="font-size:13px;">{{ $item->frequencyLabel() }}</td>
                            <td style="font-weight:700;color:{{ $item->type === 'income' ? 'var(--green)' : 'var(--red)' }};">
                                {{ $item->type === 'income' ? '+' : '-' }}Rp {{ number_format($item->amount, 0, ',', '.') }}
                            </td>
                            <td style="font-size:13px;color:var(--muted);">
                                {{ $item->next_run_at->format('d M Y') }}
                                @if ($item->next_run_at->isToday())
                                    <span style="color:var(--blue);font-weight:700;font-size:11px;"> Hari ini</span>
                                @elseif ($item->next_run_at->isTomorrow())
                                    <span style="color:#EAB308;font-weight:700;font-size:11px;"> Besok</span>
                                @endif
                            </td>
                            <td>
                                @if ($item->is_active)
                                    <span style="background:#DCFCE7;color:#15803d;padding:3px 10px;border-radius:99px;font-size:11px;font-weight:700;">Aktif</span>
                                @else
                                    <span style="background:#F1F5F9;color:#64748B;padding:3px 10px;border-radius:99px;font-size:11px;font-weight:700;">Dijeda</span>
                                @endif
                            </td>
                            <td style="text-align:right;">
                                <div style="display:flex;gap:6px;justify-content:flex-end;">
                                    <form action="{{ route('recurring.toggle', $item) }}" method="POST">
                                        @csrf @method('PATCH')
                                        <button type="submit" class="cd-btn cd-btn-white cd-btn-sm">
                                            {{ $item->is_active ? 'Jeda' : 'Aktifkan' }}
                                        </button>
                                    </form>
                                    <form action="{{ route('recurring.destroy', $item) }}" method="POST"
                                          onsubmit="cdConfirm('Hapus transaksi berulang ini?', this); return false;">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="cd-btn cd-btn-red cd-btn-sm">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</x-app-layout>
