<x-app>

<div class="container mt-5" style="max-width: 500px;">
    <h2 class="mb-4 ">Sign up</h2>
    


    {{-- Show general errors if any --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="/register">
        @csrf 

        <div class="mb-3">
            <label for="name" class="form-label">First Name</label>
            <input type="text" class="form-control @error('firstname') is-invalid @enderror" id="firstname" name="firstname" value="{{ old('firstname') }}" required>
            @error('firstname')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="secondname" class="form-label">Second Name</label>
            <input type="text" class="form-control @error('secondname') is-invalid @enderror" id="secondname" name="secondname" value="{{old('secondname')}}" required>
            @error('secondname')
            <div class="invalid-feedback">{{$message}}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email address</label>
            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required>
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required>
            @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="password_confirmation" class="form-label">Confirm Password</label>
            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
        </div>

        <button type="submit" class="btn btn-primary w-100">Create Account</button>
    </form>
     
                    <p class="text-center text-sm">
                        Already have an account?
                        <a href="/login" class="link link-primary">Sign in</a>
                    </p>
</div>
</x-app>
