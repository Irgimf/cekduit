<section>
    <p class="text-sm text-gray-600 mb-4">
        Setelah akun dihapus, semua data termasuk rekening, transaksi, dan kategori akan ikut terhapus permanen dan tidak bisa dipulihkan.
    </p>

    <button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
        class="nb-btn nb-btn-red px-4 py-2 text-sm">
        Hapus Akun Saya
    </button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
            @csrf
            @method('delete')

            <h2 class="text-lg font-black mb-2">
                Konfirmasi Hapus Akun
            </h2>

            <p class="text-sm text-gray-600 mb-4">
                Ketik password kamu untuk konfirmasi. Tindakan ini tidak bisa dibatalkan.
            </p>

            <div class="mb-4">
                <label for="password_delete" class="block text-sm font-black mb-1">
                    Password
                </label>
                <input id="password_delete" type="password"
                       name="password"
                       placeholder="Masukkan password kamu"
                       class="nb-input w-full px-3 py-2 text-sm">
                @error('password', 'userDeletion')
                    <p class="text-red-600 text-sm mt-1 font-bold">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end gap-2">
                <button type="button"
                        x-on:click="$dispatch('close')"
                        class="nb-btn nb-btn-white px-4 py-2 text-sm">
                    Batal
                </button>
                <button type="submit"
                        class="nb-btn nb-btn-red px-4 py-2 text-sm">
                    Ya, Hapus Akun
                </button>
            </div>
        </form>
    </x-modal>
</section>