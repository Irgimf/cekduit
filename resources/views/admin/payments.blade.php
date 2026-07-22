@extends('layouts.admin')
@section('content')
@php $pageTitle = 'Manajemen Pembayaran'; @endphp

{{-- Filter --}}
<div class="admin-card" style="margin-bottom:20px;">
    <div style="padding:16px 20px;">
        <form method="GET" style="display:flex;gap:10px;align-items:center;flex-wrap:wrap;">
            <input type="text" name="search" value="{{ request('search') }}"
                   class="admin-input" placeholder="Cari nama, email, order ID..." style="flex:1;min-width:200px;">
            <select name="status" class="admin-select">
                <option value="">Semua Status</option>
                <option value="pending" @selected(request('status')==='pending')>Pending</option>
                <option value="success" @selected(request('status')==='success')>Success</option>
                <option value="failed"  @selected(request('status')==='failed')>Failed</option>
            </select>
            <button type="submit" class="admin-btn admin-btn-primary">Filter</button>
            <a href="{{ route('admin.payments') }}" class="admin-btn admin-btn-white">Reset</a>
        </form>
    </div>
</div>

<div class="admin-card">
    <div class="admin-card-header">
        Daftar Pembayaran
        <span style="font-size:13px;color:#64748B;font-weight:400;">{{ $payments->total() }} transaksi</span>
    </div>
    <table class="admin-table">
        <thead>
            <tr>
                <th>User</th>
                <th>Order ID</th>
                <th>Paket</th>
                <th>Total</th>
                <th>Status</th>
                <th>Tanggal</th>
                <th style="text-align:right;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($payments as $payment)
            <tr>
                <td>
                    <div style="font-weight:600;font-size:14px;">{{ $payment->user->name }}</div>
                    <div style="font-size:12px;color:#64748B;">{{ $payment->user->email }}</div>
                </td>
                <td style="font-size:12px;color:#64748B;">{{ $payment->order_id }}</td>
                <td style="font-weight:600;">{{ $payment->planLabel() }}</td>
                <td>Rp {{ number_format($payment->amount, 0, ',', '.') }}</td>
                <td>
                    @php
                        $colors = [
                            'success'=>['#DCFCE7','#15803d'],
                            'pending'=>['#FEF9C3','#92400E'],
                            'failed' =>['#FEE2E2','#dc2626'],
                            'expired'=>['#F1F5F9','#64748B'],
                        ];
                        [$bg,$col] = $colors[$payment->status] ?? ['#F1F5F9','#64748B'];
                    @endphp
                    <span style="background:{{ $bg }};color:{{ $col }};padding:3px 10px;border-radius:99px;font-size:11px;font-weight:700;">
                        {{ ucfirst($payment->status) }}
                    </span>
                </td>
                <td style="font-size:13px;color:#64748B;">
                    {{ $payment->created_at->format('d M Y') }}<br>
                    <span style="font-size:11px;">{{ $payment->created_at->format('H:i') }}</span>
                </td>
                <td style="text-align:right;">
                    <div style="display:flex;gap:6px;justify-content:flex-end;flex-wrap:wrap;">
                        {{-- Konfirmasi jadi Success --}}
                        @if ($payment->status === 'pending')
                        <form action="{{ route('payment.confirm', $payment) }}" method="POST"
                              onsubmit="return confirm('Konfirmasi pembayaran {{ $payment->order_id }}? User akan langsung jadi Premium.')">
                            @csrf @method('PATCH')
                            <input type="hidden" name="plan" value="{{ $payment->plan }}">
                            <button type="submit" class="admin-btn admin-btn-primary admin-btn-sm">
                                ✓ Konfirmasi
                            </button>
                        </form>
                        @endif

                        {{-- Hapus --}}
                        <form action="{{ route('admin.payments.destroy', $payment) }}" method="POST"
                              onsubmit="return confirm('Hapus order {{ $payment->order_id }}?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="admin-btn admin-btn-red admin-btn-sm">
                                Hapus
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" style="text-align:center;padding:40px;color:#94A3B8;">
                    Tidak ada data pembayaran
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    @if ($payments->hasPages())
    <div style="padding:16px 20px;border-top:1px solid #F1F5F9;">
        {{ $payments->appends(request()->query())->links() }}
    </div>
    @endif
</div>
@endsection