@extends('layouts.public')

@section('title', 'Docs - TIA MCP')
@section('meta_description', 'TIA MCP docs entry for desktop setup, cloud API, security, and deployment evidence.')

@section('content')
    <section class="tmcp-container tmcp-section">
        <div class="tmcp-page-heading">
            <p class="tmcp-kicker">Docs entry</p>
            <h1>Operational docs for the beta product</h1>
            <p>Public docs will consolidate desktop setup, account/device flows, GitHub connection, entitlement errors, and deployment evidence as phases land.</p>
        </div>

        <div class="mt-10 grid gap-4 md:grid-cols-2">
            <article class="tmcp-feature-card">
                <h3>Cloud API</h3>
                <p>Health and metadata are live locally under `/api/v1`; account and entitlement endpoints arrive in later phases.</p>
                <pre class="tmcp-code mt-5">GET /api/v1/health
GET /api/v1/meta</pre>
            </article>
            <article class="tmcp-feature-card">
                <h3>Evidence</h3>
                <p>Local evidence is written under `release/evidence/`; cloud and web evidence is written under `release/cloud-evidence/`.</p>
                <pre class="tmcp-code mt-5">powershell -File scripts/phase2-gate.ps1
powershell -File scripts/cloud/collect-cloud-evidence.ps1</pre>
            </article>
        </div>
    </section>
@endsection
