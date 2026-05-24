@extends('admin.layout')

@section('title', 'Admin Audit Log - TIA MCP')

@section('content')
    <section class="tmcp-panel rounded-lg p-6">
        <p class="tmcp-kicker">Admin audit</p>
        <h1 class="mt-3 text-3xl font-black text-slate-950">Audit log</h1>

        <div class="mt-6 overflow-x-auto">
            <table class="tmcp-table">
                <thead>
                    <tr>
                        <th>When</th>
                        <th>Action</th>
                        <th>Actor</th>
                        <th>Subject</th>
                        <th>Context</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($logs as $log)
                        <tr>
                            <td>{{ $log->created_at?->toDateTimeString() }}</td>
                            <td>{{ $log->action }}</td>
                            <td>{{ $log->actor?->email ?? 'system' }}</td>
                            <td>
                                {{ $log->subjectUser?->email ?? $log->subjectDevice?->name ?? 'none' }}
                            </td>
                            <td>
                                <div class="text-sm text-slate-700">{{ $log->ip_address ?? 'no ip' }}</div>
                                @if ($log->metadata)
                                    <pre class="tmcp-code mt-2 max-w-md text-xs">{{ json_encode($log->metadata, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) }}</pre>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">No admin actions have been recorded yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $logs->links() }}
        </div>
    </section>
@endsection
