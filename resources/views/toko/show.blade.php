<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $nama_toko_asli }} - Daftar Produk</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/popup.css') }}">

    <style>
        /* STLE TOMBOL EDIT */
        .banner-edit-btn {
            position: absolute;
            top: 20px;
            right: 20px;
            
            background-color: #E1D4C2; 
            
            color: #291C0E;
            border: 2px solid #291C0E;

            padding: 8px 20px;
            border-radius: 30px;
            font-family: 'Poppins', sans-serif;
            font-weight: 600;
            font-size: 14px;
            
            cursor: pointer;
            transition: 0.3s;
            z-index: 10;
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        /* Efek saat kursor diarahkan (Hover) */
        .banner-edit-btn:hover {
            background: #291C0E; /* Jadi Cokelat Tua */
            color: #E1D4C2; /* Ikon jadi Cream */
            transform: scale(1.1);
        }
    </style>

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

        {{-- BANNER TOKO --}}
        @php
            $exts = ['webp', 'jpeg', 'jpg', 'png'];
            $banner_final = null;

            foreach ($exts as $ext) {
                $path_check = 'assets/' . $nama_toko_asli . '.' . $ext;
                if (file_exists(public_path($path_check))) {
                    $banner_final = $path_check;
                    break;
                }
            }
        @endphp

        <div style="position: relative;">

            @if($banner_final)
                <div class="shop-banner">
                    <img src="{{ asset($banner_final) }}?v={{ time() }}" alt="{{ $nama_toko_asli }}">
                    <div class="banner-content">
                        <h1>{{ $nama_toko_asli }}</h1>
                        <p>Cabang Resmi STOKIFY</p> {{-- Alamat hardcode karena tidak ada di database --}}
                    </div>
                </div>
            @else
                {{-- JIKA GAMBAR TIDAK ADA --}}
                <div class="shop-banner-dark">
                    <h1>{{ $nama_toko_asli }}</h1>
                     <p>Silakan pilih barang kebutuhan Anda</p>
                </div>
            @endif

            {{-- TOMBOL EDIT --}}
            <button onclick="openModal()" class="banner-edit-btn" title="Ubah Gambar Toko">
                <i class="fas fa-pen"></i>
                <span>Edit Gambar</span>
            </button>

        </div>

        {{-- FILTER BAR --}}
        <form action="{{ route('toko.show', urlencode($nama_toko_asli)) }}" method="GET">
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
                    <a href="{{ route('toko.show', urlencode($nama_toko_asli)) }}" class="btn-reset">Reset</a>
                </div>
            </div>
        </form>

        {{-- GRID PRODUK (DENGAN LOGIKA CEK EKSTENSI) --}}
        <div class="product-grid">
            @forelse($barang as $item)
                <a href="{{ route('produk.show', $item->barang_id) }}" class="product-card">
                    <div class="product-image">
                        @php
                            // Cek Gambar Produk
                            $prod_db = $item->gambar;
                            $prod_dasar = pathinfo($prod_db ?? '', PATHINFO_FILENAME);
                            $prod_final = null;

                            if (!empty($prod_db)) {
                                foreach ($exts as $ext) {
                                    $p_check = 'assets/' . $prod_dasar . '.' . $ext;
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

    {{-- MODAL POPUP --}}
    <div id="imageModal" class="popup-overlay" style="display: none;">
        <div class="add-product-popup" style="width: 400px;">
            <i class="fas fa-times add-product-close" onclick="closeModal()"></i>
            <h2 class="add-product-title">Atur Gambar Toko</h2>
            
            <div class="add-product-content">
                {{-- FORM UPLOAD --}}
                <form action="{{ route('toko.image.upload') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="nama_toko" value="{{ $nama_toko_asli }}">
                    <div class="form-group" style="display: block;">
                        <label class="form-label" style="display: block; margin-bottom: 10px;">Pilih Gambar Baru:</label>
                        <input type="file" name="image" class="form-input" required accept="image/*">
                    </div>
                    <div class="add-product-actions" style="margin-top: 20px;">
                        <button type="button" class="btn-cancel" onclick="closeModal()">Batal</button>
                        <button type="submit" class="btn-save">Simpan</button>
                    </div>
                </form>

                {{-- TOMBOL HAPUS (Hanya muncul jika gambar ada) --}}
                @if($banner_final)
                    <hr style="border: 0; border-top: 1px solid rgba(255,255,255,0.2); margin: 20px 0;">
                    <form action="{{ route('toko.image.delete') }}" method="POST" onsubmit="return confirm('Hapus gambar?');">
                        @csrf
                        <input type="hidden" name="nama_toko" value="{{ $nama_toko_asli }}">
                        <button type="submit" style="width: 100%; background: #c12020; color: white; padding: 10px; border: none; border-radius: 5px; cursor: pointer;">
                            <i class="fas fa-trash"></i> Hapus Gambar
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </div>

    {{-- SCRIPT --}}
    <script>
        function openModal() { document.getElementById('imageModal').style.display = 'flex'; }
        function closeModal() { document.getElementById('imageModal').style.display = 'none'; }
        window.onclick = function(e) {
            if (e.target == document.getElementById('imageModal')) closeModal();
        }
    </script>
</body>
</html>