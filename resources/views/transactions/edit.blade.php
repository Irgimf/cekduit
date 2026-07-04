<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-xl text-gray-900">
            Edit {{ $transaction->type === 'income' ? 'Pemasukan' : 'Pengeluaran' }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-md mx-auto sm:px-6 lg:px-8">
            <div class="nb-card p-6">
                <form action="{{ route('transactions.update', $transaction) }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block text-sm font-black mb-1">Rekening</label>
                        <select name="account_id" class="nb-input w-full px-3 py-2 text-sm">
                            @foreach ($accounts as $account)
                                <option value="{{ $account->id }}"
                                        @selected(old('account_id', $transaction->account_id) == $account->id)>
                                    {{ $account->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('account_id') <p class="text-red-600 text-sm mt-1 font-bold">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-black mb-1">Kategori</label>
                        <select name="category_id" class="nb-input w-full px-3 py-2 text-sm">
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}"
                                        @selected(old('category_id', $transaction->category_id) == $category->id)>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id') <p class="text-red-600 text-sm mt-1 font-bold">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-black mb-1">Jumlah</label>
                        <input type="number" step="0.01" min="0.01" name="amount"
                               value="{{ old('amount', $transaction->amount) }}"
                               class="nb-input w-full px-3 py-2 text-sm">
                        @error('amount') <p class="text-red-600 text-sm mt-1 font-bold">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-black mb-1">Tanggal</label>
                        <input type="date" name="transaction_date"
                               value="{{ old('transaction_date', $transaction->transaction_date->format('Y-m-d')) }}"
                               class="nb-input w-full px-3 py-2 text-sm">
                        @error('transaction_date') <p class="text-red-600 text-sm mt-1 font-bold">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-black mb-1">Deskripsi (opsional)</label>
                        <input type="text" name="description"
                               value="{{ old('description', $transaction->description) }}"
                               class="nb-input w-full px-3 py-2 text-sm">
                        @error('description') <p class="text-red-600 text-sm mt-1 font-bold">{{ $message }}</p> @enderror
                    </div>

                    <div class="flex justify-end gap-2 pt-2">
                        <a href="{{ route('transactions.index', ['type' => $transaction->type]) }}"
                           class="nb-btn nb-btn-white px-4 py-2 text-sm">Batal</a>
                        <button type="submit"
                                class="{{ $transaction->type === 'income' ? 'nb-btn nb-btn-green' : 'nb-btn nb-btn-red' }} px-4 py-2 text-sm">
                            Update
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>