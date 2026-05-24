<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GitHubConnectionEvent extends Model
{
    protected $table = 'github_connection_events';

    public const UPDATED_AT = null;

    protected $fillable = [
        'github_connection_id',
        'user_id',
        'event_type',
        'metadata',
    ];

    protected function casts(): array
    {
        return [
            'metadata' => 'array',
        ];
    }

    public function githubConnection(): BelongsTo
    {
        return $this->belongsTo(GitHubConnection::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
