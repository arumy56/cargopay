<x-app :isDashboard="true" title="Manage Users">
  <!-- Sidebar -->
  <nav id="sidebar">
    <div>
      <h5>🚢 Kargo Pay</h5>
      <ul>
        <li>
          <a href="{{ route('dashboard') }}">📊 Dashboard</a>
        </li>
        <li>
          <a href="{{ route('subuser.index') }}">👥 Manage Users</a>
        </li>
      </ul>
      <hr>
      <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit">Logout</button>
      </form>
    </div>
  </nav>

  <!-- Main Content -->
  <main>
    <div>
      <h2>Manage Organization Users</h2>
    </div>

    @if(session('success'))
            <div style="color: green; margin-bottom: 15px;">
                <strong>Success!</strong> {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div style="color: red; margin-bottom: 15px;">
                <strong>Please fix the errors below:</strong>
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

    <!-- CREATE FORM -->
    <div>
      <div>
        <strong>Create New User</strong>
      </div>
      <div>
        <form action="{{ route('subuser.store') }}" method="POST">
          @csrf
          <div>
            <div>
              <input type="text" name="firstname" placeholder="First Name" value="{{ old('firstname') }}" required>
            </div>
            <div>
              <input type="text" name="secondname" placeholder="Second Name" value="{{ old('secondname') }}" required>
            </div>
            <div>
              <input type="email" name="email" placeholder="Email Address" value="{{ old('email') }}" required>
            </div>
            <div>
                            
                            <input type="text" name="password" placeholder="Enter Password" id="password" required>
                        </div>
            <div>
              <button type="submit">Create User</button>
            </div>
          </div>
        </form>
      </div>
    </div>

    <!-- READ / ACTIVATE / DEACTIVATE TABLE -->
    <div>
      <div>
        <strong>All Users</strong>
      </div>
      <div>
        <table>
          <thead>
            <tr>
              <th>First Name</th>
              <th>Second Name</th>
              <th>Email</th>
              <th>Status</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            @forelse($subuser as $user)
            <tr>
              <td>{{ $user->firstname }}</td>
              <td>{{ $user->secondname }}</td>
              <td>{{ $user->email }}</td>
              <td> $user->password</td>
              <td>
                @if($user->is_active)
                <span>Active</span>
                @else
                <span>Inactive</span>
                @endif
              </td>
              <td>
                @if(!$user->is_active)
                <!-- ACTIVATE -->
                <form action="{{ route('subuser.activate', $user) }}" method="POST">
                  @csrf
                  @method('PATCH')
                  <button type="submit">Activate</button>
                </form>
                @else
                <!-- DEACTIVATE -->
                <form action="{{ route('subuser.destroy', $user) }}" method="POST" onsubmit="return confirm('Deactivate this user?');">
                  @csrf
                  @method('DELETE')
                  <button type="submit">Deactivate</button>
                </form>
                @endif
              </td>
            </tr>
            @empty
            <tr>
              <td colspan="5">No users found.</td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </main>
</x-app>
