<x-mobile-layout>
    {{-- Header --}}
    <div style="background:linear-gradient(135deg,#014BAA,#0166E8);padding:16px 20px 20px;display:flex;align-items:center;gap:12px;">
        <a href="{{ route('accounts.index') }}"
           style="width:36px;height:36px;background:rgba(255,255,255,0.2);border-radius:10px;display:flex;align-items:center;justify-content:center;text-decoration:none;flex-shrink:0;">
            <svg xmlns="http://www.w3.org/2000/svg" style="width:18px;height:18px;" fill="none" viewBox="0 0 24 24" stroke="white">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
        </a>
        <div style="font-size:18px;font-weight:700;color:#fff;">
            {{ isset($account) ? 'Edit Rekening' : 'Tambah Rekening' }}
        </div>
    </div>

    <div style="padding:16px;">
        <div style="background:#fff;border-radius:16px;padding:20px;">
            <form action="{{ isset($account) ? route('accounts.update', $account) : route('accounts.store') }}"
                  method="POST" style="display:flex;flex-direction:column;gap:16px;"
                  id="account-form">
                @csrf
                @if (isset($account)) @method('PUT') @endif

                {{-- Nama Rekening --}}
                <div>
                    <label style="display:block;font-size:13px;font-weight:600;color:#1E293B;margin-bottom:6px;">Nama Rekening</label>
                    <input type="text" name="name"
                           value="{{ old('name', isset($account) ? $account->name : '') }}"
                           placeholder="Contoh: BCA Utama, GoPay, Dompet"
                           style="width:100%;padding:12px 14px;border:1.5px solid #E2E8F0;border-radius:10px;font-size:14px;color:#1E293B;background:#fff;outline:none;font-family:inherit;">
                    @error('name')
                        <div style="font-size:12px;color:#EF4444;margin-top:4px;">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Jenis --}}
                <div>
                    <label style="display:block;font-size:13px;font-weight:600;color:#1E293B;margin-bottom:10px;">Jenis Rekening</label>
                    <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:8px;">
                        @php $currentType = old('type', isset($account) ? $account->type : 'cash'); @endphp
                        @foreach ([
                            ['value' => 'cash', 'label' => 'Cash', 'emoji' => '👛'],
                            ['value' => 'bank', 'label' => 'Bank', 'emoji' => '🏦'],
                            ['value' => 'e_wallet', 'label' => 'E-Wallet', 'emoji' => '📱'],
                        ] as $type)
                        <label style="cursor:pointer;" onclick="switchType('{{ $type['value'] }}')">
                            <input type="radio" name="type" value="{{ $type['value'] }}"
                                   {{ $currentType === $type['value'] ? 'checked' : '' }}
                                   style="display:none;">
                            <div id="type-{{ $type['value'] }}"
                                 style="padding:12px 8px;border-radius:12px;border:2px solid {{ $currentType === $type['value'] ? '#014BAA' : '#E2E8F0' }};text-align:center;background:{{ $currentType === $type['value'] ? '#E8F0FB' : '#fff' }};transition:all 0.15s;">
                                <div style="font-size:20px;margin-bottom:4px;">{{ $type['emoji'] }}</div>
                                <div style="font-size:12px;font-weight:700;color:#1E293B;">{{ $type['label'] }}</div>
                            </div>
                        </label>
                        @endforeach
                    </div>
                    @error('type')
                        <div style="font-size:12px;color:#EF4444;margin-top:4px;">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Nomor Rekening / HP (hanya untuk bank & e-wallet) --}}
                <div id="field-account-number"
                     style="{{ $currentType === 'cash' ? 'display:none;' : '' }}">
                    <label style="display:block;font-size:13px;font-weight:600;color:#1E293B;margin-bottom:6px;"
                           id="label-account-number">
                        {{ $currentType === 'e_wallet' ? 'Nomor HP' : 'Nomor Rekening' }}
                    </label>
                    <input type="text" name="account_number"
                           value="{{ old('account_number', isset($account) ? $account->account_number : '') }}"
                           placeholder="Contoh: 1234567890"
                           style="width:100%;padding:12px 14px;border:1.5px solid #E2E8F0;border-radius:10px;font-size:14px;color:#1E293B;background:#fff;outline:none;font-family:inherit;">
                    @error('account_number')
                        <div style="font-size:12px;color:#EF4444;margin-top:4px;">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Admin Fee (hanya untuk bank) --}}
                <div id="field-admin-fee"
                     style="{{ $currentType === 'bank' ? '' : 'display:none;' }}">
                    <label style="display:block;font-size:13px;font-weight:600;color:#1E293B;margin-bottom:6px;">Biaya Admin per Bulan</label>
                    <div style="position:relative;">
                        <span style="position:absolute;left:12px;top:50%;transform:translateY(-50%);font-size:13px;color:#94A3B8;font-weight:500;">Rp</span>
                        <input type="number" step="500" min="0" name="admin_fee"
                               value="{{ old('admin_fee', isset($account) ? $account->admin_fee : 0) }}"
                               style="width:100%;padding:12px 14px 12px 36px;border:1.5px solid #E2E8F0;border-radius:10px;font-size:14px;color:#1E293B;background:#fff;outline:none;font-family:inherit;">
                    </div>
                    @error('admin_fee')
                        <div style="font-size:12px;color:#EF4444;margin-top:4px;">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Info saldo (hanya untuk edit) --}}
                @if (isset($account))
                    <div style="background:#E8F0FB;border-radius:10px;padding:12px 14px;">
                        <div style="font-size:12px;font-weight:600;color:#014BAA;margin-bottom:3px;">Saldo Saat Ini</div>
                        <div style="font-size:18px;font-weight:800;color:#1E293B;">
                            Rp {{ number_format($account->balance, 0, ',', '.') }}
                        </div>
                        <div style="font-size:11px;color:#64748B;margin-top:2px;">
                            Saldo tidak bisa diedit manual
                        </div>
                    </div>
                @else
                    <div style="background:#FEF9C3;border-radius:10px;padding:12px 14px;">
                        <div style="font-size:13px;color:#92400e;">
                            💡 Saldo awal otomatis Rp 0 dan akan berubah sesuai transaksi yang kamu catat.
                        </div>
                    </div>
                @endif

                <button type="submit"
                        style="width:100%;padding:14px;background:#014BAA;color:#fff;border:none;border-radius:12px;font-size:15px;font-weight:700;cursor:pointer;font-family:inherit;">
                    {{ isset($account) ? 'Simpan Perubahan' : 'Tambah Rekening' }}
                </button>

                <a href="{{ route('accounts.index') }}"
                   style="display:block;text-align:center;padding:12px;background:#F0F4F8;border-radius:12px;font-size:14px;font-weight:600;color:#64748B;text-decoration:none;">
                    Batal
                </a>
            </form>
        </div>
    </div>

    @push('scripts')
    <script>
        function switchType(value) {
            // Update radio
            document.querySelector(`input[name="type"][value="${value}"]`).checked = true;

            // Reset visual semua
            ['cash','bank','e_wallet'].forEach(t => {
                const el = document.getElementById(`type-${t}`);
                el.style.borderColor = '#E2E8F0';
                el.style.background = '#fff';
            });

            // Highlight yang dipilih
            const selected = document.getElementById(`type-${value}`);
            selected.style.borderColor = '#014BAA';
            selected.style.background = '#E8F0FB';

            // Show/hide fields
            const fieldNumber = document.getElementById('field-account-number');
            const fieldAdmin  = document.getElementById('field-admin-fee');
            const labelNumber = document.getElementById('label-account-number');

            if (value === 'cash') {
                fieldNumber.style.display = 'none';
                fieldAdmin.style.display  = 'none';
            } else if (value === 'bank') {
                fieldNumber.style.display = '';
                fieldAdmin.style.display  = '';
                labelNumber.textContent   = 'Nomor Rekening';
            } else {
                fieldNumber.style.display = '';
                fieldAdmin.style.display  = 'none';
                labelNumber.textContent   = 'Nomor HP';
            }
        }
    </script>
    @endpush
</x-mobile-layout>