@extends('layouts.public')

@section('title', 'Rate limited - TIA MCP')

@section('content')
    <section class="mx-auto max-w-3xl px-6 py-20">
        <p class="tmcp-kicker">429</p>
        <h1 class="mt-3 text-4xl font-black text-slate-950">Too many requests</h1>
        <p class="mt-4 text-slate-700">Wait briefly before trying again.</p>
        <a class="tmcp-button tmcp-button-secondary tmcp-focus mt-8" href="{{ route('public.home') }}">Return home</a>
    </section>
@endsection
