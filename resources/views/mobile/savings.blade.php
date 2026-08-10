<x-mobile-layout>
    <div style="background:linear-gradient(135deg,#014BAA,#0166E8);padding-top:max(20px,calc(env(safe-area-inset-top,0px) + 16px));padding-left:20px;padding-right:20px;padding-bottom:24px;">
        <div style="font-size:13px;color:rgba(255,255,255,0.75);margin-bottom:2px;">⭐ Fitur Premium</div>
        <div style="font-size:20px;font-weight:700;color:#fff;">Target Tabungan</div>
    </div>

    <div style="padding:16px;display:flex;flex-direction:column;gap:14px;">

        {{-- Form buat goal baru --}}
        <div style="background:#fff;border-radius:14px;padding:16px;">
            <div style="font-size:14px;font-weight:700;color:#1E293B;margin-bottom:14px;">Buat Target Baru</div>
            <form action="{{ route('savings.store') }}" method="POST"
                  style="display:flex;flex-direction:column;gap:12px;">
                @csrf

                <div style="display:grid;grid-template-columns:56px 1fr;gap:10px;">
                    <div>
                        <label style="display:block;font-size:13px;font-weight:600;color:#1E293B;margin-bottom:5px;">Ikon</label>
                        <input type="text" name="icon" value="🏆"
                               class="mobile-input" style="text-align:center;font-size:22px;padding:8px;">
                    </div>
                    <div>
                        <label style="display:block;font-size:13px;font-weight:600;color:#1E293B;margin-bottom:5px;">Nama Goal</label>
                        <input type="text" name="name" class="mobile-input" placeholder="Laptop, Liburan, Motor...">
                    </div>
                </div>

                <div>
                    <label style="display:block;font-size:13px;font-weight:600;color:#1E293B;margin-bottom:5px;">Target Tabungan</label>
                    <div style="position:relative;">
                        <span style="position:absolute;left:12px;top:50%;transform:translateY(-50%);font-size:13px;color:#94A3B8;font-weight:500;">Rp</span>
                        <input type="number" name="target_amount" min="1000" step="1000"
                               class="mobile-input" style="padding-left:36px;" placeholder="5.000.000">
                    </div>
                </div>

                <div>
                    <label style="display:block;font-size:13px;font-weight:600;color:#1E293B;margin-bottom:5px;">Deadline (opsional)</label>
                    <input type="date" name="deadline" class="mobile-input">
                </div>

                <button type="submit"
                        style="width:100%;padding:13px;background:#014BAA;color:#fff;border:none;border-radius:12px;font-size:14px;font-weight:700;cursor:pointer;font-family:inherit;">
                    🏆 Buat Target
                </button>
            </form>
        </div>

        {{-- Daftar goal --}}
        @forelse ($goals as $goal)
        @php
            $statusInfo = [
                'completed' => ['color'=>'#22C55E','label'=>'✅ Tercapai'],
                'almost'    => ['color'=>'#EAB308','label'=>'🔥 Hampir'],
                'overdue'   => ['color'=>'#EF4444','label'=>'<x-heroicon-o-exclamation-triangle class="w-5 h-5 inline text-yellow-500" style="width:1.2em; height:1.2em;"  />️ Terlambat'],
                'active'    => ['color'=>'#014BAA','label'=>'💪 Berjalan'],
            ];
            $si = $statusInfo[$goal->status()];
        @endphp
        <div style="background:#fff;border-radius:14px;padding:16px;">
            <div style="display:flex;align-items:flex-start;justify-content:space-between;margin-bottom:12px;">
                <div style="display:flex;align-items:center;gap:10px;flex:1;min-width:0;">
                    <div style="font-size:28px;flex-shrink:0;">{{ $goal->icon }}</div>
                    <div style="min-width:0;">
                        <div style="font-size:15px;font-weight:700;color:#1E293B;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                            {{ $goal->name }}
                        </div>
                        @if ($goal->deadline)
                        <div style="font-size:11px;color:#94A3B8;margin-top:1px;">
                            {{ $goal->deadline->format('d M Y') }}
                            @if ($goal->daysLeft() !== null && !$goal->is_completed)
                                · {{ $goal->daysLeft() }} hari lagi
                            @endif
                        </div>
                        @endif
                    </div>
                </div>
                <span style="color:{{ $si['color'] }};font-size:11px;font-weight:700;flex-shrink:0;margin-left:8px;">
                    {{ $si['label'] }}
                </span>
            </div>

            {{-- Progress --}}
            <div style="margin-bottom:10px;">
                <div style="display:flex;justify-content:space-between;font-size:11px;color:#94A3B8;margin-bottom:4px;">
                    <span>Rp {{ number_format($goal->current_amount, 0, ',', '.') }}</span>
                    <span style="font-weight:700;color:{{ $si['color'] }};">{{ $goal->progressPercent() }}%</span>
                    <span>Rp {{ number_format($goal->target_amount, 0, ',', '.') }}</span>
                </div>
                <div style="height:8px;background:#F1F5F9;border-radius:99px;overflow:hidden;">
                    <div style="height:100%;width:{{ $goal->progressPercent() }}%;background:{{ $si['color'] }};border-radius:99px;"></div>
                </div>
            </div>

            @if (!$goal->is_completed && $goal->monthlyNeeded())
            <div style="font-size:12px;color:#94A3B8;margin-bottom:10px;">
                <x-heroicon-o-light-bulb class="w-5 h-5 inline text-yellow-500" style="width:1.2em; height:1.2em;"  /> Perlu ~Rp {{ number_format($goal->monthlyNeeded(), 0, ',', '.') }}/bulan
            </div>
            @endif

            <div style="display:flex;gap:8px;">
                <a href="{{ route('savings.show', $goal) }}"
                   style="flex:1;display:flex;align-items:center;justify-content:center;padding:9px;background:#E8F0FB;border-radius:9px;font-size:13px;font-weight:700;color:#014BAA;text-decoration:none;">
                    <x-heroicon-o-currency-dollar class="w-6 h-6 inline text-green-500" style="width:1.2em; height:1.2em;"  /> Detail & Setor
                </a>
                <form action="{{ route('savings.destroy', $goal) }}" method="POST"
                      onsubmit="cdConfirm('Hapus goal ini? Dana yang sudah disetor akan dikembalikan ke rekening.', this); return false;">
                    @csrf @method('DELETE')
                    <button type="submit"
                            style="padding:9px 14px;background:#FEE2E2;color:#dc2626;border:none;border-radius:9px;font-size:13px;font-weight:700;cursor:pointer;font-family:inherit;">
                        Hapus
                    </button>
                </form>
            </div>
        </div>
        @empty
        <div style="text-align:center;padding:40px 20px;color:#94A3B8;">
            <div style="font-size:48px;margin-bottom:12px;"><x-heroicon-o-building-library class="w-6 h-6 inline text-blue-500" style="width:1.2em; height:1.2em;"  /></div>
            <div style="font-size:15px;font-weight:600;margin-bottom:4px;color:#64748B;">Belum ada target tabungan</div>
            <div style="font-size:13px;">Buat goal pertamamu di atas!</div>
        </div>
        @endforelse

    </div>
    <div style="height:16px;"></div>
</x-mobile-layout>
