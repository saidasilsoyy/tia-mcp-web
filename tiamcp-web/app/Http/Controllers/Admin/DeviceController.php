<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Device;
use App\Models\User;
use App\Services\Admin\AdminAuditLogger;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DeviceController extends Controller
{
    public function index(): View
    {
        return view('admin.devices.index', [
            'devices' => Device::query()
                ->with('user')
                ->latest()
                ->paginate(20),
        ]);
    }

    public function revoke(Request $request, Device $device, AdminAuditLogger $audit): RedirectResponse
    {
        if ($device->isActive()) {
            $revokedAt = now();

            $device->update([
                'status' => 'revoked',
                'revoked_at' => $revokedAt,
            ]);

            $device->tokens()->whereNull('revoked_at')->update(['revoked_at' => $revokedAt]);
            $subjectUser = User::query()->find($device->user_id);

            $audit->record($request, 'admin.device.revoked', $subjectUser, $device, [
                'device_public_id' => $device->device_public_id,
                'name' => $device->name,
            ]);
        }

        return back()->with('status', 'Device revoked.');
    }
}
