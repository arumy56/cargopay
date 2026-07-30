



<x-app :isDashboard="true" title="Manage Users - Kargo Pay" :styles="['resources/css/subuser.index.css']">
<div id="confirmModal" class="confirm-modal">

    <div class="confirm-box">

        <h2 class="confirm-title"></h2>

        <p class="confirm-message"></p>

        <div class="confirm-actions">

            <button type="button" class="confirm-cancel">
                Cancel
            </button>

            <button type="button" class="confirm-confirm">
                Confirm
            </button>

        </div>

    </div>

</div>

<script>

    document.addEventListener('DOMContentLoaded', () => {

        const modal = document.getElementById('confirmModal');

        const title = modal.querySelector('.confirm-title');

        const message = modal.querySelector('.confirm-message');

        const confirmBtn = modal.querySelector('.confirm-confirm');

        const cancelBtn = modal.querySelector('.confirm-cancel');

        let activeForm = null;

        document.querySelectorAll('.confirm-form').forEach(form => {

            form.addEventListener('submit', function (e) {

                e.preventDefault();

                activeForm = this;

                title.textContent = this.dataset.title;

                message.textContent = this.dataset.message;

                confirmBtn.textContent = this.dataset.button;

                confirmBtn.style.background = this.dataset.color;

                modal.classList.add('show');

            });

        });

        cancelBtn.onclick = () => {

            modal.classList.remove('show');

            activeForm = null;

        };

        confirmBtn.onclick = () => {

            if (activeForm) {

                activeForm.submit();

            }

        };

        modal.addEventListener('click', function (e) {

            if (e.target === modal) {

                modal.classList.remove('show');

            }

        });

    });

</script>    
<div class="subuser-management">
        <aside class="subuser-management__sidebar">
            <a class="subuser-management__brand" href="{{ route('dashboard.index') }}">Kargo<span>Pay</span></a>
            <nav class="subuser-management__navigation" aria-label="Main navigation">
                <a href="{{ route('dashboard.index') }}">Dashboard</a>
                <a class="is-active" href="{{ route('subuser.index') }}">Manage users</a>
            </nav>
            <form class="subuser-management__logout" action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit">Log out</button>
            </form>
        </aside>

        <main class="subuser-management__content">
            <header class="subuser-management__header">
                <div>
                    <p class="subuser-management__eyebrow">Organization settings</p>
                    <h1>Manage organization users</h1>
                    <p>Create and manage the members who can access your organization.</p>
                </div>
            </header>

            @if (session('success'))
                <div class="subuser-management__alert subuser-management__alert--success" role="status">
                    <strong>Success.</strong> {{ session('success') }}</div>
            @endif

            @if ($errors->any())
                <div class="subuser-management__alert subuser-management__alert--error" role="alert">
                    <strong>Please fix the errors below.</strong>
                    <ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
                </div>
            @endif

            <section class="subuser-management__panel" aria-labelledby="create-user-title">
                <div class="subuser-management__panel-heading">
                    <div>
                        <p class="subuser-management__eyebrow">New member</p>
                        <h2 id="create-user-title">Create a user</h2>
                    </div>
                </div>
                <form class="subuser-management__form" action="{{ route('subuser.store') }}" method="POST">
                    @csrf
                    <label>First name<input type="text" name="firstname" value="{{ old('firstname') }}" required
                            autocomplete="given-name"></label>
                    <label>Last name<input type="text" name="secondname" value="{{ old('secondname') }}" required
                            autocomplete="family-name"></label>
                    <label>Email address<input type="email" name="email" value="{{ old('email') }}" required
                            autocomplete="email"></label>
                    <label>Password<input type="password" name="password" required autocomplete="new-password"></label>
                    <button type="submit">Create user</button>
                </form>
            </section>

            <section class="subuser-management__panel" aria-labelledby="users-title">
                <div class="subuser-management__panel-heading">
                    <div>
                        <p class="subuser-management__eyebrow">Directory</p>
                        <h2 id="users-title">All users</h2>
                    </div>
                    <span>{{ $subuser->count() }} {{ $subuser->count() === 1 ? 'member' : 'members' }}</span>
                </div>
                <div class="subuser-management__table-wrap">
                    <table>
                        <thead>
                            <tr>
                                <th>First name</th>
                                <th>Last name</th>
                                <th>Email</th>
                                <th>Status</th>
                                <th><span class="visually-hidden">Actions</span></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($subuser as $user)
                                <tr>
                                    <td>{{ $user->firstname }}</td>
                                    <td>{{ $user->secondname }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td><span
                                            class="subuser-management__badge {{ $user->is_active ? 'is-active' : 'is-inactive' }}">{{ $user->is_active ? 'Active' : 'Inactive' }}</span>
                                    </td>
                                    <td class="subuser-management__action">
                                        @if (!$user->is_active)
                                            <form action="{{ route('subuser.activate', $user) }}" method="POST"
                                                class="confirm-form" data-title="Activate User"
                                                data-message="Are you sure you want to activate {{ $user->firstname }} {{ $user->secondname }}?"
                                                data-button="Activate" data-color="#1674cb">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit">Activate</button>
                                            </form>
                                        @else
                                            <form action="{{ route('subuser.destroy', $user) }}" method="POST"
                                                class="confirm-form" data-title="Deactivate User"
                                                data-message="Are you sure you want to deactivate {{ $user->firstname }} {{ $user->secondname }}?"
                                                data-button="Deactivate" data-color="#dc3545">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit">Deactivate</button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="subuser-management__empty">No users found. Create your first
                                        organization user above.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </section>
        </main>
    </div>
</x-app>