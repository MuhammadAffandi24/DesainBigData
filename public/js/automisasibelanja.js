document.addEventListener('DOMContentLoaded', function () {
    const btn = document.getElementById('submit-belanja');
    if (!btn) return;

    btn.addEventListener('click', async () => {
        const popup = document.getElementById('popup-belanja');
        if (!popup) return;

        const productId = popup.dataset.productId;
        const productName = popup.dataset.productName;
        const productStock = popup.dataset.productStock;

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

        try {
            const csrfToken = document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute('content');

            const response = await fetch('/daftar-belanja', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    barang_id: productId,
                    nama_barang: productName,
                    sisa_stok: productStock || 0,
                    toko_pembelian: toko
                })
            });

            const result = await response.json();

            if (response.ok) {
                showNotif('Belanja', result.message || 'Berhasil ditambahkan', true);
                popup.style.display = 'none';
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

    const closeBtn = document.getElementById('close-belanja');
    if (closeBtn) {
        closeBtn.addEventListener('click', () => {
            document.getElementById('popup-belanja').style.display = 'none';
        });
    }

    window.addEventListener('click', function (e) {
        const belanjaPopup = document.getElementById('popup-belanja');
        if (belanjaPopup && e.target === belanjaPopup) {
            belanjaPopup.style.display = 'none';
        }
    });
});
