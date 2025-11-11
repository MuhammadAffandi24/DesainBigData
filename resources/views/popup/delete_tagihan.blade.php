<link rel="stylesheet" href="{{ asset('css/popup.css') }}">

<div class="overlay-delete" id="overlay-delete-tagihan" style="display: none;">
  <div class="delete-light">
    {{-- Tombol close (ikon silang) --}}
    <img id="close-delete-tagihan" class="material-symbols" src="{{ asset('assets/material-symbols_close.svg') }}" alt="Close" />

    {{-- Konten popup --}}
    <div class="title">Hapus Tagihan</div>

    <p class="message">
      Apakah kamu yakin ingin menghapus tagihan <br>
      <span class="item-name">{{ $tagihan->nama_tagihan }}</span>?
    </p>

    {{-- Tombol aksi --}}
    <div class="btn-group">
      <button type="button" id="cancel-delete-tagihan" class="btn-cancel">Batal</button>
      <button
        type="button"
        class="btn-delete universal-delete"
        data-id="{{ $tagihan->tagihan_id }}"
        data-url="/api/tagihan/{{ $tagihan->tagihan_id }}"
        data-label="Tagihan"
      >
        Delete
      </button>
    </div>
  </div>
</div>
