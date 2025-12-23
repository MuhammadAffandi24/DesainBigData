<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login - STOKIFY</title>

  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body class="loginadmin-page">

<div class="loginadmin-container">
    <h1 style="text-align:center">Login Admin</h1>

      <form class="login-form" action="{{ route('admin.login.submit') }}" method="POST">
          @csrf

          @if(session('error'))
              <p style="background:#ffdddd; padding:10px; border-radius:8px; margin-bottom:1rem; text-align:center; color:#b30000;">
                  {{ session('error') }}
              </p>
          @endif

          <input type="username" name="username" placeholder="Username" required>
          <input type="password" name="password" placeholder="Password" required>
          <button type="submit" class="btn dark" style="width:100%; margin-top:1rem;">Masuk</button>

      </form>
  </div>
</div>

</body>
</html>