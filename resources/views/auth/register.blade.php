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
          alert('Registrasi berhasil!');
          window.location.href = '/login'; // redirect ke halaman login
        } else {
          alert(result.message || 'Terjadi kesalahan saat registrasi.');
        }
      } catch (error) {
        console.error('Error:', error);
        alert('Gagal terhubung ke server.');
      }
    });
  </script>
</body>
</html>
