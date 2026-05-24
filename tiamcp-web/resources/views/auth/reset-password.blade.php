@extends('layouts.public')

@section('title', 'Choose new password - TIA MCP')

@section('content')
    <section class="mx-auto max-w-3xl px-6 py-16">
        <p class="tmcp-kicker">Password reset</p>
        <h1 class="mt-3 text-4xl font-black text-slate-950">Choose a new password</h1>
        <div class="tmcp-panel mt-8 rounded-lg p-6">
            <form class="grid gap-5" method="POST" action="{{ route('auth.password.store') }}">
                @csrf
                <input name="token" type="hidden" value="{{ $token }}">
                <label class="tmcp-label">
                    Email
                    <input class="tmcp-input" name="email" type="email" value="{{ old('email', $request->email) }}" autocomplete="email" required autofocus>
                    @error('email') <span class="tmcp-field-error">{{ $message }}</span> @enderror
                </label>
                <label class="tmcp-label">
                    Password
                    <input class="tmcp-input" name="password" type="password" autocomplete="new-password" required>
                    @error('password') <span class="tmcp-field-error">{{ $message }}</span> @enderror
                </label>
                <label class="tmcp-label">
                    Confirm password
                    <input class="tmcp-input" name="password_confirmation" type="password" autocomplete="new-password" required>
                </label>
                <button class="tmcp-button tmcp-button-primary tmcp-focus" type="submit">Reset password</button>
            </form>
        </div>
    </section>
@endsection
