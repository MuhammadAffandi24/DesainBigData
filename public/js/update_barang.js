/* ===============================
   OPEN POPUP
================================ */
window.openUpdateProductPopup = function (data) {
  document.getElementById('update-product-popup').style.display = 'block';
  document.getElementById('update-product-overlay').style.display = 'block';

  document.getElementById('update-barang-id').value = data.id || '';
  document.getElementById('update-product-warehouse').value = data.gudang_id || '';
  document.getElementById('update-product-name').value = data.nama || '';
  document.getElementById('update-product-category').value = data.kategori || '';
  document.getElementById('update-product-quantity').value = data.jumlah || '';
  document.getElementById('update-product-price').value = data.harga || '';
  document.getElementById('update-product-store').value = data.toko || '';

  showUpdateMessage('', '');
};

/* ===============================
   CLOSE POPUP
================================ */
window.closeUpdateProductPopup = function () {
  document.getElementById('update-product-popup').style.display = 'none';
  document.getElementById('update-product-overlay').style.display = 'none';
};

/* ===============================
   UPDATE BARANG
================================ */
window.updateProduct = async function () {
  const id = document.getElementById('update-barang-id').value;
  if (!id) {
    showUpdateMessage('⚠️ ID barang tidak ditemukan', 'error');
    return;
  }

  const data = {
    gudang_id: document.getElementById('update-product-warehouse').value,
    nama_barang: document.getElementById('update-product-name').value,
    kategori: document.getElementById('update-product-category').value,
    jumlah_barang: document.getElementById('update-product-quantity').value,
    harga_barang: document.getElementById('update-product-price').value,
    toko_pembelian: document.getElementById('update-product-store').value,
  };

  // Validasi client
  if (Object.values(data).some(v => !v)) {
    showUpdateMessage('⚠️ Semua field harus diisi sebelum update!', 'error');
    return;
  }
  if (data.jumlah_barang <= 0 || data.harga_barang <= 0) {
    showUpdateMessage('⚠️ Jumlah atau harga tidak boleh nol/negatif!', 'error');
    return;
  }

  try {
    const res = await fetch(`/barang/${id}`, {
      method: 'PUT',
      headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
        'X-CSRF-TOKEN': document
            .querySelector('meta[name="csrf-token"]')
            .getAttribute('content')
      },
      body: JSON.stringify(data)
    });

    const result = await res.json();

    if (!res.ok) {
      if (result.errors) {
        const messages = Object.values(result.errors).flat().join(', ');
        showUpdateMessage(messages, 'error');
      } else {
        showUpdateMessage(result.message || 'Update gagal', 'error');
      }
      return;
    }

    // ✅ Success → simpan pesan ke localStorage, tampilkan notif setelah reload
    localStorage.setItem('updateSuccess', result.message || 'Barang berhasil diperbarui!');
    closeUpdateProductPopup();
    location.reload();

  } catch (err) {
    console.error(err);
    showUpdateMessage(err.message || 'Terjadi kesalahan', 'error');
  }
};

/* ===============================
   MESSAGE (khusus error)
================================ */
function showUpdateMessage(msg, type) {
  const el = document.getElementById('update-form-message');
  if (!el) return;
  el.style.display = 'block';
  el.innerText = msg;
  el.className = `form-message ${type}`;
}

/* ===============================
   EVENT LISTENER
================================ */
document.addEventListener('DOMContentLoaded', () => {
  const overlay = document.getElementById('update-product-overlay');
  const closeBtn = document.getElementById('close-delete'); // sesuai blade

  if (closeBtn) {
    closeBtn.addEventListener('click', (e) => {
      e.preventDefault();
      closeUpdateProductPopup();
    });
  }

  if (overlay) {
    overlay.addEventListener('click', () => {
      closeUpdateProductPopup();
    });
  }

  document.querySelectorAll('.universal-update').forEach(btn => {
    btn.addEventListener('click', () => {
      openUpdateProductPopup({
        id: btn.dataset.id,
        gudang_id: btn.dataset.gudang,
        nama: btn.dataset.nama,
        kategori: btn.dataset.kategori,
        jumlah: btn.dataset.jumlah,
        harga: btn.dataset.harga,
        toko: btn.dataset.toko,
      });
    });
  });

  // 🔔 Cek apakah ada pesan sukses setelah reload
  const successMsg = localStorage.getItem('updateSuccess');
  if (successMsg) {
    showNotif('Update Barang', successMsg, true);
    localStorage.removeItem('updateSuccess');
  }
});
