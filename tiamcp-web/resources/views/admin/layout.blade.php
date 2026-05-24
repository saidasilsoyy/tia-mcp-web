<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>@yield('title', 'Admin - TIA MCP')</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <a class="tmcp-skip-link" href="#main-content">Skip to content</a>
        <div class="min-h-screen">
            <x-site.header />

            <div class="mx-auto grid w-full max-w-7xl gap-8 px-6 py-8 lg:grid-cols-[17rem_1fr]">
                <aside class="tmcp-panel rounded-lg p-4">
                    <p class="tmcp-kicker">Admin</p>
                    <nav class="mt-4 grid gap-2 text-sm font-semibold text-slate-700">
                        <a class="tmcp-focus rounded px-3 py-2 hover:bg-white" href="{{ route('admin.dashboard') }}">Dashboard</a>
                        <a class="tmcp-focus rounded px-3 py-2 hover:bg-white" href="{{ route('admin.users.index') }}">Users</a>
                        <a class="tmcp-focus rounded px-3 py-2 hover:bg-white" href="{{ route('admin.devices.index') }}">Devices</a>
                        <a class="tmcp-focus rounded px-3 py-2 hover:bg-white" href="{{ route('admin.audit.index') }}">Audit log</a>
                        <a class="tmcp-focus rounded px-3 py-2 hover:bg-white" href="{{ route('account.dashboard') }}">Account</a>
                        <form method="POST" action="{{ route('auth.logout') }}">
                            @csrf
                            <button class="tmcp-focus w-full rounded px-3 py-2 text-left hover:bg-white" type="submit">Sign out</button>
                        </form>
                    </nav>
                </aside>

                <main id="main-content" class="min-w-0">
                    @yield('content')
                </main>
            </div>
        </div>
    </body>
</html>
