@extends('admin.layout')

@section('title', 'Admin Dashboard - TIA MCP')

@section('content')
    <div class="grid gap-6">
        @if (session('status'))
            <div class="tmcp-status-alert">{{ session('status') }}</div>
        @endif

        <section class="tmcp-panel rounded-lg p-6">
            <p class="tmcp-kicker">Admin dashboard</p>
            <h1 class="mt-3 text-3xl font-black text-slate-950">Operational control plane</h1>
            <p class="mt-4 max-w-2xl text-slate-700">Review account state, active devices, and recent privileged actions.</p>
        </section>

        <section class="grid gap-4 md:grid-cols-4">
            <div class="tmcp-feature-card min-h-0">
                <h3>Total users</h3>
                <p class="text-3xl font-black text-slate-950">{{ $metrics['users'] }}</p>
            </div>
            <div class="tmcp-feature-card min-h-0">
                <h3>Active users</h3>
                <p class="text-3xl font-black text-slate-950">{{ $metrics['active_users'] }}</p>
            </div>
            <div class="tmcp-feature-card min-h-0">
                <h3>Admins</h3>
                <p class="text-3xl font-black text-slate-950">{{ $metrics['admins'] }}</p>
            </div>
            <div class="tmcp-feature-card min-h-0">
                <h3>Active devices</h3>
                <p class="text-3xl font-black text-slate-950">{{ $metrics['active_devices'] }}</p>
            </div>
        </section>

        <section class="tmcp-panel rounded-lg p-6">
            <div class="flex flex-wrap items-center justify-between gap-4">
                <div>
                    <p class="tmcp-kicker">Audit</p>
                    <h2 class="mt-2 text-2xl font-black text-slate-950">Recent admin actions</h2>
                </div>
                <a class="tmcp-button tmcp-button-secondary tmcp-focus" href="{{ route('admin.audit.index') }}">View audit log</a>
            </div>

            <div class="mt-5 overflow-x-auto">
                <table class="tmcp-table">
                    <thead>
                        <tr>
                            <th>Action</th>
                            <th>Actor</th>
                            <th>Subject</th>
                            <th>When</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($recentAuditLogs as $log)
                            <tr>
                                <td>{{ $log->action }}</td>
                                <td>{{ $log->actor?->email ?? 'system' }}</td>
                                <td>{{ $log->subjectUser?->email ?? $log->subjectDevice?->name ?? 'none' }}</td>
                                <td>{{ $log->created_at?->diffForHumans() }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4">No admin actions have been recorded yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>
    </div>
@endsection
