<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

class RecurringTransaction extends Model
{
    protected $fillable = [
        'user_id', 'account_id', 'category_id', 'type',
        'amount', 'description', 'frequency',
        'day_of_month', 'day_of_week',
        'start_date', 'end_date',
        'last_run_at', 'next_run_at', 'is_active',
    ];

    protected $casts = [
        'amount'      => 'decimal:2',
        'start_date'  => 'date',
        'end_date'    => 'date',
        'last_run_at' => 'date',
        'next_run_at' => 'date',
        'is_active'   => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function frequencyLabel(): string
    {
        return match($this->frequency) {
            'daily'   => 'Setiap Hari',
            'weekly'  => 'Setiap Minggu',
            'monthly' => 'Setiap Bulan',
            default   => $this->frequency,
        };
    }

    // Hitung next_run_at berikutnya setelah dijalankan
    public function calculateNextRun(Carbon $from): Carbon
    {
        return match($this->frequency) {
            'daily'   => $from->copy()->addDay(),
            'weekly'  => $from->copy()->addWeek(),
            'monthly' => $from->copy()->addMonth()
                              ->setDay(min($this->day_of_month ?? $from->day, 28)),
            default   => $from->copy()->addMonth(),
        };
    }

    // Apakah sudah expired?
    public function isExpired(): bool
    {
        return $this->end_date && now()->gt($this->end_date);
    }
}