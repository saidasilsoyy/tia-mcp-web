@extends('layouts.public')

@section('title', 'Not found - TIA MCP')

@section('content')
    <section class="mx-auto max-w-3xl px-6 py-20">
        <p class="tmcp-kicker">404</p>
        <h1 class="mt-3 text-4xl font-black text-slate-950">Page not found</h1>
        <p class="mt-4 text-slate-700">The requested TIA MCP page does not exist or has moved.</p>
        <a class="tmcp-button tmcp-button-primary tmcp-focus mt-8" href="{{ route('public.home') }}">Return home</a>
    </section>
@endsection
