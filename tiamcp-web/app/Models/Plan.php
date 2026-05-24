<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Plan extends Model
{
    protected $fillable = [
        'code',
        'name',
        'status',
        'price_cents',
        'currency',
        'billing_interval',
    ];

    public function entitlements(): BelongsToMany
    {
        return $this->belongsToMany(Entitlement::class, 'plan_entitlement')->withTimestamps();
    }

    public function subscriptions(): HasMany
    {
        return $this->hasMany(Subscription::class);
    }
}
