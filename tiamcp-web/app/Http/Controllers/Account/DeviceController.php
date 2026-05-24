<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Models\Device;
use App\Services\Devices\DeviceAuthorizationService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DeviceController extends Controller
{
    public function showActivation(): View
    {
        return view('account.devices.authorize');
    }

    public function approve(Request $request, DeviceAuthorizationService $authorizations): RedirectResponse
    {
        $validated = $request->validate([
            'user_code' => ['required', 'string', 'max:32'],
        ]);

        $authorization = $authorizations->approve($validated['user_code'], $request->user());

        $device = Device::find($authorization->device_id);

        return redirect()
            ->route('account.devices.index')
            ->with('status', 'Device '.$device->name.' approved.');
    }

    public function index(Request $request): View
    {
        return view('account.devices.index', [
            'devices' => $request->user()->devices()->latest()->get(),
        ]);
    }

    public function revoke(Request $request, Device $device): RedirectResponse
    {
        abort_unless($device->user_id === $request->user()->id, 404);

        $device->update([
            'status' => 'revoked',
            'revoked_at' => now(),
        ]);

        $device->tokens()->whereNull('revoked_at')->update(['revoked_at' => now()]);

        return back()->with('status', 'Device revoked.');
    }
}
