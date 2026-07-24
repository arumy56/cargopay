<header class="dashboard-topbar navbar navbar-expand bg-white">
    <button class="icon-button mobile-menu" type="button" data-sidebar-toggle aria-label="Open menu">&#9776;</button>
    <div class="topbar-actions">
        <button class="icon-button help-button" type="button" data-dialog-open="help-dialog" aria-label="Help">?</button>
        <button class="icon-button" type="button" data-fullscreen aria-label="Toggle fullscreen">⛶</button>
        <button class="icon-button notification-button" type="button" data-notifications aria-label="Notifications">♧<span></span></button>
        @include('partials.logout')
    </div>
    <div class="notifications-menu" hidden data-notification-menu>
        <strong>Notifications</strong>
        <p>You are all caught up.</p>
    </div>
</header>
