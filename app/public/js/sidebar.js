document.addEventListener('DOMContentLoaded', () => {
    const arrow = document.getElementById('sidebar-arrow');
    const sidebar = document.getElementById('sidebar');

    arrow.addEventListener('click', () => {
        arrow.classList.toggle('rotate');
        sidebar.classList.toggle('shrink');
        document.querySelectorAll('#sidebar .nav-link-a').forEach((p) => p.classList.toggle('remove'));
    });
});
