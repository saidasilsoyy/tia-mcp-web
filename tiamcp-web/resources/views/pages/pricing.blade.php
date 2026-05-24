@extends('layouts.public')

@section('title', 'Pricing - TIA MCP')
@section('meta_description', 'TIA MCP pricing: free during beta, with real subscription and entitlement records.')

@section('content')
    <section class="tmcp-container tmcp-section">
        <div class="grid gap-10 lg:grid-cols-[0.82fr_1.18fr]">
            <div class="tmcp-page-heading">
                <p class="tmcp-kicker">Pricing</p>
                <h1>Free during beta</h1>
                <p>The MVP intentionally has no payment processor. It still uses real subscription and entitlement records so future paid plans do not require a licensing rewrite.</p>
            </div>

            <div class="tmcp-panel rounded-lg p-6">
                <p class="tmcp-kicker">Beta plan</p>
                <p class="mt-3 text-5xl font-black text-slate-950">$0</p>
                <p class="mt-3 text-slate-700">Account-backed access for early product validation.</p>
                <ul class="mt-6 grid gap-3 text-sm font-semibold text-slate-700">
                    <li>Local desktop and MCP server workflow</li>
                    <li>Device activation model</li>
                    <li>Entitlement sync model</li>
                    <li>Optional GitHub product connection</li>
                    <li>No payment method required in MVP</li>
                </ul>
                <a class="tmcp-button tmcp-button-primary tmcp-focus mt-8" href="{{ route('auth.register') }}">Create free account</a>
            </div>
        </div>
    </section>
@endsection
