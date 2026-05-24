<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class GitHubConnection extends Model
{
    protected $table = 'github_connections';

    protected $fillable = [
        'user_id',
        'github_user_id',
        'github_username',
        'scopes',
        'encrypted_access_token',
        'encrypted_refresh_token',
        'token_expires_at',
        'last_verified_at',
        'revoked_at',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'scopes' => 'array',
            'token_expires_at' => 'datetime',
            'last_verified_at' => 'datetime',
            'revoked_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function events(): HasMany
    {
        return $this->hasMany(GitHubConnectionEvent::class);
    }

    public function isConnected(): bool
    {
        return $this->revoked_at === null && $this->status === 'connected';
    }
}
