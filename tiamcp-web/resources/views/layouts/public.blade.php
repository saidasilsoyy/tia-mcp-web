<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="description" content="@yield('meta_description', 'TIA MCP connects local TIA Portal automation with account-backed MCP access controls.')">
        <title>@yield('title', 'TIA MCP')</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <a class="tmcp-skip-link" href="#main-content">Skip to content</a>
        <x-site.header />

        <main id="main-content">
            @yield('content')
        </main>

        <x-site.footer />
    </body>
</html>
