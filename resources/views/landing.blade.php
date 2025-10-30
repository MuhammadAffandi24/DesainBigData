<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>STOKIFY - Manajemen Stok Gudang</title>

  {{-- Font dan CSS --}}
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>

  <!-- NAVBAR -->
  <header class="navbar">
    <div class="container">
      <div class="logo">
        <img src="{{ asset('assets/navbar&footer.svg') }}" alt="Logo STOKIFY" class="logo-icon">
        <h1>STOKIFY</h1>
      </div>
      <nav>
        <a href="#home">Home</a>
        <a href="#fitur">Fitur</a>
        <a href="#cara">Cara Kerja</a>
      </nav>
      <div class="actions">
        <button class="btn light">Masuk</button>
        <button class="btn dark">Daftar</button>
      </div>
    </div>
  </header>

  <!-- HERO -->
  <section id="home" class="hero">
    <img src="{{ asset('assets/Hero.svg') }}" alt="Hero Illustration" class="hero-image">
    <div class="hero-text">
      <h2>Kelola Barang & Tagihan Lebih Mudah dalam Satu Aplikasi</h2>
      <p>Ngatur stok jadi gampang banget! Cek, catet, dan atur barang langsung tanpa ribet.
        Semua kebutuhan gudang sampai tagihan bisa kamu kontrol di satu tempat.
        Simple, cepat, no drama pake <strong>STOKIFY</strong>.
      </p>
      <div class="cta">
        <button class="btn dark">Coba Gratis</button>
        <button class="btn light">Daftar Sekarang</button>
      </div>
    </div>
  </section>

  <!-- FITUR -->
  <section id="fitur" class="fitur">
    <h2>Apa yang bisa kamu lakukan?</h2>
    <div class="fitur-grid">
      <div class="fitur-card">Manajemen Barang</div>
      <div class="fitur-card">Otomatisasi</div>
      <div class="fitur-card">Infografis Keuangan</div>
      <div class="fitur-card">Riwayat Belanja</div>
    </div>
  </section>

  <!-- STATISTIK -->
<section id="cara" class="statistik">
  <h2>Gimana sih Aplikasinya??!!</h2>

  <div class="statistik-grid">
    <!-- KIRI -->
    <div class="statistik-left">
      <div class="statistik-box chart-box">
        <h3>Pengeluaran berdasarkan Kategori</h3>
        <div class="chart-container">
          <canvas id="kategoriChart"></canvas>
        </div>
      </div>

      <div class="statistik-box">
        <h3>Informasi Tagihan</h3>
        <table>
          <tr><th>Nama Tagihan</th><th>Harga Tagihan</th><th>Status</th></tr>
          <tr><td>Listrik</td><td>250.000</td><td>Aktif</td></tr>
          <tr><td>Air</td><td>100.000</td><td>Aktif</td></tr>
          <tr><td>Internet</td><td>300.000</td><td>Belum Bayar</td></tr>
        </table>
      </div>
    </div>

    <!-- KANAN -->
    <div class="statistik-right">
      <div class="statistik-box">
        <h3>Informasi Barang</h3>
        <table>
          <tr><th>Nama Barang</th><th>Jumlah</th><th>Harga</th><th>Total</th></tr>
          <tr><td>Beras</td><td>20</td><td>12.000</td><td>240.000</td></tr>
          <tr><td>Gula</td><td>15</td><td>13.000</td><td>195.000</td></tr>
          <tr><td>Minyak</td><td>10</td><td>20.000</td><td>200.000</td></tr>
        </table>
      </div>

      <div class="statistik-box wide">
        <h3>Cashflow</h3>
        <div class="cashflow-wrapper">
          <canvas id="cashflowChart"></canvas>
        </div>
      </div>
    </div>
  </div>

  <p class="cta-mini">Mau coba langsung? <strong>Daftar Sekarang</strong></p>
