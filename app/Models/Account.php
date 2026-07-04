<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Account extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'type',
        'account_number',
        'admin_fee',
    ];
    // Sengaja tidak ada 'balance' di fillable — saldo hanya boleh berubah lewat transaksi

    protected $casts = [
        'balance' => 'decimal:2',
        'admin_fee' => 'decimal:2',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    // Helper: hitung saldo real dari transaksi (verifikasi silang dengan kolom balance)
    public function getComputedBalanceAttribute(): float
    {
        $income = $this->transactions()->where('type', 'income')->sum('amount');
        $expense = $this->transactions()->where('type', 'expense')->sum('amount');
        return (float) ($income - $expense);
    }

    // Label jenis rekening
    public function getTypeLabelAttribute(): string
    {
        return match($this->type) {
            'cash' => 'Dompet / Cash',
            'bank' => 'Bank',
            'e_wallet' => 'E-Wallet',
            default => $this->type,
        };
    }
}