<x-mobile-layout>
    <div style="background:linear-gradient(135deg,#014BAA,#0166E8);padding-top:max(20px,calc(env(safe-area-inset-top,0px) + 16px));padding-left:20px;padding-right:20px;padding-bottom:24px;">
        <div style="font-size:13px;color:rgba(255,255,255,0.75);margin-bottom:2px;">⭐ Fitur Premium</div>
        <div style="font-size:20px;font-weight:700;color:#fff;">Budget Bulanan</div>
    </div>

    <div style="padding:16px;display:flex;flex-direction:column;gap:14px;">

        {{-- Tambah budget --}}
        @if ($availableCategories->isNotEmpty())
        <div style="background:#fff;border-radius:14px;padding:16px;">
            <div style="font-size:14px;font-weight:700;color:#1E293B;margin-bottom:14px;">Tambah Budget Baru</div>
            <form action="{{ route('budgets.store') }}" method="POST" style="display:flex;flex-direction:column;gap:12px;">
                @csrf
                <div>
                    <label style="display:block;font-size:13px;font-weight:600;color:#1E293B;margin-bottom:5px;">Kategori</label>
                    <select name="category_id" class="mobile-select">
                        <option value="">-- Pilih Kategori --</option>
                        @foreach ($availableCategories as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label style="display:block;font-size:13px;font-weight:600;color:#1E293B;margin-bottom:5px;">Limit Budget</label>
                    <div style="position:relative;">
                        <span style="position:absolute;left:12px;top:50%;transform:translateY(-50%);font-size:13px;color:#94A3B8;font-weight:500;">Rp</span>
                        <input type="number" name="amount" min="1000" step="1000"
                               class="mobile-input" style="padding-left:36px;" placeholder="500.000">
                    </div>
                </div>
                <input type="hidden" name="period" value="monthly">
                <button type="submit"
                        style="width:100%;padding:13px;background:#014BAA;color:#fff;border:none;border-radius:12px;font-size:14px;font-weight:700;cursor:pointer;font-family:inherit;">
                    + Tambah Budget
                </button>
            </form>
        </div>
        @endif

        {{-- Daftar budget --}}
        @forelse ($budgets as $budget)
        @php
            $statusColors = [
                'safe'     => ['bar'=>'#22C55E','bg'=>'#DCFCE7','text'=>'Aman'],
                'warning'  => ['bar'=>'#EAB308','bg'=>'#FEF9C3','text'=>'Hampir Habis'],
                'exceeded' => ['bar'=>'#EF4444','bg'=>'#FEE2E2','text'=>'Melebihi Limit'],
            ];
            $sc = $statusColors[$budget->status];
        @endphp
        <div style="background:#fff;border-radius:14px;padding:16px;">
            <div style="display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:12px;">
                <div>
                    <div style="font-size:15px;font-weight:700;color:#1E293B;">{{ $budget->category->name }}</div>
                    <div style="font-size:11px;color:#94A3B8;margin-top:1px;">Per bulan</div>
                </div>
                <span style="background:{{ $sc['bg'] }};color:{{ $sc['bar'] }};padding:3px 10px;border-radius:99px;font-size:11px;font-weight:700;flex-shrink:0;">
                    {{ $sc['text'] }}
                </span>
            </div>

            {{-- Progress --}}
            <div style="height:8px;background:#F1F5F9;border-radius:99px;overflow:hidden;margin-bottom:12px;">
                <div style="height:100%;width:{{ $budget->percent }}%;background:{{ $sc['bar'] }};border-radius:99px;"></div>
            </div>

            <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:8px;margin-bottom:12px;">
                <div>
                    <div style="font-size:10px;color:#94A3B8;font-weight:600;text-transform:uppercase;letter-spacing:.04em;margin-bottom:2px;">Terpakai</div>
                    <div style="font-size:13px;font-weight:800;color:{{ $sc['bar'] }};">
                        Rp {{ number_format($budget->spent, 0, ',', '.') }}
                    </div>
                </div>
                <div>
                    <div style="font-size:10px;color:#94A3B8;font-weight:600;text-transform:uppercase;letter-spacing:.04em;margin-bottom:2px;">Limit</div>
                    <div style="font-size:13px;font-weight:800;color:#1E293B;">
                        Rp {{ number_format($budget->amount, 0, ',', '.') }}
                    </div>
                </div>
                <div>
                    <div style="font-size:10px;color:#94A3B8;font-weight:600;text-transform:uppercase;letter-spacing:.04em;margin-bottom:2px;">Sisa</div>
                    <div style="font-size:13px;font-weight:800;color:{{ $budget->remaining() > 0 ? '#22C55E' : '#EF4444' }};">
                        Rp {{ number_format($budget->remaining(), 0, ',', '.') }}
                    </div>
                </div>
            </div>

            <form action="{{ route('budgets.destroy', $budget) }}" method="POST"
                 onsubmit="cdConfirm('Hapus budget {{ $budget->category->name }}?', this); return false;">
                @csrf @method('DELETE')
                <button type="submit"
                        style="width:100%;padding:8px;background:#FEE2E2;color:#dc2626;border:none;border-radius:8px;font-size:13px;font-weight:600;cursor:pointer;font-family:inherit;">
                    Hapus Budget
                </button>
            </form>
        </div>
        @empty
        <div style="text-align:center;padding:40px 20px;color:#94A3B8;">
            <div style="font-size:40px;margin-bottom:12px;"><x-heroicon-o-chart-bar class="w-6 h-6 inline text-blue-500" /></div>
            <div style="font-size:15px;font-weight:600;margin-bottom:4px;color:#64748B;">Belum ada budget</div>
            <div style="font-size:13px;">Tambahkan budget di atas untuk mulai mengontrol pengeluaran kamu.</div>
        </div>
        @endforelse

    </div>
    <div style="height:16px;"></div>
</x-mobile-layout>
