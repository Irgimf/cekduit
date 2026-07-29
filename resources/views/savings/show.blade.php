<x-app-layout>
    <x-slot name="header">{{ $goal->icon }} {{ $goal->name }}</x-slot>

    <div style="max-width:680px;display:flex;flex-direction:column;gap:20px;">

        {{-- Progress card --}}
        @php
            $statusInfo = [
                'completed' => ['color'=>'#22C55E','bg'=>'#DCFCE7','label'=>'✅ Tercapai!'],
                'almost'    => ['color'=>'#EAB308','bg'=>'#FEF9C3','label'=>'🔥 Hampir!'],
                'overdue'   => ['color'=>'#EF4444','bg'=>'#FEE2E2','label'=>'⚠️ Terlambat'],
                'active'    => ['color'=>'#014BAA','bg'=>'#E8F0FB','label'=>'💪 Berjalan'],
            ];
            $si = $statusInfo[$goal->status()];
        @endphp

        <div class="cd-card" style="padding:24px;">
            <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:20px;">
                <div>
                    <div style="font-size:22px;font-weight:800;color:var(--dark);">
                        {{ $goal->icon }} {{ $goal->name }}
                    </div>
                    @if ($goal->deadline)
                        <div style="font-size:13px;color:var(--muted);margin-top:3px;">
                            Deadline: {{ $goal->deadline->format('d M Y') }}
                            @if ($goal->daysLeft() !== null && ! $goal->is_completed)
                                · {{ $goal->daysLeft() }} hari lagi
                            @endif
                        </div>
                    @endif
                </div>
                <span style="background:{{ $si['bg'] }};color:{{ $si['color'] }};padding:6px 14px;border-radius:99px;font-size:13px;font-weight:700;">
                    {{ $si['label'] }}
                </span>
            </div>

            <div style="margin-bottom:16px;">
                <div style="display:flex;justify-content:space-between;font-size:13px;color:var(--muted);margin-bottom:6px;">
                    <span>Terkumpul: Rp {{ number_format($goal->current_amount, 0, ',', '.') }}</span>
                    <span style="font-weight:700;color:{{ $si['color'] }};">{{ $goal->progressPercent() }}%</span>
                    <span>Target: Rp {{ number_format($goal->target_amount, 0, ',', '.') }}</span>
                </div>
                <div style="height:14px;background:#F1F5F9;border-radius:99px;overflow:hidden;">
                    <div style="height:100%;width:{{ $goal->progressPercent() }}%;background:{{ $si['color'] }};border-radius:99px;transition:width 0.5s;"></div>
                </div>
            </div>

            <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:12px;">
                <div style="text-align:center;background:#F8FAFF;border-radius:10px;padding:14px;">
                    <div style="font-size:11px;color:var(--muted);font-weight:600;text-transform:uppercase;margin-bottom:4px;">Terkumpul</div>
                    <div style="font-size:16px;font-weight:800;color:#22C55E;">Rp {{ number_format($goal->current_amount, 0, ',', '.') }}</div>
                </div>
                <div style="text-align:center;background:#F8FAFF;border-radius:10px;padding:14px;">
                    <div style="font-size:11px;color:var(--muted);font-weight:600;text-transform:uppercase;margin-bottom:4px;">Sisa</div>
                    <div style="font-size:16px;font-weight:800;color:var(--red);">Rp {{ number_format($goal->remaining(), 0, ',', '.') }}</div>
                </div>
                <div style="text-align:center;background:#F8FAFF;border-radius:10px;padding:14px;">
                    <div style="font-size:11px;color:var(--muted);font-weight:600;text-transform:uppercase;margin-bottom:4px;">Jumlah Setor</div>
                    <div style="font-size:16px;font-weight:800;color:var(--blue);">{{ $deposits->count() }}x</div>
                </div>
            </div>
        </div>

        {{-- Form Setor --}}
        @if (! $goal->is_completed)
        <div class="cd-card" style="padding:24px;">
            <h3 style="font-size:16px;font-weight:700;color:var(--dark);margin-bottom:16px;">💰 Setor ke Goal Ini</h3>
            <form action="{{ route('savings.deposit', $goal) }}" method="POST"
                  style="display:flex;flex-direction:column;gap:14px;">
                @csrf

                <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;">
                    <div>
                        <label class="cd-label">Dari Rekening</label>
                        <select name="account_id" class="cd-input">
                            <option value="">-- Pilih --</option>
                            @foreach ($accounts as $acc)
                                <option value="{{ $acc->id }}">
                                    {{ $acc->name }} — Rp {{ number_format($acc->balance, 0, ',', '.') }}
                                </option>
                            @endforeach
                        </select>
                        @error('account_id') <p class="cd-error">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="cd-label">Jumlah Setoran</label>
                        <div style="position:relative;">
                            <span style="position:absolute;left:10px;top:50%;transform:translateY(-50%);font-size:12px;color:var(--muted);">Rp</span>
                            <input type="number" name="amount" min="1000" step="1000"
                                   class="cd-input" style="padding-left:30px;"
                                   placeholder="{{ number_format($goal->remaining(), 0, ',', '.') }}">
                        </div>
                        @error('amount') <p class="cd-error">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;">
                    <div>
                        <label class="cd-label">Tanggal</label>
                        <input type="date" name="deposited_at" value="{{ date('Y-m-d') }}" class="cd-input">
                    </div>
                    <div>
                        <label class="cd-label">Catatan (opsional)</label>
                        <input type="text" name="note" class="cd-input" placeholder="Nabung dari bonus, dll">
                    </div>
                </div>

                <button type="submit" class="cd-btn cd-btn-primary" style="justify-content:center;padding:13px;">
                    💰 Setor Sekarang
                </button>
            </form>
        </div>
        @else
        <div class="cd-card" style="padding:24px;text-align:center;background:#DCFCE7;">
            <div style="font-size:40px;margin-bottom:10px;">🎉</div>
            <div style="font-size:18px;font-weight:700;color:#15803d;">Goal Tercapai!</div>
            <div style="font-size:14px;color:#64748B;margin-top:4px;">Selamat! Kamu berhasil mencapai target tabungan ini.</div>
        </div>
        @endif

        {{-- Riwayat setoran --}}
        <div class="cd-card" style="overflow:hidden;">
            <div style="padding:16px 20px;border-bottom:1px solid var(--border);font-size:15px;font-weight:700;">
                Riwayat Setoran
            </div>
            @if ($deposits->isEmpty())
                <div style="padding:32px;text-align:center;color:var(--muted);font-size:14px;">
                    Belum ada setoran
                </div>
            @else
                <table class="cd-table">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Rekening</th>
                            <th>Catatan</th>
                            <th style="text-align:right;">Jumlah</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($deposits as $deposit)
                        <tr>
                            <td style="font-size:13px;color:var(--muted);">{{ $deposit->deposited_at->format('d M Y') }}</td>
                            <td style="font-size:13px;">{{ $deposit->account->name }}</td>
                            <td style="font-size:13px;color:var(--muted);">{{ $deposit->note ?: '—' }}</td>
                            <td style="text-align:right;font-weight:700;color:#22C55E;">
                                +Rp {{ number_format($deposit->amount, 0, ',', '.') }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>

        <a href="{{ route('savings.index') }}"
           class="cd-btn cd-btn-white" style="justify-content:center;">
            ← Kembali ke Semua Goal
        </a>
    </div>
</x-app-layout>