</section>

  <!-- MANFAAT -->
  <section class="manfaat">
    <h2>Apa Aja Manfaatnya??!!</h2>
    <div class="manfaat-grid">
      <div class="manfaat-item">
        <img src="{{ asset('assets/Jam.svg') }}" alt="Jam">
        <p>Hemat Waktu — karena stok & tagihan otomatis tercatat.</p>
      </div>
      <div class="manfaat-item">
        <img src="{{ asset('assets/lonceng.svg') }}" alt="Lonceng">
        <p>Tidak Lupa Bayar — pengingat rutin mingguan/bulanan.</p>
      </div>
      <div class="manfaat-item">
        <img src="{{ asset('assets/keranjang.svg') }}" alt="Keranjang">
        <p>Belanja Lebih Hemat — bandingkan harga dari berbagai tempat.</p>
      </div>
      <div class="manfaat-item">
        <img src="{{ asset('assets/coin.svg') }}" alt="Koin">
        <p>Pengeluaran Lebih Terkontrol — laporan & grafik jelas.</p>
      </div>
    </div>
  </section>

<!-- TESTIMONI -->
<section class="testimoni">
  <h2>Apa Kata Pengguna??</h2>
  <div class="testimoni-grid">
    <div class="testi-card">
      <img src="{{ asset('assets/pp.svg') }}" alt="Raden Budi Racing" class="testi-pp">
      <p class="name">Raden Budi Racing</p>
      <p class="stars">★★★★★</p>
      <p>Paiyohh GACORRR LEKK!!!!!!!!!!!</p>
    </div>

    <div class="testi-card">
      <img src="{{ asset('assets/pp.svg') }}" alt="Bakul Pithik" class="testi-pp">
      <p class="name">Bakul Pithik</p>
      <p class="stars">★★★★★</p>
      <p>Mantappp</p>
    </div>

    <div class="testi-card">
      <img src="{{ asset('assets/pp.svg') }}" alt="Mie Ayam 3 Rasa" class="testi-pp">
      <p class="name">Mie Ayam 3 Rasa</p>
      <p class="stars">★★★★★</p>
      <p>Monggo yang mau Mie Ayam Wonogiri</p>
    </div>

    <div class="testi-card">
      <img src="{{ asset('assets/pp.svg') }}" alt="Soto Lamongan Asoy" class="testi-pp">
      <p class="name">Soto Lamongan Asoy</p>
      <p class="stars">★★★★★</p>
      <p>Sotoku Laris</p>
    </div>
  </div>
</section>


  <!-- CTA FINAL -->
  <section class="cta-final">
    <div class="cta-left">
      <h2>Siap Mulai Mengelola Barang & Tagihan dengan Mudah?</h2>
      <p>Gratis daftar, hemat waktu, dan lebih teratur mulai hari ini.</p>
    </div>
    <div class="cta-right">
      <button class="btn light big">DAFTAR SEKARANG</button>
      <button class="btn dark big">COBA GRATIS</button>
    </div>
  </section>

  <!-- FOOTER -->
  <footer>
    <div class="footer-top">
      <div class="footer-brand">
        <img src="{{ asset('assets/navbar&footer.svg') }}" alt="Logo STOKIFY" class="footer-logo">
        <p>Need support with Stokify?<br>We’d love to hear from you.<br>Contact us anytime!</p>
      </div>
      <div class="footer-feedback">
        <h3>Feedback</h3>
        <textarea placeholder="Tulis pengalaman Anda di Stokify.."></textarea>
        <button class="btn light">Submit</button>
      </div>
      <div class="footer-info">
        <h3>Tim Pengembang Stokify</h3>
        <p>Email: stokify.team@email.com</p>
        <p>Telepon: 0812xxxxxxx</p>
        <p>Alamat: Jebres, Surakarta</p>
      </div>
    </div>
    <div class="footer-bottom">
      Copyright © 2025 — Tim Pengembang Stokify
    </div>
  </footer>

  {{-- CHART.JS --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="{{ asset('js/chartlanding.js') }}"></script>


</body>
</html>
