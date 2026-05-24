@extends('layouts.public')

@section('title', 'Verify email - TIA MCP')

@section('content')
    <section class="mx-auto max-w-3xl px-6 py-16">
        <p class="tmcp-kicker">Email verification</p>
        <h1 class="mt-3 text-4xl font-black text-slate-950">Verify your email before device activation</h1>
        <div class="tmcp-panel mt-8 rounded-lg p-6">
            <p class="text-slate-700">A verification link was sent to your email address. Device activation and entitlement issuance require a verified account.</p>
            <div class="mt-6 flex flex-wrap gap-3">
                <a class="tmcp-button tmcp-button-primary tmcp-focus" href="{{ route('account.dashboard') }}">Open account</a>
                <form method="POST" action="{{ route('auth.logout') }}">
                    @csrf
                    <button class="tmcp-button tmcp-button-secondary tmcp-focus" type="submit">Sign out</button>
                </form>
            </div>
        </div>
    </section>
@endsection
