@props(['product'])
@php
    use App\Services\LocationService;

    $off = $product->price - $product->getFinalPrice();


    $restLat = $product->restaurant->latitude;
    $restLng = $product->restaurant->longitude;
    $radius = $product->restaurant->delivery_radius;
@endphp

<div class="item my-2 product-card"
     data-restaurant-lat="{{ $restLat }}"
     data-restaurant-lng="{{ $restLng }}"
     data-delivery-radius="{{ $radius }}"
     data-product-id="{{ $product->id }}">
    <div class="offer-card p-1 h-100">
        <a href="{{ url('restaurant/product-detail/' . encrypt($product->id)) }}" class="text-decoration-none text-dark d-block">
            @if($off > 0)
                <div class="btn btn-sm" style="z-index: 1100 !important;background-color: rgba(41, 210, 78, 0.2);">
                    <strong>{{ $off }} ETB OFF</strong>
                </div>
            @endif
            <img src="{{ asset('storage/' . $product->image) ?? asset('restaurant_frontend/default-image.png') }}"  class="img-fluid mb-2 restaurant-product-image" alt="{{ $product->name }}" loading="lazy">
            <h6 class="text-dark">{{ $product->name }}</h6>
            @if($product->getFinalPrice() < $product->price)
                <span class="price">{{ $product->getFinalPrice() }} ETB</span>
                <span class="price-old">{{ $product->price }} ETB</span>
            @else
                <span class="price">{{ $product->price }} ETB</span>
            @endif
        </a>

        <div class="hover-buttons">
            <button onclick="window.location.href='{{ url('restaurant/product-detail/' . encrypt($product->id)) }}'" class="btn-view">
                <i class="bi bi-eye-fill"></i>
            </button>

            {{-- Cart button visibility controlled via JS --}}
            <button class="btn-cart add-to-cart d-none" data-product="{{ $product->id }}" data-product-price="{{ $product->getFinalPrice() }}">
                <i class="bi bi-cart-check-fill"></i>
            </button>
            <button class="btn btn-danger cart-disabled d-none" disabled>
                <i class="bi bi-cart-check-fill"></i>
            </button>

            <button class="btn-wishlist add-to-wishlist" data-product="{{ $product->id }}">
                <i class="bi bi-heart text-white"></i>
            </button>
        </div>
    </div>
</div>

