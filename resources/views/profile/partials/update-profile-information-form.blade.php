<section>
    <form id="send-verification" method="post" action="{{ route('verification.send') }}">@csrf</form>

    <form method="post" action="{{ route('profile.update') }}"
          style="display:flex;flex-direction:column;gap:16px;">
        @csrf
        @method('patch')

        <div>
            <label class="cd-label">Nama</label>
            <input id="name" type="text" name="name"
                   value="{{ old('name', $user->name) }}" required autofocus
                   class="cd-input">
            @error('name') <p class="cd-error">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="cd-label">Email</label>
            <input id="email" type="email" name="email"
                   value="{{ old('email', $user->email) }}" required
                   class="cd-input">
            @error('email') <p class="cd-error">{{ $message }}</p> @enderror

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div style="margin-top:8px;padding:10px;background:#fef9c3;border-radius:8px;font-size:13px;">
                    Email belum terverifikasi.
                    <button form="send-verification"
                            style="color:var(--blue);font-weight:600;background:none;border:none;cursor:pointer;padding:0;">
                        Kirim ulang verifikasi
                    </button>
                </div>
                @if (session('status') === 'verification-link-sent')
                    <p style="font-size:13px;color:var(--green);margin-top:4px;">Link verifikasi terkirim.</p>
                @endif
            @endif
        </div>

        <div style="display:flex;align-items:center;gap:12px;">
            <button type="submit" class="cd-btn cd-btn-primary">Simpan Perubahan</button>
            @if (session('status') === 'profile-updated')
                <p style="font-size:13px;color:var(--green);font-weight:500;">✓ Tersimpan</p>
            @endif
        </div>
    </form>
</section>