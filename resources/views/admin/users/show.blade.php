@extends('layouts.admin')

@section('content')
    @php $pageTitle = 'Detail User: ' . $user->name; @endphp

    <div style="max-width:800px;">

        {{-- Info User --}}
        <div class="admin-card" style="margin-bottom:20px;">
            <div style="padding:24px;display:flex;align-items:center;gap:20px;">
                <img src="{{ $user->avatar_url }}" style="width:72px;height:72px;border-radius:50%;object-fit:cover;border:3px solid #E2E8F0;">
                <div style="flex:1;">
                    <div style="font-size:20px;font-weight:700;color:#0F172A;margin-bottom:2px;">{{ $user->name }}</div>
                    <div style="font-size:14px;color:#64748B;margin-bottom:8px;">{{ $user->email }}</div>
                    <span class="role-badge {{ $user->role }}" style="font-size:12px;">
                        {{ ucfirst($user->role) }}
                    </span>
                </div>
                <div style="text-align:right;">
                    <div style="font-size:12px;color:#94A3B8;margin-bottom:4px;">Bergabung</div>
                    <div style="font-size:14px;font-weight:600;">{{ $user->created_at->format('d M Y') }}</div>
                </div>
            </div>

            {{-- Statistik user --}}
            <div style="display:grid;grid-template-columns:repeat(5,1fr);border-top:1px solid #F1F5F9;">
                @foreach ([
                    ['Rekening', $accountCount],
                    ['Kategori', $categoryCount],
                    ['Transaksi', $transactionCount],
                    ['Total Masuk', 'Rp ' . number_format($totalIncome, 0, ',', '.')],
                    ['Total Keluar', 'Rp ' . number_format($totalExpense, 0, ',', '.')],
                ] as [$label, $value])
                <div style="padding:16px;text-align:center;border-right:1px solid #F1F5F9;">
                    <div style="font-size:11px;color:#94A3B8;font-weight:600;text-transform:uppercase;letter-spacing:.04em;margin-bottom:5px;">{{ $label }}</div>
                    <div style="font-size:16px;font-weight:700;color:#0F172A;">{{ $value }}</div>
                </div>
                @endforeach
            </div>
        </div>

        {{-- Ubah Role --}}
        <div class="admin-card">
            <div class="admin-card-header">Ubah Role & Subscription</div>
            <div style="padding:24px;">
                <form action="{{ route('admin.users.update-role', $user) }}" method="POST"
                      style="display:flex;flex-direction:column;gap:16px;"
                      x-data="{ role: '{{ $user->role }}' }">
                    @csrf @method('PATCH')

                    <div>
                        <label style="display:block;font-size:13px;font-weight:600;color:#0F172A;margin-bottom:6px;">Role</label>
                        <select name="role" x-model="role" class="admin-select" style="width:100%;">
                            <option value="user">Free (User biasa)</option>
                            <option value="premium">Premium</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>

                    <div x-show="role === 'premium'" style="display:grid;grid-template-columns:1fr 1fr;gap:12px;">
                        <div>
                            <label style="display:block;font-size:13px;font-weight:600;color:#0F172A;margin-bottom:6px;">Paket</label>
                            <select name="subscription_plan" class="admin-select" style="width:100%;">
                                <option value="monthly" @selected($user->subscription_plan === 'monthly')>Bulanan</option>
                                <option value="yearly"  @selected($user->subscription_plan === 'yearly')>Tahunan</option>
                            </select>
                        </div>
                        <div>
                            <label style="display:block;font-size:13px;font-weight:600;color:#0F172A;margin-bottom:6px;">Aktif Hingga</label>
                            <input type="date" name="subscription_expires_at"
                                   value="{{ $user->subscription_expires_at?->format('Y-m-d') ?? now()->addMonth()->format('Y-m-d') }}"
                                   class="admin-input" style="width:100%;">
                        </div>
                    </div>

                    <div style="display:flex;gap:10px;align-items:center;">
                        <button type="submit" class="admin-btn admin-btn-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" style="width:16px;height:16px;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/>
                            </svg>
                            Simpan Perubahan
                        </button>
                        <a href="{{ route('admin.users.index') }}" class="admin-btn admin-btn-white">Kembali</a>
                    </div>
                </form>

                @if ($user->id !== auth()->id())
                <div style="margin-top:24px;padding-top:20px;border-top:1px solid #F1F5F9;">
                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST"
                          onsubmit="return confirm('Hapus akun {{ $user->name }}? Semua datanya akan ikut terhapus.')">
                        @csrf @method('DELETE')
                        <button type="submit" class="admin-btn admin-btn-red admin-btn-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" style="width:14px;height:14px;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                            Hapus Akun User Ini
                        </button>
                    </form>
                </div>
                @endif
            </div>
        </div>
    </div>
@endsection