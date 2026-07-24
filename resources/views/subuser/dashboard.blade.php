<x-app :isDashboard="true" title="My Dashboard - Kargo Pay">
  <!-- Sidebar -->
  <nav id="sidebar">
    <div>
      <h5>🚢 Kargo Pay</h5>
      <ul>
        @if($user->isSuperuser())
          <li>
            <a href="{{ route('dashboard.index') }}">📊 Main Dashboard</a>
          </li>
        @endif
        <li>
          <a href="{{ route('subuser.dashboard') }}">📊 My Dashboard</a>
        </li>
      </ul>
      <hr>
      
      @if($user->isSubuser() && $organization)
        <div>
          <small>Organization</small>
          <div>
            <div>
              {{ strtoupper(substr($organization->firstname, 0, 1)) }}
            </div>
            <div>
              
              <div>{{ $organization->fullName() }}</div>
              <div>{{ $organization->email }}</div>
            </div>
          </div>
        </div>
        <hr>
      @endif

      <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit">Logout</button>
      </form>
    </div>
  </nav>

  <!-- Main Content -->
  <main>
    <!-- Welcome Header -->
    <div>
      <div>
        <h1>Welcome, {{ $user->fullName() }}! 👋</h1>
        
        @if($user->isSuperuser())
          <p>You are logged in as the <strong>Superuser </strong>.</p>
        @elseif($user->isSubuser() && $organization)
          <p>You are part of <strong>{{ $organization->fullName() }}</strong>'s organization.</p>
        @else
          <p>Welcome to your workspace.</p>
        @endif
      </div>
      <div>
        <span>Active Member</span>
      </div>
    </div>

    <!-- Info Cards -->
    <div>
      <div>
        <div>
          <div>My Role</div>
          <div>{{ ucfirst($user->role) }}</div>
          <div>{{ $user->isSuperuser() ? 'System Administrator' : 'Organization Member' }}</div>
        </div>
      </div>

      @if($organization)
      <div>
        <div>
          <div>Organization Admin</div>
          <div>{{ $organization->fullName() }}</div>
          <div>{{ $organization->email }}</div>
        </div>
      </div>
      @endif

      <div>
        <div>
          <div>Account Status</div>
          <div>Verified</div>
          <div>{{ $user->is_active ? 'Activated' : 'Pending Activation' }}</div>
        </div>
      </div>
    </div>

    <!-- Organization Details Card -->
    <div>
      <div>
        <h5>🏢 Account Details</h5>
      </div>
      <div>
        <table>
          @if($user->isSuperuser())
            <tr>
              <td><strong>Account Type:</strong></td>
              <td>Superuser (Root Admin)</td>
            </tr>
          @else
            <tr>
              <td><strong>Organization Name:</strong></td>
              <td>{{ $organization->fullName() }}</td>
            </tr>
            <tr>
              <td><strong>Admin Email:</strong></td>
              <td>{{ $organization->email }}</td>
            </tr>
          @endif
          
          <tr>
            <td><strong>Member Since:</strong></td>
            <td>{{ $user->created_at->format('F d, Y') }}</td>
          </tr>
          <tr>
            <td><strong>Your Email:</strong></td>
            <td>{{ $user->email }}</td>
          </tr>
        </table>
      </div>
    </div>
  </main>
</x-app>