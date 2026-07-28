<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

class Budget extends Model
{
    protected $fillable = [
        'user_id',
        'category_id',
        'amount',
        'period',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    // Hitung total pengeluaran bulan ini untuk budget ini
    public function spentThisMonth(): float
    {
        $now = Carbon::now();

        return (float) $this->user->transactions()
            ->where('category_id', $this->category_id)
            ->where('type', 'expense')
            ->where('is_transfer', false)
            ->whereYear('transaction_date', $now->year)
            ->whereMonth('transaction_date', $now->month)
            ->sum('amount');
    }

    // Persentase terpakai (0-100+)
    public function spentPercent(): float
    {
        if ($this->amount <= 0) return 0;
        return min(($this->spentThisMonth() / $this->amount) * 100, 100);
    }

    // Status budget
    public function status(): string
    {
        $percent = $this->spentPercent();
        if ($percent >= 100) return 'exceeded';
        if ($percent >= 80)  return 'warning';
        return 'safe';
    }

    // Sisa budget
    public function remaining(): float
    {
        return max(0, $this->amount - $this->spentThisMonth());
    }
}