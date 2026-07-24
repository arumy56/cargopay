<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Kargo Pay' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/js/dashboard.js'])
</head>
<body class="dashboard-page">
    <div class="dashboard-shell">
        @include('partials.sidebar')

        <section class="dashboard-main">
            @include('partials.navbar')
            @yield('content')
            <footer class="dashboard-footer">&copy; {{ now()->year }} Kenya Ports Authority. All rights reserved.</footer>
        </section>
    </div>

    @stack('dialogs')
</body>
</html>
