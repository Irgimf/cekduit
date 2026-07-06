<x-mobile-layout>
    {{-- Header --}}
    <div class="mobile-page-header" style="flex-direction:column;align-items:center;padding:24px 20px 32px;">
        <img src="{{ Auth::user()->avatar_url }}" alt="Avatar"
             style="width:80px;height:80px;border-radius:50%;object-fit:cover;border:3px solid rgba(255,255,255,0.4);margin-bottom:12px;">
        <div style="color:#fff;font-size:18px;font-weight:700;">{{ Auth::user()->name }}</div>
        <div style="color:rgba(255,255,255,0.75);font-size:13px;margin-top:2px;">{{ Auth::user()->email }}</div>
    </div>

    <div style="padding:16px;display:flex;flex-direction:column;gap:12px;">

        {{-- Foto Profil --}}
        <div class="mobile-card">
            <div class="mobile-card-body">
                <div style="font-size:14px;font-weight:700;color:#1E293B;margin-bottom:12px;">Foto Profil</div>

                @if (session('status') === 'avatar-updated')
                    <div style="background:#DCFCE7;color:#16a34a;padding:10px 12px;border-radius:8px;font-size:13px;font-weight:500;margin-bottom:12px;">
                        ✓ Foto profil berhasil diperbarui
                    </div>
                @endif

                <div style="display:flex;align-items:center;gap:12px;margin-bottom:12px;">
                    <img id="current_avatar" src="{{ Auth::user()->avatar_url }}" alt="Avatar"
                         style="width:56px;height:56px;border-radius:50%;object-fit:cover;border:2px solid #E8F0FB;">
                    <div>
                        <label for="avatar_input" class="mobile-btn mobile-btn-white"
                               style="padding:8px 14px;font-size:13px;display:inline-flex;width:auto;cursor:pointer;">
                            <svg xmlns="http://www.w3.org/2000/svg" style="width:16px;height:16px;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            Pilih Foto
                        </label>
                        <input type="file" id="avatar_input" accept="image/png,image/jpeg" class="hidden" style="display:none;">
                    </div>
                </div>

                <form id="avatar_form" method="POST" action="{{ route('profile.avatar') }}">
                    @csrf
                    <input type="hidden" id="avatar_cropped" name="avatar_cropped">
                    <button type="submit" id="avatar_submit"
                            class="mobile-btn mobile-btn-primary" style="display:none;padding:11px;">
                        Simpan Foto
                    </button>
                </form>
            </div>
        </div>

        {{-- Informasi Profil --}}
        <div class="mobile-card">
            <div class="mobile-card-body">
                <div style="font-size:14px;font-weight:700;color:#1E293B;margin-bottom:16px;">Informasi Profil</div>
                <form method="POST" action="{{ route('profile.update') }}">
                    @csrf @method('PATCH')
                    <div class="mobile-form-group">
                        <label class="mobile-label">Nama</label>
                        <input type="text" name="name" value="{{ old('name', Auth::user()->name) }}"
                               class="mobile-input">
                        @error('name') <div class="mobile-error">{{ $message }}</div> @enderror
                    </div>
                    <div class="mobile-form-group">
                        <label class="mobile-label">Email</label>
                        <input type="email" name="email" value="{{ old('email', Auth::user()->email) }}"
                               class="mobile-input">
                        @error('email') <div class="mobile-error">{{ $message }}</div> @enderror
                    </div>
                    <button type="submit" class="mobile-btn mobile-btn-primary" style="padding:11px;">
                        Simpan Perubahan
                    </button>
                    @if (session('status') === 'profile-updated')
                        <div style="text-align:center;color:#16a34a;font-size:13px;font-weight:500;margin-top:8px;">✓ Profil berhasil diperbarui</div>
                    @endif
                </form>
            </div>
        </div>

        {{-- Ubah Password --}}
        <div class="mobile-card">
            <div class="mobile-card-body">
                <div style="font-size:14px;font-weight:700;color:#1E293B;margin-bottom:16px;">Ubah Password</div>
                <form method="POST" action="{{ route('password.update') }}">
                    @csrf @method('PUT')
                    <div class="mobile-form-group">
                        <label class="mobile-label">Password Saat Ini</label>
                        <input type="password" name="current_password" class="mobile-input" placeholder="••••••••">
                        @error('current_password', 'updatePassword')
                            <div class="mobile-error">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mobile-form-group">
                        <label class="mobile-label">Password Baru</label>
                        <input type="password" name="password" class="mobile-input" placeholder="Min. 8 karakter">
                        @error('password', 'updatePassword')
                            <div class="mobile-error">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mobile-form-group">
                        <label class="mobile-label">Konfirmasi Password</label>
                        <input type="password" name="password_confirmation" class="mobile-input" placeholder="Ulangi password baru">
                    </div>
                    <button type="submit" class="mobile-btn" style="background:#1E293B;color:#fff;padding:11px;">
                        Update Password
                    </button>
                    @if (session('status') === 'password-updated')
                        <div style="text-align:center;color:#16a34a;font-size:13px;font-weight:500;margin-top:8px;">✓ Password berhasil diperbarui</div>
                    @endif
                </form>
            </div>
        </div>

        {{-- Logout --}}
        <div class="mobile-card">
            <div class="mobile-card-body">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="mobile-btn mobile-btn-red" style="padding:13px;">
                        <svg xmlns="http://www.w3.org/2000/svg" style="width:18px;height:18px;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                        </svg>
                        Keluar dari Akun
                    </button>
                </form>
            </div>
        </div>

        {{-- Hapus Akun --}}
        <button onclick="openSheet('sheet-delete')"
                style="background:none;border:none;color:#EF4444;font-size:13px;font-weight:600;cursor:pointer;padding:8px;text-align:center;width:100%;">
            Hapus Akun
        </button>

        {{-- Sheet Hapus Akun --}}
        <div id="sheet-delete" class="mobile-modal-overlay">
            <div class="mobile-modal-sheet">
                <div class="mobile-modal-handle"></div>
                <h3 style="font-size:17px;font-weight:700;color:#EF4444;margin-bottom:8px;">Hapus Akun</h3>
                <p style="font-size:13px;color:#64748B;margin-bottom:20px;">Semua data akan terhapus permanen dan tidak bisa dipulihkan.</p>
                <form method="POST" action="{{ route('profile.destroy') }}">
                    @csrf @method('DELETE')
                    <div class="mobile-form-group">
                        <label class="mobile-label">Masukkan Password untuk Konfirmasi</label>
                        <input type="password" name="password" class="mobile-input" placeholder="Password kamu">
                        @error('password', 'userDeletion')
                            <div class="mobile-error">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="mobile-btn mobile-btn-red">Ya, Hapus Akun Saya</button>
                    <button type="button" onclick="closeSheet('sheet-delete')" class="mobile-btn mobile-btn-white">Batal</button>
                </form>
            </div>
        </div>
    </div>

    <div style="height:16px;"></div>

    {{-- Cropper untuk avatar --}}
    <div id="crop_modal" style="display:none;position:fixed;inset:0;background:rgba(15,23,42,0.7);z-index:9999;align-items:flex-end;justify-content:center;">
        <div style="background:#fff;border-radius:24px 24px 0 0;padding:16px 20px 40px;width:100%;max-height:85vh;overflow:hidden;">
            <div style="width:40px;height:4px;background:#E2E8F0;border-radius:99px;margin:0 auto 16px;"></div>
            <h3 style="font-size:16px;font-weight:700;color:#1E293B;margin-bottom:12px;">Atur Foto Profil</h3>
            <div style="max-height:300px;overflow:hidden;border-radius:12px;border:1.5px solid #E2E8F0;">
                <img id="crop_preview" src="" style="max-width:100%;display:block;">
            </div>
            <div style="display:flex;gap:10px;margin-top:16px;">
                <button id="crop_cancel" class="mobile-btn mobile-btn-white" style="padding:11px;">Batal</button>
                <button id="crop_btn" class="mobile-btn mobile-btn-primary" style="padding:11px;">Gunakan Foto</button>
            </div>
        </div>
    </div>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.2/cropper.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.2/cropper.min.js"></script>

    @push('scripts')
    <script>
        function openSheet(id) { document.getElementById(id).style.display = 'flex'; }
        function closeSheet(id) { document.getElementById(id).style.display = 'none'; }
        document.querySelectorAll('.mobile-modal-overlay').forEach(el => {
            el.addEventListener('click', e => { if (e.target === el) closeSheet(el.id); });
        });

        // Cropper
        const cropModal   = document.getElementById('crop_modal');
        const input       = document.getElementById('avatar_input');
        const preview     = document.getElementById('crop_preview');
        const cropBtn     = document.getElementById('crop_btn');
        const cancelBtn   = document.getElementById('crop_cancel');
        const croppedInput= document.getElementById('avatar_cropped');
        const submitBtn   = document.getElementById('avatar_submit');
        let cropper = null;

        document.body.appendChild(cropModal);

        input.addEventListener('change', e => {
            const file = e.target.files[0];
            if (!file) return;
            const reader = new FileReader();
            reader.onload = ev => {
                preview.src = ev.target.result;
                cropModal.style.display = 'flex';
                if (cropper) { cropper.destroy(); cropper = null; }
                preview.onload = () => {
                    cropper = new Cropper(preview, { aspectRatio: 1, viewMode: 2, dragMode: 'move', autoCropArea: 0.8 });
                };
            };
            reader.readAsDataURL(file);
        });

        cropBtn.addEventListener('click', () => {
            if (!cropper) return;
            cropper.getCroppedCanvas({ width: 300, height: 300 }).toBlob(blob => {
                document.getElementById('current_avatar').src = URL.createObjectURL(blob);
                const reader = new FileReader();
                reader.onload = e => {
                    croppedInput.value = e.target.result;
                    submitBtn.style.display = 'flex';
                };
                reader.readAsDataURL(blob);
                cropModal.style.display = 'none';
                if (cropper) { cropper.destroy(); cropper = null; }
                input.value = '';
            }, 'image/jpeg', 0.9);
        });

        cancelBtn.addEventListener('click', () => {
            cropModal.style.display = 'none';
            if (cropper) { cropper.destroy(); cropper = null; }
            input.value = '';
        });
    </script>
    @endpush
</x-mobile-layout>