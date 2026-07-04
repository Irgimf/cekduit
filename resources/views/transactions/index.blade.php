<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-xl text-gray-900">Transaksi</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 space-y-4">

            {{-- Tab Pemasukan / Pengeluaran --}}
            <div class="flex">
                <a href="{{ route('transactions.index', array_merge(request()->query(), ['type' => 'income'])) }}"
                   class="flex-1 py-3 text-center font-black text-sm border-2 border-black
                          {{ $activeTab === 'income' ? 'bg-black text-white' : 'bg-white text-black hover:bg-gray-50' }}">
                    Pemasukan
                </a>
                <a href="{{ route('transactions.index', array_merge(request()->query(), ['type' => 'expense'])) }}"
                   class="flex-1 py-3 text-center font-black text-sm border-2 border-l-0 border-black
                          {{ $activeTab === 'expense' ? 'bg-black text-white' : 'bg-white text-black hover:bg-gray-50' }}">
                    Pengeluaran
                </a>
            </div>

            {{-- Filter --}}
            <form method="GET" class="nb-card p-4 grid grid-cols-1 md:grid-cols-5 gap-3">
                <input type="hidden" name="type" value="{{ $activeTab }}">
                <input type="text" name="search" value="{{ request('search') }}"
                       placeholder="Cari deskripsi..."
                       class="nb-input px-3 py-2 text-sm">
                <select name="account_id" class="nb-input px-3 py-2 text-sm">
                    <option value="">Semua Rekening</option>
                    @foreach ($accounts as $account)
                        <option value="{{ $account->id }}" @selected(request('account_id') == $account->id)>
                            {{ $account->name }}
                        </option>
                    @endforeach
                </select>
                <select name="category_id" class="nb-input px-3 py-2 text-sm">
                    <option value="">Semua Kategori</option>
                    @foreach ($activeTab === 'income' ? $incomeCategories : $expenseCategories as $category)
                        <option value="{{ $category->id }}" @selected(request('category_id') == $category->id)>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                <input type="date" name="from_date" value="{{ request('from_date') }}"
                       class="nb-input px-3 py-2 text-sm">
                <input type="date" name="to_date" value="{{ request('to_date') }}"
                       class="nb-input px-3 py-2 text-sm">
                <div class="md:col-span-5 flex justify-end gap-2">
                    <a href="{{ route('transactions.index', ['type' => $activeTab]) }}"
                       class="nb-btn nb-btn-white px-4 py-2 text-sm">Reset</a>
                    <button type="submit" class="nb-btn nb-btn-dark px-4 py-2 text-sm">Filter</button>
                </div>
            </form>

            {{-- Tombol Tambah --}}
            <div class="flex justify-end">
                @if ($activeTab === 'income')
                    <button onclick="document.getElementById('modal-income').classList.remove('hidden')"
                            class="nb-btn nb-btn-green px-4 py-2 text-sm">
                        + Tambah Pemasukan
                    </button>
                @else
                    <button onclick="document.getElementById('modal-expense').classList.remove('hidden')"
                            class="nb-btn nb-btn-red px-4 py-2 text-sm">
                        + Tambah Pengeluaran
                    </button>
                @endif
            </div>

            {{-- Tabel Transaksi --}}
            <div class="nb-card overflow-x-auto">
                <table class="nb-table w-full text-left min-w-[700px]">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Rekening</th>
                            <th>Kategori</th>
                            <th>Deskripsi</th>
                            <th>Jumlah</th>
                            <th class="text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($transactions as $transaction)
                            <tr>
                                <td>{{ $transaction->transaction_date->format('d/m/Y') }}</td>
                                <td>{{ $transaction->account->name }}</td>
                                <td>{{ $transaction->category->name }}</td>
                                <td>{{ $transaction->description ?: '-' }}</td>
                                <td class="font-black"
                                    style="color: {{ $transaction->type === 'income' ? '#16a34a' : '#dc2626' }}">
                                    {{ $transaction->type === 'income' ? '+' : '-' }}Rp {{ number_format($transaction->amount, 0, ',', '.') }}
                                </td>
                                <td class="text-right">
                                    <div class="flex justify-end gap-2">
                                        <a href="{{ route('transactions.edit', $transaction) }}"
                                           class="nb-btn nb-btn-primary px-3 py-1 text-xs">Edit</a>
                                        <form action="{{ route('transactions.destroy', $transaction) }}" method="POST"
                                              class="inline" onsubmit="return confirm('Hapus transaksi ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="nb-btn nb-btn-red px-3 py-1 text-xs">Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-8 font-bold text-gray-500">
                                    Belum ada data {{ $activeTab === 'income' ? 'pemasukan' : 'pengeluaran' }}.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div>{{ $transactions->links() }}</div>
        </div>
    </div>

    {{-- Modal Tambah Pemasukan --}}
    <div id="modal-income" class="hidden fixed inset-0 flex items-center justify-center"
         style="background: rgba(0,0,0,0.75); z-index: 9999;">
        <div class="nb-card p-6 w-full max-w-md mx-4">
            <h3 class="font-black text-lg mb-4">Tambah Pemasukan</h3>
            <form action="{{ route('transactions.store-income') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-black mb-1">Rekening</label>
                    <select name="account_id" class="nb-input w-full px-3 py-2 text-sm">
                        <option value="">-- Pilih Rekening --</option>
                        @foreach ($accounts as $account)
                            <option value="{{ $account->id }}">{{ $account->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-black mb-1">Kategori</label>
                    <select name="category_id" class="nb-input w-full px-3 py-2 text-sm">
                        <option value="">-- Pilih Kategori --</option>
                        @foreach ($incomeCategories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-black mb-1">Jumlah</label>
                    <input type="number" step="0.01" min="0.01" name="amount"
                           class="nb-input w-full px-3 py-2 text-sm">
                </div>
                <div>
                    <label class="block text-sm font-black mb-1">Tanggal</label>
                    <input type="date" name="transaction_date" value="{{ date('Y-m-d') }}"
                           class="nb-input w-full px-3 py-2 text-sm">
                </div>
                <div>
                    <label class="block text-sm font-black mb-1">Deskripsi (opsional)</label>
                    <input type="text" name="description" class="nb-input w-full px-3 py-2 text-sm">
                </div>
                <div class="flex justify-end gap-2 pt-2">
                    <button type="button"
                            onclick="document.getElementById('modal-income').classList.add('hidden')"
                            class="nb-btn nb-btn-white px-4 py-2 text-sm">Batal</button>
                    <button type="submit" class="nb-btn nb-btn-green px-4 py-2 text-sm">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Modal Tambah Pengeluaran --}}
    <div id="modal-expense" class="hidden fixed inset-0 flex items-center justify-center"
         style="background: rgba(0,0,0,0.75); z-index: 9999;">
        <div class="nb-card p-6 w-full max-w-md mx-4">
            <h3 class="font-black text-lg mb-4">Tambah Pengeluaran</h3>
            <form action="{{ route('transactions.store-expense') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-black mb-1">Rekening</label>
                    <select name="account_id" class="nb-input w-full px-3 py-2 text-sm">
                        <option value="">-- Pilih Rekening --</option>
                        @foreach ($accounts as $account)
                            <option value="{{ $account->id }}">{{ $account->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-black mb-1">Kategori</label>
                    <select name="category_id" class="nb-input w-full px-3 py-2 text-sm">
                        <option value="">-- Pilih Kategori --</option>
                        @foreach ($expenseCategories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-black mb-1">Jumlah</label>
                    <input type="number" step="0.01" min="0.01" name="amount"
                           class="nb-input w-full px-3 py-2 text-sm">
                </div>
                <div>
                    <label class="block text-sm font-black mb-1">Tanggal</label>
                    <input type="date" name="transaction_date" value="{{ date('Y-m-d') }}"
                           class="nb-input w-full px-3 py-2 text-sm">
                </div>
                <div>
                    <label class="block text-sm font-black mb-1">Deskripsi (opsional)</label>
                    <input type="text" name="description" class="nb-input w-full px-3 py-2 text-sm">
                </div>
                <div class="flex justify-end gap-2 pt-2">
                    <button type="button"
                            onclick="document.getElementById('modal-expense').classList.add('hidden')"
                            class="nb-btn nb-btn-white px-4 py-2 text-sm">Batal</button>
                    <button type="submit" class="nb-btn nb-btn-red px-4 py-2 text-sm">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>