<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'INEGI Estados') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @stack('styles')
    </head>
    <body class="d-flex flex-column">
        <nav class="navbar navbar-expand-lg bg-white border-bottom sticky-top">
            <div class="container py-2">
                <a class="navbar-brand fw-bold text-primary" href="{{ route('welcome') }}">
                    {{ config('app.name', 'INEGI Estados') }}
                </a>

                <div class="navbar-nav">
                    <a class="nav-link" href="{{ route('states.index') }}">Estados</a>
                </div>
            </div>
        </nav>

        <main class="flex-grow-1">
            @yield('content')
        </main>

        <footer class="py-4 text-center text-secondary small">
            INEGI Estados
        </footer>
        @stack('scripts')
        @stack('vite')
    </body>
</html>
