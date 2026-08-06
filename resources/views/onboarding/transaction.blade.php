<x-onboarding-layout>
    <div class="ob-header">
        <a href="{{ route('onboarding.step', 'category') }}"
           style="color:rgba(255,255,255,0.8);text-decoration:none;font-size:14px;font-weight:500;">
            ← Kembali
        </a>
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
            <svg xmlns="http://www.w3.org/2000/svg" style="width:32px;height:32px;color:#ca8a04;"
                 fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
        <div class="ob-title">Catat Transaksi Pertama</div>
        <div class="ob-desc">Opsional — kamu bisa tap "Lewati" di atas dan mulai mencatat nanti.</div>

        @if ($accounts->isEmpty())
            {{-- Kalau tidak ada rekening, skip langsung ke done --}}
            <div style="background:#FEF9C3;border-radius:12px;padding:16px;margin-bottom:20px;font-size:14px;color:#92400E;">
                ⚠️ Kamu belum memiliki rekening. Lewati langkah ini dan tambah rekening dulu dari dashboard.
            </div>
            <a href="{{ route('onboarding.step', 'done') }}"
               class="ob-btn ob-btn-primary"
               style="display:block;text-align:center;text-decoration:none;">
                Lanjut ke Selesai →
            </a>
        @else
            <form method="POST" action="{{ route('onboarding.store-transaction') }}"
                  style="display:flex;flex-direction:column;gap:0;"
                  id="tx-form">
                @csrf

                {{-- Jenis transaksi --}}
                <div class="ob-form-group">
                    <label class="ob-label">Jenis Transaksi</label>
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px;">
                        <div id="btn-income"
                             onclick="selectTxType('income')"
                             style="padding:12px;border:2px solid #16a34a;border-radius:12px;
                                    text-align:center;cursor:pointer;background:#DCFCE7;
                                    font-size:14px;font-weight:700;color:#16a34a;">
                            📈 Pemasukan
                        </div>
                        <div id="btn-expense"
                             onclick="selectTxType('expense')"
                             style="padding:12px;border:2px solid #E2E8F0;border-radius:12px;
                                    text-align:center;cursor:pointer;background:#fff;
                                    font-size:14px;font-weight:700;color:#64748B;">
                            📉 Pengeluaran
                        </div>
                    </div>
                    <input type="hidden" name="type" id="tx-type" value="income">
                </div>

                {{-- Rekening --}}
                <div class="ob-form-group">
                    <label class="ob-label">Rekening</label>
                    <select name="account_id" class="ob-select">
                        <option value="">-- Pilih Rekening --</option>
                        @foreach ($accounts as $acc)
                            <option value="{{ $acc->id }}">{{ $acc->name }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Kategori --}}
                <div class="ob-form-group">
                    <label class="ob-label">Kategori</label>
                    <select name="category_id" class="ob-select" id="tx-category">
                        @if ($incomeCategories->isNotEmpty())
                            <optgroup label="Pemasukan">
                                @foreach ($incomeCategories as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                @endforeach
                            </optgroup>
                        @else
                            <option value="">-- Belum ada kategori --</option>
                        @endif
                    </select>
                </div>

                {{-- Jumlah --}}
                <div class="ob-form-group">
                    <label class="ob-label">Jumlah</label>
                    <div style="position:relative;">
                        <span style="position:absolute;left:14px;top:50%;transform:translateY(-50%);
                                     font-size:14px;color:#94A3B8;font-weight:500;pointer-events:none;">Rp</span>
                        <input type="number" name="amount" min="1" step="1"
                               class="ob-input" style="padding-left:44px;"
                               placeholder="0">
                    </div>
                </div>

                {{-- Tanggal --}}
                <div class="ob-form-group">
                    <label class="ob-label">Tanggal</label>
                    <input type="date" name="transaction_date"
                           value="{{ date('Y-m-d') }}" class="ob-input">
                </div>

                {{-- Catatan --}}
                <div class="ob-form-group" style="margin-bottom:28px;">
                    <label class="ob-label">
                        Catatan
                        <span style="color:#94A3B8;font-weight:400;">(opsional)</span>
                    </label>
                    <input type="text" name="description" class="ob-input"
                           placeholder="Contoh: Gaji Juli, Makan siang">
                </div>

                <button type="submit" class="ob-btn ob-btn-primary">
                    Simpan & Selesai →
                </button>
            </form>
        @endif
    </div>

    @push('scripts')
    <script>
        const incomeCats  = @json($incomeCategories->map(fn($c) => ['id' => $c->id, 'name' => $c->name])->values());
        const expenseCats = @json($expenseCategories->map(fn($c) => ['id' => $c->id, 'name' => $c->name])->values());

        function selectTxType(type) {
            document.getElementById('tx-type').value = type;

            // Reset tampilan
            const btnIncome  = document.getElementById('btn-income');
            const btnExpense = document.getElementById('btn-expense');

            if (type === 'income') {
                btnIncome.style.cssText  = 'padding:12px;border:2px solid #16a34a;border-radius:12px;text-align:center;cursor:pointer;background:#DCFCE7;font-size:14px;font-weight:700;color:#16a34a;';
                btnExpense.style.cssText = 'padding:12px;border:2px solid #E2E8F0;border-radius:12px;text-align:center;cursor:pointer;background:#fff;font-size:14px;font-weight:700;color:#64748B;';
            } else {
                btnIncome.style.cssText  = 'padding:12px;border:2px solid #E2E8F0;border-radius:12px;text-align:center;cursor:pointer;background:#fff;font-size:14px;font-weight:700;color:#64748B;';
                btnExpense.style.cssText = 'padding:12px;border:2px solid #dc2626;border-radius:12px;text-align:center;cursor:pointer;background:#FEE2E2;font-size:14px;font-weight:700;color:#dc2626;';
            }

            // Update dropdown kategori
            const sel  = document.getElementById('tx-category');
            const cats = type === 'income' ? incomeCats : expenseCats;
            sel.innerHTML = '';

            if (cats.length === 0) {
                const opt = document.createElement('option');
                opt.value = '';
                opt.text  = '-- Belum ada kategori --';
                sel.appendChild(opt);
                return;
            }

            cats.forEach(c => {
                const opt = document.createElement('option');
                opt.value = c.id;
                opt.text  = c.name;
                sel.appendChild(opt);
            });
        }
    </script>
    @endpush
</x-onboarding-layout>