<aside class="dashboard-sidebar" id="dashboard-sidebar">
    <div class="sidebar-header">
        <a class="dashboard-brand" href="{{ route('dashboard') }}">Kargo<span>Pay</span></a>
        <button class="icon-button sidebar-toggle" type="button" data-sidebar-toggle aria-label="Collapse menu">&#9776;</button>
    </div>

    <div class="account-summary">
        <img src="{{ asset('images/kpa.jpg') }}" alt="Kenya Ports Authority logo">
        <strong>{{ auth()->user()->firstname }} {{ auth()->user()->secondname }}</strong>
        <span>{{ auth()->user()->email }}</span>
        <small>{{ auth()->user()->isSuperuser() ? 'Administrator' : 'Member' }}</small>
    </div>

    <nav class="dashboard-nav nav flex-column" aria-label="Main navigation">
        <a class="nav-link is-active" href="{{ route('dashboard') }}"><span>⌂</span> Overview</a>
        <button class="nav-link" type="button" data-dialog-open="biller-dialog"><span>▣</span> Bills</button>
        <button class="nav-link" type="button" data-dialog-open="organization-dialog"><span>▤</span> My Organization</button>
        <button class="nav-link" type="button" data-dialog-open="profile-dialog"><span>◉</span> My Profile</button>
        @if(auth()->user()->isSuperuser())
            <a class="nav-link" href="{{ route('subuser.index') }}"><span>♟</span> Manage Users</a>
        @endif
    </nav>
</aside>
