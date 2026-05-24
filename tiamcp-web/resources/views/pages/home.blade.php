@extends('layouts.public')

@section('title', 'TIA MCP - Local-first TIA Portal automation')
@section('meta_description', 'TIA MCP is a Windows desktop and MCP server product for local-first TIA Portal automation with account-backed entitlement controls.')

@section('content')
    <x-site.hero />

    <section class="tmcp-metric-strip">
        <div class="tmcp-container grid gap-4 py-5 text-sm font-semibold text-slate-700 md:grid-cols-4">
            <p><span class="text-slate-950">Mode:</span> local-first desktop runtime</p>
            <p><span class="text-slate-950">API:</span> {{ config('tiamcp.api_version') }} health/meta ready</p>
            <p><span class="text-slate-950">MVP billing:</span> free during beta</p>
            <p><span class="text-slate-950">Security:</span> revocable and auditable</p>
        </div>
    </section>

    <x-site.feature-band
        kicker="Product shape"
        title="Automation tools with policy controls before execution"
        body="TIA MCP keeps the engineering workflow local while the cloud app owns identity, subscription, device, and GitHub connection state."
    >
        <article class="tmcp-feature-card">
            <h3>Local-first TIA automation</h3>
            <p>Desktop and MCP server workflows stay on the Windows machine where TIA Portal is installed.</p>
        </article>
        <article class="tmcp-feature-card">
            <h3>MCP tools with policy controls</h3>
            <p>Tool execution can be checked against entitlement and GitHub connection state before handlers run.</p>
        </article>
        <article class="tmcp-feature-card">
            <h3>Account and entitlement sync</h3>
            <p>The cloud API is the source of truth for beta subscription and device access state.</p>
        </article>
        <article class="tmcp-feature-card">
            <h3>GitHub integration when connected</h3>
            <p>GitHub product access remains separate from GitHub login and is only used after explicit connection.</p>
        </article>
    </x-site.feature-band>

    <x-site.security-grid />
@endsection
