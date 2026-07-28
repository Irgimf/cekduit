<x-app-layout>
    <x-slot name="header">Budget per Kategori</x-slot>

    <div style="max-width:800px;display:flex;flex-direction:column;gap:20px;">

        {{-- Header info --}}
        <div class="cd-card" style="padding:20px;background:linear-gradient(135deg,#014BAA,#0166E8);color:#fff;">
            <div style="font-size:15px;font-weight:700;margin-bottom:4px;">⭐ Fitur Premium — Budget Bulanan</div>
            <div style="font-size:13px;opacity:0.85;">
                Set batas pengeluaran per kategori setiap bulan. Dapatkan peringatan otomatis saat anggaran hampir habis.
            </div>
        </div>

        {{-- Tambah Budget Baru --}}
        @if ($availableCategories->isNotEmpty())
        <div class="cd-card" style="padding:24px;">
            <h3 style="font-size:16px;font-weight:700;color:var(--dark);margin-bottom:16px;">Tambah Budget Baru</h3>
            <form action="{{ route('budgets.store') }}" method="POST"
                  style="display:grid;grid-template-columns:2fr 1fr 1fr auto;gap:12px;align-items:end;">
                @csrf

                <div>
                    <label class="cd-label">Kategori Pengeluaran</label>
                    <select name="category_id" class="cd-input">
                        <option value="">-- Pilih Kategori --</option>
                        @foreach ($availableCategories as $cat)
                            <option value="{{ $cat->id }}" @selected(old('category_id') == $cat->id)>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id') <p class="cd-error">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="cd-label">Limit (Rp)</label>
                    <div style="position:relative;">
                        <span style="position:absolute;left:10px;top:50%;transform:translateY(-50%);font-size:12px;color:var(--muted);">Rp</span>
                        <input type="number" name="amount" min="1000" step="1000"
                               value="{{ old('amount') }}"
                               class="cd-input" style="padding-left:30px;" placeholder="500000">
                    </div>
                    @error('amount') <p class="cd-error">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="cd-label">Periode</label>
                    <select name="period" class="cd-input">
                        <option value="monthly" @selected(old('period','monthly') === 'monthly')>Bulanan</option>
                        <option value="yearly"  @selected(old('period') === 'yearly')>Tahunan</option>
                    </select>
                </div>

                <button type="submit" class="cd-btn cd-btn-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Tambah
                </button>
            </form>
        </div>
        @endif

        {{-- Daftar Budget --}}
        @if ($budgets->isEmpty())
            <div class="cd-card" style="padding:48px;text-align:center;">
                <svg xmlns="http://www.w3.org/2000/svg" style="width:48px;height:48px;color:var(--border);margin:0 auto 12px;display:block;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 11h.01M12 11h.01M15 11h.01M4 19h16a2 2 0 002-2V7a2 2 0 00-2-2H4a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
                <p style="color:var(--muted);font-size:15px;font-weight:500;">Belum ada budget yang diatur</p>
                <p style="color:var(--muted);font-size:13px;margin-top:4px;">Tambahkan budget di atas untuk mulai mengontrol pengeluaran kamu.</p>
            </div>
        @else
            <div style="display:flex;flex-direction:column;gap:14px;">
                @foreach ($budgets as $budget)
                @php
                    $statusColors = [
                        'safe'     => ['bar'=>'#22C55E','bg'=>'#DCFCE7','text'=>'Aman'],
                        'warning'  => ['bar'=>'#EAB308','bg'=>'#FEF9C3','text'=>'Hampir Habis'],
                        'exceeded' => ['bar'=>'#EF4444','bg'=>'#FEE2E2','text'=>'Melebihi Limit'],
                    ];
                    $sc = $statusColors[$budget->status];
                @endphp
                <div class="cd-card" style="padding:20px;">
                    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:14px;">
                        <div style="display:flex;align-items:center;gap:10px;">
                            <div style="width:36px;height:36px;background:#FEE2E2;border-radius:10px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                <svg xmlns="http://www.w3.org/2000/svg" style="width:18px;height:18px;color:#dc2626;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                </svg>
                            </div>
                            <div>
                                <div style="font-size:15px;font-weight:700;color:var(--dark);">{{ $budget->category->name }}</div>
                                <div style="font-size:12px;color:var(--muted);">
                                    {{ $budget->period === 'monthly' ? 'Per bulan' : 'Per tahun' }}
                                </div>
                            </div>
                        </div>
                        <div style="display:flex;align-items:center;gap:10px;">
                            <span style="background:{{ $sc['bg'] }};color:{{ $sc['bar'] }};padding:4px 12px;border-radius:99px;font-size:12px;font-weight:700;">
                                {{ $sc['text'] }}
                            </span>
                            <form action="{{ route('budgets.destroy', $budget) }}" method="POST"
                                  onsubmit="return confirm('Hapus budget {{ $budget->category->name }}?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="cd-btn cd-btn-red cd-btn-sm">Hapus</button>
                            </form>
                        </div>
                    </div>

                    {{-- Progress bar --}}
                    <div style="margin-bottom:10px;">
                        <div style="height:10px;background:#F1F5F9;border-radius:99px;overflow:hidden;">
                            <div style="height:100%;width:{{ $budget->percent }}%;background:{{ $sc['bar'] }};border-radius:99px;transition:width 0.5s ease;"></div>
                        </div>
                    </div>

                    {{-- Angka --}}
                    <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:10px;">
                        <div>
                            <div style="font-size:11px;color:var(--muted);font-weight:600;text-transform:uppercase;letter-spacing:.04em;margin-bottom:2px;">Terpakai</div>
                            <div style="font-size:15px;font-weight:800;color:{{ $sc['bar'] }};">
                                Rp {{ number_format($budget->spent, 0, ',', '.') }}
                            </div>
                        </div>
                        <div>
                            <div style="font-size:11px;color:var(--muted);font-weight:600;text-transform:uppercase;letter-spacing:.04em;margin-bottom:2px;">Limit</div>
                            <div style="font-size:15px;font-weight:800;color:var(--dark);">
                                Rp {{ number_format($budget->amount, 0, ',', '.') }}
                            </div>
                        </div>
                        <div>
                            <div style="font-size:11px;color:var(--muted);font-weight:600;text-transform:uppercase;letter-spacing:.04em;margin-bottom:2px;">Sisa</div>
                            <div style="font-size:15px;font-weight:800;color:{{ $budget->remaining() > 0 ? '#22C55E' : '#EF4444' }};">
                                Rp {{ number_format($budget->remaining(), 0, ',', '.') }}
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        @endif
    </div>
</x-app-layout>