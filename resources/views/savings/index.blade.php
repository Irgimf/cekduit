<x-app-layout>
    <x-slot name="header">Target Tabungan</x-slot>

    <div style="max-width:900px;display:flex;flex-direction:column;gap:20px;">

        <div class="cd-card" style="padding:20px;background:linear-gradient(135deg,#014BAA,#0166E8);color:#fff;">
            <div style="font-size:15px;font-weight:700;margin-bottom:4px;">⭐ Fitur Premium — Target Tabungan</div>
            <div style="font-size:13px;opacity:0.85;">
                Buat goal tabungan dengan target dan deadline. Setor dari rekening manapun dan pantau progressnya.
            </div>
        </div>

        {{-- Form buat goal baru --}}
        <div class="cd-card" style="padding:24px;">
            <h3 style="font-size:16px;font-weight:700;color:var(--dark);margin-bottom:18px;">Buat Target Baru</h3>
            <form action="{{ route('savings.store') }}" method="POST">
                @csrf
                <div style="display:grid;grid-template-columns:auto 2fr 2fr 2fr auto;gap:12px;align-items:end;">
                    <div>
                        <label class="cd-label">Ikon</label>
                        <input type="text" name="icon" value="{{ old('icon', '🏆') }}"
                               class="cd-input" style="width:56px;text-align:center;font-size:20px;">
                    </div>
                    <div>
                        <label class="cd-label">Nama Goal</label>
                        <input type="text" name="name" value="{{ old('name') }}"
                               class="cd-input" placeholder="Contoh: Laptop baru, Liburan, Motor">
                        @error('name') <p class="cd-error">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="cd-label">Target (Rp)</label>
                        <div style="position:relative;">
                            <span style="position:absolute;left:10px;top:50%;transform:translateY(-50%);font-size:12px;color:var(--muted);">Rp</span>
                            <input type="number" name="target_amount" min="1000" step="1000"
                                   value="{{ old('target_amount') }}"
                                   class="cd-input" style="padding-left:30px;" placeholder="5.000.000">
                        </div>
                        @error('target_amount') <p class="cd-error">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="cd-label">Deadline (opsional)</label>
                        <input type="date" name="deadline" value="{{ old('deadline') }}" class="cd-input">
                    </div>
                    <button type="submit" class="cd-btn cd-btn-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Buat
                    </button>
                </div>
            </form>
        </div>

        {{-- Daftar goal --}}
        @if ($goals->isEmpty())
            <div class="cd-card" style="padding:48px;text-align:center;">
                <div style="font-size:48px;margin-bottom:12px;"><x-heroicon-o-building-library class="w-6 h-6 inline text-blue-500" style="width:1.2em; height:1.2em;"  /></div>
                <p style="color:var(--muted);font-size:15px;font-weight:500;">Belum ada target tabungan</p>
                <p style="color:var(--muted);font-size:13px;margin-top:4px;">Buat goal pertamamu di atas dan mulai menabung!</p>
            </div>
        @else
            <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(280px,1fr));gap:16px;">
                @foreach ($goals as $goal)
                @php
                    $statusInfo = [
                        'completed' => ['color'=>'#22C55E','bg'=>'#DCFCE7','label'=>'✅ Tercapai!'],
                        'almost'    => ['color'=>'#EAB308','bg'=>'#FEF9C3','label'=>'🔥 Hampir!'],
                        'overdue'   => ['color'=>'#EF4444','bg'=>'#FEE2E2','label'=>'<x-heroicon-o-exclamation-triangle class="w-5 h-5 inline text-yellow-500" style="width:1.2em; height:1.2em;"  />️ Terlambat'],
                        'active'    => ['color'=>'#014BAA','bg'=>'#E8F0FB','label'=>'💪 Berjalan'],
                    ];
                    $si = $statusInfo[$goal->status()];
                @endphp
                <div class="cd-card" style="padding:20px;{{ $goal->is_completed ? 'border:2px solid #22C55E;' : '' }}">
                    {{-- Header --}}
                    <div style="display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:14px;">
                        <div style="display:flex;align-items:center;gap:10px;">
                            <div style="font-size:28px;line-height:1;">{{ $goal->icon }}</div>
                            <div>
                                <div style="font-size:15px;font-weight:700;color:var(--dark);">{{ $goal->name }}</div>
                                @if ($goal->deadline)
                                    <div style="font-size:11px;color:var(--muted);margin-top:1px;">
                                        Deadline: {{ $goal->deadline->format('d M Y') }}
                                        @if ($goal->daysLeft() !== null && ! $goal->is_completed)
                                            ({{ $goal->daysLeft() }} hari lagi)
                                        @endif
                                    </div>
                                @endif
                            </div>
                        </div>
                        <span style="background:{{ $si['bg'] }};color:{{ $si['color'] }};padding:3px 10px;border-radius:99px;font-size:11px;font-weight:700;white-space:nowrap;">
                            {{ $si['label'] }}
                        </span>
                    </div>

                    {{-- Progress --}}
                    <div style="margin-bottom:12px;">
                        <div style="display:flex;justify-content:space-between;font-size:12px;color:var(--muted);margin-bottom:5px;">
                            <span>Rp {{ number_format($goal->current_amount, 0, ',', '.') }}</span>
                            <span style="font-weight:700;">{{ $goal->progressPercent() }}%</span>
                            <span>Rp {{ number_format($goal->target_amount, 0, ',', '.') }}</span>
                        </div>
                        <div style="height:10px;background:#F1F5F9;border-radius:99px;overflow:hidden;">
                            <div style="height:100%;width:{{ $goal->progressPercent() }}%;background:{{ $si['color'] }};border-radius:99px;transition:width 0.5s ease;"></div>
                        </div>
                    </div>

                    {{-- Info sisa --}}
                    @if (! $goal->is_completed)
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:8px;margin-bottom:14px;">
                        <div style="background:#F8FAFF;border-radius:8px;padding:10px;">
                            <div style="font-size:10px;color:var(--muted);font-weight:600;text-transform:uppercase;letter-spacing:.04em;margin-bottom:2px;">Sisa</div>
                            <div style="font-size:14px;font-weight:800;color:var(--dark);">
                                Rp {{ number_format($goal->remaining(), 0, ',', '.') }}
                            </div>
                        </div>
                        @if ($goal->monthlyNeeded())
                        <div style="background:#F8FAFF;border-radius:8px;padding:10px;">
                            <div style="font-size:10px;color:var(--muted);font-weight:600;text-transform:uppercase;letter-spacing:.04em;margin-bottom:2px;">Per Bulan</div>
                            <div style="font-size:14px;font-weight:800;color:var(--blue);">
                                Rp {{ number_format($goal->monthlyNeeded(), 0, ',', '.') }}
                            </div>
                        </div>
                        @endif
                    </div>
                    @endif

                    {{-- Aksi --}}
                    <div style="display:flex;gap:8px;">
                        <a href="{{ route('savings.show', $goal) }}"
                           class="cd-btn cd-btn-white cd-btn-sm" style="flex:1;justify-content:center;">
                            Detail & Setor
                        </a>
                        <form action="{{ route('savings.destroy', $goal) }}" method="POST"
                              onsubmit="cdConfirm('Hapus goal ini? Dana akan dikembalikan ke rekening.', this); return false;">
                            @csrf @method('DELETE')
                            <button type="submit" class="cd-btn cd-btn-red cd-btn-sm">Hapus</button>
                        </form>
                    </div>
                </div>
                @endforeach
            </div>
        @endif
    </div>
</x-app-layout>
