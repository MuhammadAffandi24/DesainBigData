<div id="add-product-overlay" class="popup-overlay" style="display: none;"></div>
<div id="add-product-popup" class="add-product-popup" style="display: none;">
    <div class="add-product-header">
        <h2 class="add-product-title">Tambah Barang</h2>
        <button type="button" class="add-product-close" onclick="closeAddProductPopup()"></button>
    </div>
    
    <div class="add-product-content">
        <div class="form-group">
            <label class="form-label">Nama Barang</label>
            <input type="text" class="form-input" id="product-name" name="name">
        </div>
        
        <div class="form-group">
            <label class="form-label">Kategori</label>
            <select class="form-select" id="product-category" name="category">
                // Ini aku ngasal aja ya ges biar pas demo jalan, yang penting work
                // Kalau sudah ada database, bisa dihubungkan
                <option value="">Pilih Kategori</option>
                <option value="makanan">Makanan</option>
                <option value="minuman">Minuman</option>
                <option value="sembako">Sembako</option>
                <option value="lainnya">Lainnya</option>
            </select>
        </div>
        
        <div class="form-group">
            <label class="form-label">Jumlah</label>
            <input type="number" class="form-input" id="product-quantity" name="quantity" min="1">
        </div>
        
        <div class="form-group">
            <label class="form-label">Harga</label>
            <input type="number" class="form-input" id="product-price" name="price" min="0">
        </div>
        
        <div class="form-group">
            <label class="form-label">Toko Pembelian</label>
            <input type="text" class="form-input" id="product-store" name="store">
        </div>
    </div>
    
    <div class="add-product-actions">
        <button type="button" class="btn-cancel" onclick="closeAddProductPopup()">Batal</button>
        <button type="button" class="btn-save" onclick="saveProduct()">Simpan</button>
    </div>
</div>