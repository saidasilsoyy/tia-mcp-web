@extends('layouts.public')

@section('title', 'Features - TIA MCP')
@section('meta_description', 'Explore TIA MCP desktop, MCP, entitlement, GitHub, and deployment readiness features.')

@section('content')
    <section class="tmcp-container tmcp-section">
        <div class="tmcp-page-heading">
            <p class="tmcp-kicker">Features</p>
            <h1>Built for engineers who need local automation and accountable access</h1>
            <p>TIA MCP combines a Windows desktop runtime, local MCP server, and Hostinger-first cloud account layer without pretending local binaries are impossible to patch.</p>
        </div>

        <div class="mt-10 grid gap-4 md:grid-cols-2 lg:grid-cols-3">
            <article class="tmcp-feature-card">
                <h3>Desktop-managed local server</h3>
                <p>Electron owns local server lifecycle and account status surfaces without exposing raw provider tokens to renderer code.</p>
            </article>
            <article class="tmcp-feature-card">
                <h3>API v1 contract</h3>
                <p>Health and metadata endpoints already establish the versioned cloud API namespace for later account and device phases.</p>
            </article>
            <article class="tmcp-feature-card">
                <h3>Free beta subscription model</h3>
                <p>The MVP uses real subscription and entitlement records without adding a payment processor yet.</p>
            </article>
            <article class="tmcp-feature-card">
                <h3>Device activation path</h3>
                <p>The public device page is reserved for browser-based activation from the desktop app.</p>
            </article>
            <article class="tmcp-feature-card">
                <h3>GitHub connection boundary</h3>
                <p>Identity login and product repository access are separate OAuth grants with separate client configuration.</p>
            </article>
            <article class="tmcp-feature-card">
                <h3>Evidence scripts</h3>
                <p>Local and cloud scripts write command evidence, package output, and explicit skip reasons instead of fake success.</p>
            </article>
        </div>
    </section>
@endsection
