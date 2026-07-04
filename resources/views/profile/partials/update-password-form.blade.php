<section>
    <form method="post" action="{{ route('password.update') }}"
          style="display:flex;flex-direction:column;gap:16px;">
        @csrf
        @method('put')

        <div>
            <label class="cd-label">Password Saat Ini</label>
            <input id="current_password" type="password" name="current_password"
                   class="cd-input" placeholder="••••••••">
            @error('current_password', 'updatePassword')
                <p class="cd-error">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="cd-label">Password Baru</label>
            <input id="password" type="password" name="password"
                   class="cd-input" placeholder="Min. 8 karakter">
            @error('password', 'updatePassword')
                <p class="cd-error">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="cd-label">Konfirmasi Password Baru</label>
            <input id="password_confirmation" type="password" name="password_confirmation"
                   class="cd-input" placeholder="Ulangi password baru">
        </div>

        <div style="display:flex;align-items:center;gap:12px;">
            <button type="submit" class="cd-btn cd-btn-dark">Update Password</button>
            @if (session('status') === 'password-updated')
                <p style="font-size:13px;color:var(--green);font-weight:500;">✓ Password diperbarui</p>
            @endif
        </div>
    </form>
</section>