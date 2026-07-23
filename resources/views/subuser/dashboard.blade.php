<x-app :isDashboard="true" title="My Dashboard - Kargo Pay">
  <!-- Sidebar -->
  <nav id="sidebar">
    <div>
      <h5>🚢 Kargo Pay</h5>
      <ul>
        <li>
          <a href="{{ route('subuser.dashboard') }}">📊 My Dashboard</a>
        </li>
        
        <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit">Logout</button>
      </form>
       
      </ul>
      <hr>
      <div>
        <small>Organization</small>
        
          
         <div>
            
    <span> Name: </span> <span>{{ $organization->fullName() }}  </span>  <span>Email: {{ $organization->email }}</span>
</div>

        
      </div>
      <hr>
      
    </div>
  </nav>

  <!-- Main Content -->
  <main>
    <!-- Welcome Header -->
    <div>
      <div>
        <h1>Welcome, {{ $subuser->firstname }}! 👋</h1>
        <p>You are part of <strong>{{ $organization->fullName() }}</strong>'s organization.</p>
      </div>
      <div>
        <span>Active Member</span>
      </div>
    </div>

    <!-- Info Cards -->
    <div>
      

      <div>
        <div>
          <div>Organization</div>
          <div>{{ $organization->firstname }}</div>
          <div>{{ $organization->email }}</div>
        </div>
      </div>

      <div>
        <div>
          <div>Account Status</div>
          <div>Verified</div>
          <div>Activated by admin</div>
        </div>
      </div>
    </div>

    <!-- Organization Details Card -->
    <div>
      <div>
        <h5>🏢 Organization Details</h5>
      </div>
      <div>
        <table>
          <tr>
            <td><strong>Organization Name:</strong></td>
            <td>{{ $organization->fullName() }}</td>
          </tr>
          <tr>
            <td><strong>Admin Email:</strong></td>
            <td>{{ $organization->email }}</td>
          </tr>
          <tr>
            <td><strong>Member Since:</strong></td>
            <td>{{ $subuser->created_at->format('F d, Y') }}</td>
          </tr>
          <tr>
            <td><strong>Your Email:</strong></td>
            <td>{{ $subuser->email }}</td>
          </tr>
        </table>
      </div>
    </div>

    
  </main>
</x-app>
