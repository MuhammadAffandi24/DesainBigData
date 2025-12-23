document.addEventListener('DOMContentLoaded', function () {
  const deleteButtons = document.querySelectorAll('.universal-delete');

  deleteButtons.forEach(button => {
    button.addEventListener('click', async () => {
      const id    = button.dataset.id;
      const url   = button.dataset.url;
      const label = button.dataset.label;

      // ambil overlay sesuai konteks (misalnya overlay-delete-tagihan)
      const overlayId = button.closest('.overlay-delete')?.id || 'overlay-delete';
      const overlay   = document.getElementById(overlayId);

      // ambil token dari localStorage
      const token = localStorage.getItem('token');
      if (!token) {
        showNotif(label, 'Token tidak ditemukan, silakan login ulang.', false);
        if (overlay) overlay.style.display = 'none';
        return;
      }

      try {
        const response = await fetch(url, {
          method: 'DELETE',
          headers: {
            'Authorization': `Bearer ${token}`,
            'Accept': 'application/json'
          }
        });

        const result = await response.json();

        if (response.ok) {
          showNotif(label, result.message || `${label} berhasil dihapus`, true);
          // contoh: reload halaman biar data update
          setTimeout(() => window.location.reload(), 1000);
        } else {
          showNotif(label, result.message || `Gagal menghapus ${label}`, false);
        }

        if (overlay) overlay.style.display = 'none';
      } catch (error) {
        console.error(error);
        showNotif(label, 'Terjadi kesalahan saat menghapus.', false);
        if (overlay) overlay.style.display = 'none';
      }
    });
  });

  // tombol close/cancel overlay (global)
  const closeBtn  = document.getElementById('close-delete');
  const cancelBtn = document.getElementById('cancel-delete');
  const overlay   = document.querySelector('.overlay-delete');

  if (closeBtn && overlay) closeBtn.onclick  = () => overlay.style.display = 'none';
  if (cancelBtn && overlay) cancelBtn.onclick = () => overlay.style.display = 'none';

  // fungsi notif sederhana
  function showNotif(action, message, isSuccess) {
    const notif = document.createElement('div');
    notif.className = isSuccess ? 'notif-sukses' : 'notif-error';
    notif.innerHTML = `
      <span class="notif-title">${isSuccess ? 'Berhasil' : 'Gagal'}</span>
      <p class="notif-message">${message}</p>
      <img class="notif-close" src="/assets/material-symbols_close.svg" alt="Close">
    `;

    const container = document.getElementById('notif-container') || document.body;
    container.appendChild(notif);

    setTimeout(() => notif.remove(), 6000);
    notif.querySelector('.notif-close').onclick = () => notif.remove();
  }
});
