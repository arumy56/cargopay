<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sign in | Kargo Pay</title>
    @vite(['resources/css/login.css', 'resources/js/app.js'])
</head>
<body class="login-page">
    <main class="login-layout">
        <section class="login-form-panel" aria-labelledby="sign-in-title">
            <div class="login-form-wrap">
                <div class="brand-mark" aria-label="Kenya Ports Authority">
                    <img src="{{ asset('images/kpa.jpg') }}" alt="Kenya Ports Authority logo">
                </div>

                <p class="eyebrow">Sign in</p>
                <h1 id="sign-in-title">Welcome back</h1>
                <p class="intro">Sign in to process your port payments.</p>

                @if ($errors->any())
                    <div class="login-alert" role="alert">
                        {{ $errors->first() }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}" class="login-form">
                    @csrf

                    <div class="field-group">
                        <label for="email">Email Address / Username</label>
                        <div class="input-wrap">
                            <svg aria-hidden="true" viewBox="0 0 24 24"><path d="M3.5 6.5h17v11h-17zM4 7l8 6 8-6"/></svg>
                            <input id="email" type="email" name="email" value="{{ old('email') }}" autocomplete="email" placeholder="you@company.com" required autofocus>
                        </div>
                    </div>

                    <div class="field-group">
                        <div class="field-label-row">
                            <label for="password">Password</label>
                            <a href="#">Forgot password?</a>
                        </div>
                        <div class="input-wrap">
                            <svg aria-hidden="true" viewBox="0 0 24 24"><path d="M7.5 10V8a4.5 4.5 0 0 1 9 0v2M6 10h12v9H6z"/></svg>
                            <input id="password" type="password" name="password" autocomplete="current-password" placeholder="Enter password" required>
                        </div>
                    </div>

                    <div class="submit-row">
                        <button type="submit">Sign in <span aria-hidden="true">→</span></button>
                    </div>
                </form>

                <p class="register-prompt">New to Kargo Pay? <a href="{{ route('register') }}">Create an account</a></p>
            </div>
        </section>

        <section class="hero-panel" aria-label="Kargo Pay port payments">
            <img class="hero-image" src="{{ asset('images/mombasa port.jpg') }}" alt="Shipping containers and cranes at Mombasa Port">
            <div class="live-status"><span></span> Live &middot; processing payments</div>
            <div class="hero-copy">
                <p class="hero-eyebrow">Kargo Pay</p>
                <h2>The first 24/7 automation platform for <em>customs duties</em> in Africa.</h2>
            </div>
        </section>
    </main>
</body>
</html>
