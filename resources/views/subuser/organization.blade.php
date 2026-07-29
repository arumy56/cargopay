<x-app :isDashboard="true" title="Manage Organization | Kargo Pay">
    <div class="container-fluid">
        <div class="row min-vh-100">
            
            <!-- Sidebar -->
            @include('partials.sidebar')

            <!-- Main Content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4 bg-light">
                
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2 class="h3 fw-bold">🏢 Manage Organization & Roles</h2>
                    <a href="{{ route('subuser.index') }}" class="btn btn-outline-primary btn-sm">← Back to Users</a>
                </div>

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white">
                        <strong>Active Members — Assign Roles</strong>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Status</th>
                                        <th>Current Role</th>
                                        <th>Assign Role</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($users as $user)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="bg-secondary text-white rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 32px; height: 32px; font-size: 12px;">
                                                        {{ strtoupper(substr($user->firstname, 0, 1)) }}{{ strtoupper(substr($user->secondname, 0, 1)) }}
                                                    </div>
                                                    <div>
                                                        <div class="fw-semibold">{{ $user->fullName() }}</div>
                                                        <small class="text-muted">Created {{ $user->created_at->format('M d, Y') }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>{{ $user->email }}</td>
                                            <td>
                                                @if($user->is_active)
                                                    <span class="badge bg-success">Active</span>
                                                @else
                                                    <span class="badge bg-secondary">Inactive</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($user->role)
                                                    <span class="badge bg-primary">{{ ucfirst($user->role) }}</span>
                                                @else
                                                    <span class="text-muted">No Role</span>
                                                @endif
                                            </td>
                                            <td>
                                                <form action="{{ route('subuser.updateRole', $user->id) }}" method="POST" class="d-flex gap-2">
                                                    @csrf
                                                    @method('PUT')
                                                    
                                                    <select name="role" class="form-select form-select-sm" style="width: 150px;">
                                                        <option value="">-- No Role --</option>
                                                        <option value="finance" {{ $user->role == 'finance' ? 'selected' : '' }}>Finance</option>
                                                        <option value="clearance" {{ $user->role == 'clearance' ? 'selected' : '' }}>Clearance</option>
                                                        <option value="operations" {{ $user->role == 'operations' ? 'selected' : '' }}>Operations</option>
                                                        <option value="manager" {{ $user->role == 'manager' ? 'selected' : '' }}>Manager</option>
                                                    </select>
                                                    
                                                    <button type="submit" class="btn btn-sm btn-primary">Update</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center text-muted py-4">
                                                No active members found. 
                                                <a href="{{ route('subuser.index') }}">Activate users first</a>.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                {{-- Role Descriptions --}}
                <div class="row mt-4">
                    <div class="col-md-6">
                        <div class="card border-0 shadow-sm">
                            <div class="card-header bg-light">
                                <strong>Role Permissions</strong>
                            </div>
                            <div class="card-body">
                                <ul class="list-unstyled mb-0">
                                    <li class="mb-2"><span class="badge bg-primary">Finance</span> — Manage payments, invoices, transactions</li>
                                    <li class="mb-2"><span class="badge bg-primary">Clearance</span> — Handle customs, documentation</li>
                                    <li class="mb-2"><span class="badge bg-primary">Operations</span> — Manage shipments, logistics</li>
                                    <li class="mb-0"><span class="badge bg-primary">Manager</span> — Oversee all department activities</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

            </main>
        </div>
    </div>
</x-app>