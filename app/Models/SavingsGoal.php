<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

class SavingsGoal extends Model
{
    protected $fillable = [
        'user_id', 'name', 'icon',
        'target_amount', 'current_amount',
        'deadline', 'is_completed',
    ];

    protected $casts = [
        'target_amount'  => 'decimal:2',
        'current_amount' => 'decimal:2',
        'deadline'       => 'date',
        'is_completed'   => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function deposits(): HasMany
    {
        return $this->hasMany(SavingsDeposit::class);
    }

    // Persentase progress (0-100)
    public function progressPercent(): float
    {
        if ($this->target_amount <= 0) return 0;
        return min(round(($this->current_amount / $this->target_amount) * 100, 1), 100);
    }

    // Sisa yang perlu ditabung
    public function remaining(): float
    {
        return max(0, $this->target_amount - $this->current_amount);
    }

    // Status goal
    public function status(): string
    {
        if ($this->is_completed) return 'completed';
        if ($this->deadline && now()->gt($this->deadline)) return 'overdue';
        if ($this->progressPercent() >= 80) return 'almost';
        return 'active';
    }

    // Sisa hari hingga deadline
    public function daysLeft(): ?int
    {
        if (! $this->deadline) return null;
        return max(0, (int) now()->diffInDays($this->deadline, false));
    }

    // Estimasi harus nabung per bulan
    public function monthlyNeeded(): ?float
    {
        if (! $this->deadline || $this->remaining() <= 0) return null;
        $months = max(1, now()->diffInMonths($this->deadline, false));
        return $this->remaining() / $months;
    }
}