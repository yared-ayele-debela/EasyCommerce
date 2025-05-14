@props(['product'])
@php
    $off = $product->price - $product->getFinalPrice();

    $parsedPath = $product->image ? parse_url($product->image, PHP_URL_PATH) : null;
    $relativePath = $parsedPath ? str_replace('storage/', '', ltrim($parsedPath, '/')) : null;
    $imageSrc = ($relativePath && Storage::disk('public')->exists($relativePath))
        ? $product->image
        : asset('restaurant_frontend/default-image.png');
@endphp

<div class="item my-2">
    <div class="offer-card p-3 h-100">
        <a href="{{ url('restaurant/product-detail/' . encrypt($product->id)) }}" class="text-decoration-none text-dark d-block">
            @if($off > 0)
            <div class="btn btn-sm btn-primary" style="z-index: 1100 !important;">
                {{ $off }} ETB OFF
            </div>
            @endif
            <img src="{{ $imageSrc }}" class="img-fluid mb-2" alt="{{ $product->name }}">
            <h6 class="text-dark">{{ $product->name }}</h6>
            <p class="mb-0">
                <span class="price">{{ $product->getFinalPrice() }} ETB</span>
                <span class="price-old">{{ $product->price }} ETB</span>
            </p>
        </a>

        <div class="hover-buttons">
            <button onclick="window.location.href='{{ url('restaurant/product-detail/' . encrypt($product->id)) }}'" class="btn-view">
                <i class="bi bi-eye-fill"></i>
            </button>
            <button class="btn-cart add-to-cart" data-product="{{ $product->id }}" data-product-price="{{ $product->price }}">
                <i class="bi bi-cart-check-fill"></i>
            </button>
            <button class="btn-wishlist add-to-wishlist" data-product="{{ $product->id }}">
                <i class="bi bi-heart text-white"></i>
            </button>
        </div>
    </div>
</div>
