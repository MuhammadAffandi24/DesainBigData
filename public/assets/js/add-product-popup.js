document.addEventListener('DOMContentLoaded', function() {
    // Add to window object so it can be called from anywhere
    window.showAddProductPopup = function() {
        document.getElementById('add-product-overlay').style.display = 'block';
        document.getElementById('add-product-popup').style.display = 'block';
    }

    window.closeAddProductPopup = function() {
        document.getElementById('add-product-overlay').style.display = 'none';
        document.getElementById('add-product-popup').style.display = 'none';
        // Reset form
        document.querySelectorAll('#add-product-popup input').forEach(input => {
            input.value = '';
        });
        document.getElementById('product-category').value = '';
    }

    window.saveProduct = async function() {
        const data = {
            name: document.getElementById('product-name').value,
            category: document.getElementById('product-category').value,
            quantity: document.getElementById('product-quantity').value,
            price: document.getElementById('product-price').value,
            store: document.getElementById('product-store').value
        };

        // Validasi
        if (!data.name || !data.category || !data.quantity || !data.price || !data.store) {
            alert('Semua field harus diisi');
            return;
        }

        try {
            const response = await fetch('/api/barang', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')
                },
                body: JSON.stringify(data)
            });

            const result = await response.json();

            if (response.ok) {
                alert('Barang berhasil ditambahkan');
                closeAddProductPopup();
                // Optional: refresh halaman atau update list barang
                window.location.reload();
            } else {
                throw new Error(result.message || 'Gagal menambahkan barang');
            }
        } catch (error) {
            alert(error.message || 'Terjadi kesalahan');
        }
    }

    // Close when clicking overlay
    document.getElementById('add-product-overlay').addEventListener('click', function(e) {
        if (e.target === this) {
            closeAddProductPopup();
        }
    });
});