<x-app :isDashboard="true" title="My Dashboard - Kargo Pay" :styles="['resources/css/subuser.dashboard.css']">
    <div class="subuser-dashboard">
        <aside class="subuser-dashboard__sidebar">
            <a class="subuser-dashboard__brand" href="{{ route('subuser.dashboard') }}">Kargo<span>Pay</span></a>

            <nav class="subuser-dashboard__navigation" aria-label="Main navigation">
                @if ($user->isSuperuser())
                    <a href="{{ route('dashboard.index') }}">Dashboard</a>
                @endif
                <a class="is-active" href="{{ route('subuser.dashboard') }}">My Dashboard</a>
            </nav>

            @if ($user->isSubuser() && $organization)
                <section class="subuser-dashboard__organization" aria-label="Organization details">
                    <p>Organization</p>
                    <div class="subuser-dashboard__organization-details">
                        <span aria-hidden="true">{{ strtoupper(substr($organization->firstname, 0, 1)) }}</span>
                        <div>
                            <strong>{{ $organization->fullName() }}</strong>
                            <small>{{ $organization->email }}</small>
                        </div>
                    </div>
                </section>
            @endif

            <form class="subuser-dashboard__logout" action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit">Log out</button>
            </form>
        </aside>

        <main class="subuser-dashboard__content">
            <header class="subuser-dashboard__header">
                <div>
                    <p class="subuser-dashboard__eyebrow">Your workspace</p>
                    <h1>Welcome, {{ $user->fullName() }}</h1>
                    @if ($user->isSuperuser())
                        <p>You are logged in as the system administrator.</p>
                    @elseif ($user->isSubuser() && $organization)
                        <p>You are part of <strong>{{ $organization->fullName() }}</strong>'s organization.</p>
                    @else
                        <p>Welcome to your workspace.</p>
                    @endif
                </div>
                <span class="subuser-dashboard__status">Active member</span>
            </header>

            <section class="subuser-dashboard__cards" aria-label="Account summary">
                <article>
                    <p>My role</p>
                    <strong>{{ ucfirst($user->role) }}</strong>
                    <small>{{ $user->isSuperuser() ? 'System Administrator' : 'Organization Member' }}</small>
                </article>

                @if ($organization)
                    <article>
                        <p>Organization admin</p>
                        <strong>{{ $organization->fullName() }}</strong>
                        <small>{{ $organization->email }}</small>
                    </article>
                @endif

                <article>
                    <p>Account status</p>
                    <strong>Verified</strong>
                    <small>{{ $user->is_active ? 'Activated' : 'Pending activation' }}</small>
                </article>
            </section>

            <section class="subuser-dashboard__details" aria-labelledby="account-details-title">
                <div>
                    <p class="subuser-dashboard__eyebrow">Profile</p>
                    <h2 id="account-details-title">Account details</h2>
                </div>
                <dl>
                    @if ($user->isSuperuser())
                        <div><dt>Account type</dt><dd>Superuser (Root Admin)</dd></div>
                    @else
                        <div><dt>Organization name</dt><dd>{{ $organization->fullName() }}</dd></div>
                        <div><dt>Admin email</dt><dd>{{ $organization->email }}</dd></div>
                    @endif
                    <div><dt>Member since</dt><dd>{{ $user->created_at->format('F d, Y') }}</dd></div>
                    <div><dt>Your email</dt><dd>{{ $user->email }}</dd></div>
                </dl>
            </section>
        </main>
    </div>
</x-app>
