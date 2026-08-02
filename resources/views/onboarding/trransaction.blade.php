<x-onboarding-layout>
    <div class="ob-header">
        <a href="{{ route('onboarding.step', 'category') }}" style="color:rgba(255,255,255,0.8);text-decoration:none;font-size:14px;">← Kembali</a>
        <form method="POST" action="{{ route('onboarding.store-transaction') }}">
            @csrf
            <button type="submit" class="ob-skip">Lewati</button>
        </form>
    </div>

    <div class="ob-steps">
        <div class="ob-step-dot done"></div>
        <div class="ob-step-dot done"></div>
        <div class="ob-step-dot done"></div>
        <div class="ob-step-dot active"></div>
    </div>

    <div class="ob-content">
        <div class="ob-icon" style="background:#FEF9C3;">
            <svg xmlns="http://www.w3.org/2000/svg" style="width:32px;height:32px;color:#ca8a04;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
        <div class="ob-title">Catat Transaksi Pertama</div>
        <div class="ob-desc">Opsional — kamu bisa lewati ini dan mulai mencatat nanti kapan saja.</div>

        <form method="POST" action="{{ route('onboarding.store-transaction') }}"
              style="display:flex;flex-direction:column;gap:0;" x-data="{ type: 'income' }">
            @csrf

            {{-- Jenis transaksi --}}
            <div class="ob-form-group">
                <label class="ob-label">Jenis Transaksi</label>
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px;">
                    <div onclick="selectTxType('income', this)"
                         id="tx-income"
                         style="padding:12px;border:2px solid #16a34a;border-radius:12px;text-align:center;cursor:pointer;background:#DCFCE7;font-size:14px;font-weight:700;color:#16a34a;">
                        📈 Pemasukan
                    </div>
                    <div onclick="selectTxType('expense', this)"
                         id="tx-expense"
                         style="padding:12px;border:2px solid #E2E8F0;border-radius:12px;text-align:center;cursor:pointer;background:#fff;font-size:14px;font-weight:700;color:#64748B;">
                        📉 Pengeluaran
                    </div>
                </div>
                <input type="hidden" name="type" id="tx-type" value="income">
            </div>

            {{-- Rekening --}}
            <div class="ob-form-group">
                <label class="ob-label">Rekening</label>
                <select name="account_id" class="ob-select">
                    @foreach ($accounts as $acc)
                        <option value="{{ $acc->id }}">{{ $acc->name }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Kategori --}}
            <div class="ob-form-group">
                <label class="ob-label">Kategori</label>
                <select name="category_id" class="ob-select" id="tx-category">
                    <optgroup label="Pemasukan" id="opt-income">
                        @foreach ($incomeCategories as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                        @endforeach
                    </optgroup>
                </select>
            </div>

            {{-- Jumlah --}}
            <div class="ob-form-group">
                <label class="ob-label">Jumlah</label>
                <div style="position:relative;">
                    <span style="position:absolute;left:14px;top:50%;transform:translateY(-50%);font-size:14px;color:#94A3B8;font-weight:500;">Rp</span>
                    <input type="number" name="amount" min="1" step="1"
                           class="ob-input" style="padding-left:40px;" placeholder="0">
                </div>
            </div>

            {{-- Tanggal --}}
            <div class="ob-form-group">
                <label class="ob-label">Tanggal</label>
                <input type="date" name="transaction_date" value="{{ date('Y-m-d') }}" class="ob-input">
            </div>

            {{-- Deskripsi --}}
            <div class="ob-form-group" style="margin-bottom:24px;">
                <label class="ob-label">Catatan <span style="color:#94A3B8;font-weight:400;">(opsional)</span></label>
                <input type="text" name="description" class="ob-input" placeholder="Contoh: Gaji Juli, Makan siang">
            </div>

            <button type="submit" class="ob-btn ob-btn-primary">
                Simpan & Selesai →
            </button>
        </form>
    </div>

    @push('scripts')
    <script>
        const incomeCategories  = @json($incomeCategories->map(fn($c) => ['id' => $c->id, 'name' => $c->name]));
        const expenseCategories = @json($expenseCategories->map(fn($c) => ['id' => $c->id, 'name' => $c->name]));

        function selectTxType(type, el) {
            // Reset visual
            document.getElementById('tx-income').style.cssText  = 'padding:12px;border:2px solid #E2E8F0;border-radius:12px;text-align:center;cursor:pointer;background:#fff;font-size:14px;font-weight:700;color:#64748B;';
            document.getElementById('tx-expense').style.cssText = 'padding:12px;border:2px solid #E2E8F0;border-radius:12px;text-align:center;cursor:pointer;background:#fff;font-size:14px;font-weight:700;color:#64748B;';

            if (type === 'income') {
                document.getElementById('tx-income').style.cssText  = 'padding:12px;border:2px solid #16a34a;border-radius:12px;text-align:center;cursor:pointer;background:#DCFCE7;font-size:14px;font-weight:700;color:#16a34a;';
            } else {
                document.getElementById('tx-expense').style.cssText = 'padding:12px;border:2px solid #dc2626;border-radius:12px;text-align:center;cursor:pointer;background:#FEE2E2;font-size:14px;font-weight:700;color:#dc2626;';
            }

            document.getElementById('tx-type').value = type;

            // Update kategori
            const cats = type === 'income' ? incomeCategories : expenseCategories;
            const sel  = document.getElementById('tx-category');
            sel.innerHTML = '';
            cats.forEach(c => {
                const opt  = document.createElement('option');
                opt.value  = c.id;
                opt.text   = c.name;
                sel.appendChild(opt);
            });
        }
    </script>
    @endpush
</x-onboarding-layout>