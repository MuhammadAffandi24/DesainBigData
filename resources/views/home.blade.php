<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>STOKIFY - Home</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/home.css') }}">
  <link rel="stylesheet" href="{{ asset('css/notif.css') }}">
  <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</head>

<body class="home-page">
  <script>
  function toggleSidebar() {
    const sidebar = document.getElementById('sidebar');
    sidebar.classList.toggle('active');
  }

  // Scroll ke section target saat submit filter
  function scrollToSection(form) {
    const action = form.getAttribute('action');
    const hashIndex = action.indexOf('#');
    if (hashIndex !== -1) {
      const targetId = action.substring(hashIndex + 1);
      const el = document.getElementById(targetId);
      if (el) {
        setTimeout(() => {
          el.scrollIntoView({ behavior: 'smooth' });
        }, 100);
      }
    }
  }
  </script>

  {{-- HEADER --}}
  <header class="navbar">
    <div class="logo">
      <a class="logo-link">
        <img src="{{ asset('assets/menu.svg') }}" alt="Menu" class="logo-icon" onclick="toggleSidebar()" style="cursor: pointer;">
        <img src="{{ asset('assets/navbar&footer.svg') }}" alt="Logo STOKIFY" class="logo-icon">
        <h3>STOKIFY</h3>
      </a>
    </div>
    <nav>
      <ul>
        <li><a href="#">Home</a></li>
        <li><a href="#manajemen-barang">Manajemen</a></li>
        <li><a href="#daftar-belanja">Belanja</a></li>
        <li><a href="#footer">Contact</a></li>
        <li><a href="#footer">Tentang</a></li>
      </ul>
    </nav>
    <div class="logo">
      <a class="logo-link">
        <img src="{{ asset('assets/pp.svg') }}" alt="PP" class="logo-icon">
      </a>
    </div>
  </header>

  <!-- SIDEBAR -->
  <aside class="sidebar" id="sidebar">
    <div class="close-btn" onclick="toggleSidebar()">
      <i class="fas fa-times"></i>
    </div>

    <div class="logo">
      <a class="logo-link" href="#">
        <img src="{{ asset('assets/close.svg') }}" alt="Close" class="logo-icon" onclick="toggleSidebar()">
      </a>
    </div>

    <!-- Menu Sidebar -->
    <ul class="sidebar-menu">
      <li><a href="#" class="active">Home</a></li>
      <li class="dropdown">
        <a href="#manajemen-barang">Manajemen</a>
        <ul class="submenu">
          <li><a href="#">Manajemen Barang</a></li>
          <li><a href="#">Riwayat Belanja</a></li>
          <li><a href="#">Manajemen Tagihan</a></li>
          <ul class="submenu">
            <li><a href="#">Riwayat Pembayaran</a></li>
            <li><a href="#">Riwayat Tagihan</a></li>
          </ul>
        </ul>
      </li>
      <li><a href="#daftar-belanja">Belanja</a></li>
      <li><a href="#">Pengaturan</a></li>
      <li><a href="#">Akun</a></li>
      <li>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="logout-btn">Logout</button>
        </form>
      </li>
    </ul>
  </aside>

<!-- NOTIF -->
<div id="notif-container"></div>

