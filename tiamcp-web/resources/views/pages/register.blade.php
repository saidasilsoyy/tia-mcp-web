@extends('layouts.public')

@section('title', 'Create account - TIA MCP')

@section('content')
    <section class="mx-auto max-w-3xl px-6 py-16">
        <p class="tmcp-kicker">Free beta subscription</p>
        <h1 class="mt-3 text-4xl font-black text-slate-950">Create your TIA MCP account</h1>
        <div class="tmcp-panel mt-8 rounded-lg p-6">
            <p class="text-slate-700">Registration will provision a free beta subscription and entitlement record in the auth phase. No payment processor is part of the MVP.</p>
            <div class="mt-6 flex flex-wrap gap-3">
                <a class="tmcp-button tmcp-button-primary tmcp-focus" href="{{ route('auth.login') }}">Sign in</a>
                <a class="tmcp-button tmcp-button-secondary tmcp-focus" href="{{ route('device.activation') }}">Device activation</a>
            </div>
        </div>
    </section>
@endsection
