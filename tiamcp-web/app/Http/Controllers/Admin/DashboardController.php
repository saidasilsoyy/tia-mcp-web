<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminAuditLog;
use App\Models\Device;
use App\Models\User;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        return view('admin.dashboard', [
            'metrics' => [
                'users' => User::query()->count(),
                'active_users' => User::query()->where('status', 'active')->count(),
                'admins' => User::query()->where('role', 'admin')->count(),
                'active_devices' => Device::query()->where('status', 'active')->whereNull('revoked_at')->count(),
            ],
            'recentAuditLogs' => AdminAuditLog::query()
                ->with(['actor', 'subjectUser', 'subjectDevice'])
                ->latest('created_at')
                ->limit(8)
                ->get(),
        ]);
    }
}
