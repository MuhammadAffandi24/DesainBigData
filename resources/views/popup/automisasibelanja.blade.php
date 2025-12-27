<link rel="stylesheet" href="{{ asset('css/stock-notification.css') }}">

<div class="overlay-belanja" id="popup-belanja" style="display:none;">
  <div class="belanja-light">
    <img id="close-belanja"
         class="material-symbols"
         src="{{ asset('assets/material-symbols_close(2).svg') }}"
         alt="Close" />

    <div class="belanja-content">
      <div class="belanja-title">Tambah Daftar Belanja</div>

      <div class="belanja-message">
        <!-- DIISI DARI JS -->
      </div>

      <div class="belanja-field">
        <label>Tempat Beli:</label>
        <div class="belanja-toko-group">
          <label class="toko-option">
            <input type="radio" name="toko" value="Indomaret" checked>
            Indomaret
          </label>

          <label class="toko-option">
            <input type="radio" name="toko" value="">
            <input type="text"
                   name="toko_custom"
                   placeholder="Toko lain..."
                   class="toko-lain-input">
          </label>
        </div>
      </div>

      <div class="belanja-btn-group">
        <button
          type="button"
          class="btn-belanja"
          id="submit-belanja">
          Tambah ke Daftar Belanja
        </button>
      </div>
    </div>
  </div>
</div>
