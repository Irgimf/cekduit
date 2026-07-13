@extends('layouts.admin')

@section('content')
    @php $pageTitle = 'Dashboard Admin'; @endphp

    {{-- Stat Cards --}}
    <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:16px;margin-bottom:24px;">
        <div class="admin-stat-card">
            <div class="admin-stat-label">Total User</div>
            <div class="admin-stat-value">{{ number_format($totalUsers) }}</div>
            <div class="admin-stat-sub">+{{ $newUsersToday }} hari ini</div>
        </div>
        <div class="admin-stat-card">
            <div class="admin-stat-label">User Premium</div>
            <div class="admin-stat-value" style="color:#92400E;">{{ number_format($premiumUsers) }}</div>
            <div class="admin-stat-sub">Aktif saat ini</div>
        </div>
        <div class="admin-stat-card">
            <div class="admin-stat-label">User Gratis</div>
            <div class="admin-stat-value" style="color:#64748B;">{{ number_format($freeUsers) }}</div>
            <div class="admin-stat-sub">Potensi upgrade</div>
        </div>
        <div class="admin-stat-card">
            <div class="admin-stat-label">Transaksi Bulan Ini</div>
            <div class="admin-stat-value" style="color:#014BAA;">{{ number_format($transactionsMonth) }}</div>
            <div class="admin-stat-sub">Total: {{ number_format($totalTransactions) }}</div>
        </div>
    </div>

    <div style="display:grid;grid-template-columns:2fr 1fr;gap:20px;">

        {{-- Grafik Pertumbuhan User --}}
        <div class="admin-card">
            <div class="admin-card-header">Pertumbuhan User (6 Bulan Terakhir)</div>
            <div style="padding:20px;">
                <canvas id="userGrowthChart" height="80"
                        data-labels="{{ json_encode(array_column($userGrowth, 'label')) }}"
                        data-counts="{{ json_encode(array_column($userGrowth, 'count')) }}">
                </canvas>
            </div>
        </div>

        {{-- Distribusi Role --}}
        <div class="admin-card">
            <div class="admin-card-header">Distribusi User</div>
            <div style="padding:20px;">
                @php
                    $adminCount = \App\Models\User::where('role', 'admin')->count();
                @endphp
                <div style="display:flex;flex-direction:column;gap:12px;">
                    <div>
                        <div style="display:flex;justify-content:space-between;font-size:13px;margin-bottom:5px;">
                            <span style="color:#64748B;font-weight:500;">Free</span>
                            <span style="font-weight:700;">{{ $freeUsers }}</span>
                        </div>
                        <div style="height:8px;background:#F1F5F9;border-radius:99px;">
                            <div style="height:100%;width:{{ $totalUsers > 0 ? ($freeUsers/$totalUsers)*100 : 0 }}%;background:#94A3B8;border-radius:99px;"></div>
                        </div>
                    </div>
                    <div>
                        <div style="display:flex;justify-content:space-between;font-size:13px;margin-bottom:5px;">
                            <span style="color:#92400E;font-weight:500;">⭐ Premium</span>
                            <span style="font-weight:700;">{{ $premiumUsers }}</span>
                        </div>
                        <div style="height:8px;background:#F1F5F9;border-radius:99px;">
                            <div style="height:100%;width:{{ $totalUsers > 0 ? ($premiumUsers/$totalUsers)*100 : 0 }}%;background:#EAB308;border-radius:99px;"></div>
                        </div>
                    </div>
                    <div>
                        <div style="display:flex;justify-content:space-between;font-size:13px;margin-bottom:5px;">
                            <span style="color:#dc2626;font-weight:500;">Admin</span>
                            <span style="font-weight:700;">{{ $adminCount }}</span>
                        </div>
                        <div style="height:8px;background:#F1F5F9;border-radius:99px;">
                            <div style="height:100%;width:{{ $totalUsers > 0 ? ($adminCount/$totalUsers)*100 : 0 }}%;background:#EF4444;border-radius:99px;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- User Terbaru --}}
    <div class="admin-card" style="margin-top:20px;">
        <div class="admin-card-header">
            User Terbaru
            <a href="{{ route('admin.users.index') }}" class="admin-btn admin-btn-white admin-btn-sm">Lihat Semua</a>
        </div>
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Daftar</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($recentUsers as $user)
                <tr>
                    <td>
                        <div style="display:flex;align-items:center;gap:10px;">
                            <img src="{{ $user->avatar_url }}" style="width:32px;height:32px;border-radius:50%;object-fit:cover;">
                            <span style="font-weight:600;">{{ $user->name }}</span>
                        </div>
                    </td>
                    <td style="color:#64748B;">{{ $user->email }}</td>
                    <td>
                        <span class="role-badge {{ $user->role }}">
                            {{ ucfirst($user->role) }}
                        </span>
                    </td>
                    <td style="color:#64748B;font-size:13px;">{{ $user->created_at->format('d M Y') }}</td>
                    <td>
                        <a href="{{ route('admin.users.show', $user) }}" class="admin-btn admin-btn-white admin-btn-sm">Detail</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const el = document.getElementById('userGrowthChart');
        new Chart(el, {
            type: 'bar',
            data: {
                labels: JSON.parse(el.dataset.labels),
                datasets: [{
                    label: 'User Baru',
                    data: JSON.parse(el.dataset.counts),
                    backgroundColor: '#014BAA',
                    borderRadius: 6,
                }]
            },
            options: {
                responsive: true,
                plugins: { legend: { display: false } },
                scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } }
            }
        });
    </script>
    @endpush
@endsection