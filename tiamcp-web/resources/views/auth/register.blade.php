@extends('layouts.public')

@section('title', 'Create account - TIA MCP')

@section('content')
    <section class="mx-auto max-w-3xl px-6 py-16">
        <p class="tmcp-kicker">Free beta subscription</p>
        <h1 class="mt-3 text-4xl font-black text-slate-950">Create your TIA MCP account</h1>
        <div class="tmcp-panel mt-8 rounded-lg p-6">
            <form class="grid gap-5" method="POST" action="{{ route('auth.register') }}">
                @csrf
                <label class="tmcp-label">
                    Name
                    <input class="tmcp-input" name="name" type="text" value="{{ old('name') }}" autocomplete="name" required autofocus>
                    @error('name') <span class="tmcp-field-error">{{ $message }}</span> @enderror
                </label>

                <label class="tmcp-label">
                    Email
                    <input class="tmcp-input" name="email" type="email" value="{{ old('email') }}" autocomplete="email" required>
                    @error('email') <span class="tmcp-field-error">{{ $message }}</span> @enderror
                </label>

                <label class="tmcp-label">
                    Password
                    <input class="tmcp-input" name="password" type="password" autocomplete="new-password" required>
                    <span class="tmcp-form-help">Use at least 12 characters with letters and numbers.</span>
                    @error('password') <span class="tmcp-field-error">{{ $message }}</span> @enderror
                </label>

                <label class="tmcp-label">
                    Confirm password
                    <input class="tmcp-input" name="password_confirmation" type="password" autocomplete="new-password" required>
                </label>

                <button class="tmcp-button tmcp-button-primary tmcp-focus" type="submit">Create free account</button>
            </form>

            <div class="mt-6 grid gap-3 border-t border-stone-300 pt-6 sm:grid-cols-2">
                <a class="tmcp-button tmcp-button-secondary tmcp-focus" href="{{ route('auth.oauth.redirect', 'google') }}">Continue with Google</a>
                <a class="tmcp-button tmcp-button-secondary tmcp-focus" href="{{ route('auth.oauth.redirect', 'github') }}">Continue with GitHub</a>
            </div>

            <p class="mt-6 text-sm font-semibold text-slate-600">
                Already registered?
                <a class="tmcp-focus rounded text-teal-700" href="{{ route('auth.login') }}">Sign in</a>
            </p>
        </div>
    </section>
@endsection
