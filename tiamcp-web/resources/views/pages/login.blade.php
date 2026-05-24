@extends('layouts.public')

@section('title', 'Sign in - TIA MCP')

@section('content')
    <section class="mx-auto max-w-3xl px-6 py-16">
        <p class="tmcp-kicker">Account access</p>
        <h1 class="mt-3 text-4xl font-black text-slate-950">Sign in to TIA MCP</h1>
        <div class="tmcp-panel mt-8 rounded-lg p-6">
            <p class="text-slate-700">Email, Google, and GitHub login flows are implemented in the next auth phase. This route is reserved now so the web app has a stable public auth surface.</p>
            <div class="mt-6 flex flex-wrap gap-3">
                <a class="tmcp-button tmcp-button-primary tmcp-focus" href="{{ route('auth.register') }}">Create account</a>
                <a class="tmcp-button tmcp-button-secondary tmcp-focus" href="{{ route('public.home') }}">Back to product</a>
            </div>
        </div>
    </section>
@endsection
