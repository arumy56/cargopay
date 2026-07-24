<form method="POST" action="{{ route('logout') }}">
    @csrf
    <button class="logout-button btn" type="submit">Log out <span aria-hidden="true">&rarr;</span></button>
</form>