{{-- MAIN CONTENT --}}
<main class="content">
  @include('partials.stock-low-popup')
  @include('partials.add-product-popup')
  @include('popup.automisasibelanja')
  @include('popup.delete_barang')
  @include('popup.delete_daftarbelanja')
  @include('popup.update_barang')
  @include('popup.update_belanja')

  {{-- Section 1: Menu Utama --}}
  <section class="banner">
    <a href="{{ route('dashboard') }}" class="menu-card" style="text-decoration: none; color: #E1D4C2;">
      <img src="{{ asset('assets/Dashboard.svg') }}" alt="Dashboard">
      <h2>Dashboard</h2>
    </a>
  </section>

  <section class="menu-section">
    <a href="{{ route('toko.index') }}" class="menu-card" style="text-decoration: none; color: #E1D4C2;">
      <i class="fas fa-store fa-2x"></i>
      <img src="{{ asset('assets/Toko.svg') }}" alt="Toko">
      <h3>Cek Toko</h3>
    </a>
    <a href="#manajemen-barang" class="menu-card">
      <i class="fas fa-box fa-2x"></i>
      <img src="{{ asset('assets/Kelola Barang.svg') }}" alt="Kelola Barang">
      <h3>Kelola Barang</h3>
    </a>
    <a href="#daftar-belanja" class="menu-card" style="text-decoration: none; color: #E1D4C2;">
      <i class="fas fa-receipt fa-2x"></i>
      <img src="{{ asset('assets/Kelola Tagihan.svg') }}" alt="Kelola Belanja">
      <h3>Kelola Belanja</h3>
    </a>
  </section>

  {{-- Section 2: Manajemen Barang --}}
  <div class="section-wrapper" id="manajemen-barang">
    <section class="table-section manajemen-barang">
      <h3>Manajemen Barang</h3>

      <!-- Filter -->
      <form method="GET" action="{{ route('home') }}#manajemen-barang" class="filter-bar" onsubmit="scrollToSection(this)">
          <select name="kategori" class="filter-select">
              <option value="">Semua Kategori</option>
              @foreach ($kategoriList as $k)
                  <option value="{{ $k }}" {{ request('kategori') == $k ? 'selected' : '' }}>
                      {{ $k }}
                  </option>
              @endforeach
          </select>

          <input
              type="text"
              name="search"
              class="filter-input"
              placeholder="Cari Barang…"
              value="{{ request('search') }}"
          >

          <button type="submit" class="btn dark">Cari</button>
      </form>

      <!-- Tabel -->
      <div class="table-container">
          <table class="styled-table">
              <thead>
                  <tr>
                      <th>No</th>
                      <th>Nama Barang</th>
                      <th>Kategori</th>
                      <th>Jumlah Barang</th>
                      <th>Harga Barang</th>
                      <th>Toko Pembelian</th>
                      <th>Aksi</th>
                  </tr>
              </thead>

              <tbody>
                  @forelse ($barang as $b)
                  <tr>
                      <td>{{ $loop->iteration }}</td>
                      <td>{{ $b->nama_barang }}</td>
                      <td>{{ $b->kategori }}</td>
                      <td>{{ $b->jumlah_barang }}</td>
                      <td>Rp {{ number_format($b->harga_barang,0,',','.') }}</td>
                      <td>{{ $b->toko_pembelian }}</td>

                      <td class="aksi-cell">
                        <!-- UPDATE -->
                        <button
                          type="button"
                          class="btn dark aksi-btn universal-update"
                          data-id="{{ $b->barang_id }}"
                          data-nama="{{ $b->nama_barang }}"
                          data-kategori="{{ $b->kategori }}"
                          data-jumlah="{{ $b->jumlah_barang }}"
                          data-harga="{{ $b->harga_barang }}"
                          data-toko="{{ $b->toko_pembelian }}"
                          data-gudang="{{ $b->gudang_id }}"
                        >
                          Update
                        </button>

                        <!-- DELETE -->
                        <button
                          type="button"
                          class="btn light aksi-btn universal-delete"
                          data-id="{{ $b->barang_id }}"
                          data-nama="{{ $b->nama_barang }}"
                          data-url="/barang/{{ $b->barang_id }}"
                          data-label="Barang"
                          data-popup-target="#overlay-delete"
                        >
                          Delete
                        </button>
                      </td>
                  </tr>
                  @empty
                  <tr>
                      <td colspan="7" class="no-data">Tidak ada data barang</td>
                  </tr>
                  @endforelse
              </tbody>
          </table>
      </div>

      <!-- Pagination Barang -->
      <div class="table-top-bar">
          <button type="button" class="btn dark" onclick="showAddProductPopup()">
              Tambah Barang
          </button>
          <div class="pagination-center">
              @if ($barang->total() > 0)
                  {{ $barang->appends(request()->except('barang_page'))->links() }}
              @endif
          </div>
      </div>
    </section>
  </div>

  {{-- Section 3: Daftar Belanja --}}
  <div class="section-wrapper" id="daftar-belanja">
    <section class="table-section manajemen-barang daftar-belanja">
      <h3>Daftar Belanja</h3>

      <!-- Filter -->
      <form method="GET" action="{{ route('home') }}#daftar-belanja" class="filter-bar" onsubmit="scrollToSection(this)">
          <select name="kategori_daftar" class="filter-select">
              <option value="">Semua Kategori</option>
              @foreach ($kategoriList as $k)
                  <option value="{{ $k }}" {{ request('kategori_daftar') == $k ? 'selected' : '' }}>
                      {{ $k }}
                  </option>
              @endforeach
          </select>

          <input
              type="text"
              name="search_daftar"
              class="filter-input"
              placeholder="Cari Barang…"
              value="{{ request('search_daftar') }}"
          >

          <button type="submit" class="btn dark">Cari</button>
      </form>

      <!-- Tabel -->
      <div class="table-container">
          <table class="styled-table">
              <thead>
                  <tr>
                      <th>No</th>
                      <th>Nama Barang</th>
                      <th>Sisa Stok</th>
                      <th>Toko Pembelian</th>
                      <th>Aksi</th>
                  </tr>
              </thead>

              <tbody>
              @forelse ($daftarBelanja as $db)
              <tr>
                  <td>{{ $loop->iteration }}</td>
                  <td>{{ $db->nama_barang }}</td>
                  <td>{{ $db->sisa_stok }}</td>
                  <td>{{ $db->toko_pembelian }}</td>

                  <td class="aksi-cell">
                      <!-- UPDATE -->
                      <button
                          type="button"
                          class="btn dark aksi-btn universal-update-belanja"
                          data-id="{{ $db->barang_id }}"
                          data-nama="{{ $db->nama_barang }}"
                          data-stok="{{ $db->sisa_stok }}"
                          data-toko="{{ $db->toko_pembelian }}"
                      >
                          Update
                      </button>

                      <!-- DELETE -->
                      <button
                        type="button"
                        class="btn light aksi-btn universal-delete"
                        data-id="{{ $db->barang_id }}"
                        data-nama="{{ $db->nama_barang }}"
                        data-url="{{ route('daftar-belanja.destroy', $db->barang_id) }}"
                        data-label="Daftar Belanja"
                        data-popup-target="#overlay-delete-daftar"
                      >
                        Delete
                      </button>
                  </td>
              </tr>
              @empty
              <tr>
                  <td colspan="5" class="no-data">
                      Tidak ada barang
                  </td>
              </tr>
              @endforelse
              </tbody>
          </table>
      </div>

      <!-- Pagination Daftar Belanja -->
      <div class="pagination-center">
          @if ($daftarBelanja->total() > 0)
              {{ $daftarBelanja->appends(request()->except('daftar_page'))->links() }}
          @endif
      </div>
    </section>
  </div>

  {{-- Section 4: Riwayat Belanja --}}
  <div class="section-wrapper">
    <section class="table-section manajemen-barang riwayat-belanja">
      <h3>Riwayat Belanja</h3>

      <!-- Filter -->
      <div class="filter-bar">
          <select class="filter-select">
              <option>Tanggal</option>
          </select>
          <select class="filter-select">
              <option>Nama Barang</option>
          </select>
          <select class="filter-select">
              <option>Kategori</option>
          </select>
          <select class="filter-select">
              <option>Tempat Beli</option>
          </select>

          <button class="btn dark">Apply</button>
          <button class="btn light">Reset</button>
      </div>

      <!-- Tabel -->
      <div class="table-container">
          <table class="styled-table">
              <thead>
                  <tr>
                      <th>Tanggal</th>
                      <th>Waktu</th>
                      <th>Nama Barang</th>
                      <th>Kategori</th>
                      <th>Tempat Beli</th>
                      <th>Jumlah</th>
                      <th>Harga</th>
                      <th>Total Harga</th>
                  </tr>
              </thead>

              <tbody>
              @forelse ($riwayatBelanja as $item)
              <tr>
                  <td>{{ $item->tanggal }}</td>
                  <td>{{ $item->waktu }}</td>
                  <td>{{ $item->nama_barang }}</td>
                  <td>{{ $item->kategori }}</td>
                  <td>{{ $item->tempat_beli }}</td>
                  <td>{{ $item->jumlah }}</td>
                  <td>Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
                  <td>Rp {{ number_format($item->total_harga, 0, ',', '.') }}</td>
              </tr>
              @empty
              <tr>
                  <td colspan="8" style="text-align:center;">
                      Belum ada riwayat belanja
                  </td>
              </tr>
              @endforelse
              </tbody>
          </table>
      </div>

      <!-- Pagination Riwayat Belanja -->
      <div class="pagination-center">
          @if ($riwayatBelanja->total() > 0)
              {{ $riwayatBelanja->appends(request()->except('riwayat_page'))->links() }}
          @endif
      </div>

    </section>
  </div>
</main>

<!-- FOOTER -->
<footer id="footer">
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

<script src="{{ asset('js/notif.js') }}"></script>
<script src="{{ asset('js/delete.js') }}"></script>
<script src="{{ asset('js/add-product-popup.js') }}"></script>
<script src="{{ asset('js/stock-notification.js') }}"></script>
<script src="{{ asset('js/automisasibelanja.js') }}"></script>
<script src="{{ asset('js/update_barang.js') }}"></script>
<script src="{{ asset('js/update_belanja.js') }}"></script>

</body>
</html>
