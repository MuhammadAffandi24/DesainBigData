// ==========================================
// BUKA POPUP TAMBAH DAFTAR BELANJA
// DIPANGGIL DARI POPUP STOK LOW
// ==========================================
function openBelanjaPopup(button) {
    const productId = button.dataset.productId;
    const productName = button.dataset.productName;
    const productStock = button.dataset.productStock; // ambil stok dari data attribute

    // Tutup popup stok rendah
    const stockOverlay = document.getElementById('stock-low-overlay');
    if (stockOverlay) {
        stockOverlay.style.display = 'none';
    }

    // Ambil popup belanja
    const popup = document.getElementById('popup-belanja');
    if (!popup) {
        console.error('popup-belanja tidak ditemukan');
        return;
    }

    // Simpan data ke popup
    popup.dataset.productId = productId;
    popup.dataset.productName = productName;
    popup.dataset.productStock = productStock; // simpan stok ke dataset

    // Tampilkan nama barang
    const nameEl = popup.querySelector('.belanja-message');
    if (nameEl) {
        nameEl.textContent = `${productName} (sisa ${productStock} pcs) akan ditambahkan ke daftar belanja`;
    }

    // Tampilkan popup belanja
    popup.style.display = 'flex';
}

// ==========================================
// DOM READY
// ==========================================
document.addEventListener('DOMContentLoaded', function () {
    const stockPopup = document.getElementById('stock-low-popup');
    const stockOverlay = document.getElementById('stock-low-overlay');

    // ===== POPUP STOK LOW (MUNCUL SETIAP 10 MENIT SEKALI) =====
    if (stockPopup && stockOverlay && stockPopup.querySelectorAll('.stock-low-item').length > 0) {
        const lastShown = localStorage.getItem('stockLowLastShown');
        const now = Date.now();
        const interval = 1 * 60 * 1000; // 10 menit

        if (!lastShown || (now - parseInt(lastShown, 10)) > interval) {
            stockOverlay.style.display = 'flex';
            localStorage.setItem('stockLowLastShown', now.toString());
        }
        // kalau belum lewat 10 menit → tidak tampil
    }

    // ===== SUBMIT DAFTAR BELANJA =====
    const btn = document.getElementById('submit-belanja');
    if (btn) {
        btn.addEventListener('click', async () => {
            const popup = document.getElementById('popup-belanja');
            if (!popup) return;

            const productId = popup.dataset.productId;
            const productName = popup.dataset.productName;
            const productStock = popup.dataset.productStock; // ambil stok dari dataset

            if (!productId || !productName) {
                showNotif('Belanja', 'Data barang tidak valid', false);
                return;
            }

            const tokoRadio = document.querySelector('input[name="toko"]:checked');
            const tokoCustom = document.querySelector('input[name="toko_custom"]');

            const toko = tokoRadio?.value || tokoCustom?.value || '';

            if (!toko) {
                showNotif('Belanja', 'Pilih atau isi toko pembelian', false);
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
                        sisa_stok: productStock || 0, 
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
    }

    // ===== TOMBOL CLOSE POPUP BELANJA =====
    const closeBtn = document.getElementById('close-belanja');
    if (closeBtn) {
        closeBtn.addEventListener('click', () => {
            const popup = document.getElementById('popup-belanja');
            if (popup) popup.style.display = 'none';
        });
    }

    // ===== KLIK DI LUAR POPUP BELANJA =====
    window.addEventListener('click', function (e) {
        const belanjaPopup = document.getElementById('popup-belanja');
        if (belanjaPopup && e.target === belanjaPopup) {
            belanjaPopup.style.display = 'none';
        }
    });
});
