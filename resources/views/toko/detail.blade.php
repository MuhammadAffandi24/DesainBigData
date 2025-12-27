<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail - {{ $barang->nama_barang }}</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;700;800&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</head>
<body style="background-color: #e1d4c2;">

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

    {{-- Script Back dinamis: kembali ke toko asal barang tersebut --}}
    <div class="nav-header">
        <a href="{{ route('toko.show', urlencode($barang->toko_pembelian)) }}" class="back-icon">
            <i class="fas fa-chevron-left"></i>
        </a>
    </div>

    <div class="product-detail-container">
        <div class="product-image-section">
            @php
                $nama_file = $barang->gambar ?? null; 
                $path = 'assets/' . $nama_file;
                $gambar_siap = !empty($nama_file) && file_exists(public_path($path));
            @endphp

            @if($gambar_siap)
                <img src="{{ asset($path) }}" alt="{{ $barang->nama_barang }}" class="product-img-real">
            @else
                <div class="product-placeholder">
                    <i class="fas fa-box-open"></i>
                    <p style="margin: 0; font-size: 14px; opacity: 0.7;">Gambar Tidak Tersedia</p>
                </div>
            @endif
        </div>

        <div class="product-info-section">
            <span class="product-category">{{ $barang->kategori ?? 'Umum' }}</span>

            <h1 class="product-title">{{ $barang->nama_barang }}</h1>

            <p style="color: #555; line-height: 1.6; font-size: 16px; margin-bottom: 20px;">
                Tersedia di toko <strong>{{ $barang->toko_pembelian }}</strong>.<br>
                Stok saat ini: <strong>{{ $barang->jumlah_barang }} pcs</strong>.
            </p>

            <div class="product-price">
                Rp {{ number_format($barang->harga_barang, 0, ',', '.') }}
            </div>
        </div>
    </div>
</body>
</html>