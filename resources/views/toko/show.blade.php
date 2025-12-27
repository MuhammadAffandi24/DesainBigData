<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $toko->nama_toko }} - Daftar Produk</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700;800&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</head>
<body style="background-color: #e1d4c2;">

    {{-- NAVBAR --}}
    <nav class="navbar">
        <div class="container">
            <div class="logo">
                <a class="logo-link" href="{{ route('home') }}">
                    <img src="{{ asset('assets/navbar&footer.svg') }}" alt="Logo" class="logo-icon">
                    <h1>STOKIFY</h1>
                </a>
            </div>
            <nav>
                <a href="{{ route('home') }}">Home</a>
                <a href="#">Manajemen</a>
                <a href="{{ route('toko.index') }}">Belanja</a>
                <a href="#">Contact</a>
                <a href="#">Tentang</a>
            </nav>
            <div class="actions">
                <a href="#"><img src="{{ asset('assets/pp.svg') }}" style="width: 40px;"></a>
            </div>
        </div>
    </nav>

    <div class="main-wrapper">
        {{-- TOMBOL KEMBALI --}}
        <div class="nav-header">
            <a href="{{ route('toko.index') }}" class="back-icon">
                <i class="fas fa-chevron-left"></i>
            </a>
        </div>

        {{-- ========================================================= --}}
        {{-- BANNER TOKO (DINAMIS DENGAN LOGIKA CEK EKSTENSI)          --}}
        {{-- ========================================================= --}}
        @php
            // Logika Cek Gambar Toko (Sama persis dengan index.blade)
            $banner_db = $toko->banner_toko; 
            $banner_base = pathinfo($banner_db, PATHINFO_FILENAME);
            $exts = ['webp', 'jpg', 'jpeg', 'png'];
            $banner_final = null;

            if(!empty($banner_db)){
                foreach ($exts as $ext) {
                    $path_check = 'assets/' . $banner_base . '.' . $ext;
                    if (file_exists(public_path($path_check))) {
                        $banner_final = $path_check;
                        break;
                    }
                }
            }
        @endphp

        @if($banner_final)
            {{-- JIKA GAMBAR ADA: Pakai Style Banner dengan Gambar --}}
            <div class="shop-banner">
                <img src="{{ asset($banner_final) }}" alt="{{ $toko->nama_toko }}">
                <div class="banner-content">
                    <h1>{{ $toko->nama_toko }}</h1>
                    <p>{{ $toko->alamat ?? 'Alamat tidak tersedia' }}</p>
                </div>
            </div>
        @else
            {{-- JIKA GAMBAR HILANG: Pakai Style Banner Gelap (Fallback) --}}
            <div class="shop-banner-dark">
                 <h1>{{ $toko->nama_toko }}</h1>
                 <p>Silakan pilih barang kebutuhan Anda</p>
            </div>
        @endif


        {{-- ========================================================= --}}
        {{-- FILTER BAR                                                --}}
        {{-- ========================================================= --}}
        <form action="{{ route('toko.show', $id) }}" method="GET">
            <div class="filter-bar">
                
                {{-- Kiri: Dropdown Kategori --}}
                <div class="filter-left">
                    <select name="kategori" class="filter-select">
                        <option value="">Semua Kategori</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat }}" {{ request('kategori') == $cat ? 'selected' : '' }}>
                                {{ $cat }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Kanan: Tombol Apply & Reset --}}
                <div class="filter-right">
                    <button type="submit" class="btn-apply">Apply</button>
                    <a href="{{ route('toko.show', $id) }}" class="btn-reset">Reset</a>
                </div>

            </div>
        </form>

        {{-- ========================================================= --}}
        {{-- GRID PRODUK (DENGAN LOGIKA CEK EKSTENSI)                  --}}
        {{-- ========================================================= --}}
        <div class="product-grid">
            @forelse($barang as $item)
                <a href="{{ route('produk.show', $item->barang_id) }}" class="product-card">
                    <div class="product-image">
                        @php
                            // Logika Cek Gambar Produk
                            $prod_db = $item->gambar;
                            $prod_base = pathinfo($prod_db, PATHINFO_FILENAME);
                            $prod_final = null;

                            if (!empty($prod_db)) {
                                foreach ($exts as $ext) {
                                    $p_check = 'assets/' . $prod_base . '.' . $ext;
                                    if (file_exists(public_path($p_check))) {
                                        $prod_final = $p_check;
                                        break;
                                    }
                                }
                            }
                        @endphp

                        @if($prod_final)
                            <img src="{{ asset($prod_final) }}" alt="{{ $item->nama_barang }}">
                        @else
                            {{-- Placeholder jika gambar produk hilang --}}
                            <div class="img-placeholder">
                               <i class="fas fa-box-open"></i>
                               <span>Gambar Tidak Tersedia</span>
                            </div>
                        @endif
                    </div>
                    <h3 class="product-title">{{ $item->nama_barang }}</h3>
                    <p class="product-price">Rp {{ number_format($item->harga_barang, 0, ',', '.') }}</p>
                </a>
            @empty
                <div style="text-align: center; width: 100%; grid-column: 1 / -1; padding: 40px;">
                    <h3>Produk tidak ditemukan.</h3>
                    <p>Coba reset filter atau pilih kategori lain.</p>
                </div>
            @endforelse
        </div>
    </div>
    
</body>
</html>