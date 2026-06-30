<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-xl text-gray-900">Rekening</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-4 flex justify-end">
                <a href="{{ route('accounts.create') }}" class="nb-btn nb-btn-primary px-4 py-2 text-sm">
                    + Tambah Rekening
                </a>
            </div>

            <div class="nb-card overflow-x-auto">
                <table class="nb-table w-full text-left min-w-[500px]">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Jenis</th>
                            <th>Saldo</th>
                            <th class="text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($accounts as $account)
                            <tr>
                                <td class="font-bold">{{ $account->name }}</td>
                                <td class="capitalize">{{ str_replace('_', ' ', $account->type) }}</td>
                                <td class="font-bold">Rp {{ number_format($account->balance, 0, ',', '.') }}</td>
                                <td class="text-right">
                                    <div class="flex justify-end gap-2">
                                        <a href="{{ route('accounts.edit', $account) }}"
                                           class="nb-btn nb-btn-primary px-3 py-1 text-xs">Edit</a>
                                        <form action="{{ route('accounts.destroy', $account) }}" method="POST"
                                              class="inline" onsubmit="return confirm('Hapus rekening ini?')">
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
                                <td colspan="4" class="text-center text-gray-500 py-8 font-bold">
                                    Belum ada rekening.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>