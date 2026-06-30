<section>
    <form method="post" action="{{ route('password.update') }}" class="space-y-4">
        @csrf
        @method('put')

        <div>
            <label for="current_password" class="block text-sm font-black mb-1">
                Password Saat Ini
            </label>
            <input id="current_password" type="password"
                   name="current_password"
                   autocomplete="current-password"
                   class="nb-input w-full px-3 py-2 text-sm">
            @error('current_password', 'updatePassword')
                <p class="text-red-600 text-sm mt-1 font-bold">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="password" class="block text-sm font-black mb-1">
                Password Baru
            </label>
            <input id="password" type="password"
                   name="password"
                   autocomplete="new-password"
                   class="nb-input w-full px-3 py-2 text-sm">
            @error('password', 'updatePassword')
                <p class="text-red-600 text-sm mt-1 font-bold">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="password_confirmation" class="block text-sm font-black mb-1">
                Konfirmasi Password Baru
            </label>
            <input id="password_confirmation" type="password"
                   name="password_confirmation"
                   autocomplete="new-password"
                   class="nb-input w-full px-3 py-2 text-sm">
            @error('password_confirmation', 'updatePassword')
                <p class="text-red-600 text-sm mt-1 font-bold">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex items-center gap-3 pt-2">
            <button type="submit" class="nb-btn nb-btn-dark px-4 py-2 text-sm">
                Update Password
            </button>

            @if (session('status') === 'password-updated')
                <p class="text-sm font-bold text-green-600">
                    Password berhasil diperbarui.
                </p>
            @endif
        </div>
    </form>
</section>