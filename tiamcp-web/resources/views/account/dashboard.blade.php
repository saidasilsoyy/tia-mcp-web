@extends('layouts.app')

@section('title', 'Account - TIA MCP')

@section('content')
    <div class="grid gap-6">
        @if (session('status'))
            <div class="tmcp-status-alert">{{ session('status') }}</div>
        @endif

        <section class="tmcp-panel rounded-lg p-6">
            <p class="tmcp-kicker">Account dashboard</p>
            <h1 class="mt-3 text-3xl font-black text-slate-950">Cloud account foundation</h1>
            <p class="mt-4 max-w-2xl text-slate-700">Your free beta subscription, device activation state, GitHub connection state, and entitlement summary are server-authoritative.</p>
        </section>

        <section class="grid gap-4 md:grid-cols-3">
            <div class="tmcp-feature-card min-h-0">
                <h3>Subscription</h3>
                <p class="font-semibold text-slate-700">{{ $summary['subscription']['plan'] ?? 'none' }} / {{ $summary['subscription']['status'] }}</p>
            </div>
            <div class="tmcp-feature-card min-h-0">
                <h3>Email</h3>
                <p class="font-semibold text-slate-700">{{ $summary['account']['email_verified'] ? 'Verified' : 'Not verified' }}</p>
            </div>
            <div class="tmcp-feature-card min-h-0">
                <h3>GitHub</h3>
                <p class="font-semibold text-slate-700">{{ $summary['github']['status'] }}</p>
            </div>
        </section>

        <section class="tmcp-panel rounded-lg p-6">
            <div class="flex flex-wrap items-center justify-between gap-4">
                <div>
                    <p class="tmcp-kicker">Entitlements</p>
                    <h2 class="mt-2 text-2xl font-black text-slate-950">Current grants</h2>
                </div>
                <a class="tmcp-button tmcp-button-secondary tmcp-focus" href="{{ route('account.github.show') }}">Manage GitHub</a>
            </div>
            <div class="mt-5 flex flex-wrap gap-2">
                @forelse ($summary['entitlements'] as $code)
                    <span class="rounded border border-stone-300 bg-white px-3 py-2 text-sm font-bold text-slate-800">{{ $code }}</span>
                @empty
                    <p class="text-slate-700">No active entitlements. Verify email and keep the account active.</p>
                @endforelse
            </div>
        </section>

        <section class="tmcp-panel rounded-lg p-6">
            <div class="flex flex-wrap items-center justify-between gap-4">
                <div>
                    <p class="tmcp-kicker">Devices</p>
                    <h2 class="mt-2 text-2xl font-black text-slate-950">Recent desktop activations</h2>
                </div>
                <a class="tmcp-button tmcp-button-secondary tmcp-focus" href="{{ route('account.devices.index') }}">Manage devices</a>
            </div>
            <div class="mt-5 overflow-x-auto">
                <table class="tmcp-table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Status</th>
                            <th>Last seen</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($devices as $device)
                            <tr>
                                <td>{{ $device->name }}</td>
                                <td>{{ $device->status }}</td>
                                <td>{{ $device->last_seen_at?->diffForHumans() ?? 'Never' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3">No devices are connected yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>
    </div>
@endsection
