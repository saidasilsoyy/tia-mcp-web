@extends('layouts.public')

@section('title', 'Reset password - TIA MCP')

@section('content')
    <section class="mx-auto max-w-3xl px-6 py-16">
        <p class="tmcp-kicker">Password reset</p>
        <h1 class="mt-3 text-4xl font-black text-slate-950">Send a reset link</h1>
        <div class="tmcp-panel mt-8 rounded-lg p-6">
            @if (session('status'))
                <div class="tmcp-status-alert mb-5">{{ session('status') }}</div>
            @endif
            <form class="grid gap-5" method="POST" action="{{ route('auth.password.email') }}">
                @csrf
                <label class="tmcp-label">
                    Email
                    <input class="tmcp-input" name="email" type="email" value="{{ old('email') }}" autocomplete="email" required autofocus>
                    @error('email') <span class="tmcp-field-error">{{ $message }}</span> @enderror
                </label>
                <button class="tmcp-button tmcp-button-primary tmcp-focus" type="submit">Send reset link</button>
            </form>
        </div>
    </section>
@endsection
