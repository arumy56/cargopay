@extends('layouts.app', ['title' => 'My Organization | Kargo Pay'])

@section('content')
    @php
        $organizationTabs = [
            'overview' => ['label' => 'Organization overview', 'route' => 'organization.index'],
            'users' => ['label' => 'Manage users', 'route' => 'organization.users'],
            'wallets' => ['label' => 'Wallets', 'route' => 'organization.wallets'],
            'biller' => ['label' => 'Biller accounts', 'route' => 'organization.biller'],
            'roles' => ['label' => 'Company roles', 'route' => 'organization.roles'],
        ];
        $activeTab = $organizationTabs[$section];
    @endphp

    <main class="organization-page">
        <header class="organization-page__header">
            <div>
                <p class="organization-page__eyebrow">My organization</p>
                <h1>{{ $activeTab['label'] }}</h1>
            </div>
            <a class="organization-page__back" href="{{ route('dashboard.index') }}">← Dashboard</a>
        </header>

        @if(session('success'))
            <div class="organization-alert" role="status">{{ session('success') }}</div>
        @endif

        <section class="organization-workspace">
                @if($section === 'overview')
                    <div class="organization-hero">
                        <span class="organization-hero__mark">{{ strtoupper(substr(auth()->user()->firstname, 0, 1)) }}</span>
                        <div>
                            <p>Company workspace</p>
                            <h2>{{ auth()->user()->firstname }} {{ auth()->user()->secondname }}</h2>
                            <span>{{ $activeMembers->count() }} active {{ $activeMembers->count() === 1 ? 'member' : 'members' }} in your organization</span>
                        </div>
                    </div>
                    <div class="organization-summary-grid">
                        <a href="{{ route('organization.users') }}"><span>Team members</span><strong>{{ $subusers->count() }}</strong><small>Manage access</small></a>
                        <a href="{{ route('organization.roles') }}"><span>Assigned roles</span><strong>{{ $activeMembers->whereNotNull('role')->count() }}</strong><small>Review permissions</small></a>
                        <a href="{{ route('organization.biller') }}"><span>Biller account</span><strong>{{ auth()->user()->billerAccount?->is_completed ? 'Active' : 'Set up' }}</strong><small>{{ auth()->user()->billerAccount?->is_completed ? 'View account' : 'Link an account' }}</small></a>
                    </div>
                @elseif($section === 'users')
                    <div class="organization-panel">
                        <div class="organization-panel__heading"><div><p>New member</p><h2>Add a team member</h2></div></div>
                        @if($errors->any())<div class="organization-error"><ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
                        <form class="organization-form" action="{{ route('subuser.store') }}" method="POST">
                            @csrf
                            <label>First name<input name="firstname" value="{{ old('firstname') }}" required autocomplete="given-name"></label>
                            <label>Last name<input name="secondname" value="{{ old('secondname') }}" required autocomplete="family-name"></label>
                            <label>Email address<input type="email" name="email" value="{{ old('email') }}" required autocomplete="email"></label>
                            <label>Password<input type="password" name="password" required autocomplete="new-password"></label>
                            <button type="submit">Create user</button>
                        </form>
                    </div>
                    <div class="organization-panel">
                        <div class="organization-panel__heading"><div><p>Directory</p><h2>Your team</h2></div><span>{{ $subusers->count() }} total</span></div>
                        <div class="organization-table-wrap"><table><thead><tr><th>Member</th><th>Email</th><th>Status</th><th>Role</th><th></th></tr></thead><tbody>
                            @forelse($subusers as $user)
                                <tr><td><strong>{{ $user->fullName() }}</strong><small>Added {{ $user->created_at->format('M j, Y') }}</small></td><td>{{ $user->email }}</td><td><span class="organization-status {{ $user->is_active ? 'is-active' : '' }}">{{ $user->is_active ? 'Active' : 'Inactive' }}</span></td><td>{{ $user->role && $user->role !== 'subuser' ? ucfirst($user->role) : '—' }}</td><td>@if(!$user->is_active)<form action="{{ route('subuser.activate', $user) }}" method="POST">@csrf @method('PATCH')<button class="organization-table-button">Activate</button></form>@endif</td></tr>
                            @empty
                                <tr><td colspan="5" class="organization-empty">No members yet. Add your first team member above.</td></tr>
                            @endforelse
                        </tbody></table></div>
                    </div>
                @elseif($section === 'wallets')
                    <div class="organization-empty-state"><span>◫</span><h2>Your company wallet</h2><p>Wallet balances and funding activity will appear here once your company wallet is connected.</p><a href="{{ route('organization.biller') }}">Review biller account</a></div>
                @elseif($section === 'biller')
                    <div class="organization-panel organization-biller">
                        <div class="organization-panel__heading"><div><p>Payments setup</p><h2>{{ $account?->is_completed ? 'Biller account details' : 'Link your biller account' }}</h2></div><span class="organization-status {{ $account?->is_completed ? 'is-active' : '' }}">{{ $account?->is_completed ? 'Active' : 'Not linked' }}</span></div>
                        @if($errors->any())<div class="organization-error"><ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
                        @if($account?->is_completed)<div class="organization-account-details"><div><span>KRA PIN</span><strong>{{ $account->kra_pin }}</strong></div><div><span>Biller account number</span><strong>{{ $account->biller_account }}</strong></div></div>@endif
                        <form class="organization-form organization-form--stacked" action="{{ route('biller.store') }}" method="POST">
                            @csrf
                            <label>KRA PIN<input name="kra_pin" value="{{ old('kra_pin', $account?->kra_pin) }}" required></label>
                            <label>Biller account number<input name="biller_account" value="{{ old('biller_account', $account?->biller_account) }}" required></label>
                            <button type="submit">{{ $account ? 'Save changes' : 'Link biller account' }}</button>
                        </form>
                    </div>
                @elseif($section === 'roles')
                    <div class="organization-panel">
                        <div class="organization-panel__heading"><div><p>Access control</p><h2>Assign company roles</h2></div></div>
                        <div class="organization-table-wrap"><table><thead><tr><th>Member</th><th>Email</th><th>Current role</th><th>Assign role</th></tr></thead><tbody>
                            @forelse($activeMembers as $user)
                                <tr><td><strong>{{ $user->fullName() }}</strong></td><td>{{ $user->email }}</td><td>{{ $user->role ? ucfirst($user->role) : 'No role' }}</td><td><form class="organization-role-form" action="{{ route('subuser.updateRole', $user->id) }}" method="POST">@csrf @method('PUT')<select name="role"><option value="">No role</option>@foreach(['finance', 'clearance', 'operations', 'manager'] as $role)<option value="{{ $role }}" @selected($user->role === $role)>{{ ucfirst($role) }}</option>@endforeach</select><button class="organization-table-button">Update</button></form></td></tr>
                            @empty
                                <tr><td colspan="4" class="organization-empty">Activate a team member before assigning roles.</td></tr>
                            @endforelse
                        </tbody></table></div>
                    </div>
                    <div class="organization-role-guide"><article><strong>Finance</strong><span>Manage payments, invoices, and transactions.</span></article><article><strong>Clearance</strong><span>Handle customs and documentation.</span></article><article><strong>Operations</strong><span>Manage shipments and logistics.</span></article><article><strong>Manager</strong><span>Oversee department activities.</span></article></div>
                @endif
        </section>
    </main>
@endsection

@push('dialogs')
    @include('partials.dashboard-dialogs')
@endpush
