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

    protected $fillable = [
        'name',
        'email',
        'password',
        'avatar',
        'otp_code',
        'otp_expires_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'otp_expires_at' => 'datetime',  // ← tambahkan ini
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
}


