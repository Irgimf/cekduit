<x-onboarding-layout>
    <div class="ob-header">
        <a href="{{ route('onboarding.index') }}" style="color:rgba(255,255,255,0.8);text-decoration:none;font-size:14px;">← Kembali</a>
        <form method="POST" action="{{ route('onboarding.skip') }}">
            @csrf
            <button type="submit" class="ob-skip">Lewati</button>
        </form>
    </div>

    <div class="ob-steps">
        <div class="ob-step-dot done"></div>
        <div class="ob-step-dot active"></div>
        <div class="ob-step-dot"></div>
        <div class="ob-step-dot"></div>
    </div>

    <div class="ob-content">
        <div class="ob-icon" style="background:#E8F0FB;">
            <svg xmlns="http://www.w3.org/2000/svg" style="width:32px;height:32px;color:#014BAA;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
            </svg>
        </div>
        <div class="ob-title">Tambah Rekening</div>
        <div class="ob-desc">Masukkan rekening utama kamu dulu. Kamu bisa tambah lebih banyak nanti.</div>

        <form method="POST" action="{{ route('onboarding.store-account') }}"
              style="display:flex;flex-direction:column;gap:0;" x-data="{ type: 'cash' }">
            @csrf

            <div class="ob-form-group">
                <label class="ob-label">Nama Rekening</label>
                <input type="text" name="name" class="ob-input" required
                       placeholder="Contoh: Dompet, BCA, GoPay"
                       value="{{ old('name') }}">
                @error('name') <div style="font-size:12px;color:#EF4444;margin-top:4px;">{{ $message }}</div> @enderror
            </div>

            <div class="ob-form-group">
                <label class="ob-label">Jenis Rekening</label>
                <div class="ob-chip-grid">
                    @foreach ([
                        ['cash',     '<x-heroicon-o-wallet class="w-6 h-6 inline text-purple-500" />', 'Dompet / Cash'],
                        ['bank',     '<x-heroicon-o-building-library class="w-6 h-6 inline text-blue-500" />', 'Bank'],
                        ['e_wallet', '<x-heroicon-o-device-phone-mobile class="w-6 h-6 inline text-gray-500" />', 'E-Wallet'],
                    ] as [$val, $emoji, $label])
                    <div class="ob-chip {{ old('type','cash') === $val ? 'selected' : '' }}"
                         onclick="selectType('{{ $val }}', this)"
                         style="{{ $val === 'e_wallet' ? 'grid-column:1/-1;' : '' }}">
                        {{ $emoji }} {{ $label }}
                    </div>
                    @endforeach
                </div>
                <input type="hidden" name="type" id="type-input" value="{{ old('type','cash') }}">
            </div>

            <div class="ob-form-group" id="field-number" style="{{ old('type','cash') === 'cash' ? 'display:none;' : '' }}">
                <label class="ob-label" id="label-number">Nomor Rekening</label>
                <input type="text" name="account_number" class="ob-input"
                       placeholder="Masukkan nomor rekening / HP"
                       value="{{ old('account_number') }}">
            </div>

            <div style="margin-bottom:24px;"></div>

            <button type="submit" class="ob-btn ob-btn-primary">
                Simpan & Lanjut →
            </button>
        </form>
    </div>

    @push('scripts')
    <script>
        function selectType(val, el) {
            document.querySelectorAll('.ob-chip').forEach(c => c.classList.remove('selected'));
            el.classList.add('selected');
            document.getElementById('type-input').value = val;

            const fieldNum  = document.getElementById('field-number');
            const labelNum  = document.getElementById('label-number');
            fieldNum.style.display = val === 'cash' ? 'none' : '';
            labelNum.textContent   = val === 'e_wallet' ? 'Nomor HP' : 'Nomor Rekening';
        }
    </script>
    @endpush
</x-onboarding-layout>