<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>STOKIFY - Registrasi Gudang</title>

  {{-- FONT & CSS --}}
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>

<body class="loginadmin-page">
  <div class="register-container">
    {{-- Bagian kiri (gambar/logo) --}}
    <div class="register-left">
      <img src="{{ asset('assets/navbar&footer.svg') }}" alt="Logo STOKIFY">
    </div>

    {{-- Bagian kanan (form registrasi gudang) --}}
    <div class="register-right">
      <div class="register-box">
        <h1>Registrasi Gudang</h1>

        {{-- Form registrasi gudang --}}
        <form id="formRegisterGudang">
          @csrf
          <input type="text" id="nama_gudang" name="nama_gudang" placeholder="Nama Gudang" required>
          <input type="text" id="lokasi" name="lokasi" placeholder="Lokasi" required>
          <button type="submit">Daftar</button>
        </form>

        <p>Sudah punya gudang? <a href="{{ url('/home') }}">Kembali ke Home</a></p>
      </div>
    </div>
  </div>

  {{-- Script untuk submit ke API --}}
  <script>
    document.getElementById('formRegisterGudang').addEventListener('submit', async function (e) {
      e.preventDefault();

      const nama_gudang = document.getElementById('nama_gudang').value;
      const lokasi = document.getElementById('lokasi').value;

      try {
        const response = await fetch('{{ route('gudang.register.post') }}', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
          },
          body: JSON.stringify({ nama_gudang, lokasi })
        });

        const result = await response.json();

        if (response.ok) {
          alert('Gudang berhasil didaftarkan!');
          window.location.href = '/home';
        } else {
          alert(result.message || 'Terjadi kesalahan saat mendaftarkan gudang.');
        }
      } catch (error) {
        console.error(error);
        alert('Gagal terhubung ke server.');
      }
    });
  </script>
</body>
</html>
