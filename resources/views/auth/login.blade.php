<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>STOKIFY - Login</title>

  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body class="login-page">

<div class="login-container">
  <!-- BAGIAN KIRI -->
  <div class="left">
    <img src="{{ asset('assets/Hero.svg') }}" class="login-image">
    <a href="{{ route('admin.login') }}" class="admin-btn">Login as ADMIN</a>
  </div>

  <!-- BAGIAN KANAN (FORM) -->
  <div class="right">
    <h1 style="margin-bottom:20px; color:#bfa58b; text-align:center">Login</h1>

    <form class="login-form" action="{{ route('login') }}" method="POST">
      @csrf

      @if(session('error'))
        <p style="background:#ffdddd; padding:10px; border-radius:8px; margin-bottom:1rem; text-align:center; color:#b30000;">
            {{ session('error') }}
        </p>
      @endif

      <input type="text" name="username" placeholder="Username" required>
      <input type="password" name="password" placeholder="Password" required>
      <button type="submit" class="btn light" style="width:100%; margin-top:1rem;">Masuk</button>
    </form>

    <p style="color:#bfa58b;">Belum punya akun?
      <a href="{{ route('register') }}" style="color:#bfa58b;">Daftar</a>
    </p>
  </div>
</div>

</body>
</html>
