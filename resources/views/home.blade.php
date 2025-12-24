<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>STOKIFY - Home</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/home.css') }}">
  <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</head>

<body class="home-page">
  <script>
  function toggleSidebar() {
    const sidebar = document.getElementById('sidebar');
    sidebar.classList.toggle('active');
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
        <li><a href="#">Manajemen</a></li>
        <li><a href="#">Belanja</a></li>
        <li><a href="#">Contact</a></li>
        <li><a href="#">Tentang</a></li>
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
        <a href="#">Manajemen</a>
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
      <li><a href="#">Belanja</a></li>
      <li><a href="#">Pengaturan</a></li>
      <li><a href="#">Akun</a></li>
      <li><a href="#">Logout</a></li>
    </ul>
  </aside>

  {{-- MAIN CONTENT --}}
  <main class="content">

    {{-- Section 1: Menu Utama --}}
    <section class="banner">
      <img src="{{ asset('assets/Dashboard.svg') }}" alt="Dashboard">
      <h2>Dashboard</h2>
    </section>

    <section class="menu-section">
      <a href="{{ route('toko.index') }}" class="menu-card" style="text-decoration: none; color: #E1D4C2;">
        <i class="fas fa-store fa-2x"></i>
        <img src="{{ asset('assets/Toko.svg') }}" alt="Toko">
        <h3>Cek Toko</h3>
      </a>
      <div class="menu-card">
        <i class="fas fa-box fa-2x"></i>
        <img src="{{ asset('assets/Kelola Barang.svg') }}" alt="Kelola Barang">
        <h3>Kelola Barang</h3>
      </div>
      <div class="menu-card">
        <i class="fas fa-receipt fa-2x"></i>
        <img src="{{ asset('assets/Kelola Tagihan.svg') }}" alt="Kelola Tagihan">
        <h3>Kelola Riwayat</h3>
      </div>
    </section>

    {{-- Section 2: Manajemen Barang --}}
    <section class="table-section manajemen-barang">
        <h3>Manajemen Barang</h3>

        <!-- Filter -->
        <div class="filter-bar">
            <select class="filter-select">
                <option value="">Kategori</option>
            </select>
            <input type="text" class="filter-input" placeholder="Cari Barang…">
        </div>

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
                        <td>{{ $b->nama }}</td>
                        <td>{{ $b->kategori }}</td>
                        <td>{{ $b->jumlah }}</td>
                        <td>Rp {{ number_format($b->harga,0,',','.') }}</td>
                        <td>{{ $b->toko_pembelian }}</td>

                        <td class="aksi-cell">

                          <!-- UPDATE -->
                          <a href="#" class="btn dark aksi-btn">
                              Update
                          </a>

                          <!-- DELETE -->
                          <form action="{{ route('barang.destroy', $b->barang_id) }}" method="POST"
                                onsubmit="return confirm('Yakin ingin menghapus barang ini?')">
                              @csrf
                              @method('DELETE')
                              <button class="btn light aksi-btn">
                                  Delete
                              </button>
                          </form>

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

        <div class="pagination-center">
            {{ $barang->links() }}
        </div>
    </section>

    <section class="table-section manajemen-barang daftar-belanja">
        <h3>Daftar Belanja</h3>

        <!-- Filter -->
        <div class="filter-bar">
            <select class="filter-select">
                <option value="">Kategori</option>
            </select>
            <input type="text" class="filter-input" placeholder="Cari Barang…">
        </div>

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
                @forelse ($barang as $b)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $b->nama }}</td>
                    <td>{{ $b->jumlah }}</td>
                    <td>{{ $b->toko_pembelian }}</td>

                    <td class="aksi-cell">
                        <!-- UPDATE -->
                        <a href="#" class="btn dark aksi-btn">Update</a>

                        <!-- DELETE -->
                        <form action="{{ route('barang.destroy', $b->barang_id) }}"
                              method="POST"
                              onsubmit="return confirm('Hapus barang ini?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn light aksi-btn">Delete</button>
                        </form>
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

        <div class="pagination-center">
            {{ $barang->links() }}
        </div>
    </section>

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
                @forelse ($barang as $item)
                <tr>
                    <td>{{ $item->created_at?->format('d F Y') ?? '-' }}</td>
                    <td>{{ $item->created_at?->format('H:i') ?? '-' }}</td>
                    <td>{{ $item->nama_barang }}</td>
                    <td>{{ $item->kategori }}</td>
                    <td>{{ $item->toko_pembelian }}</td>
                    <td>{{ $item->jumlah_barang }}</td>
                    <td>Rp {{ number_format($item->harga_barang,0,',','.') }}</td>
                    <td>
                        Rp {{ number_format($item->jumlah_barang * $item->harga_barang,0,',','.') }}
                    </td>
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

        <div class="pagination-center">
            {{-- {{ $riwayat->links() }} --}}
        </div>
    </section>

  </main>

  {{-- FOOTER --}}
  <footer class="footer">
    <div class="footer-content">
      <p>© 2025 STOKIFY | All rights reserved.</p>
    </div>
  </footer>
</body>
</html>
