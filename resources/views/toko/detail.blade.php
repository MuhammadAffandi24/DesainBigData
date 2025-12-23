<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Produk - STOKIFY</title>
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
            <a href="javascript:history.back()" class="back-icon">&#10094;</a>
        </div>

        <div class="item-detail-wrapper">
            <div class="item-image-box">
                <img src="{{ asset('assets/kopi.png') }}" alt="Produk">
            </div>

            <div class="item-info-side">
                <h1>Kopi</h1>
                <p>Minuman</p>
            </div>
        </div>
    </div>

</body>
</html>