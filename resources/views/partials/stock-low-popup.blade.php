<div id="stock-low-popup" class="stock-low-popup" style="display: none;">
    <div class="stock-low-content">
        <h2 class="stock-low-title">!Stok Hampir Habis!</h2>
        <div class="stock-low-items">
            @foreach($lowStockProducts as $product)
            <div class="stock-low-item">
                <span class="stock-info">{{ $product->name }} sisa {{ $product->stock }} pcs</span>
                <button class="add-to-cart-btn" 
                        onclick="addToCart({{ $product->id }}, '{{ $product->name }}')"
                        data-product-id="{{ $product->id }}">
                    Tambah ke Daftar Belanja
                </button>
            </div>
            @endforeach
        </div>
        <button class="open-cart-btn" onclick="window.location.href='{{ route('daftar.belanja.index') }}'">
            Buka Daftar Belanja
        </button>
    </div>
</div>