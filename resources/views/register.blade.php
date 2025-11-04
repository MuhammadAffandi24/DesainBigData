<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>STOKIFY - Registrasi</title>

  {{-- FONT & CSS --}}
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>

<body class="loginadmin-page">
  <div class="register-container">
    <div class="register-left">
      <img src="{{ asset('assets/navbar&footer.svg') }}" alt="Logo STOKIFY">
    </div>

    <div class="register-right">
      <div class="register-box">
        <h1>Registrasi</h1>

        <form action="{{ route('register.post') }}" method="POST">
          @csrf
          <input type="text" name="username" placeholder="Username" required>
          <input type="password" name="password" placeholder="Password" required>
          <button type="submit">Daftar</button>
        </form>

        <p>Sudah Punya Akun? <a href="{{ route('login.form') }}">Login</a></p>
      </div>
    </div>
  </div>

</body>
</html>