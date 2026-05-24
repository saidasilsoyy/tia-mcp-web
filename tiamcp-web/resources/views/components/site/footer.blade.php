<footer class="border-t border-stone-300/80">
    <div class="mx-auto grid max-w-7xl gap-6 px-6 py-10 text-sm text-slate-600 md:grid-cols-[1fr_auto] md:items-start">
        <div>
            <p class="font-black text-slate-950">TIA MCP</p>
            <p class="mt-2 max-w-xl">&copy; {{ date('Y') }} TIA MCP. Beta access is account-backed, revocable, auditable, and intentionally not described as unhackable.</p>
        </div>
        <div class="grid gap-2 font-semibold sm:grid-cols-2">
            <a class="tmcp-focus rounded hover:text-slate-950" href="{{ route('public.features') }}">Features</a>
            <a class="tmcp-focus rounded hover:text-slate-950" href="{{ route('public.security') }}">Security</a>
            <a class="tmcp-focus rounded hover:text-slate-950" href="{{ route('public.pricing') }}">Pricing</a>
            <a class="tmcp-focus rounded hover:text-slate-950" href="{{ route('public.download') }}">Download</a>
            <a class="tmcp-focus rounded hover:text-slate-950" href="{{ route('public.privacy') }}">Privacy</a>
            <a class="tmcp-focus rounded hover:text-slate-950" href="{{ route('public.terms') }}">Terms</a>
            <a class="tmcp-focus rounded hover:text-slate-950" href="mailto:{{ config('tiamcp.support_email') }}">Support</a>
            <a class="tmcp-focus rounded hover:text-slate-950" href="{{ url('/api/v1/meta') }}">API meta</a>
        </div>
    </div>
</footer>
