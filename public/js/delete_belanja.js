document.addEventListener('DOMContentLoaded', () => {
  const deleteButtons = document.querySelectorAll('.delete-belanja');

  deleteButtons.forEach(button => {
    button.addEventListener('click', async (e) => {
      e.preventDefault();

      const id = button.dataset.id;
      const url = button.dataset.url;
      const label = button.dataset.label || 'Item';
      const itemName = button.dataset.nama || '-';
      const popupSelector = button.dataset.popupTarget || '#overlay-delete';
      const overlay = document.querySelector(popupSelector);
      if (!overlay) return;

      const popupDeleteBtn = overlay.querySelector('.delete-belanja');
      const nameEl = overlay.querySelector('.item-name');
      const closeBtn = overlay.querySelector('.btn-cancel, .material-symbols');

      const closeOverlay = () => overlay.style.display = 'none';
      if (closeBtn) closeBtn.onclick = closeOverlay;

      if (!button.closest('.overlay-delete')) {
        if (popupDeleteBtn) {
          popupDeleteBtn.dataset.id = id;
          popupDeleteBtn.dataset.url = url;
          popupDeleteBtn.dataset.label = label;
        }
        if (nameEl) nameEl.textContent = itemName;
        overlay.style.display = 'flex';
        return;
      }

      try {
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        const response = await fetch(url, {
          method: 'DELETE',
          headers: {
            'Accept': 'application/json',
            'X-CSRF-TOKEN': csrfToken
          },
          credentials: 'same-origin'
        });

        let result = {};
        try { result = await response.json(); } catch {}

        sessionStorage.setItem('notif', JSON.stringify({
          message: response.ok ? (result.message || `${label} berhasil dihapus`) : (result.message || `Gagal menghapus ${label}`),
          isSuccess: response.ok
        }));

        closeOverlay();
        window.location.reload();

      } catch (error) {
        sessionStorage.setItem('notif', JSON.stringify({
          message: error.message || 'Terjadi kesalahan saat menghapus.',
          isSuccess: false
        }));
        closeOverlay();
        window.location.reload();
      }
    });
  });
});
