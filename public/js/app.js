// import './bootstrap';

document.addEventListener('DOMContentLoaded', () => {
    const toggle = document.getElementById('menuToggle');
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('sidebarOverlay');
    const closeBtn = document.getElementById('closeSidebar');

    toggle.addEventListener('click', () => {
        sidebar.classList.add('sidebar-open');
        overlay.classList.add('active');
    });

    closeBtn.addEventListener('click', () => {
        sidebar.classList.remove('sidebar-open');
        overlay.classList.remove('active');
    });

    overlay.addEventListener('click', () => {
        sidebar.classList.remove('sidebar-open');
        overlay.classList.remove('active');
    });

    // 🔥 AUTO CLOSE SAAT MENU DIKLIK
    document.querySelectorAll('.sidebar-menu a').forEach(link => {
        link.addEventListener('click', () => {
            sidebar.classList.remove('sidebar-open');
            overlay.classList.remove('active');
        });
    });
});
