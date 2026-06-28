<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Rekening
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-800 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            <div class="mb-4 flex justify-end">
                <a href="{{ route('accounts.create') }}"
                   class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">
                    + Tambah Rekening
                </a>
            </div>

            <div class="bg-white shadow-sm rounded-lg overflow-hidden">
                <table class="w-full text-left">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-sm font-medium text-gray-600">Nama</th>
                            <th class="px-6 py-3 text-sm font-medium text-gray-600">Jenis</th>
                            <th class="px-6 py-3 text-sm font-medium text-gray-600">Saldo</th>
                            <th class="px-6 py-3 text-sm font-medium text-gray-600 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($accounts as $account)
                            <tr>
                                <td class="px-6 py-4">{{ $account->name }}</td>
                                <td class="px-6 py-4 capitalize">{{ str_replace('_', ' ', $account->type) }}</td>
                                <td class="px-6 py-4">Rp {{ number_format($account->balance, 0, ',', '.') }}</td>
                                <td class="px-6 py-4 text-right space-x-2">
                                    <a href="{{ route('accounts.edit', $account) }}"
                                       class="text-indigo-600 hover:underline">Edit</a>
                                    <form action="{{ route('accounts.destroy', $account) }}" method="POST"
                                          class="inline" onsubmit="return confirm('Hapus rekening ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:underline">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-4 text-center text-gray-500">
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