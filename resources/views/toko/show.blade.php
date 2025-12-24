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
        <div class="nav-header">
            <a href="{{ route('toko.index') }}" class="back-icon">
                <i class="fas fa-chevron-left"></i>
            </a>
        </div>

        <div class="shop-banner" style="background: #e8d9c1; padding: 40px; border-radius: 20px; margin-bottom: 30px;">
            <h1 style="color: #291C0E; margin: 0;">Daftar Produk</h1>
            <p style="color: #555;">Pilih barang kebutuhan Anda di sini</p>
        </div>

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