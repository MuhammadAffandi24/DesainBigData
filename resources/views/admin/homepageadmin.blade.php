<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard Superadmin - STOKIFY</title>

  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>

<!-- DELETE MODAL -->
<div id="deleteModal" class="modal">
    <div class="modal-content">
        <h3>⚠️Hapus User⚠️</h3>
        <p>
            Yakin ingin menghapus user
            <strong id="deleteUsername"></strong>?
        </p>

        <form id="deleteForm" method="POST">
            @csrf
            @method('DELETE')

            <div class="modal-actions">
                <button type="button" class="btn-cancel" id="cancelDelete">Batal</button>
                <button type="submit" class="btn-danger">Hapus</button>
            </div>
        </form>
    </div>
</div>

<body>

<!-- ================= NAVBAR ================= -->
<header class="navbar">
  <div class="container">

    <!-- TOGGLE SIDEBAR -->
    <div class="menu-toggle" id="menuToggle">
        <img src="{{ asset(path: 'assets/menu.svg') }}" alt="Menu">
    </div>

      <div class="logo">
          <a href="/" class="logo-link">
          <img src="{{ asset('assets/navbar&footer.svg') }}" alt="Logo STOKIFY" class="logo-icon">
          <h1>STOKIFY</h1>
          </a>
      </div>
    <nav>
      <a href="/superadmin/home">Home</a>
      <a href="#users">Manajemen User</a>
      <a href="#monitoring">Monitoring</a>
    </nav>
  </div>
</header>


<!-- ================= SIDEBAR ================= -->
<div class="sidebar-overlay" id="sidebarOverlay"></div>

<aside class="sidebar" id="sidebar">

  <div class="sidebar-header">
    <img src="{{ asset('assets/material-symbols_close(2).svg') }}" alt="Close" class="sidebar-close" id="closeSidebar">
  </div>

  <ul class="sidebar-menu">
    <li><a href="#home" class="active">Home</a></li>
    <li><a href="#users">Manajemen User</a></li>
    <li><a href="#monitoring">Monitoring Global</a></li>
    <li><a href="#">Pengaturan</a></li>
    <li><a href="#">Akun</a></li>
    <li class="logout-card">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="logout-btn-card">
                Logout
            </button>
        </form>
    </li>
  </ul>

</aside>


<!-- ================= WRAPPER ================= -->
<div id="home" style="padding-top:140px;">

  <!-- WELCOME -->
  <div class="center">
    <div class="superadmin-banner">
      WELCOME SUPERADMIN!
    </div>
  </div>

  <!-- MENU SUPERADMIN -->
  <div class="dashboard-menu">
      <a href="#users" class="menu-card">
        <img src="{{ asset('assets/User.svg') }}" class="menu-icon-img">
        <div class="menu-label">Manajemen User</div>
      </a>

      <a href="#monitoring" class="menu-card">
        <img src="{{ asset('assets/MonitoringGlobal.svg') }}" class="menu-icon-img">
        <div class="menu-label">Monitoring Global</div>
      </a>
  </div>

  <!-- TITLE -->
  <h1 id="users" class="section-title">Daftar User</h1>


  <!-- TABLE -->
  <div class="table-wrapper">
    <table class="data-table">
      <thead>
        <tr>
          <th>User_ID</th>
          <th>Username</th>
          <th>Status Akun</th>
          <th style="text-align:center;">Action</th>
        </tr>
      </thead>

      <tbody>
        @foreach($users as $u)
        <tr>
          <td>{{ $u->user_id }}</td>
          <td>{{ $u->username }}</td>

          <td>
            @if ($u->role === 'Superadmin')
                <select disabled>
                    <option selected>Active</option>
                </select>
            @else
                <form action="{{ route('superadmin.user.updateStatus', $u->user_id) }}" method="POST">
                    @csrf
                    <select name="status" onchange="this.form.submit()">
                        <option value="Aktif" {{ $u->status == 'Aktif' ? 'selected' : '' }}>
                            Active
                        </option>
                        <option value="Tidak Aktif" {{ $u->status == 'Tidak Aktif' ? 'selected' : '' }}>
                            Inactive
                        </option>
                    </select>
                </form>
            @endif
          </td>

          <td style="text-align:center;">
            @if ($u->role !== 'Superadmin')
            <button
                class="btn-delete open-delete-modal"
                data-id="{{ $u->user_id }}"
                data-username="{{ $u->username }}">
                Delete
            </button>
            @endif
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>


  <!-- PIE CHART PERSENTASE -->
  @php
      $total = $aktif + $nonaktif;
      $percentage = $total > 0 ? ($aktif / $total * 100) : 0;
  @endphp


  <!-- STATISTICS -->
  <div id="monitoring" class="stats-container">

      <!-- TOTAL GUDANG -->
      <div class="stats-box">
          <h2 class="stats-title">Total Gudang Terdaftar</h2>

          <div class="stats-card dark">
              <div class="big-number">{{ $total_gudang }}</div>
              <div class="big-label">Gudang Terdaftar</div>
          </div>
      </div>

      <!-- PIE CHART TANPA JS -->
      <div class="stats-box">
          <h2 class="stats-title">Gudang Aktif vs Tidak Aktif</h2>

          <div class="stats-card dark chart-box">
              <div class="pie" style="--percent: {{ $percentage }}"></div>

              <div class="chart-label">
                  Aktif: {{ $aktif }} | Tidak Aktif: {{ $nonaktif }}
              </div>
          </div>
      </div>

  </div>

</div> <!-- END WRAPPER -->


<!-- FOOTER MANGGIL DARI app.css -->
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
<script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
