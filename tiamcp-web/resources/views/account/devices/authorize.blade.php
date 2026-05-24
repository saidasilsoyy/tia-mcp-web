@extends('layouts.public')

@section('title', 'Activate device - TIA MCP')

@section('content')
    <section class="mx-auto max-w-3xl px-6 py-16">
        <p class="tmcp-kicker">Desktop connection</p>
        <h1 class="mt-3 text-4xl font-black text-slate-950">Activate desktop device</h1>
        <div class="tmcp-panel mt-8 rounded-lg p-6">
            <p class="text-slate-700">Enter the code shown by the TIA MCP desktop app. Device activation requires a signed-in, verified account.</p>
            @auth
                @if (auth()->user()->hasVerifiedEmail())
                    <form class="mt-6 grid gap-5" method="POST" action="{{ route('device.approve') }}">
                        @csrf
                        <label class="tmcp-label">
                            Device code
                            <input class="tmcp-input uppercase" name="user_code" type="text" inputmode="text" value="{{ old('user_code') }}" placeholder="ABCD-EFGH" required autofocus>
                            @error('user_code') <span class="tmcp-field-error">{{ $message }}</span> @enderror
                        </label>
                        <button class="tmcp-button tmcp-button-primary tmcp-focus" type="submit">Approve device</button>
                    </form>
                @else
                    <div class="tmcp-alert mt-6">Verify your email before approving a desktop device.</div>
                    <a class="tmcp-button tmcp-button-primary tmcp-focus mt-5" href="{{ route('verification.notice') }}">Verify email</a>
                @endif
            @else
                <div class="mt-6 flex flex-wrap gap-3">
                    <a class="tmcp-button tmcp-button-primary tmcp-focus" href="{{ route('auth.login') }}">Sign in to approve</a>
                    <a class="tmcp-button tmcp-button-secondary tmcp-focus" href="{{ route('auth.register') }}">Create free account</a>
                </div>
            @endauth
            <p class="mt-4 text-sm font-semibold text-slate-600">Current API base: {{ config('tiamcp.public_api_base_url') }}</p>
        </div>
    </section>
@endsection
