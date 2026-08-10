<x-mobile-layout>
    <div style="background:linear-gradient(135deg,#014BAA,#0166E8);
                padding-top:max(16px,calc(env(safe-area-inset-top,0px) + 14px));
                padding-left:20px;padding-right:20px;padding-bottom:20px;
                display:flex;align-items:center;gap:12px;">
        <a href="{{ route('transactions.index', ['type' => $transaction->type]) }}"
           style="width:36px;height:36px;background:rgba(255,255,255,0.2);border-radius:10px;
                  display:flex;align-items:center;justify-content:center;text-decoration:none;flex-shrink:0;">
            <svg xmlns="http://www.w3.org/2000/svg" style="width:18px;height:18px;" fill="none" viewBox="0 0 24 24" stroke="white">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
        </a>
        <div style="font-size:18px;font-weight:700;color:#fff;">Edit Transaksi</div>
    </div>

    <div style="padding:16px;">
        <div style="background:#fff;border-radius:16px;padding:20px;">
            <form action="{{ route('transactions.update', $transaction) }}" method="POST"
                  style="display:flex;flex-direction:column;gap:14px;">
                @csrf
                @method('PUT')

                {{-- Jenis --}}
                <div>
                    <label style="display:block;font-size:13px;font-weight:600;color:#1E293B;margin-bottom:6px;">Jenis</label>
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:8px;">
                        <div onclick="selectType('income')" id="btn-income"
                             style="padding:10px;border:2px solid {{ $transaction->type === 'income' ? '#16a34a' : '#E2E8F0' }};
                                    border-radius:10px;text-align:center;cursor:pointer;font-size:13px;font-weight:700;
                                    color:{{ $transaction->type === 'income' ? '#16a34a' : '#64748B' }};
                                    background:{{ $transaction->type === 'income' ? '#DCFCE7' : '#fff' }};">
                            <x-heroicon-o-arrow-trending-up class="w-5 h-5 inline text-green-500" style="width:1.2em; height:1.2em;"  /> Pemasukan
                        </div>
                        <div onclick="selectType('expense')" id="btn-expense"
                             style="padding:10px;border:2px solid {{ $transaction->type === 'expense' ? '#dc2626' : '#E2E8F0' }};
                                    border-radius:10px;text-align:center;cursor:pointer;font-size:13px;font-weight:700;
                                    color:{{ $transaction->type === 'expense' ? '#dc2626' : '#64748B' }};
                                    background:{{ $transaction->type === 'expense' ? '#FEE2E2' : '#fff' }};">
                            <x-heroicon-o-arrow-trending-down class="w-5 h-5 inline text-red-500" style="width:1.2em; height:1.2em;"  /> Pengeluaran
                        </div>
                    </div>
                    <input type="hidden" name="type" id="type-input" value="{{ $transaction->type }}">
                </div>

                {{-- Rekening --}}
                <div>
                    <label style="display:block;font-size:13px;font-weight:600;color:#1E293B;margin-bottom:6px;">Rekening</label>
                    <select name="account_id" class="mobile-select">
                        @foreach ($accounts as $acc)
                            <option value="{{ $acc->id }}" @selected($acc->id === $transaction->account_id)>
                                {{ $acc->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Kategori --}}
                <div>
                    <label style="display:block;font-size:13px;font-weight:600;color:#1E293B;margin-bottom:6px;">Kategori</label>
                    <select name="category_id" class="mobile-select" id="cat-select">
                        @foreach ($incomeCategories as $cat)
                            <option value="{{ $cat->id }}"
                                    data-type="income"
                                    @selected($cat->id === $transaction->category_id)>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                        @foreach ($expenseCategories as $cat)
                            <option value="{{ $cat->id }}"
                                    data-type="expense"
                                    @selected($cat->id === $transaction->category_id)>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Jumlah --}}
                <div>
                    <label style="display:block;font-size:13px;font-weight:600;color:#1E293B;margin-bottom:6px;">Jumlah</label>
                    <div style="position:relative;">
                        <span style="position:absolute;left:12px;top:50%;transform:translateY(-50%);
                                     font-size:13px;color:#94A3B8;font-weight:500;">Rp</span>
                        <input type="number" name="amount" min="1" step="1"
                               value="{{ $transaction->amount }}"
                               class="mobile-input" style="padding-left:36px;">
                    </div>
                    @error('amount') <div style="font-size:12px;color:#EF4444;margin-top:4px;">{{ $message }}</div> @enderror
                </div>

                {{-- Tanggal --}}
                <div>
                    <label style="display:block;font-size:13px;font-weight:600;color:#1E293B;margin-bottom:6px;">Tanggal</label>
                    <input type="date" name="transaction_date"
                           value="{{ $transaction->transaction_date->format('Y-m-d') }}"
                           class="mobile-input">
                </div>

                {{-- Deskripsi --}}
                <div>
                    <label style="display:block;font-size:13px;font-weight:600;color:#1E293B;margin-bottom:6px;">
                        Catatan <span style="color:#94A3B8;font-weight:400;">(opsional)</span>
                    </label>
                    <input type="text" name="description"
                           value="{{ $transaction->description }}"
                           class="mobile-input" placeholder="Tulis catatan...">
                </div>

                <button type="submit"
                        style="width:100%;padding:14px;background:#014BAA;color:#fff;border:none;
                               border-radius:12px;font-size:15px;font-weight:700;cursor:pointer;
                               font-family:inherit;margin-top:4px;">
                    Simpan Perubahan
                </button>

                <a href="{{ route('transactions.index', ['type' => $transaction->type]) }}"
                   style="display:block;text-align:center;padding:12px;background:#F0F4F8;
                          border-radius:12px;font-size:14px;font-weight:600;color:#64748B;
                          text-decoration:none;">
                    Batal
                </a>
            </form>
        </div>
    </div>

    <div style="height:16px;"></div>

    @push('scripts')
    <script>
        function selectType(type) {
            document.getElementById('type-input').value = type;

            const btnI = document.getElementById('btn-income');
            const btnE = document.getElementById('btn-expense');

            if (type === 'income') {
                btnI.style.cssText = 'padding:10px;border:2px solid #16a34a;border-radius:10px;text-align:center;cursor:pointer;font-size:13px;font-weight:700;color:#16a34a;background:#DCFCE7;';
                btnE.style.cssText = 'padding:10px;border:2px solid #E2E8F0;border-radius:10px;text-align:center;cursor:pointer;font-size:13px;font-weight:700;color:#64748B;background:#fff;';
            } else {
                btnI.style.cssText = 'padding:10px;border:2px solid #E2E8F0;border-radius:10px;text-align:center;cursor:pointer;font-size:13px;font-weight:700;color:#64748B;background:#fff;';
                btnE.style.cssText = 'padding:10px;border:2px solid #dc2626;border-radius:10px;text-align:center;cursor:pointer;font-size:13px;font-weight:700;color:#dc2626;background:#FEE2E2;';
            }

            // Filter kategori
            const sel = document.getElementById('cat-select');
            Array.from(sel.options).forEach(opt => {
                opt.hidden = opt.dataset.type !== type;
            });
            // Select first visible
            const first = Array.from(sel.options).find(o => !o.hidden);
            if (first) sel.value = first.value;
        }
    </script>
    @endpush
</x-mobile-layout>
