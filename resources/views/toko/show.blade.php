<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Toko - STOKIFY</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700;800&display=swap" rel="stylesheet">
</head>
<body>

    <header class="navbar">
        <div class="container">
            <div class="logo">
                <a href="/" class="logo-link">
                    <img src="{{ asset('assets/navbar&footer.svg') }}" alt="Logo" class="logo-icon">
                    <h1>STOKIFY</h1>
                </a>
            </div>
            <nav>
                <a href="/">Home</a>
                <a href="#">Manajemen</a>
                <a href="#">Belanja</a>
                <a href="#">Contact</a>
                <a href="#">Tentang</a>
            </nav>
            <div class="actions">
                <a href="#"><img src="{{ asset('assets/pp.svg') }}" style="width: 40px;"></a>
            </div>
        </div>
    </header>

    <div class="main-wrapper">
        <div class="nav-header">
            <a href="{{ route('toko.index') }}" class="back-icon">&#10094;</a>
        </div>

        <div class="shop-banner">
            <img src="{{ asset('assets/toko1_wide.jpg') }}" alt="Banner">
            <div class="banner-text">
                <h1>Rejeki Abadi</h1>
                <p>Jl. Mayor Sunaryo no. 4, Pasar Gede</p>
            </div>
        </div>

        <div class="filter-bar">
            <div class="filter-group">
                <select class="custom-select">
                    <option>Nama Barang</option>
                </select>
                <select class="custom-select">
                    <option>Kategori</option>
                </select>
            </div>
            <div class="filter-group">
                <button class="btn-apply">Apply</button>
                <button class="btn-reset">Reset</button>
            </div>
        </div>

        <div class="product-grid">
            <a href="{{ route('produk.show', 1) }}" class="product-card">
                <div class="product-img-box">
                    <img src="{{ asset('assets/kopi.png') }}" alt="Kopi">
                </div>
                <div class="product-info">
                    <h3>Kopi</h3>
                    <p>Harga</p>
                </div>
            </a>

            <a href="#" class="product-card">
                <div class="product-img-box">
                    <img src="{{ asset('assets/minyak.png') }}" alt="Minyak">
                </div>
                <div class="product-info">
                    <h3>Minyak Zaitun</h3>
                    <p>Harga</p>
                </div>
            </a>

            <a href="#" class="product-card">
                <div class="product-img-box">
                    <img src="{{ asset('assets/mie.png') }}" alt="Mie">
                </div>
                <div class="product-info">
                    <h3>Bungkus Mi</h3>
                    <p>Harga</p>
                </div>
            </a>
            
            </div>
    </div>

</body>
</html>