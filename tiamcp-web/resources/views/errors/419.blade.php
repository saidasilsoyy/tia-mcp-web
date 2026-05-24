@extends('layouts.public')

@section('title', 'Session expired - TIA MCP')

@section('content')
    <section class="mx-auto max-w-3xl px-6 py-20">
        <p class="tmcp-kicker">419</p>
        <h1 class="mt-3 text-4xl font-black text-slate-950">Session expired</h1>
        <p class="mt-4 text-slate-700">Refresh the page and try the action again.</p>
        <a class="tmcp-button tmcp-button-primary tmcp-focus mt-8" href="{{ route('auth.login') }}">Sign in</a>
    </section>
@endsection
