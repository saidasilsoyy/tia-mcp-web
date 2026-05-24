@extends('layouts.app')

@section('title', 'GitHub connection - TIA MCP')

@section('content')
    <section class="tmcp-panel rounded-lg p-6">
        @if (session('status'))
            <div class="tmcp-status-alert mb-5">{{ session('status') }}</div>
        @endif
        <p class="tmcp-kicker">Integration</p>
        <h1 class="mt-3 text-3xl font-black text-slate-950">GitHub product connection</h1>
        <p class="mt-4 max-w-2xl text-slate-700">Login with GitHub and GitHub repository feature access are separate. Product tokens stay encrypted on the server and are never returned to desktop entitlement APIs.</p>

        <div class="tmcp-feature-card mt-6 min-h-0">
            <h3>{{ $connection?->isConnected() ? 'Connected' : 'Not connected' }}</h3>
            @if ($connection?->isConnected())
                <p>Connected as <strong>{{ $connection->github_username ?? $connection->github_user_id }}</strong>. Scopes: {{ implode(', ', $connection->scopes ?? []) ?: 'none recorded' }}.</p>
                <form class="mt-5" method="POST" action="{{ route('account.github.disconnect') }}">
                    @csrf
                    <button class="tmcp-button tmcp-button-secondary tmcp-focus" type="submit">Disconnect GitHub</button>
                </form>
            @else
                <p>GitHub-dependent entitlements remain denied until this account is connected.</p>
                <a class="tmcp-button tmcp-button-primary tmcp-focus mt-5" href="{{ route('account.github.redirect') }}">Connect GitHub</a>
            @endif
        </div>
    </section>
@endsection
