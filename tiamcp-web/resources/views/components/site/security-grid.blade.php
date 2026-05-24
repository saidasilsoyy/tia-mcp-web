<section class="tmcp-section">
    <div class="tmcp-container">
        <div class="tmcp-page-heading">
            <p class="tmcp-kicker">Security posture</p>
            <h2>Crack-resistant, not unhackable</h2>
            <p>
                The security model is explicit about attacker capabilities. A determined local administrator can patch local checks, so authority, revocation, signing, and audit state stay server-side.
            </p>
        </div>

        <div class="mt-10 grid gap-4 md:grid-cols-2 lg:grid-cols-3">
            <article class="tmcp-feature-card">
                <h3>Server-authoritative access</h3>
                <p>Subscription, device, and GitHub-connected capabilities are represented by cloud state rather than local claims.</p>
            </article>
            <article class="tmcp-feature-card">
                <h3>Signed entitlement documents</h3>
                <p>The desktop and MCP server can verify signed claims without receiving the signing private key.</p>
            </article>
            <article class="tmcp-feature-card">
                <h3>Revocation-aware design</h3>
                <p>Offline access is bounded by an explicit window, trading usability for a known revocation delay.</p>
            </article>
            <article class="tmcp-feature-card">
                <h3>Renderer token boundary</h3>
                <p>Raw provider tokens do not belong in desktop renderer code, localStorage, logs, or MCP process arguments.</p>
            </article>
            <article class="tmcp-feature-card">
                <h3>Separate GitHub grants</h3>
                <p>GitHub login identifies a user; GitHub product connection authorizes repository/product features.</p>
            </article>
            <article class="tmcp-feature-card">
                <h3>Evidence-first operations</h3>
                <p>Smoke, security smoke, packaging, and deployment verification scripts write explicit evidence and skips.</p>
            </article>
        </div>
    </div>
</section>
