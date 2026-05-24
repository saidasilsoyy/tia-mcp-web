@extends('layouts.public')

@section('title', 'Privacy - TIA MCP')
@section('meta_description', 'TIA MCP beta privacy summary.')

@section('content')
    <section class="tmcp-container tmcp-section">
        <div class="tmcp-page-heading">
            <p class="tmcp-kicker">Privacy</p>
            <h1>Beta privacy summary</h1>
            <p>This page is a product-phase placeholder, not final legal counsel. The production version must be reviewed before launch.</p>
        </div>

        <div class="mt-10 grid gap-4 md:grid-cols-2">
            <article class="tmcp-feature-card">
                <h3>Account data</h3>
                <p>The cloud app will store account identity, subscription state, device records, and audit events needed to operate access controls.</p>
            </article>
            <article class="tmcp-feature-card">
                <h3>GitHub data</h3>
                <p>GitHub product connection will use the minimum scopes needed for selected features and remains separate from GitHub login.</p>
            </article>
            <article class="tmcp-feature-card">
                <h3>Local engineering data</h3>
                <p>TIA Portal project automation is designed to run locally. Future cloud features should avoid uploading project contents unless explicitly added and documented.</p>
            </article>
            <article class="tmcp-feature-card">
                <h3>Support</h3>
                <p>Contact {{ config('tiamcp.support_email') }} for privacy or support requests during beta.</p>
            </article>
        </div>
    </section>
@endsection
