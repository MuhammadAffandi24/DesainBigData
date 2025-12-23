document.addEventListener('DOMContentLoaded', function () {
  const btn = document.getElementById('submit-belanja');
  if (!btn) return;

  btn.addEventListener('click', async () => {
    const url = btn.dataset.url;
    const namaBarang = btn.dataset.nama;
    const tokoRadio = document.querySelector('input[name="toko"]:checked');
    const tokoCustom = document.querySelector('input[name="toko_custom"]').value;

    const toko = tokoRadio && tokoRadio.value ? tokoRadio.value : tokoCustom;

    const token = localStorage.getItem('token');
    if (!token) {
      showNotif('Belanja', 'Tidak ada token. Login API dulu.', false);
      return;
    }

    try {
      const response = await fetch(url, {
        method: 'POST',
        headers: {
          'Authorization': 'Bearer ' + token,
          'Content-Type': 'application/json',
          'Accept': 'application/json'
        },
        body: JSON.stringify({
          nama_barang: namaBarang,
          toko: toko
        })
      });

      const result = await response.json();
      if (response.ok) {
        showNotif('Belanja', result.message || 'Berhasil ditambahkan', true);
        document.getElementById('popup-belanja').style.display = 'none';
      } else {
        showNotif('Belanja', result.message || 'Gagal menambahkan', false);
      }
    } catch (err) {
      console.error(err);
      showNotif('Belanja', 'Terjadi kesalahan saat menambahkan.', false);
    }
  });
});
