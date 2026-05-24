@extends('admin.layout')

@section('title', 'Admin Devices - TIA MCP')

@section('content')
    <section class="tmcp-panel rounded-lg p-6">
        @if (session('status'))
            <div class="tmcp-status-alert mb-5">{{ session('status') }}</div>
        @endif

        <p class="tmcp-kicker">Admin devices</p>
        <h1 class="mt-3 text-3xl font-black text-slate-950">Activated devices</h1>

        <div class="mt-6 overflow-x-auto">
            <table class="tmcp-table">
                <thead>
                    <tr>
                        <th>Device</th>
                        <th>User</th>
                        <th>Platform</th>
                        <th>Status</th>
                        <th>Last seen</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($devices as $device)
                        <tr>
                            <td>
                                <div class="font-bold text-slate-950">{{ $device->name }}</div>
                                <div class="text-sm text-slate-600">{{ $device->device_public_id }}</div>
                            </td>
                            <td>{{ $device->user?->email ?? 'deleted user' }}</td>
                            <td>{{ $device->platform ?? 'unknown' }} / {{ $device->app_version ?? 'unknown' }}</td>
                            <td>{{ $device->status }}</td>
                            <td>{{ $device->last_seen_at?->diffForHumans() ?? 'Never' }}</td>
                            <td>
                                @if ($device->isActive())
                                    <form method="POST" action="{{ route('admin.devices.revoke', $device) }}">
                                        @csrf
                                        <button class="tmcp-button tmcp-button-secondary tmcp-focus" type="submit">Revoke</button>
                                    </form>
                                @else
                                    <span class="text-sm font-bold text-slate-500">Revoked</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">No devices have been activated yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $devices->links() }}
        </div>
    </section>
@endsection
