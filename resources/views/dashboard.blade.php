<x-app :isDashboard="true" title="Dashboard - Kargo Pay">
  <!-- Sidebar Navigation Column -->
  <nav id="sidebar">
    <div>
      <h5>🚢 Kargo Pay</h5>
      
      @if(auth()->user()->isSuperuser())
    <li class="nav-item">
        <a class="nav-link text-dark rounded px-3 py-2" href="{{ route('subuser.index') }}">
            👥 Manage Users
        </a>
    </li>
@endif

<div>
     <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit">Logout</button>
      </form>
</div>
    </div>
  </nav>

  <!-- Main Content Column -->
  <main>
    <!-- Welcome Section Header -->
    <div>
      <div>
        <h1>Welcome back, {{ Auth::user()->firstname }}! 👋</h1>
        <p>Here is what is happening with Kargo Pay today.</p>
      </div>
    </div>

   
    


      

    
  </main>
</x-app>
