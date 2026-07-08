@if (config('is_mobile'))
<x-mobile-auth-layout>
    <div style="padding-top:max(44px, calc(env(safe-area-inset-top, 0px) + 24px));padding-left:32px;padding-right:32px;padding-bottom:24px;text-align:center;">
        <div class="mobile-auth-top" style="padding-left:32px;padding-right:32px;padding-bottom:32px;text-align:center;">
            <div style="width:64px;height:64px;background:rgba(255,255,255,0.2);border-radius:20px;display:flex;align-items:center;justify-content:center;margin:0 auto 12px;">
                <svg xmlns="http://www.w3.org/2000/svg" style="width:32px;height:32px;" fill="none" viewBox="0 0 24 24" stroke="white" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div style="font-size:26px;font-weight:800;color:#fff;">CekDuit</div>
            <div style="font-size:13px;color:rgba(255,255,255,0.75);margin-top:4px;">Mulai kelola keuangan kamu</div>
        </div>

        <div style="flex:1;background:#F0F4F8;border-radius:28px 28px 0 0;padding:28px 24px 40px;overflow-y:auto;">
            <h2 style="font-size:20px;font-weight:700;color:#1E293B;margin-bottom:4px;">Buat Akun Baru</h2>
            <p style="font-size:13px;color:#94A3B8;margin-bottom:24px;">Gratis dan mudah digunakan</p>

            <form method="POST" action="{{ route('register') }}" style="display:flex;flex-direction:column;gap:14px;">
                @csrf
                <div class="mobile-form-group">
                    <label class="mobile-label">Nama Lengkap</label>
                    <input type="text" name="name" value="{{ old('name') }}" required autofocus
                           class="mobile-input" placeholder="Nama kamu">
                    @error('name') <div class="mobile-error">{{ $message }}</div> @enderror
                </div>
                <div class="mobile-form-group">
                    <label class="mobile-label">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required
                           class="mobile-input" placeholder="nama@email.com">
                    @error('email') <div class="mobile-error">{{ $message }}</div> @enderror
                </div>
                <div class="mobile-form-group">
                    <label class="mobile-label">Password</label>
                    <input type="password" name="password" required
                           class="mobile-input" placeholder="Min. 8 karakter">
                    @error('password') <div class="mobile-error">{{ $message }}</div> @enderror
                </div>
                <div class="mobile-form-group">
                    <label class="mobile-label">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" required
                           class="mobile-input" placeholder="Ulangi password">
                </div>
                <button type="submit" class="mobile-btn mobile-btn-primary" style="margin-top:4px;">
                    Buat Akun
                </button>
            </form>

            <p style="text-align:center;margin-top:20px;font-size:13px;color:#64748B;">
                Sudah punya akun?
                <a href="{{ route('login') }}" style="color:#014BAA;font-weight:700;text-decoration:none;">Masuk di sini</a>
            </p>
        </div>
    </div>
</x-mobile-auth-layout>

@else

<x-guest-layout>
    <h2 style="font-size:20px;font-weight:700;color:var(--dark);margin-bottom:4px;">Buat Akun</h2>
    <p style="font-size:14px;color:var(--muted);margin-bottom:24px;">Mulai kelola keuangan kamu hari ini</p>
    <form method="POST" action="{{ route('register') }}" style="display:flex;flex-direction:column;gap:16px;">
        @csrf
        <div>
            <label class="cd-label">Nama Lengkap</label>
            <input type="text" name="name" value="{{ old('name') }}" required autofocus class="cd-input" placeholder="Nama kamu">
            @error('name') <p class="cd-error">{{ $message }}</p> @enderror
        </div>
        <div>
            <label class="cd-label">Email</label>
            <input type="email" name="email" value="{{ old('email') }}" required class="cd-input" placeholder="nama@email.com">
            @error('email') <p class="cd-error">{{ $message }}</p> @enderror
        </div>
        <div>
            <label class="cd-label">Password</label>
            <input type="password" name="password" required class="cd-input" placeholder="Min. 8 karakter">
            @error('password') <p class="cd-error">{{ $message }}</p> @enderror
        </div>
        <div>
            <label class="cd-label">Konfirmasi Password</label>
            <input type="password" name="password_confirmation" required class="cd-input" placeholder="Ulangi password">
        </div>
        <button type="submit" class="cd-btn cd-btn-primary" style="justify-content:center;padding:11px;">Buat Akun</button>
    </form>
    <p style="text-align:center;margin-top:20px;font-size:13px;color:var(--muted);">
        Sudah punya akun? <a href="{{ route('login') }}" style="color:var(--blue);font-weight:600;">Masuk di sini</a>
    </p>
</x-guest-layout>

@endif