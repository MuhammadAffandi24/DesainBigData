/* ===============================
   OPEN POPUP
================================ */
window.openUpdateBelanjaPopup = function (data) {
  document.getElementById('update-cart-popup').style.display = 'block';
  document.getElementById('update-cart-overlay').style.display = 'block';

  document.getElementById('update-cart-id').value = data.id || '';
  document.getElementById('update-cart-name').value = data.nama_barang || '';
  document.getElementById('update-cart-stock').value = data.sisa_stok || '';
  document.getElementById('update-cart-store').value = data.toko_pembelian || '';

  showUpdateBelanjaMessage('', '');
};

/* ===============================
   CLOSE POPUP
================================ */
window.closeUpdateBelanjaPopup = function () {
  document.getElementById('update-cart-popup').style.display = 'none';
  document.getElementById('update-cart-overlay').style.display = 'none';
};

/* ===============================
   UPDATE BELANJA (WEB)
================================ */
window.updateBelanja = async function () {
  const id = document.getElementById('update-cart-id').value;
  if (!id) {
    showUpdateBelanjaMessage('⚠️ ID belanja tidak ditemukan', 'error');
    return;
  }

  const data = {
    nama_barang: document.getElementById('update-cart-name').value,
    sisa_stok: document.getElementById('update-cart-stock').value,
    toko_pembelian: document.getElementById('update-cart-store').value,
  };

  // Validasi client
  if (Object.values(data).some(v => !v)) {
    showUpdateBelanjaMessage('⚠️ Semua field wajib diisi!', 'error');
    return;
  }
  if (data.sisa_stok < 0) {
    showUpdateBelanjaMessage('⚠️ Sisa stok tidak boleh negatif!', 'error');
    return;
  }

  try {
    const csrfToken = document
      .querySelector('meta[name="csrf-token"]')
      .getAttribute('content');

    const res = await fetch(`/daftar-belanja/${id}`, {
      method: 'PUT',
      headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
        'X-CSRF-TOKEN': csrfToken
      },
      body: JSON.stringify(data)
    });

    const result = await res.json().catch(() => ({}));

    if (!res.ok) {
      showUpdateBelanjaMessage(
        result.message || 'Update daftar belanja gagal',
        'error'
      );
      return;
    }

    // ✅ Success
    sessionStorage.setItem(
      'notif',
      JSON.stringify({
        message: result.message || 'Daftar belanja berhasil diperbarui',
        isSuccess: true
      })
    );

    closeUpdateBelanjaPopup();
    location.reload();

  } catch (err) {
    console.error(err);
    showUpdateBelanjaMessage('Terjadi kesalahan sistem', 'error');
  }
};

/* ===============================
   MESSAGE
================================ */
function showUpdateBelanjaMessage(msg, type) {
  const el = document.getElementById('update-cart-message');
  if (!el) return;
  el.style.display = msg ? 'block' : 'none';
  el.innerText = msg;
  el.className = `form-message ${type}`;
}

/* ===============================
   EVENT LISTENER
================================ */
document.addEventListener('DOMContentLoaded', () => {
  const overlay = document.getElementById('update-cart-overlay');
  const closeBtn = document.getElementById('close-cart');

  if (closeBtn) closeBtn.addEventListener('click', closeUpdateBelanjaPopup);
  if (overlay) overlay.addEventListener('click', closeUpdateBelanjaPopup);

  document.querySelectorAll('.universal-update-belanja').forEach(btn => {
    btn.addEventListener('click', () => {
      openUpdateBelanjaPopup({
        id: btn.dataset.id,
        nama_barang: btn.dataset.nama,
        sisa_stok: btn.dataset.stok,
        toko_pembelian: btn.dataset.toko,
      });
    });
  });

  document
    .querySelector('#update-cart-popup .btn-save')
    ?.addEventListener('click', updateBelanja);

  document
    .querySelector('#update-cart-popup .btn-cancel')
    ?.addEventListener('click', closeUpdateBelanjaPopup);
});
