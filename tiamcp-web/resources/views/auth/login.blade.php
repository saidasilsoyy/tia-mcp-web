@extends('layouts.public')

@section('title', 'Sign in - TIA MCP')

@section('content')
    <section class="mx-auto max-w-3xl px-6 py-16">
        <p class="tmcp-kicker">Account access</p>
        <h1 class="mt-3 text-4xl font-black text-slate-950">Sign in to TIA MCP</h1>
        <div class="tmcp-panel mt-8 rounded-lg p-6">
            @if (session('status'))
                <div class="tmcp-status-alert mb-5">{{ session('status') }}</div>
            @endif

            <form class="grid gap-5" method="POST" action="{{ route('auth.login') }}">
                @csrf
                <label class="tmcp-label">
                    Email
                    <input class="tmcp-input" name="email" type="email" value="{{ old('email') }}" autocomplete="email" required autofocus>
                    @error('email') <span class="tmcp-field-error">{{ $message }}</span> @enderror
                </label>

                <label class="tmcp-label">
                    Password
                    <input class="tmcp-input" name="password" type="password" autocomplete="current-password" required>
                    @error('password') <span class="tmcp-field-error">{{ $message }}</span> @enderror
                </label>

                <label class="flex items-center gap-3 text-sm font-semibold text-slate-700">
                    <input class="h-4 w-4" name="remember" type="checkbox" value="1">
                    Keep me signed in
                </label>

                <button class="tmcp-button tmcp-button-primary tmcp-focus" type="submit">Sign in</button>
            </form>

            <div class="mt-6 grid gap-3 border-t border-stone-300 pt-6 sm:grid-cols-2">
                <a class="tmcp-button tmcp-button-secondary tmcp-focus" href="{{ route('auth.oauth.redirect', 'google') }}">Continue with Google</a>
                <a class="tmcp-button tmcp-button-secondary tmcp-focus" href="{{ route('auth.oauth.redirect', 'github') }}">Continue with GitHub</a>
            </div>

            <div class="mt-6 flex flex-wrap gap-4 text-sm font-semibold">
                <a class="tmcp-focus rounded text-teal-700" href="{{ route('auth.register') }}">Create account</a>
                <a class="tmcp-focus rounded text-teal-700" href="{{ route('auth.password.request') }}">Forgot password</a>
            </div>
        </div>
    </section>
@endsection
