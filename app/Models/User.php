<?php

namespace App\Models;

use App\Mail\OtpMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    // Konstanta batas free user
    const FREE_MAX_ACCOUNTS   = 2;
    const FREE_MAX_CATEGORIES = 5;
    const FREE_HISTORY_DAYS   = 30;

    protected $fillable = [
        'name',
        'email',
        'password',
        'avatar',
        'otp_code',
        'otp_expires_at',
        'role',
        'subscription_plan',
        'subscription_expires_at',
        'midtrans_order_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at'       => 'datetime',
            'password'                => 'hashed',
            'otp_expires_at'          => 'datetime',
            'subscription_expires_at' => 'datetime',
        ];
    }

    public function accounts(): HasMany
    {
        return $this->hasMany(Account::class);
    }

    public function categories(): HasMany
    {
        return $this->hasMany(Category::class);
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    public function getAvatarUrlAttribute(): string
    {
    return $this->avatar
        ? asset('storage/' . $this->avatar)
        : 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&background=6366f1&color=fff';
    }

    public function generateAndSendOtp(string $purpose = 'verifikasi akun'): void
    {
        $code = (string) random_int(100000, 999999);

        $this->update([
            'otp_code' => $code,
            'otp_expires_at' => now()->addMinutes(5),
        ]);

        Mail::to($this->email)->send(new OtpMail($code, $purpose));
    }

    public function isOtpValid(string $code): bool
    {
        return $this->otp_code === $code
            && $this->otp_expires_at
            && now()->lessThan($this->otp_expires_at);
    }

    public function clearOtp(): void
    {
        $this->update(['otp_code' => null, 'otp_expires_at' => null]);
    }
    // ===== HELPER METHODS =====

    // Apakah user adalah admin?
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    // Apakah user punya akses premium (termasuk admin)?
    public function isPremium(): bool
    {
        if ($this->role === 'admin') return true;
        if ($this->role === 'premium') {
            // Cek apakah subscription masih aktif
            if ($this->subscription_expires_at === null) return false;
            return $this->subscription_expires_at->isFuture();
        }
        return false;
    }

    // Apakah user adalah free user?
    public function isFree(): bool
    {
        return ! $this->isPremium();
    }

    // Berapa hari lagi subscription berakhir?
    public function daysUntilExpiry(): int
    {
        if (! $this->subscription_expires_at) return 0;
        return max(0, (int) now()->diffInDays($this->subscription_expires_at, false));
    }

    // Label status subscription untuk tampilan
    public function subscriptionLabel(): string
    {
        if ($this->isAdmin()) return 'Admin';
        if ($this->isPremium()) {
            return 'Premium · Aktif hingga ' . $this->subscription_expires_at->format('d M Y');
        }
        return 'Free';
    }
}