<x-onboarding-layout>
    <div class="ob-header">
        <a href="{{ route('onboarding.step', 'account') }}" style="color:rgba(255,255,255,0.8);text-decoration:none;font-size:14px;">← Kembali</a>
        <form method="POST" action="{{ route('onboarding.skip') }}">
            @csrf
            <button type="submit" class="ob-skip">Lewati</button>
        </form>
    </div>

    <div class="ob-steps">
        <div class="ob-step-dot done"></div>
        <div class="ob-step-dot done"></div>
        <div class="ob-step-dot active"></div>
        <div class="ob-step-dot"></div>
    </div>

    <div class="ob-content">
        <div class="ob-icon" style="background:#DCFCE7;">
            <svg xmlns="http://www.w3.org/2000/svg" style="width:32px;height:32px;color:#16a34a;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
            </svg>
        </div>
        <div class="ob-title">Pilih Kategori</div>
        <div class="ob-desc">Tap kategori yang sering kamu gunakan. Kamu bisa tambah/hapus kapan saja.</div>

        <form method="POST" action="{{ route('onboarding.store-categories') }}">
            @csrf

            {{-- Kategori Pemasukan --}}
            <div style="margin-bottom:20px;">
                <div style="font-size:13px;font-weight:700;color:#16a34a;text-transform:uppercase;letter-spacing:.05em;margin-bottom:10px;">
                    📈 Pemasukan
                </div>
                @php
                $incomeSuggestions = ['Gaji', 'Freelance', 'Bisnis', 'Investasi', 'Hadiah', 'Beasiswa', 'Dana Kaget', 'Bonus'];
                @endphp
                <div style="display:flex;flex-wrap:wrap;gap:8px;">
                    @foreach ($incomeSuggestions as $i => $cat)
                    <label style="cursor:pointer;">
                        <input type="checkbox" name="income_categories[]" value="{{ $cat }}"
                               style="display:none;" class="cat-check"
                               {{ in_array($cat, ['Gaji', 'Freelance']) ? 'checked' : '' }}>
                        <div class="cat-chip {{ in_array($cat, ['Gaji', 'Freelance']) ? 'cat-selected-income' : '' }}"
                             style="padding:8px 14px;border:2px solid {{ in_array($cat, ['Gaji', 'Freelance']) ? '#16a34a' : '#E2E8F0' }};border-radius:99px;font-size:13px;font-weight:600;color:{{ in_array($cat, ['Gaji', 'Freelance']) ? '#16a34a' : '#64748B' }};background:{{ in_array($cat, ['Gaji', 'Freelance']) ? '#DCFCE7' : '#fff' }};transition:all 0.15s;">
                            {{ $cat }}
                        </div>
                    </label>
                    @endforeach
                </div>
            </div>

            {{-- Kategori Pengeluaran --}}
            <div style="margin-bottom:24px;">
                <div style="font-size:13px;font-weight:700;color:#dc2626;text-transform:uppercase;letter-spacing:.05em;margin-bottom:10px;">
                    📉 Pengeluaran
                </div>
                @php
                $expenseSuggestions = ['Makan & Minum', 'Transportasi', 'Belanja', 'Hiburan', 'Kesehatan', 'Pendidikan', 'Tagihan', 'Pulsa & Internet', 'Kos / Sewa', 'Kebutuhan Kuliah'];
                @endphp
                <div style="display:flex;flex-wrap:wrap;gap:8px;">
                    @foreach ($expenseSuggestions as $cat)
                    @php $defaultSelected = in_array($cat, ['Makan & Minum', 'Transportasi', 'Belanja']); @endphp
                    <label style="cursor:pointer;">
                        <input type="checkbox" name="expense_categories[]" value="{{ $cat }}"
                               style="display:none;" class="cat-check"
                               {{ $defaultSelected ? 'checked' : '' }}>
                        <div class="cat-chip {{ $defaultSelected ? 'cat-selected-expense' : '' }}"
                             style="padding:8px 14px;border:2px solid {{ $defaultSelected ? '#dc2626' : '#E2E8F0' }};border-radius:99px;font-size:13px;font-weight:600;color:{{ $defaultSelected ? '#dc2626' : '#64748B' }};background:{{ $defaultSelected ? '#FEE2E2' : '#fff' }};transition:all 0.15s;">
                            {{ $cat }}
                        </div>
                    </label>
                    @endforeach
                </div>
            </div>

            <button type="submit" class="ob-btn ob-btn-primary">
                Simpan & Lanjut →
            </button>
        </form>
    </div>

    @push('scripts')
    <script>
        document.querySelectorAll('.cat-check').forEach(checkbox => {
            const chip = checkbox.nextElementSibling;
            const isIncome = checkbox.name === 'income_categories[]';

            checkbox.addEventListener('change', () => {
                if (checkbox.checked) {
                    chip.style.borderColor = isIncome ? '#16a34a' : '#dc2626';
                    chip.style.background  = isIncome ? '#DCFCE7' : '#FEE2E2';
                    chip.style.color       = isIncome ? '#16a34a' : '#dc2626';
                } else {
                    chip.style.borderColor = '#E2E8F0';
                    chip.style.background  = '#fff';
                    chip.style.color       = '#64748B';
                }
            });

            chip.addEventListener('click', () => {
                checkbox.checked = !checkbox.checked;
                checkbox.dispatchEvent(new Event('change'));
            });
        });
    </script>
    @endpush
</x-onboarding-layout>