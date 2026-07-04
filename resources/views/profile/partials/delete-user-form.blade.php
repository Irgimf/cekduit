<section>
    <button x-data="" x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
            class="cd-btn cd-btn-red">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
        </svg>
        Hapus Akun Saya
    </button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" style="padding:24px;">
            @csrf
            @method('delete')

            <h2 style="font-size:17px;font-weight:700;color:var(--dark);margin-bottom:8px;">Konfirmasi Hapus Akun</h2>
            <p style="font-size:14px;color:var(--muted);margin-bottom:20px;">
                Masukkan password untuk mengkonfirmasi. Tindakan ini tidak bisa dibatalkan.
            </p>

            <div style="margin-bottom:20px;">
                <label class="cd-label">Password</label>
                <input id="password_delete" type="password" name="password"
                       class="cd-input" placeholder="Masukkan password kamu">
                @error('password', 'userDeletion')
                    <p class="cd-error">{{ $message }}</p>
                @enderror
            </div>

            <div style="display:flex;justify-content:flex-end;gap:10px;">
                <button type="button" x-on:click="$dispatch('close')"
                        class="cd-btn cd-btn-white">Batal</button>
                <button type="submit" class="cd-btn cd-btn-red">Ya, Hapus Akun</button>
            </div>
        </form>
    </x-modal>
</section>