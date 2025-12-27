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
   UPDATE BELANJA
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
    showUpdateBelanjaMessage('⚠️ Semua field wajib diisi sebelum update!', 'error');
    return;
  }
  if (data.sisa_stok < 0) {
    showUpdateBelanjaMessage('⚠️ Sisa stok tidak boleh negatif!', 'error');
    return;
  }

  try {
    const token = localStorage.getItem('token');

    const res = await fetch(`/api/daftar-belanja/${id}`, {
      method: 'PUT', // sesuai route
      headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
        'Authorization': `Bearer ${token}`
      },
      body: JSON.stringify(data)
    });

    const result = await res.json();

    if (!res.ok) {
      if (result.errors) {
        const messages = Object.values(result.errors).flat().join(', ');
        showUpdateBelanjaMessage(messages, 'error');
      } else {
        showUpdateBelanjaMessage(result.message || 'Update gagal', 'error');
      }
      return;
    }

    // ✅ Success → simpan pesan ke localStorage, tampilkan notif setelah reload
    localStorage.setItem('updateBelanjaSuccess', result.message || 'Daftar belanja berhasil diperbarui!');
    closeUpdateBelanjaPopup();
    location.reload();

  } catch (err) {
    console.error(err);
    showUpdateBelanjaMessage(err.message || 'Terjadi kesalahan', 'error');
  }
};

/* ===============================
   MESSAGE (khusus error)
================================ */
function showUpdateBelanjaMessage(msg, type) {
  const el = document.getElementById('update-cart-message');
  if (!el) return;
  el.style.display = 'block';
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

  // tombol update & batal
  document.querySelector('#update-cart-popup .btn-save').addEventListener('click', updateBelanja);
  document.querySelector('#update-cart-popup .btn-cancel').addEventListener('click', closeUpdateBelanjaPopup);

  // 🔔 Cek apakah ada pesan sukses setelah reload
  const successMsg = localStorage.getItem('updateBelanjaSuccess');
  if (successMsg) {
    showNotif('Update Belanja', successMsg, true);
    localStorage.removeItem('updateBelanjaSuccess');
  }
});
