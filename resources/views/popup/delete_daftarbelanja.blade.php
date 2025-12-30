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
        class="btn light aksi-btn delete-belanja"
        data-id="{{ $db->belanja_id }}"   
        data-nama="{{ $db->nama_barang }}"
        data-url="{{ route('daftar-belanja.destroy', $db->belanja_id) }}"
        data-label="Daftar Belanja"
        data-popup-target="#overlay-delete-daftar"
      >
        Delete
      </button>

    </div>

  </div>
</div>
