@extends('layouts.public')

@section('title', 'Terms - TIA MCP')
@section('meta_description', 'TIA MCP beta terms summary.')

@section('content')
    <section class="tmcp-container tmcp-section">
        <div class="tmcp-page-heading">
            <p class="tmcp-kicker">Terms</p>
            <h1>Beta terms summary</h1>
            <p>This page is a product-phase placeholder, not final legal counsel. The production version must be reviewed before launch.</p>
        </div>

        <div class="mt-10 grid gap-4 md:grid-cols-2">
            <article class="tmcp-feature-card">
                <h3>Beta access</h3>
                <p>Access is free during beta, revocable, and subject to product readiness limits documented in the launch checklist.</p>
            </article>
            <article class="tmcp-feature-card">
                <h3>Security limits</h3>
                <p>The product is designed to be crack-resistant, revocable, and auditable. It is not represented as unhackable.</p>
            </article>
            <article class="tmcp-feature-card">
                <h3>Local responsibility</h3>
                <p>Users remain responsible for validating automation behavior before applying changes to industrial environments.</p>
            </article>
            <article class="tmcp-feature-card">
                <h3>Service changes</h3>
                <p>Subscription, entitlement, and GitHub-connected capabilities may change as the MVP moves toward public beta.</p>
            </article>
        </div>
    </section>
@endsection
