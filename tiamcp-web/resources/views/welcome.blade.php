@extends('layouts.public')

@section('title', 'TIA MCP')

@section('content')
    <section class="mx-auto max-w-3xl px-6 py-16">
        <p class="tmcp-kicker">TIA MCP</p>
        <h1 class="mt-3 text-4xl font-black text-slate-950">Local-first TIA Portal automation</h1>
        <p class="mt-4 text-slate-700">Use the product home route for the current public web experience.</p>
        <a class="tmcp-button tmcp-button-primary tmcp-focus mt-8" href="{{ route('public.home') }}">Open product home</a>
    </section>
@endsection
