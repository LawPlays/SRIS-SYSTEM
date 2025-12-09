<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class VerificationCode extends Model
{
    protected $fillable = [
        'user_id',
        'email',
        'code',
        'expires_at',
        'is_used',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'is_used' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function isExpired(): bool
    {
        return $this->expires_at->isPast();
    }

    public function isValid(): bool
    {
        return !$this->is_used && !$this->isExpired();
    }

    public static function generateCode(): string
    {
        return str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
    }

    public static function createForUser(User $user): self
    {
        // Delete any existing codes for this user
        self::where('user_id', $user->id)->delete();

        return self::create([
            'user_id' => $user->id,
            'email' => $user->email,
            'code' => self::generateCode(),
            'expires_at' => Carbon::now()->addMinutes(15), // Code expires in 15 minutes
        ]);
    }

    public static function createForEmail(string $email): self
    {
        // Delete any existing codes for this email
        self::where('email', $email)->whereNull('user_id')->delete();

        return self::create([
            'user_id' => null,
            'email' => $email,
            'code' => self::generateCode(),
            'expires_at' => Carbon::now()->addMinutes(15), // Code expires in 15 minutes
        ]);
    }

    public function markAsUsed(): void
    {
        $this->update(['is_used' => true]);
    }
}
