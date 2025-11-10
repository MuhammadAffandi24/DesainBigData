{{-- delete_sukses.blade.php --}}
@if (session('success'))
  <div id="notif-sukses" class="notif-sukses">
    <span class="notif-title">Hapus Barang</span>
    <p class="notif-message">{{ session('success') }} 😊</p>
    <img id="notif-close" class="notif-close" src="{{ asset('assets/material-symbols_close.svg') }}" alt="Close">
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const notif = document.getElementById('notif-sukses');
      const closeBtn = document.getElementById('notif-close');

      if (notif) {
        notif.style.display = 'block';

        // Tutup otomatis
        setTimeout(() => {
          notif.style.animation = 'fadeOut 0.5s ease-in-out forwards';
          setTimeout(() => notif.remove(), 500);
        }, 8000);

        // Tutup manual
        if (closeBtn) {
          closeBtn.addEventListener('click', () => {
            notif.style.display = 'none';
          });
        }
      }
    });
  </script>
@endif
