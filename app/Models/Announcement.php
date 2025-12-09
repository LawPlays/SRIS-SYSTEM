<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Announcement extends Model
{
    protected $fillable = [
        'title',
        'content',
        'user_id',
        'is_active',
        'priority',
        'publish_at',
        'expire_at',
        'audience_grade_level',
        'audience_strand',
        'audience_role'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'publish_at' => 'datetime',
        'expire_at' => 'datetime'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true)
            ->where(function ($q) {
                $q->whereNull('publish_at')->orWhere('publish_at', '<=', now());
            })
            ->where(function ($q) {
                $q->whereNull('expire_at')->orWhere('expire_at', '>', now());
            });
    }

    public function scopeByPriority($query)
    {
        return $query->orderBy('priority', 'desc')->orderBy('created_at', 'desc');
    }

    public function scopeForAudience($query, ?string $gradeLevel, ?string $strand, string $role)
    {
        return $query->where(function ($q) use ($role) {
                $q->whereNull('audience_role')->orWhere('audience_role', $role)->orWhere('audience_role', 'all');
            })
            ->where(function ($q) use ($gradeLevel) {
                if ($gradeLevel) {
                    $q->whereNull('audience_grade_level')->orWhere('audience_grade_level', $gradeLevel);
                }
            })
            ->where(function ($q) use ($strand) {
                if ($strand) {
                    $q->whereNull('audience_strand')->orWhere('audience_strand', $strand);
                }
            });
    }
}
