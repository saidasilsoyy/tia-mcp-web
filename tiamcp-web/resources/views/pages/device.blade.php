@extends('layouts.public')

@section('title', 'Activate device - TIA MCP')

@section('content')
    <section class="mx-auto max-w-3xl px-6 py-16">
        <p class="tmcp-kicker">Desktop connection</p>
        <h1 class="mt-3 text-4xl font-black text-slate-950">Activate desktop device</h1>
        <div class="tmcp-panel mt-8 rounded-lg p-6">
            <p class="text-slate-700">Device authorization endpoints are added in the device phase. This page gives the desktop app a stable browser destination for activation.</p>
            <p class="mt-4 text-sm font-semibold text-slate-600">Current API base: {{ config('tiamcp.public_api_base_url') }}</p>
        </div>
    </section>
@endsection
