<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cek Toko - STOKIFY</title>
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
            <a href="{{ url('/')}}" class="back-icon">&#10094;
                <i class="fas fa-chevron-left"></i>
            </a>
        </div>

        <div class="shop-grid">
            <a href="{{ route('toko.show', 1) }}" class="shop-card active">
                <img src="{{ asset('assets/toko1.jpg') }}" alt="Rejeki Abadi">
                <h3 class="shop-name">Rejeki Abadi</h3>
            </a>
            
            <a href="{{ route('toko.show', 2) }}" class="shop-card">
                <img src="{{ asset('assets/toko2.jpg') }}" alt="Amanah">
                <h3 class="shop-name">Amanah</h3>
            </a>

            <a href="{{ route('toko.show', 3) }}" class="shop-card">
                <img src="{{ asset('assets/toko3.jpg') }}" alt="Serba Ada">
                <h3 class="shop-name">Serba Ada</h3>
            </a>

            <a href="{{ route('toko.show', 4) }}" class="shop-card">
                <img src="{{ asset('assets/toko4.jpg') }}" alt="Pojok Barang">
                <h3 class="shop-name">Pojok Barang</h3>
            </a>

            <a href="{{ route('toko.show', 5) }}" class="shop-card">
                <img src="{{ asset('assets/toko5.jpg') }}" alt="Toko Maju Jaya">
                <h3 class="shop-name">Toko Maju Jaya</h3>
            </a>

            <a href="{{ route('toko.show', 6) }}" class="shop-card">
                <img src="{{ asset('assets/toko6.jpg') }}" alt="Laci Ajaib">
                <h3 class="shop-name">Laci Ajaib</h3>
            </a>
        </div>
    </div>

</body>
</html>