<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $title ?? 'KargoPay' }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-light min-vh-100 d-flex flex-column">

    @if(!isset($isDashboard))

        <nav class="navbar navbar-expand-lg bg-white shadow-sm border-bottom">

            <div class="container">

                <a class="navbar-brand fw-bold text-primary" href="/">
                    KargoPay
                </a>

                <div class="d-flex gap-2">

                    <a href="{{ route('login') }}" class="btn btn-outline-primary">
                        Sign In
                    </a>

                    <a href="{{ route('register') }}" class="btn btn-primary">
                        Sign Up
                    </a>

                </div>

            </div>

        </nav>

    @endif

    <main class="flex-grow-1">

        {{ $slot }}

    </main>

</body>

</html>