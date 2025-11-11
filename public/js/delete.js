document.addEventListener('DOMContentLoaded', function () {
  const deleteButtons = document.querySelectorAll('.universal-delete');
  const overlay = document.querySelector('.overlay-delete');
  const closeBtn = document.getElementById('close-delete');
  const cancelBtn = document.getElementById('cancel-delete');

  if (closeBtn) closeBtn.onclick = () => overlay.style.display = 'none';
  if (cancelBtn) cancelBtn.onclick = () => overlay.style.display = 'none';

  deleteButtons.forEach(button => {
    button.addEventListener('click', async () => {
      const id = button.dataset.id;
      const url = button.dataset.url;
      const label = button.dataset.label;

      try {
        const response = await fetch(url, {
          method: 'DELETE',
          headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json'
          }
        });

        const result = await response.json();

        if (response.ok) {
          showNotif(label, result.message, true); 
        } else {
          showNotif(label, result.message, false); 
        }

        overlay.style.display = 'none';
      } catch (error) {
        showNotif(label, 'Terjadi kesalahan saat menghapus.', false);
        overlay.style.display = 'none';
      }
    });
  });

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
