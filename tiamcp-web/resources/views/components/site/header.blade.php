<header class="sticky top-0 z-40 border-b border-stone-300/80 bg-[#f5f4ee]/95 backdrop-blur">
    <div class="mx-auto flex w-full max-w-7xl items-center justify-between gap-4 px-6 py-3">
        <a class="tmcp-focus flex items-center gap-3 rounded" href="{{ route('public.home') }}" aria-label="TIA MCP home">
            <img class="h-10 w-10 rounded-md" src="{{ asset('assets/brand/tiamcp-mark.png') }}" alt="" width="40" height="40">
            <span class="leading-tight">
                <span class="block text-sm font-black uppercase text-slate-950">TIA MCP</span>
                <span class="block text-xs font-semibold text-slate-600">Industrial automation MCP</span>
            </span>
        </a>

        <nav class="hidden items-center gap-5 text-sm font-bold text-slate-700 md:flex">
            <a class="tmcp-nav-link tmcp-focus" href="{{ route('public.features') }}">Features</a>
            <a class="tmcp-nav-link tmcp-focus" href="{{ route('public.security') }}">Security</a>
            <a class="tmcp-nav-link tmcp-focus" href="{{ route('public.pricing') }}">Pricing</a>
            <a class="tmcp-nav-link tmcp-focus" href="{{ route('public.docs') }}">Docs</a>
            @auth
                <a class="tmcp-nav-link tmcp-focus" href="{{ route('account.dashboard') }}">Account</a>
            @else
                <a class="tmcp-nav-link tmcp-focus" href="{{ route('auth.login') }}">Sign in</a>
            @endauth
            <a class="tmcp-button tmcp-button-primary tmcp-focus" href="{{ route('public.download') }}">Download for Windows</a>
        </nav>

        <button class="tmcp-mobile-toggle tmcp-focus md:hidden" type="button" data-mobile-menu-button aria-controls="mobile-menu" aria-expanded="false">
            <span class="sr-only">Menu</span>
            <span></span>
            <span></span>
            <span></span>
        </button>
    </div>

    <nav id="mobile-menu" class="tmcp-mobile-menu hidden border-t border-stone-300 bg-[#f5f4ee] px-6 py-4 md:hidden" data-mobile-menu>
        <a class="tmcp-mobile-link tmcp-focus" href="{{ route('public.features') }}">Features</a>
        <a class="tmcp-mobile-link tmcp-focus" href="{{ route('public.security') }}">Security</a>
        <a class="tmcp-mobile-link tmcp-focus" href="{{ route('public.pricing') }}">Pricing</a>
        <a class="tmcp-mobile-link tmcp-focus" href="{{ route('public.docs') }}">Docs</a>
        @auth
            <a class="tmcp-mobile-link tmcp-focus" href="{{ route('account.dashboard') }}">Account</a>
        @else
            <a class="tmcp-mobile-link tmcp-focus" href="{{ route('auth.login') }}">Sign in</a>
        @endauth
        <a class="tmcp-button tmcp-button-primary tmcp-focus mt-3 w-full" href="{{ route('public.download') }}">Download for Windows</a>
    </nav>
</header>
