<aside class="dashboard-sidebar" id="dashboard-sidebar">
    <div class="sidebar-header">
        <a class="dashboard-brand" href="{{ route('dashboard.index') }}">Kargo<span>Pay</span></a>
        <button class="icon-button sidebar-toggle" type="button" data-sidebar-toggle aria-label="Collapse menu">☰</button>
    </div>

    <div class="account-summary">
        <img src="{{ asset('images/kpa.jpg') }}" alt="Kenya Ports Authority logo">
        <strong>{{ auth()->user()->firstname }} {{ auth()->user()->secondname }}</strong>
        <span>{{ auth()->user()->email }}</span>
        <small>{{ auth()->user()->isSuperuser() ? 'Administrator' : 'Member' }}</small>
    </div>

    <nav class="dashboard-nav nav flex-column" aria-label="Main navigation">
        <a class="nav-link {{ request()->routeIs('dashboard.index') ? 'is-active' : '' }}" href="{{ route('dashboard.index') }}"><span>⌂</span> Overview</a>

        @if(auth()->user()->isSuperuser())
            <div class="nav-group {{ request()->routeIs('organization.*') || request()->routeIs('subuser.*') ? 'is-open' : '' }}">
                <button class="nav-link nav-group__title {{ request()->routeIs('organization.*') || request()->routeIs('subuser.*') ? 'is-active' : '' }}" type="button" data-nav-group><span>▦</span> My Organization <b>⌄</b></button>
                <div class="nav-group__links">
                    <a href="{{ route('organization.users') }}" class="{{ request()->routeIs('organization.users') ? 'is-current' : '' }}">Manage Users</a>
                    <a href="{{ route('organization.wallets') }}" class="{{ request()->routeIs('organization.wallets') ? 'is-current' : '' }}">Wallets</a>
                    <a href="{{ route('organization.biller') }}" class="{{ request()->routeIs('organization.biller') ? 'is-current' : '' }}">Biller Accounts</a>
                    <a href="{{ route('organization.roles') }}" class="{{ request()->routeIs('organization.roles') || request()->routeIs('subuser.organization') ? 'is-current' : '' }}">Company Roles</a>
                </div>
            </div>
        @endif

        <div class="nav-group">
            <button class="nav-link nav-group__title" type="button" data-nav-group><span>⇄</span> Transactions <b>⌄</b></button>
            <div class="nav-group__links">
                <button type="button" data-dialog-open="biller-dialog">Bills</button>
                <button type="button" data-dialog-open="biller-dialog">Payments</button>
                <button type="button" data-dialog-open="biller-dialog">Transaction History</button>
                <button type="button" data-dialog-open="biller-dialog">Receipts</button>
            </div>
        </div>

        <button class="nav-link" type="button" data-dialog-open="profile-dialog"><span>◉</span> My Profile</button>
    </nav>
</aside>

@if(session('openBillerDialog'))
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.getElementById('biller-dialog')?.showModal();
        });
    </script>
@endif
