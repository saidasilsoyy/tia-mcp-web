<?php

namespace App\Services\Admin;

use App\Models\AdminAuditLog;
use App\Models\Device;
use App\Models\User;
use Illuminate\Http\Request;

class AdminAuditLogger
{
    /**
     * @param  array<string, mixed>  $metadata
     */
    public function record(
        Request $request,
        string $action,
        ?User $subjectUser = null,
        ?Device $subjectDevice = null,
        array $metadata = [],
    ): AdminAuditLog {
        $actorId = $request->user()?->getAuthIdentifier();

        return AdminAuditLog::query()->create([
            'actor_user_id' => $actorId === null ? null : (int) $actorId,
            'subject_user_id' => $subjectUser?->id,
            'subject_device_id' => $subjectDevice?->id,
            'action' => $action,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'metadata' => $metadata,
        ]);
    }
}
