<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Entitlement extends Model
{
    protected $fillable = [
        'code',
        'name',
        'description',
    ];

    public function plans(): BelongsToMany
    {
        return $this->belongsToMany(Plan::class, 'plan_entitlement')->withTimestamps();
    }
}
