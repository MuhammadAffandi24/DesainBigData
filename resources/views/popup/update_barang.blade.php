<link rel="stylesheet" href="{{ asset('css/popup.css') }}">

<!-- Overlay -->
<div id="update-product-overlay" class="popup-overlay" style="display: none;"></div>

<!-- Popup Update Barang -->
<div id="update-product-popup" class="add-product-popup" style="display: none;">
    <div class="add-product-header">
        <h2 class="add-product-title">Update Barang</h2>
        <img
        id="close-delete"
        class="material-symbols"
        src="{{ asset('assets/material-symbols_close(2).svg') }}"
        alt="Close"
        onclick="closeUpdateProductPopup()"
        style="cursor:pointer"
        />

    </div>

    <div id="update-form-message" class="form-message"></div>

    <div class="add-product-content">
        <!-- hidden id -->
        <input type="hidden" id="update-barang-id">

        <div class="form-group">
            <label class="form-label">Gudang</label>
            <select class="form-select" id="update-product-warehouse">
                @foreach($userGudangs as $gudang)
                    <option value="{{ $gudang->gudang_id }}">
                        {{ $gudang->nama_gudang }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label class="form-label">Nama Barang</label>
            <input type="text" class="form-input" id="update-product-name">
        </div>

        <div class="form-group">
            <label class="form-label">Kategori</label>
            <select class="form-select" id="update-product-category">
                <option value="">Pilih Kategori</option>
                <option value="makanan">Makanan</option>
                <option value="minuman">Minuman</option>
                <option value="sembako">Sembako</option>
                <option value="elektronik">Elektronik</option>
                <option value="pakaian">Pakaian</option>
                <option value="kesehatan">Kesehatan</option>
                <option value="kebersihan">Kebersihan</option>
                <option value="mainan">Mainan</option>
                <option value="lain-lain">Lain-lain</option>
            </select>
        </div>

        <div class="form-group">
            <label class="form-label">Jumlah</label>
            <input type="number" class="form-input" id="update-product-quantity" min="1">
        </div>

        <div class="form-group">
            <label class="form-label">Harga</label>
            <input type="number" class="form-input" id="update-product-price" min="0">
        </div>

        <div class="form-group">
            <label class="form-label">Toko Pembelian</label>
            <input type="text" class="form-input" id="update-product-store">
        </div>
    </div>

    <div class="add-product-actions">
        <button type="button" class="btn-cancel" onclick="closeUpdateProductPopup()">Batal</button>
        <button type="button" class="btn-save" onclick="updateProduct()">Update</button>
    </div>
</div>
