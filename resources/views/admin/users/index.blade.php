@extends('layouts.admin')

@section('content')
    @php $pageTitle = 'Manajemen User'; @endphp

    {{-- Filter --}}
    <div class="admin-card" style="margin-bottom:20px;">
        <div style="padding:16px 20px;">
            <form method="GET" style="display:flex;gap:10px;align-items:center;flex-wrap:wrap;">
                <input type="text" name="search" value="{{ request('search') }}"
                       class="admin-input" placeholder="Cari nama atau email..." style="flex:1;min-width:200px;">
                <select name="role" class="admin-select">
                    <option value="">Semua Role</option>
                    <option value="user"    @selected(request('role') === 'user')>Free</option>
                    <option value="premium" @selected(request('role') === 'premium')>Premium</option>
                    <option value="admin"   @selected(request('role') === 'admin')>Admin</option>
                </select>
                <button type="submit" class="admin-btn admin-btn-primary">Filter</button>
                <a href="{{ route('admin.users.index') }}" class="admin-btn admin-btn-white">Reset</a>
            </form>
        </div>
    </div>

    {{-- Tabel User --}}
    <div class="admin-card">
        <div class="admin-card-header">
            Daftar User
            <span style="font-size:13px;color:#64748B;font-weight:400;">
                {{ $users->total() }} user ditemukan
            </span>
        </div>
        <table class="admin-table">
            <thead>
                <tr>
                    <th>User</th>
                    <th>Role</th>
                    <th>Status Subscription</th>
                    <th>Expired</th>
                    <th>Daftar</th>
                    <th style="text-align:right;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($users as $user)
                <tr>
                    <td>
                        <div style="display:flex;align-items:center;gap:10px;">
                            <img src="{{ $user->avatar_url }}" style="width:36px;height:36px;border-radius:50%;object-fit:cover;flex-shrink:0;">
                            <div>
                                <div style="font-weight:600;font-size:14px;">{{ $user->name }}</div>
                                <div style="font-size:12px;color:#64748B;">{{ $user->email }}</div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <span class="role-badge {{ $user->role }}">
                            @if ($user->role === 'premium') ⭐ @endif
                            {{ ucfirst($user->role) }}
                        </span>
                    </td>
                    <td style="font-size:13px;color:#64748B;">{{ ucfirst($user->subscription_plan) }}</td>
                    <td style="font-size:13px;color:#64748B;">
                        @if ($user->subscription_expires_at)
                            {{ $user->subscription_expires_at->format('d M Y') }}
                            @if ($user->subscription_expires_at->isPast())
                                <span style="color:#EF4444;font-size:11px;"> (Expired)</span>
                            @endif
                        @else
                            —
                        @endif
                    </td>
                    <td style="font-size:13px;color:#64748B;">{{ $user->created_at->format('d M Y') }}</td>
                    <td style="text-align:right;">
                        <div style="display:flex;gap:6px;justify-content:flex-end;">
                            <a href="{{ route('admin.users.show', $user) }}"
                               class="admin-btn admin-btn-white admin-btn-sm">Detail</a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="text-align:center;padding:40px;color:#94A3B8;">Tidak ada user ditemukan</td>
                </tr>
                @endforelse
            </tbody>
        </table>

        @if ($users->hasPages())
        <div style="padding:16px 20px;border-top:1px solid #F1F5F9;">
            {{ $users->appends(request()->query())->links() }}
        </div>
        @endif
    </div>
@endsection