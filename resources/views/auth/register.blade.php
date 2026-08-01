@if (config('is_mobile'))
<x-mobile-auth-layout>
    <div style="padding-top:max(44px, calc(env(safe-area-inset-top, 0px) + 24px));padding-left:32px;padding-right:32px;padding-bottom:24px;text-align:center;">
        <div class="mobile-auth-top" style="padding-left:32px;padding-right:32px;padding-bottom:32px;text-align:center;">
            <x-logo-icon size="72" radius="18" />
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

                <!-- Checkbox Persetujuan Mobile -->
                <div style="background:#F8FAFF;border-radius:10px;padding:12px;margin-bottom:4px;text-align:left;">
                    <label style="display:flex;align-items:flex-start;gap:10px;cursor:pointer;">
                        <input type="checkbox" name="agree_terms" required
                               style="width:16px;height:16px;margin-top:2px;accent-color:#014BAA;flex-shrink:0;">
                        <span style="font-size:12px;color:#64748B;line-height:1.6;">
                            Saya menyetujui
                            <a href="{{ route('legal.terms') }}" target="_blank" style="color:#014BAA;font-weight:700;">Syarat & Ketentuan</a>
                            dan
                            <a href="{{ route('legal.privacy') }}" target="_blank" style="color:#014BAA;font-weight:700;">Kebijakan Privasi</a>
                            CekDuit
                        </span>
                    </label>
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

        <!-- Checkbox Persetujuan Desktop -->
        <div style="background:#F8FAFF;border-radius:10px;padding:12px;border:1px solid #E2E8F0;">
            <label style="display:flex;align-items:flex-start;gap:10px;cursor:pointer;">
                <input type="checkbox" name="agree_terms" required
                       style="width:15px;height:15px;margin-top:2px;accent-color:#014BAA;flex-shrink:0;">
                <span style="font-size:13px;color:var(--muted);line-height:1.6;">
                    Saya menyetujui
                    <a href="{{ route('legal.terms') }}" target="_blank" style="color:var(--blue);font-weight:600;">Syarat & Ketentuan</a>
                    dan
                    <a href="{{ route('legal.privacy') }}" target="_blank" style="color:var(--blue);font-weight:600;">Kebijakan Privasi</a>
                    CekDuit
                </span>
            </label>
        </div>

        <button type="submit" class="cd-btn cd-btn-primary" style="justify-content:center;padding:11px;">Buat Akun</button>
    </form>
    <p style="text-align:center;margin-top:20px;font-size:13px;color:var(--muted);">
        Sudah punya akun? <a href="{{ route('login') }}" style="color:var(--blue);font-weight:600;">Masuk di sini</a>
    </p>
</x-guest-layout>

@endif
