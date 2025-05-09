@foreach($auto_scroll_products as $product)
<div class="col-md-3 col-6 col-lg-2">
    <div class="offer-card p-3 h-100">
        <a href="{{ url('restaurant/product-detail/'.encrypt($product->id)) }}" class="text-decoration-none text-dark d-block">
            @php
            $parsedPath = $product->image ? parse_url($product->image, PHP_URL_PATH) : null;
            $relativePath = $parsedPath ? str_replace('storage/', '', ltrim($parsedPath, '/')) : null;
        @endphp

        @if($relativePath && Storage::disk('public')->exists($relativePath))
            <img src="{{ $product->image }}" class="img-fluid mb-2" alt="{{ $product->name }}">
        @else
            <img src="{{ asset('restaurant_frontend/default-image.png') }}" class="img-fluid mb-2" alt="No Image">
        @endif
                  <h6 class="text-dark">{{ $product->name }}</h6>
            <p class="mb-0">
                <span class="price">{{ $product->getFinalPrice() }} ETB</span>
                <span class="price-old">{{ $product->price }} ETB</span>
            </p>
        </a>
        <div class="hover-buttons">
            <button onclick="window.location.href='{{ url('restaurant/product-detail/'.encrypt($product->id)) }}'" class="btn-view">
                <i class="bi bi-eye-fill"></i>
            </button>
            <button class="btn-cart add-to-cart" data-product="{{ $product->id }}">
                <i class="bi bi-cart-check-fill"></i>
            </button>
            <button class="btn-wishlist add-to-wishlist" data-product="{{ $product->id }}">
                <i class="bi bi-heart text-white"></i>
            </button>
        </div>
    </div>
</div>
@endforeach
