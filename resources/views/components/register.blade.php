<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Create your account | Kargo Pay</title>
    @vite(['resources/css/registration.css', 'resources/js/app.js'])
</head>
<body class="registration-page">
    <div class="background" style="background-image: linear-gradient(rgba(2, 49, 86, 0.45), rgba(2, 49, 86, 0.45)), url('{{ asset('images/mombasa port.jpg') }}');"></div>
    <main class="registration-layout">
    
        <section class="registration-panel" aria-labelledby="registration-title">
            <div class="registration-card">
                <img class="registration-logo" src="{{ asset('images/kpa.jpg') }}" alt="Kenya Ports Authority logo">
                <h1 id="registration-title">Create Your Account!</h1>
                <p class="registration-intro">Get started! Sign up below to create your account.</p>

                @if ($errors->any())
                    <div class="registration-alert" role="alert">
                        <strong>Please check the highlighted fields.</strong>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ url('/register') }}" class="registration-form">
                    @csrf
                    <div class="registration-fields">
                        <div class="registration-field">
                            <label for="firstname">First Name</label>
                            <input id="firstname" name="firstname" type="text" value="{{ old('firstname') }}" placeholder="Enter first name" required autocomplete="given-name">
                            @error('firstname')<p class="field-error">{{ $message }}</p>@enderror
                        </div>
                        <div class="registration-field">
                            <label for="secondname">Last Name</label>
                            <input id="secondname" name="secondname" type="text" value="{{ old('secondname') }}" placeholder="Enter last name" required autocomplete="family-name">
                            @error('secondname')<p class="field-error">{{ $message }}</p>@enderror
                        </div>
                        <div class="registration-field">
                            <label for="email">Email Address</label>
                            <input id="email" name="email" type="email" value="{{ old('email') }}" placeholder="you@company.com" required autocomplete="email">
                            @error('email')<p class="field-error">{{ $message }}</p>@enderror
                        </div>
                        <div class="registration-field">
                            <label for="phone">Phone Number <span>Optional</span></label>
                            <input id="phone" name="phone" type="tel" value="{{ old('phone') }}" placeholder="+254 700 000 000" autocomplete="tel">
                        </div>
                        <div class="registration-field">
                            <label for="password">Password</label>
                            <input id="password" name="password" type="password" placeholder="Create a password" required autocomplete="new-password">
                            @error('password')<p class="field-error">{{ $message }}</p>@enderror
                        </div>
                        <div class="registration-field">
                            <label for="password_confirmation">Confirm Password</label>
                            <input id="password_confirmation" name="password_confirmation" type="password" placeholder="Confirm your password" required autocomplete="new-password">
                        </div>
                    </div>

                    <div class="registration-actions">
                        <a href="{{ route('login') }}">I already have an account</a>
                    </div>
                    <label class="terms-check">
                        <input type="checkbox" required>
                        <span>I accept the <a href="#">Terms and Conditions</a> and <a href="#">Privacy Policy</a>.</span>
                    </label>
                    <button class="registration-submit" type="submit">Create account <span aria-hidden="true">&rarr;</span></button>
                </form>
            </div>
        </section>
    </main>
</body>
</html>
