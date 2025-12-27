<link rel="stylesheet" href="{{ asset('css/stock-notification.css') }}">

<div id="stock-low-overlay" class="stock-low-overlay" style="display:none;">
    <div id="stock-low-popup" class="stock-low-popup">

        <div class="stock-low-header">
            <h2 class="stock-low-title">⚠ Stok Hampir Habis!</h2>
            <img src="{{ asset('assets/material-symbols_close(2).svg') }}"
                 alt="Close"
                 class="stock-low-close-btn"
                 onclick="document.getElementById('stock-low-overlay').style.display='none'">
        </div>

        <div class="stock-low-items">
            @foreach($lowStockProducts as $product)
                <div class="stock-low-item">
                    <span>
                        {{ $product->name }} sisa {{ $product->stock }} pcs
                    </span>

                    <button
                        type="button"
                        class="add-to-cart-btn"
                        onclick="openBelanjaPopup(this)"
                        data-product-id="{{ $product->id }}"
                        data-product-name="{{ $product->name }}"
                        data-product-stock="{{ $product->stock }}"  
                    >
                        Tambah ke Daftar Belanja
                    </button>
                </div>
            @endforeach
        </div>

        <button
            type="button"
            class="stock-low-open-cart"
            onclick="
                document.getElementById('stock-low-overlay').style.display='none';
                document.getElementById('daftar-belanja')?.scrollIntoView({ behavior: 'smooth' });
            "
        >
            Buka Daftar Belanja
        </button>

    </div>
</div>
