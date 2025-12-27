document.addEventListener('DOMContentLoaded', function () {
    const btn = document.getElementById('submit-belanja');
    if (!btn) return;

    // klik tombol tambah ke daftar belanja
    btn.addEventListener('click', async () => {
        const popup = document.getElementById('popup-belanja');
        if (!popup) return;

        const productId = popup.dataset.productId;
        const productName = popup.dataset.productName;
        const productStock = popup.dataset.productStock; // ambil stok dari dataset

        if (!productId || !productName) {
            showNotif('Belanja', 'Data barang tidak ditemukan', false);
            return;
        }

        const tokoRadio = document.querySelector('input[name="toko"]:checked');
        const tokoCustom = document.querySelector('input[name="toko_custom"]');

        const toko = tokoRadio?.value || tokoCustom?.value || '';

        if (!toko) {
            showNotif('Belanja', 'Isi atau pilih toko pembelian', false);
            return;
        }

        const token = localStorage.getItem('token');
        if (!token) {
            showNotif('Belanja', 'Tidak ada token. Login API dulu.', false);
            return;
        }

        try {
            const response = await fetch('/api/daftar-belanja', {
                method: 'POST',
                headers: {
                    'Authorization': 'Bearer ' + token,
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    barang_id: productId,
                    nama_barang: productName,
                    sisa_stok: productStock || 0, // kirim stok, default 0
                    toko_pembelian: toko
                })
            });

            const result = await response.json();

            if (response.ok) {
                showNotif('Belanja', result.message || 'Berhasil ditambahkan', true);
                popup.style.display = 'none';

                // reload + scroll ke section daftar belanja
                window.location.hash = '#daftar-belanja';
                location.reload();
            } else {
                showNotif('Belanja', result.message || 'Gagal menambahkan', false);
            }
        } catch (err) {
            console.error(err);
            showNotif('Belanja', 'Terjadi kesalahan saat menambahkan.', false);
        }
    });

    // tombol close popup belanja
    const closeBtn = document.getElementById('close-belanja');
    if (closeBtn) {
        closeBtn.addEventListener('click', () => {
            document.getElementById('popup-belanja').style.display = 'none';
        });
    }

    // klik di luar popup
    window.addEventListener('click', function (e) {
        const belanjaPopup = document.getElementById('popup-belanja');
        if (belanjaPopup && e.target === belanjaPopup) {
            belanjaPopup.style.display = 'none';
        }
    });
});
