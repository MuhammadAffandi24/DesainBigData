<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail - {{ $barang->nama_barang }}</title>

    {{-- CSS --}}
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/popup.css') }}">

    {{-- FONT & ICON --}}
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;700;800&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>

    <style>
        .product-image-section {
            background-color: transparent !important;
            box-shadow: none !important;
            border: none !important;
            padding: 0 !important;
            display: flex;
            flex-direction: column; 
            align-items: center;
            justify-content: center;
            gap: 20px; 
        }

        .product-img-real {
            width: 400px;
            height: 400px;
            object-fit: cover; 
            border-radius: 20px;
            filter: drop-shadow(0 10px 15px rgba(0,0,0,0.1));
            background-color: #fff;
        }

        .product-placeholder {
            width: 400px; 
            height: 400px; 
            background: #291C0E; 
            border-radius: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            color: #E1D4C2;
            filter: drop-shadow(0 10px 15px rgba(0,0,0,0.1));
        }

        @media (max-width: 768px) {
            .product-img-real, .product-placeholder {
                width: 100%;
                height: auto; 
                aspect-ratio: 1/1;
            }
        }

        .btn-edit-img {
            background-color: #FFFFFF;
            color: #291C0E;
            border: 2px solid #291C0E;
            padding: 8px 20px;
            border-radius: 8px;
            font-family: 'Poppins', sans-serif;
            font-weight: 700;
            font-size: 14px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: 0.2s;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }
        .btn-edit-img:hover {
            background: #291C0E;
            color: #E1D4C2;
            transform: translateY(-3px);
        }
    </style>
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

    {{-- TOMBOL KEMBALI --}}
    <div class="nav-header">
        <a href="{{ route('toko.show', urlencode($barang->toko_pembelian)) }}" class="back-icon">
            <i class="fas fa-chevron-left"></i>
        </a>
    </div>

    {{-- PEMBUNGKUS UTAMA --}}
    <div class="product-detail-container">
        {{-- KIRI --}}
        <div class="product-image-section">
            {{-- GAMBAR --}}
            @php
                $cleanName = preg_replace('/[^A-Za-z0-9]/', '_', $barang->nama_barang);
                $extensions = ['jpg','jpeg','png','webp'];
                $gambar_siap = false;
                $path = null;

                foreach ($extensions as $ext) {
                    $cek = 'assets/' . $cleanName . '.' . $ext;
                        if (file_exists(public_path($cek))) {
                        $path = $cek;
                        $gambar_siap = true;
                        break;
                    }
                }
            @endphp

            @if($gambar_siap)
                <img src="{{ asset($path) }}" alt="{{ $barang->nama_barang }}" class="product-img-real">
            @else
                <div class="product-placeholder">
                    <i class="fas fa-box-open"></i>
                    <p style="margin: 0; font-size: 14px; opacity: 0.7;">Gambar Tidak Tersedia</p>
                </div>
            @endif

            {{-- TOMBOL EDIT GAMBAR --}}
            <button onclick="openModal()" class="btn-edit-img">
                <i class="fas fa-camera"></i>
                <span>Edit Gambar</span>
            </button>
        </div>

        {{-- KANAN --}}
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

        {{-- MODAL POPUP UPLOAD PRODUK --}}
        <div id="imageModal" class="popup-overlay" style="display: none;">
            <div class="add-product-popup" style="width: 400px;">
                <i class="fas fa-times add-product-close" onclick="closeModal()"></i>
                <h2 class="add-product-title">Ganti Gambar Produk</h2>
                <div class="add-product-content">
                
                    {{-- FORM UPLOAD --}}
                    <form action="{{ route('produk.image.upload') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="barang_id" value="{{ $barang->barang_id }}">
                    
                        <div class="form-group" style="display: block;">
                            <label class="form-label" style="display: block; margin-bottom: 10px;">Pilih Gambar Baru:</label>
                            <input type="file" name="image" class="form-input" required accept="image/*">
                        </div>
                    
                        <div class="add-product-actions" style="margin-top: 20px;">
                            <button type="button" class="btn-cancel" onclick="closeModal()">Batal</button>
                            <button type="submit" class="btn-save">Simpan</button>
                        </div>
                    </form>

                    {{-- FORM HAPUS (Hanya jika gambar ada) --}}
                    @if($gambar_siap)
                        <hr style="border: 0; border-top: 1px solid rgba(255,255,255,0.2); margin: 20px 0;">
                    
                        <form action="{{ route('produk.image.delete') }}" method="POST" onsubmit="return confirm('Hapus gambar produk ini?');">
                            @csrf
                            <input type="hidden" name="barang_id" value="{{ $barang->barang_id }}">
                            <button type="submit" style="width: 100%; background: #c12020; color: white; padding: 10px; border: none; border-radius: 5px; cursor: pointer; font-weight: 600;">
                                <i class="fas fa-trash"></i> Hapus Gambar
                            </button>
                        </form>
                    @endif

                </div>
            </div>
        </div>
    </div>

    {{-- SCRIPT MODAL --}}
    <script>
        function openModal() { document.getElementById('imageModal').style.display = 'flex'; }
        function closeModal() { document.getElementById('imageModal').style.display = 'none'; }
        window.onclick = function(e) {
            if (e.target == document.getElementById('imageModal')) closeModal();
        }
    </script>
</body>
</html>