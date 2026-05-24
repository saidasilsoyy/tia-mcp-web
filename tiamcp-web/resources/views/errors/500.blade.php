@extends('layouts.public')

@section('title', 'Service unavailable - TIA MCP')

@section('content')
    <section class="mx-auto max-w-3xl px-6 py-20">
        <p class="tmcp-kicker">500</p>
        <h1 class="mt-3 text-4xl font-black text-slate-950">Service temporarily unavailable</h1>
        <p class="mt-4 text-slate-700">The request could not be completed. No sensitive diagnostic details are shown here.</p>
        <a class="tmcp-button tmcp-button-secondary tmcp-focus mt-8" href="{{ route('public.home') }}">Return home</a>
    </section>
@endsection
