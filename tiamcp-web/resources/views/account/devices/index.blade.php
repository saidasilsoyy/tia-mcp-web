@extends('layouts.app')

@section('title', 'Devices - TIA MCP')

@section('content')
    <section class="tmcp-panel rounded-lg p-6">
        @if (session('status'))
            <div class="tmcp-status-alert mb-5">{{ session('status') }}</div>
        @endif
        <p class="tmcp-kicker">Devices</p>
        <h1 class="mt-3 text-3xl font-black text-slate-950">Activated desktop devices</h1>
        <div class="mt-6 overflow-x-auto">
            <table class="tmcp-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Platform</th>
                        <th>Version</th>
                        <th>Status</th>
                        <th>Last seen</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($devices as $device)
                        <tr>
                            <td>{{ $device->name }}</td>
                            <td>{{ $device->platform ?? 'unknown' }}</td>
                            <td>{{ $device->app_version ?? 'unknown' }}</td>
                            <td>{{ $device->status }}</td>
                            <td>{{ $device->last_seen_at?->diffForHumans() ?? 'Never' }}</td>
                            <td>
                                @if ($device->isActive())
                                    <form method="POST" action="{{ route('account.devices.revoke', $device) }}">
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
    </section>
@endsection
