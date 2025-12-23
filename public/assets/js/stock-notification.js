// NOTIFIKASI  STOK HAMPIR HABIS

gitdocument.addEventListener('DOMContentLoaded', function() {
    // Listen for stock low notifications
    window.Echo?.private(`App.Models.User.${userId}`)
        .notification((notification) => {
            if (notification.type === 'stock.low') {
                showStockLowPopup(notification.data);
            }
        });

    // Function to show the popup
    function showStockLowPopup(data) {
        const popup = document.getElementById('stock-low-popup');
        if (!popup) return;

        // Show popup
        popup.style.display = 'block';

        // Update content if needed
        const itemsContainer = popup.querySelector('.stock-low-items');
        if (itemsContainer && Array.isArray(data)) {
            itemsContainer.innerHTML = data.map(product => `
                <div class="stock-low-item">
                    <span class="stock-info">${product.product_name} sisa ${product.stock} pcs</span>
                    <button class="add-to-cart-btn" 
                            onclick="addToCart(${product.product_id}, '${product.product_name}')"
                            data-product-id="${product.product_id}">
                        Tambah ke Daftar Belanja
                    </button>
                </div>
            `).join('');
        }
    }

    // Function to add product to cart
    window.addToCart = async function(productId, productName) {
        try {
            const response = await fetch('/api/daftar-belanja/add', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')
                },
                body: JSON.stringify({
                    product_id: productId,
                    quantity: 1
                })
            });

            if (response.ok) {
                const button = document.querySelector(`[data-product-id="${productId}"]`);
                if (button) {
                    button.textContent = 'Ditambahkan ✓';
                    button.style.backgroundColor = '#45a049';
                }
                // Optional: Show success message
                alert(`${productName} berhasil ditambahkan ke daftar belanja`);
            }
        } catch (error) {
            console.error('Error adding to cart:', error);
            alert('Gagal menambahkan ke daftar belanja');
        }
    }

    // Close popup when clicking outside
    window.addEventListener('click', function(e) {
        const popup = document.getElementById('stock-low-popup');
        if (e.target === popup) {
            popup.style.display = 'none';
        }
    });
});