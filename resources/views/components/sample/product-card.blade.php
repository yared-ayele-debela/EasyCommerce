<div class="product-card">
    <img src="{{ asset('storage/'.$product->image) ?? asset('images/default-product.jpg') }}" alt="{{ $product->name }}"
        class="product-image">
    <div class="product-info">
        <div class="product-name">{{ $product->name }}</div>
        <div class="product-pricing">
            @if($product->price > $product->price)
                <span class="old-price">{{ $product->price }}</span>
            @endif
            <span class="new-price">{{ $product->price }}</span>
        </div>
    </div>
    <div class="action-buttons">
        <button class="action-btn" aria-label="Add to Wishlist" title="Add to Wishlist">
            <i class="fas fa-heart"></i>
        </button>
        <button class="action-btn" aria-label="Add to Cart" title="Add to Cart">
            <i class="fas fa-shopping-cart"></i>
        </button>
        <button class="action-btn" aria-label="View Details" title="View Details">
            <i class="fas fa-eye"></i>
        </button>
    </div>
</div>
