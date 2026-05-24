@extends('layouts.public')

@section('title', 'Security - TIA MCP')
@section('meta_description', 'TIA MCP security model for account-backed, revocable, auditable, crack-resistant access.')

@section('content')
    <x-site.security-grid />

    <section class="tmcp-container tmcp-section-tight">
        <div class="overflow-x-auto">
            <table class="tmcp-table">
                <thead>
                    <tr>
                        <th>Control</th>
                        <th>Current phase</th>
                        <th>Security purpose</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>OAuth separation</td>
                        <td>Designed, not implemented</td>
                        <td>Prevents GitHub login from silently becoming product repository authorization.</td>
                    </tr>
                    <tr>
                        <td>Signed entitlements</td>
                        <td>Designed, not implemented</td>
                        <td>Lets local components verify server-issued access claims without owning signing secrets.</td>
                    </tr>
                    <tr>
                        <td>No raw provider tokens in renderer</td>
                        <td>Required for desktop phase</td>
                        <td>Reduces exposure through logs, localStorage, devtools, and MCP arguments.</td>
                    </tr>
                    <tr>
                        <td>Evidence scripts</td>
                        <td>Implemented locally</td>
                        <td>Records what passed, what skipped, and what still requires external deployment.</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </section>
@endsection
