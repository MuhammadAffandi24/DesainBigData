<link rel="stylesheet" href="{{ asset('css/popup.css') }}">

<div class="overlay-delete" id="overlay-delete" style="display: none;">
  <div class="delete">
    {{-- Tombol close --}}
    <img id="close-delete" class="material-symbols" src="{{ asset('assets/material-symbols_close(2).svg') }}" alt="Close" />

    {{-- Konten popup --}}
    <div class="title">Hapus Barang</div>

    <p class="message">
      Apakah anda yakin ingin menghapus barang <br>
      <span class="item-name">{{ $barang->nama_barang }}</span>?
    </p>

    {{-- Tombol aksi --}}
    <div class="btn-group">
      <button type="button" id="cancel-delete" class="btn-cancel">Batal</button>
      <button
        type="button"
        class="btn-delete universal-delete"
        data-id="{{ $barang->barang_id }}"
        data-url="/api/barang/{{ $barang->barang_id }}"
        data-label="Barang"
      >
        Delete
      </button>
    </div>
  </div>
</div>
