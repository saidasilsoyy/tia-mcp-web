@extends('layouts.public')

@section('title', 'Download - TIA MCP')
@section('meta_description', 'Download information for the TIA MCP Windows desktop beta.')

@section('content')
    <section class="tmcp-container tmcp-section">
        <div class="grid gap-10 lg:grid-cols-[0.85fr_1.15fr] lg:items-start">
            <div class="tmcp-page-heading">
                <p class="tmcp-kicker">Windows desktop</p>
                <h1>Download for Windows</h1>
                <p>The desktop app is the local control surface for account status, device activation, and MCP server startup.</p>
                <div class="mt-8 flex flex-col gap-3 sm:flex-row">
                    <span class="tmcp-button tmcp-button-primary" aria-disabled="true">Signed installer pending</span>
                    <a class="tmcp-button tmcp-button-secondary tmcp-focus" href="{{ route('auth.register') }}">Create free account</a>
                </div>
            </div>

            <div class="tmcp-alert">
                <p class="font-black">No fake binary link</p>
                <p class="mt-2">The public signed installer is not published in this phase. Desktop packaging remains in the local product scripts and later release phases.</p>
            </div>
        </div>

        <div class="mt-12 grid gap-4 md:grid-cols-3">
            <article class="tmcp-feature-card">
                <h3>1. Create account</h3>
                <p>Email, Google, and GitHub login flows are implemented in later auth phases.</p>
            </article>
            <article class="tmcp-feature-card">
                <h3>2. Activate device</h3>
                <p>The desktop will open the browser activation flow and store device tokens in the main process.</p>
            </article>
            <article class="tmcp-feature-card">
                <h3>3. Run local MCP</h3>
                <p>The server enforces entitlement before executing gated tools once the enforcement phase lands.</p>
            </article>
        </div>
    </section>
@endsection
