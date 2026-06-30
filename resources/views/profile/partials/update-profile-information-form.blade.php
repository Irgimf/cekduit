<section>
    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="space-y-4">
        @csrf
        @method('patch')

        <div>
            <label for="name" class="block text-sm font-black mb-1">Nama</label>
            <input id="name" type="text" name="name"
                   value="{{ old('name', $user->name) }}"
                   required autofocus autocomplete="name"
                   class="nb-input w-full px-3 py-2 text-sm">
            @error('name')
                <p class="text-red-600 text-sm mt-1 font-bold">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="email" class="block text-sm font-black mb-1">Email</label>
            <input id="email" type="email" name="email"
                   value="{{ old('email', $user->email) }}"
                   required autocomplete="username"
                   class="nb-input w-full px-3 py-2 text-sm">
            @error('email')
                <p class="text-red-600 text-sm mt-1 font-bold">{{ $message }}</p>
            @enderror

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="mt-2">
                    <p class="text-sm font-bold text-amber-600">
                        Email kamu belum terverifikasi.
                        <button form="send-verification"
                                class="underline cursor-pointer">
                            Kirim ulang verifikasi
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="text-sm font-bold text-green-600 mt-1">
                            Link verifikasi baru sudah dikirim ke email kamu.
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-3 pt-2">
            <button type="submit" class="nb-btn nb-btn-primary px-4 py-2 text-sm">
                Simpan Perubahan
            </button>

            @if (session('status') === 'profile-updated')
                <p class="text-sm font-bold text-green-600">
                    Tersimpan.
                </p>
            @endif
        </div>
    </form>
</section>