<link rel="stylesheet" href="{{ asset('css/automisasi.css') }}">
<div class="overlay-belanja" id="popup-belanja" style="display:none;">
  <div class="belanja-light">
    <img id="close-belanja" class="material-symbols" 
         src="{{ asset('assets/material-symbols_close.svg') }}" alt="Close" />

    <div class="belanja-content">
      <div class="belanja-title">Tambah Daftar Belanja</div>

      <div class="belanja-message">
        {{ $barang->nama_barang }} sisa {{ $barang->jumlah_barang }} pcs
      </div>

      <div class="belanja-field">
        <label>Tempat Beli:</label>
        <div class="belanja-toko-group">
          <label class="toko-option">
            <input type="radio" name="toko" value="{{ $barang->toko_pembelian }}" checked>
            {{ $barang->toko_pembelian }}
          </label>
          <label class="toko-option">
            <input type="radio" name="toko" value="">
            <input type="text" name="toko_custom" placeholder="Toko lain..." class="toko-lain-input">
          </label>
        </div>
      </div>

      <div class="belanja-btn-group">
        <button 
          type="button" 
          class="btn-belanja" 
          id="submit-belanja"
          data-url="/api/daftar-belanja"
          data-nama="{{ $barang->nama_barang }}">
          Tambah ke Daftar Belanja
        </button>
      </div>
    </div>
  </div>
</div>
