document.addEventListener('DOMContentLoaded', () => {
  const overlay = document.getElementById('add-product-overlay');
  const popup   = document.getElementById('add-product-popup');
  const msgBox  = document.getElementById('form-message');

  // ===== Fungsi Buka Popup =====
  window.showAddProductPopup = () => {
    overlay.style.display = 'flex';
    popup.style.display   = 'block';
  };

  // ===== Fungsi Tutup Popup =====
  window.closeAddProductPopup = () => {
    overlay.style.display = 'none';
    popup.style.display   = 'none';
    popup.querySelectorAll('input, select').forEach(el => el.value = '');
    if (msgBox) {
      msgBox.style.display = 'none';
      msgBox.textContent   = '';
      msgBox.className     = 'form-message';
    }
  };

  // ===== Fungsi Simpan Barang =====
  window.saveProduct = async () => {
    const fields = {
      'gudang_id': 'product-warehouse',
      'nama_barang': 'product-name',
      'kategori': 'product-category',
      'jumlah_barang': 'product-quantity',
      'harga_barang': 'product-price',
      'toko_pembelian': 'product-store'
    };

    const data = Object.fromEntries(
      Object.entries(fields).map(([key, id]) => [key, document.getElementById(id).value])
    );

    // Validasi semua field terisi
    if (Object.values(data).some(v => !v)) {
      if (msgBox) {
        msgBox.style.display = 'block';
        msgBox.className     = 'form-message error';
        msgBox.textContent   = '⚠️ Semua field harus diisi sebelum menyimpan!';
      }
      return;
    }

    // Validasi jumlah/harga
    if (data.jumlah_barang <= 0 || data.harga_barang <= 0) {
      if (msgBox) {
        msgBox.style.display = 'block';
        msgBox.className     = 'form-message error';
        msgBox.textContent   = '⚠️ Jumlah atau harga tidak boleh negatif atau nol!';
      }
      return;
    }

    try {
      const response = await fetch('/barang', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json',
          'X-CSRF-TOKEN': document
            .querySelector('meta[name="csrf-token"]')
            .getAttribute('content')
        },
        body: JSON.stringify(data)
      });

      // Cek dulu apakah response JSON valid
      let result;
      try { result = await response.json(); }
      catch { result = { message: response.statusText }; }

      showNotif(
        'Tambah Barang',
        result.message || (response.ok ? 'Barang berhasil ditambahkan!' : 'Gagal menambahkan barang'),
        response.ok
      );

      if (response.ok) closeAddProductPopup();
    } catch (err) {
      if (msgBox) {
        msgBox.style.display = 'block';
        msgBox.className     = 'form-message error';
        msgBox.textContent   = err.message || 'Terjadi kesalahan';
      }
      showNotif('Tambah Barang', err.message || 'Terjadi kesalahan', false);
    }
  };

  // ===== Tutup popup jika klik overlay =====
  overlay.addEventListener('click', e => {
    if (e.target === overlay) closeAddProductPopup();
  });
});
