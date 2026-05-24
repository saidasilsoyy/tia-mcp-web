<?php

namespace App\Services\Audit;

use App\Models\LoginEvent;
use App\Models\User;
use Illuminate\Http\Request;

class LoginEventRecorder
{
    /**
     * @param  array<string, mixed>  $metadata
     */
    public function record(Request $request, string $eventType, ?User $user = null, ?string $email = null, array $metadata = []): void
    {
        LoginEvent::create([
            'user_id' => $user?->id,
            'event_type' => $eventType,
            'email' => $email ?? $user?->email,
            'ip_address' => $request->ip(),
            'user_agent' => (string) $request->userAgent(),
            'metadata' => $metadata,
        ]);
    }
}
