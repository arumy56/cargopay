document.addEventListener('DOMContentLoaded', () => {
    const sidebar = document.querySelector('#dashboard-sidebar');
    const notificationMenu = document.querySelector('[data-notification-menu]');

    document.querySelectorAll('[data-sidebar-toggle]').forEach((button) => {
        button.addEventListener('click', () => sidebar?.classList.toggle('is-collapsed'));
    });

    document.querySelectorAll('[data-dialog-open]').forEach((button) => {
        button.addEventListener('click', () => document.querySelector(`#${button.dataset.dialogOpen}`)?.showModal());
    });

    document.querySelectorAll('[data-dialog-close]').forEach((button) => {
        button.addEventListener('click', () => button.closest('dialog')?.close());
    });

    document.querySelectorAll('dialog').forEach((dialog) => {
        dialog.addEventListener('click', (event) => {
            if (event.target === dialog) dialog.close();
        });
    });

    document.querySelector('[data-notifications]')?.addEventListener('click', () => {
        notificationMenu.hidden = !notificationMenu.hidden;
    });

    document.querySelector('[data-fullscreen]')?.addEventListener('click', async () => {
        if (document.fullscreenElement) {
            await document.exitFullscreen();
        } else {
            await document.documentElement.requestFullscreen();
        }
    });
});
