<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Load Bootstrap CSS via Vite or CDN -->
    <link href="https://jsdelivr.net" rel="stylesheet">
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <title>{{ $title ?? 'Kargo Pay' }}</title>
</head>
<body class="bg-light min-vh-100 d-flex flex-col">

    {{-- CONDITIONAL: Show standard website navbar only if NOT a dashboard page --}}
    @if(!isset($isDashboard))
        <nav class="navbar navbar-expand-lg navbar-white bg-white border-bottom shadow-sm">
            <div class="container">
                <a class="navbar-brand fw-bold text-primary" href="/"> 🚢 Kargo</a>
                <div class="d-flex gap-2">
                    <a href="{{ route('login') }}" class="btn btn-outline-secondary btn-sm">Sign In</a>
                    <a href="{{ route('register') }}" class="btn btn-primary btn-sm">Sign Up</a>
                </div>
            </div>
        </nav>
    @endif

    {{-- Render the specific page content --}}
    <main class="flex-grow-1">
        {{ $slot }}
    </main>

    <!-- Bootstrap Bundle JS -->
    <script src="https://jsdelivr.net"></script>
</body>
</html>
