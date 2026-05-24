<section class="tmcp-container tmcp-hero-grid">
    <div class="max-w-3xl">
        <p class="tmcp-kicker">Local-first TIA automation, cloud-governed access</p>
        <h1 class="mt-4 text-4xl font-black leading-tight text-slate-950 md:text-6xl">TIA MCP</h1>
        <p class="mt-5 max-w-2xl text-lg leading-8 text-slate-700">
            A Windows desktop and MCP server product for engineers who need local TIA Portal automation with account-backed subscription, device, and GitHub-aware policy controls.
        </p>
        <div class="mt-8 flex flex-col gap-3 sm:flex-row">
            <a class="tmcp-button tmcp-button-primary tmcp-focus" href="{{ route('public.download') }}">Download for Windows</a>
            <a class="tmcp-button tmcp-button-secondary tmcp-focus" href="{{ route('auth.register') }}">Create free account</a>
        </div>
        <dl class="mt-9 grid gap-4 text-sm text-slate-700 sm:grid-cols-3">
            <div>
                <dt class="font-black text-slate-950">Local runtime</dt>
                <dd class="mt-1">TIA Portal stays on the workstation.</dd>
            </div>
            <div>
                <dt class="font-black text-slate-950">Cloud policy</dt>
                <dd class="mt-1">Entitlements are server-authoritative.</dd>
            </div>
            <div>
                <dt class="font-black text-slate-950">GitHub optional</dt>
                <dd class="mt-1">Connected only by separate grant.</dd>
            </div>
        </dl>
    </div>

    <x-site.product-frame />
</section>
