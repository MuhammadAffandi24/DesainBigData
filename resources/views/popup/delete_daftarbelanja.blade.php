<link rel="stylesheet" href="{{ asset('css/popup.css') }}">

<div class="overlay-delete" id="overlay-delete-daftar" style="display: none; justify-content:center; align-items:center;">
  <div class="delete">

    {{-- Tombol close --}}
    <img
      id="close-delete-daftar"
      class="material-symbols"
      src="{{ asset('assets/material-symbols_close(2).svg') }}"
      alt="Close"
    />

    {{-- Konten popup --}}
    <div class="title">Hapus Daftar Belanja</div>

    <p class="message">
      Apakah anda yakin ingin menghapus daftar belanja  
      <span class="item-name" id="delete-item-name-daftar">-</span>?
    </p>

    {{-- Tombol aksi --}}
    <div class="btn-group">
      <button type="button" id="cancel-delete-daftar" class="btn-cancel">
        Batal
      </button>

      <button
        type="button"
        class="btn-delete universal-delete"
        data-id=""
        data-url=""
        data-label="Daftar Belanja"
      >
        Delete
      </button>
    </div>

  </div>
</div>
