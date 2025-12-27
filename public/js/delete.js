document.addEventListener('DOMContentLoaded', function () {
  const deleteButtons = document.querySelectorAll('.universal-delete');

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

      const popupDeleteBtn = overlay.querySelector('.universal-delete');
      const nameEl = overlay.querySelector('.item-name');
      const closeBtn = overlay.querySelector('.btn-cancel, .material-symbols');

      const closeOverlay = () => { overlay.style.display = 'none'; };
      if (closeBtn) closeBtn.onclick = closeOverlay;

      // Jika tombol berasal dari list (bukan popup), tampilkan popup konfirmasi
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

      // Tombol Delete popup ditekan
      try {
        let headers = { 'Accept': 'application/json' };
        let credentials = 'same-origin';

        // Deteksi apakah URL route web (non-API)
        if (!url.startsWith('/api/')) {
          const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
          headers['X-CSRF-TOKEN'] = csrfToken;
          headers['Content-Type'] = 'application/json';
        } else {
          // API route → pakai Bearer token
          const token = localStorage.getItem('token');
          if (!token) {
            sessionStorage.setItem(
              'notif',
              JSON.stringify({ message: 'Token tidak ditemukan, silakan login ulang.', isSuccess: false })
            );
            closeOverlay();
            window.location.reload();
            return;
          }
          headers['Authorization'] = `Bearer ${token}`;
        }

        const response = await fetch(url, {
          method: 'DELETE',
          headers: headers,
          credentials: credentials
        });

        let result = {};
        try { result = await response.json(); } catch {}

        sessionStorage.setItem(
          'notif',
          JSON.stringify({
            message: response.ok
              ? (result.message || `${label} berhasil dihapus`)
              : (result.message || `Gagal menghapus ${label}`),
            isSuccess: response.ok
          })
        );

        closeOverlay();
        window.location.reload();
      } catch (error) {
        sessionStorage.setItem(
          'notif',
          JSON.stringify({ message: 'Terjadi kesalahan saat menghapus.', isSuccess: false })
        );
        closeOverlay();
        window.location.reload();
      }
    });
  });
});
