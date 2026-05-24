<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

class DeviceToken extends Model
{
    protected $fillable = [
        'device_id',
        'access_token_hash',
        'access_token_expires_at',
        'refresh_token_hash',
        'last_used_at',
        'expires_at',
        'revoked_at',
    ];

    protected function casts(): array
    {
        return [
            'access_token_expires_at' => 'datetime',
            'last_used_at' => 'datetime',
            'expires_at' => 'datetime',
            'revoked_at' => 'datetime',
        ];
    }

    public function device(): BelongsTo
    {
        return $this->belongsTo(Device::class);
    }

    public function isUsable(): bool
    {
        $device = Device::find($this->device_id);

        return $this->revoked_at === null && Carbon::parse($this->expires_at)->isFuture() && $device?->isActive();
    }
}
