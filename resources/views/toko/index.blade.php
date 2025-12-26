<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cek Toko - STOKIFY</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700;800&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
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
            <a href="{{ url('/')}}" class="back-icon">
                <i class="fas fa-chevron-left"></i>
            </a>
        </div>

        <div class="shop-grid">
            @foreach($tokos as $toko)
                <a href="{{ route('toko.show', $toko->toko_id) }}" class="shop-card">
                    
                    {{-- LOGIKA PINTAR: CEK SEGALA JENIS EKSTENSI --}}
                    @php 
                        $db_file = $toko->banner_toko; // misal: toko1.jpg
                        $nama_dasar = pathinfo($db_file, PATHINFO_FILENAME); // ambil: toko1
                        
                        // Daftar ekstensi yang mau dicek
                        $extensions = ['jpg', 'jpeg', 'png', 'webp'];
                        $final_path = null;

                        // Loop cek satu per satu
                        foreach ($extensions as $ext) {
                            $cek_path = 'assets/' . $nama_dasar . '.' . $ext;
                            if (file_exists(public_path($cek_path))) {
                                $final_path = $cek_path;
                                break; // Ketemu! Berhenti mencari.
                            }
                        }
                    @endphp

                    @if($final_path)
                        {{-- Gambar Ditemukan (Apapun ekstensinya) --}}
                        <img src="{{ asset($final_path) }}" alt="{{ $toko->nama_toko }}">
                    @else
                        {{-- Gambar Benar-benar Tidak Ada --}}
                        <div class="img-placeholder">
                            <i class="fas fa-store-alt"></i>
                            <span>Gambar Tidak Tersedia</span>
                        </div>
                    @endif

                    <h3 class="shop-name">{{ $toko->nama_toko }}</h3>
                </a>
            @endforeach
        </div>
    </div>

</body>
</html>