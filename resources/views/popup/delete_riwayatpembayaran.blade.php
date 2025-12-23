<link rel="stylesheet" href="{{ asset('css/popup.css') }}">

<div id="overlay-delete-riwayat" class="overlay-delete" style="display:none;">
  <div class="delete-light">
    <img id="close-delete-riwayat" class="material-symbols" 
         src="{{ asset('assets/material-symbols_close.svg') }}" alt="Close" />

    <div class="delete-content">
      <div class="title">Hapus Riwayat Pembayaran</div>
      <p class="message">
        Apakah anda yakin ingin menghapus riwayat pembayaran untuk tagihan 
        <span class="item-name">{{ $riwayat->nama_tagihan }}</span>?
      </p>

      <div class="btn-group">
        <button type="button" id="cancel-delete-riwayat" class="btn-cancel">Batal</button>
        <button 
          type="button" 
          class="btn-delete universal-delete"
          data-url="/api/riwayat-pembayaran/{{ $riwayat->pembayaran_id }}"
          data-label="Riwayat Pembayaran">
          Delete
        </button>
      </div>
    </div>
  </div>
</div>
