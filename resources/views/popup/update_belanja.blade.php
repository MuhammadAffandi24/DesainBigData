<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="stylesheet" href="{{ asset('css/popup.css') }}">

<!-- Overlay -->
<div id="update-cart-overlay" class="popup-overlay" style="display: none;"></div>

<!-- Popup Update Daftar Belanja -->
<div id="update-cart-popup" class="add-product-popup" style="display: none;">
    <div class="add-product-header">
        <h2 class="add-product-title">Update Daftar Belanja</h2>
        <img
            id="close-cart"
            class="material-symbols"
            src="{{ asset('assets/material-symbols_close(2).svg') }}"
            alt="Close"
            style="cursor:pointer"
        />
    </div>

    <!-- Pesan validasi / sukses -->
    <div id="update-cart-message" class="form-message"></div>

    <div class="add-product-content">
        <!-- Hidden ID -->
        <input type="hidden" id="update-cart-id">

        <div class="form-group">
            <label class="form-label" for="update-cart-name">Nama Barang</label>
            <input
                type="text"
                class="form-input"
                id="update-cart-name"
                placeholder="Masukkan nama barang"
            >
        </div>

        <div class="form-group">
            <label class="form-label" for="update-cart-stock">Sisa Stok</label>
            <input
                type="number"
                class="form-input"
                id="update-cart-stock"
                min="0"
                placeholder="Masukkan sisa stok"
            >
        </div>

        <div class="form-group">
            <label class="form-label" for="update-cart-store">Toko Pembelian</label>
            <input
                type="text"
                class="form-input"
                id="update-cart-store"
                placeholder="Masukkan toko pembelian"
            >
        </div>
    </div>

    <div class="add-product-actions">
        <button type="button" class="btn btn-cancel">Batal</button>
        <button type="button" class="btn btn-save">Update</button>
    </div>
</div>
