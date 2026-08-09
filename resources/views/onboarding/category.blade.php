<x-onboarding-layout>
    <div class="ob-header">
        <a href="{{ route('onboarding.step', 'account') }}"
           style="color:rgba(255,255,255,0.8);text-decoration:none;font-size:14px;font-weight:500;">
            ← Kembali
        </a>
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
            <svg xmlns="http://www.w3.org/2000/svg" style="width:32px;height:32px;color:#16a34a;"
                 fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
            </svg>
        </div>
        <div class="ob-title">Pilih Kategori</div>
        <div class="ob-desc">Tap kategori yang sering kamu gunakan. Kamu juga bisa tambah kategori sendiri.</div>

        {{-- Info limit untuk free user --}}
        @if (auth()->user()->isFree())
            <div id="limit-info"
                 style="background:#FEF9C3;border-radius:10px;padding:12px 14px;margin-bottom:20px;display:flex;align-items:center;gap:8px;font-size:13px;color:#92400E;font-weight:500;transition:all 0.2s;">
                <svg xmlns="http://www.w3.org/2000/svg" style="width:16px;height:16px;flex-shrink:0;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span>Akun gratis: maksimal <strong>&nbsp;{{ \App\Models\User::FREE_MAX_CATEGORIES }} kategori&nbsp;</strong> total (pemasukan + pengeluaran). Terpilih: <strong id="total-count">&nbsp;0&nbsp;</strong>/{{ \App\Models\User::FREE_MAX_CATEGORIES }}</span>
            </div>
        @endif

        @if ($errors->has('categories'))
            <div style="background:#FEE2E2;border-radius:10px;padding:12px 14px;margin-bottom:16px;font-size:13px;color:#dc2626;font-weight:500;">
                <x-heroicon-o-exclamation-triangle class="w-5 h-5 inline text-yellow-500" />️ {{ $errors->first('categories') }}
            </div>
        @endif

        <form method="POST" action="{{ route('onboarding.store-categories') }}" id="category-form">
            @csrf

            {{-- Kategori Pemasukan --}}
            <div style="margin-bottom:24px;">
                <div style="font-size:12px;font-weight:700;color:#16a34a;text-transform:uppercase;letter-spacing:.06em;margin-bottom:12px;display:flex;align-items:center;gap:6px;">
                    <x-heroicon-o-arrow-trending-up class="w-5 h-5 inline text-green-500" /> Pemasukan
                </div>

                <div style="display:flex;flex-wrap:wrap;gap:8px;margin-bottom:12px;" id="income-chips">
                    @php
                        $incomeSuggestions = ['Gaji','Freelance','Bisnis','Investasi','Hadiah','Beasiswa','Dana Kaget','Bonus','Uang Jajan','Penjualan'];
                        $defaultIncome = ['Gaji','Freelance'];
                    @endphp

                    @foreach ($incomeSuggestions as $cat)
                        @php $isDefault = in_array($cat, $defaultIncome); @endphp
                        <div class="chip-item {{ $isDefault ? 'chip-income-active' : 'chip-inactive' }}"
                             data-type="income"
                             data-value="{{ $cat }}"
                             onclick="toggleChip(this, 'income')">
                            {{ $cat }}
                            <input type="checkbox"
                                   name="income_categories[]"
                                   value="{{ $cat }}"
                                   style="display:none;"
                                   {{ $isDefault ? 'checked' : '' }}>
                        </div>
                    @endforeach
                </div>

                {{-- Tambah kategori pemasukan sendiri --}}
                <div style="display:flex;gap:8px;align-items:center;">
                    <input type="text" id="custom-income-input"
                           placeholder="Tambah kategori pemasukan..."
                           style="flex:1;padding:10px 14px;border:1.5px solid #E2E8F0;border-radius:10px;font-size:13px;color:#1E293B;background:#fff;outline:none;font-family:inherit;"
                           onfocus="this.style.borderColor='#16a34a'"
                           onblur="this.style.borderColor='#E2E8F0'"
                           onkeydown="if(event.key==='Enter'){event.preventDefault();addCustomChip('income');}">
                    <button type="button" onclick="addCustomChip('income')"
                            style="padding:10px 14px;background:#DCFCE7;color:#16a34a;border:none;border-radius:10px;font-size:13px;font-weight:700;cursor:pointer;white-space:nowrap;font-family:inherit;">
                        + Tambah
                    </button>
                </div>
            </div>

            {{-- Divider --}}
            <div style="height:1px;background:#E2E8F0;margin-bottom:24px;"></div>

            {{-- Kategori Pengeluaran --}}
            <div style="margin-bottom:28px;">
                <div style="font-size:12px;font-weight:700;color:#dc2626;text-transform:uppercase;letter-spacing:.06em;margin-bottom:12px;display:flex;align-items:center;gap:6px;">
                    <x-heroicon-o-arrow-trending-down class="w-5 h-5 inline text-red-500" /> Pengeluaran
                </div>

                <div style="display:flex;flex-wrap:wrap;gap:8px;margin-bottom:12px;" id="expense-chips">
                    @php
                        $expenseSuggestions = ['Makan & Minum','Transportasi','Belanja','Hiburan','Kesehatan','Pendidikan','Tagihan','Pulsa & Internet','Kos / Sewa','Kebutuhan Kuliah','Skincare','Olahraga'];
                        $defaultExpense = ['Makan & Minum','Transportasi','Belanja'];
                    @endphp

                    @foreach ($expenseSuggestions as $cat)
                        @php $isDefault = in_array($cat, $defaultExpense); @endphp
                        <div class="chip-item {{ $isDefault ? 'chip-expense-active' : 'chip-inactive' }}"
                             data-type="expense"
                             data-value="{{ $cat }}"
                             onclick="toggleChip(this, 'expense')">
                            {{ $cat }}
                            <input type="checkbox"
                                   name="expense_categories[]"
                                   value="{{ $cat }}"
                                   style="display:none;"
                                   {{ $isDefault ? 'checked' : '' }}>
                        </div>
                    @endforeach
                </div>

                {{-- Tambah kategori pengeluaran sendiri --}}
                <div style="display:flex;gap:8px;align-items:center;">
                    <input type="text" id="custom-expense-input"
                           placeholder="Tambah kategori pengeluaran..."
                           style="flex:1;padding:10px 14px;border:1.5px solid #E2E8F0;border-radius:10px;font-size:13px;color:#1E293B;background:#fff;outline:none;font-family:inherit;"
                           onfocus="this.style.borderColor='#dc2626'"
                           onblur="this.style.borderColor='#E2E8F0'"
                           onkeydown="if(event.key==='Enter'){event.preventDefault();addCustomChip('expense');}">
                    <button type="button" onclick="addCustomChip('expense')"
                            style="padding:10px 14px;background:#FEE2E2;color:#dc2626;border:none;border-radius:10px;font-size:13px;font-weight:700;cursor:pointer;white-space:nowrap;font-family:inherit;">
                        + Tambah
                    </button>
                </div>
            </div>

            {{-- Info jumlah dipilih --}}
            <div id="selection-info"
                 style="background:#E8F0FB;border-radius:10px;padding:10px 14px;margin-bottom:20px;font-size:13px;color:#014BAA;font-weight:500;text-align:center;">
                Terpilih: <span id="income-count">0</span> pemasukan, <span id="expense-count">0</span> pengeluaran
            </div>

            <button type="submit" class="ob-btn ob-btn-primary">
                Simpan & Lanjut →
            </button>
        </form>
    </div>

    <style>
        .chip-item {
            padding: 8px 16px;
            border-radius: 99px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.15s;
            user-select: none;
            border: 2px solid;
        }
        .chip-inactive {
            border-color: #E2E8F0;
            background: #fff;
            color: #64748B;
        }
        .chip-income-active {
            border-color: #16a34a;
            background: #DCFCE7;
            color: #16a34a;
        }
        .chip-expense-active {
            border-color: #dc2626;
            background: #FEE2E2;
            color: #dc2626;
        }
    </style>

    @push('scripts')
    <script>
        const IS_FREE    = {{ auth()->user()->isFree() ? 'true' : 'false' }};
        const MAX_CATS   = {{ \App\Models\User::FREE_MAX_CATEGORIES }};

        function countSelected() {
            const checked = document.querySelectorAll(
                '[name="income_categories[]"]:checked, [name="expense_categories[]"]:checked'
            );
            return checked.length;
        }

        function updateLimitUI() {
            const incomeChecked  = document.querySelectorAll('[name="income_categories[]"]:checked').length;
            const expenseChecked = document.querySelectorAll('[name="expense_categories[]"]:checked').length;
            const totalSelected  = incomeChecked + expenseChecked;

            const incomeCountEl  = document.getElementById('income-count');
            const expenseCountEl = document.getElementById('expense-count');
            if (incomeCountEl) incomeCountEl.textContent  = incomeChecked;
            if (expenseCountEl) expenseCountEl.textContent = expenseChecked;

            const info = document.getElementById('total-count');
            if (info) {
                info.textContent = totalSelected;
            }

            const limitInfo = document.getElementById('limit-info');
            if (limitInfo) {
                if (totalSelected >= MAX_CATS) {
                    limitInfo.style.background = '#FEE2E2';
                    limitInfo.style.color      = '#dc2626';
                } else {
                    limitInfo.style.background = '#FEF9C3';
                    limitInfo.style.color      = '#92400E';
                }
            }
        }

        function toggleChip(el, type) {
            const checkbox  = el.querySelector('input[type="checkbox"]');
            const isChecked = checkbox.checked;

            // Jika belum tercentang dan sudah mencapai batas maksimal untuk akun gratis
            if (!isChecked && IS_FREE && countSelected() >= MAX_CATS) {
                showLimitAlert();
                return;
            }

            checkbox.checked = !isChecked;

            if (checkbox.checked) {
                el.className = type === 'income'
                    ? 'chip-item chip-income-active'
                    : 'chip-item chip-expense-active';
            } else {
                el.className = 'chip-item chip-inactive';
            }

            updateLimitUI();
        }

        function addCustomChip(type) {
            const input = document.getElementById(`custom-${type}-input`);
            const value = input.value.trim();

            if (!value) {
                input.focus();
                return;
            }

            // Cek limit untuk free user
            if (IS_FREE && countSelected() >= MAX_CATS) {
                showLimitAlert();
                input.value = '';
                return;
            }

            // Cek duplikat
            const existing = document.querySelectorAll(`[name="${type}_categories[]"]`);
            for (let el of existing) {
                if (el.value.toLowerCase() === value.toLowerCase()) {
                    input.value = '';
                    input.focus();
                    return;
                }
            }

            // Buat chip baru
            const container = document.getElementById(`${type}-chips`);
            const chip      = document.createElement('div');
            chip.className  = type === 'income'
                ? 'chip-item chip-income-active'
                : 'chip-item chip-expense-active';
            chip.dataset.type  = type;
            chip.dataset.value = value;
            chip.onclick = function() { toggleChip(this, type); };
            chip.innerHTML = `${value} <input type="checkbox" name="${type}_categories[]" value="${value}" style="display:none;" checked>`;

            container.appendChild(chip);
            input.value = '';
            input.focus();
            updateLimitUI();
        }

        function showLimitAlert() {
            const el = document.getElementById('limit-info');
            if (el) {
                el.style.background = '#FEE2E2';
                el.style.color      = '#dc2626';
                el.style.transform  = 'scale(1.02)';
                setTimeout(() => {
                    el.style.transform = 'scale(1)';
                }, 200);
            }

            // Flash toast pesan
            let msg = document.getElementById('limit-flash');
            if (!msg) {
                msg = document.createElement('div');
                msg.id = 'limit-flash';
                msg.style.cssText = `
                    position: fixed;
                    top: 20px;
                    left: 50%;
                    transform: translateX(-50%);
                    background: #dc2626;
                    color: #fff;
                    padding: 10px 18px;
                    border-radius: 99px;
                    font-size: 13px;
                    font-weight: 700;
                    z-index: 9999;
                    white-space: nowrap;
                    box-shadow: 0 4px 16px rgba(0,0,0,0.2);
                    transition: opacity 0.3s;
                `;
                document.body.appendChild(msg);
            }
            msg.textContent = `Maksimal ${MAX_CATS} kategori untuk akun gratis!`;
            msg.style.opacity = '1';
            msg.style.display = 'block';
            setTimeout(() => {
                msg.style.opacity = '0';
                setTimeout(() => msg.style.display = 'none', 300);
            }, 2500);
        }

        // Cegah submit jika melebihi limit
        document.getElementById('category-form').addEventListener('submit', function(e) {
            if (IS_FREE && countSelected() > MAX_CATS) {
                e.preventDefault();
                showLimitAlert();
                return false;
            }
        });

        // Inisialisasi hitungan awal
        updateLimitUI();
    </script>
    @endpush
</x-onboarding-layout>