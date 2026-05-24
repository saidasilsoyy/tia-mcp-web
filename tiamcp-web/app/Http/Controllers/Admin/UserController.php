<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\Admin\AdminAuditLogger;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class UserController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->query('search', ''));

        $users = User::query()
            ->withCount('devices')
            ->when($search !== '', function ($query) use ($search): void {
                $query->where(function ($query) use ($search): void {
                    $query->where('email', 'like', '%'.$search.'%')
                        ->orWhere('name', 'like', '%'.$search.'%');
                });
            })
            ->latest()
            ->paginate(20)
            ->withQueryString();

        return view('admin.users.index', [
            'users' => $users,
            'search' => $search,
        ]);
    }

    public function updateRole(Request $request, User $user, AdminAuditLogger $audit): RedirectResponse
    {
        $validated = $request->validate([
            'role' => ['required', 'string', Rule::in(['user', 'admin'])],
        ]);

        if ($request->user()?->is($user) && $validated['role'] !== 'admin') {
            return back()->withErrors(['role' => 'Admins cannot remove their own admin role.']);
        }

        $previousRole = (string) $user->getAttribute('role');

        if ($previousRole !== $validated['role']) {
            $user->forceFill(['role' => $validated['role']])->save();

            $audit->record($request, 'admin.user.role_updated', $user, metadata: [
                'from' => $previousRole,
                'to' => $validated['role'],
            ]);
        }

        return back()->with('status', 'User role updated.');
    }

    public function updateStatus(Request $request, User $user, AdminAuditLogger $audit): RedirectResponse
    {
        $validated = $request->validate([
            'status' => ['required', 'string', Rule::in(['active', 'suspended'])],
        ]);

        if ($request->user()?->is($user) && $validated['status'] !== 'active') {
            return back()->withErrors(['status' => 'Admins cannot suspend their own account.']);
        }

        $previousStatus = (string) $user->getAttribute('status');

        if ($previousStatus !== $validated['status']) {
            $user->forceFill(['status' => $validated['status']])->save();

            $audit->record($request, 'admin.user.status_updated', $user, metadata: [
                'from' => $previousStatus,
                'to' => $validated['status'],
            ]);
        }

        return back()->with('status', 'User status updated.');
    }
}
