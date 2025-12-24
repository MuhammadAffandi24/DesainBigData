<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Produk</title>
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

        {{-- HEADER TOKO --}}
        <div class="shop-banner-dark">
             <h1>{{ $barang->first()->toko_pembelian ?? 'Daftar Produk' }}</h1>
        </div>

        {{-- === MULAI KODE FILTER === --}}
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
                    
                    {{-- Tombol Reset: Link kembali ke URL toko tanpa filter --}}
                    <a href="{{ route('toko.show', $id) }}" class="btn-reset">Reset</a>
                </div>

            </div>
        </form>
        {{-- === SELESAI KODE FILTER === --}}

        <div class="product-grid">
            {{-- ... Kode Grid Produk di bawah sini ... --}}

        <div class="product-grid">
            @forelse($barang as $item)
                <a href="{{ route('produk.show', $item->barang_id) }}" class="product-card">
                    <div class="product-image">
                        @if(file_exists(public_path('assets/' . $item->gambar)) && !empty($item->gambar))
                            <img src="{{ asset('assets/' . $item->gambar) }}" alt="{{ $item->nama_barang }}">
                        @else
                            <div style="width: 100%; height: 100%; background: #291C0E; display:flex; align-items:center; justify-content:center; border-radius: 15px;">
                               <i class="fas fa-box-open" style="font-size:40px; color:#E1D4C2;"></i>
                            </div>
                        @endif
                    </div>
                    <h3 class="product-title">{{ $item->nama_barang }}</h3>
                    <p class="product-price">Rp {{ number_format($item->harga_barang, 0, ',', '.') }}</p>
                </a>
            @empty
                <div style="text-align: center; width: 100%; grid-column: 1 / -1;">
                    <h3>Belum ada produk di toko ini.</h3>
                </div>
            @endforelse
        </div>
    </div>
    
</body>
</html>