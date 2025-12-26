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

    /* ================= DELETE USER MODAL ================= */
    const deleteModal = document.getElementById('deleteModal');
    const deleteForm = document.getElementById('deleteForm');
    const deleteUsername = document.getElementById('deleteUsername');
    const cancelDelete = document.getElementById('cancelDelete');

    document.querySelectorAll('.open-delete-modal').forEach(btn => {
        btn.addEventListener('click', () => {
            const userId = btn.dataset.id;
            const username = btn.dataset.username;

            deleteUsername.innerText = username;
            deleteForm.action = `/superadmin/user/${userId}`;
            deleteModal.classList.add('show');
        });
    });

    cancelDelete.addEventListener('click', () => {
        deleteModal.classList.remove('show');
    });
});
