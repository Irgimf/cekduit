<x-app-layout>
    <x-slot name="header">
        <div style="display:flex;align-items:center;gap:12px;">
            <a href="{{ route('accounts.index') }}" class="cd-btn cd-btn-white cd-btn-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>
            <h1 class="cd-page-title">Edit Rekening</h1>
        </div>
    </x-slot>

    <div style="max-width:480px;">
        <div class="cd-card" style="padding:28px;">
            <form action="{{ route('accounts.update', $account) }}" method="POST"
                  style="display:flex;flex-direction:column;gap:18px;"
                  x-data="{ type: '{{ old('type', $account->type) }}' }">
                @csrf
                @method('PUT')

                <div>
                    <label class="cd-label">Nama Rekening</label>
                    <input type="text" name="name" value="{{ old('name', $account->name) }}"
                           class="cd-input">
                    @error('name') <p class="cd-error">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="cd-label">Jenis</label>
                    <select name="type" x-model="type" class="cd-input">
                        <option value="cash" @selected(old('type', $account->type) == 'cash')>Dompet / Cash</option>
                        <option value="bank" @selected(old('type', $account->type) == 'bank')>Bank</option>
                        <option value="e_wallet" @selected(old('type', $account->type) == 'e_wallet')>E-Wallet</option>
                    </select>
                    @error('type') <p class="cd-error">{{ $message }}</p> @enderror
                </div>

                <div x-show="type !== 'cash'">
                    <label class="cd-label">
                        <span x-show="type === 'bank'">Nomor Rekening</span>
                        <span x-show="type === 'e_wallet'">Nomor HP</span>
                    </label>
                    <input type="text" name="account_number"
                           value="{{ old('account_number', $account->account_number) }}"
                           class="cd-input">
                    @error('account_number') <p class="cd-error">{{ $message }}</p> @enderror
                </div>

                <div x-show="type === 'bank'">
                    <label class="cd-label">Biaya Admin per Bulan</label>
                    <div style="position:relative;">
                        <span style="position:absolute;left:12px;top:50%;transform:translateY(-50%);font-size:13px;color:var(--muted);font-weight:500;">Rp</span>
                        <input type="number" step="500" min="0" name="admin_fee"
                               value="{{ old('admin_fee', $account->admin_fee) }}"
                               class="cd-input" style="padding-left:36px;">
                    </div>
                    @error('admin_fee') <p class="cd-error">{{ $message }}</p> @enderror
                </div>

                <div style="background:var(--blue-light);border-radius:8px;padding:12px;">
                    <p style="font-size:12px;color:var(--blue);font-weight:600;">Saldo saat ini</p>
                    <p style="font-size:20px;font-weight:800;color:var(--dark);">
                        Rp {{ number_format($account->balance, 0, ',', '.') }}
                    </p>
                    <p style="font-size:11px;color:var(--muted);margin-top:2px;">
                        Saldo tidak bisa diedit manual — berubah otomatis dari transaksi
                    </p>
                </div>

                <div style="display:flex;gap:10px;justify-content:flex-end;padding-top:4px;">
                    <a href="{{ route('accounts.index') }}" class="cd-btn cd-btn-white">Batal</a>
                    <button type="submit" class="cd-btn cd-btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>