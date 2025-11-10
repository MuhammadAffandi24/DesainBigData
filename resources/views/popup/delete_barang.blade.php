{{-- resources/views/popup/hapus_barang.blade.php --}}
<link rel="stylesheet" href="{{ asset('css/popup.css') }}">
<div class="overlay-delete">
  <div class="delete-barang">
    {{-- Tombol close (ikon silang) --}}
    <img id="close-delete" class="material-symbols" src="{{ asset('assets/material-symbols_close.svg') }}" alt="Close" />

    <div class="delete-content">
      <div class="title">Hapus Barang</div>

      {{-- Pesan konfirmasi --}}
      <p class="message">
        Apakah kamu yakin ingin menghapus barang <br>
        <span class="item-name">{{ $barang->nama_barang }}</span>?
      </p>

      {{-- Form hapus --}}
      <form method="POST" action="{{ route('barang.destroy') }}">
        @csrf
        <input type="hidden" name="id" value="{{ $barang->barang_id }}">

        {{-- Tombol aksi --}}
        <div class="btn-group">
          <button type="button" id="cancel-delete" class="btn-cancel">Batal</button>
          <button type="submit" class="btn-delete">Delete</button>
        </div>
      </form>
    </div>
  </div>
</div>
