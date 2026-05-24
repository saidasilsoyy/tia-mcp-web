<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

class DeviceAuthorization extends Model
{
    protected $fillable = [
        'device_code_hash',
        'user_code_hash',
        'user_code_display',
        'user_id',
        'device_id',
        'status',
        'client_name',
        'platform',
        'app_version',
        'machine_fingerprint_hash',
        'requested_ip',
        'requested_user_agent',
        'expires_at',
        'approved_at',
        'denied_at',
        'last_polled_at',
        'poll_count',
    ];

    protected function casts(): array
    {
        return [
            'expires_at' => 'datetime',
            'approved_at' => 'datetime',
            'denied_at' => 'datetime',
            'last_polled_at' => 'datetime',
            'poll_count' => 'integer',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function device(): BelongsTo
    {
        return $this->belongsTo(Device::class);
    }

    public function isExpired(): bool
    {
        return Carbon::parse($this->expires_at)->isPast();
    }

    public function secondsSinceLastPoll(): ?int
    {
        if ($this->last_polled_at === null) {
            return null;
        }

        return (int) Carbon::parse($this->last_polled_at)->diffInSeconds(now(), true);
    }
}
