function showNotif(action, message, isSuccess) {
  const notif = document.createElement('div');
  notif.className = isSuccess ? 'notif-sukses' : 'notif-error';
  notif.innerHTML = `
    <span class="notif-title">${isSuccess ? 'Success' : 'Error'}</span>
    <p class="notif-message">${message}</p>
    <img class="notif-close" src="/assets/material-symbols_close.svg" alt="Close">
  `;

  const container = document.getElementById('notif-container') || document.body;
  container.appendChild(notif);

  // tombol close 
  const closeBtn = notif.querySelector('.notif-close');
  if (closeBtn) {
    closeBtn.onclick = () => notif.remove();
  }

  // auto remove setelah 10 detik
  setTimeout(() => {
    if (notif.parentNode) {
      notif.remove();
    }
  }, 10000);
}
