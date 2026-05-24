<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminAuditLog;
use Illuminate\View\View;

class AuditLogController extends Controller
{
    public function index(): View
    {
        return view('admin.audit.index', [
            'logs' => AdminAuditLog::query()
                ->with(['actor', 'subjectUser', 'subjectDevice'])
                ->latest('created_at')
                ->paginate(30),
        ]);
    }
}
