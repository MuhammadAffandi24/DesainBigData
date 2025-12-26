<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>STOKIFY - Registrasi User</title>

  {{-- FONT & CSS --}}
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>

<!-- ================= MODAL REGISTER ================= -->
<div class="modal-overlay" id="registerModal">
  <div class="modal-card">
    <h2 id="modalTitle">Registrasi Berhasil!</h2>
    <p id="modalMessage">
      Akun berhasil dibuat. Silakan login untuk melanjutkan.
    </p>
    <button id="modalBtn">Ke Halaman Login</button>
  </div>
</div>

<body class="loginadmin-page">
  <div class="register-container">
    {{-- Bagian kiri --}}
    <div class="register-left">
      <img src="{{ asset('assets/navbar&footer.svg') }}" alt="Logo STOKIFY">
    </div>

    {{-- Bagian kanan --}}
    <div class="register-right">
      <div class="register-box">
        <h1>Registrasi</h1>

        {{-- Form registrasi user --}}
        <form id="formRegisterUser">
          @csrf
          <input type="text" id="username" name="username" placeholder="Username" required>
          <input type="password" id="password" name="password" placeholder="Password" required>
          <button type="submit">Daftar</button>
        </form>

        <p>Sudah punya akun? <a href="{{ route('login.form') }}">Login</a></p>
      </div>
    </div>
  </div>

  {{-- Script untuk kirim data ke API --}}
  <script>
    document.getElementById('formRegisterUser').addEventListener('submit', async function(e) {
        e.preventDefault();

        const username = document.getElementById('username').value;
        const password = document.getElementById('password').value;

        const modal = document.getElementById('registerModal');
        const title = document.getElementById('modalTitle');
        const message = document.getElementById('modalMessage');
        const btn = document.getElementById('modalBtn');

        try {
            const response = await fetch('/api/users/register', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ username, password })
            });

            const result = await response.json();

            if (response.ok) {
                title.innerText = 'Registrasi Berhasil!';
                message.innerText = 'Akun berhasil dibuat. Silakan login untuk melanjutkan.';
                btn.innerText = 'Login Sekarang';
                btn.onclick = () => window.location.href = '/login';
            } else {
                title.innerText = 'Registrasi Gagal!';
                message.innerText = result.message || 'Terjadi kesalahan saat registrasi.';
                btn.innerText = 'Tutup';
                btn.onclick = () => modal.classList.remove('show');
            }

            modal.classList.add('show');

        } catch (error) {
            title.innerText = 'Error ⚠️';
            message.innerText = 'Gagal terhubung ke server.';
            btn.innerText = 'Tutup';
            btn.onclick = () => modal.classList.remove('show');
            modal.classList.add('show');
        }
    });
  </script>
</body>
</html>
