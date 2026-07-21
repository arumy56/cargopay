<x-app>
@if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif


   <form method="POST" action="/login">
    @csrf
    <label for="email" class="form-label">Email</label>
    <input type="email" name="email">
    <label for="password" class="form-label">Password</label>
    <input type="password" name="password">
   <div>
       <button type="submit" class="btn btn-primary w-10 center">Sign In</button>
       </div> 
    
   </form>
     <p class="text-center text-sm">
                        Don't have an account?
                        <a href="/register" class="link link-primary">Sign Up</a>
                    </p>
</x-app>