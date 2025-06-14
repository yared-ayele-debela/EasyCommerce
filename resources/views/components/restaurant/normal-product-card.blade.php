@props(['product', 'badge','bgColor'])
@php
use App\Services\LocationService;
$locationService = new LocationService();

    $off = $product->price - $product->getFinalPrice();
    $parsedPath = $product->image ? parse_url($product->image, PHP_URL_PATH) : null;
    $relativePath = $parsedPath ? str_replace('storage/', '', ltrim($parsedPath, '/')) : null;
    $imageSrc = ($relativePath && Storage::disk('public')->exists($relativePath))
        ? $product->image
        : asset('restaurant_frontend/default-image.png');

    $userLat = session(key: 'user_lat');
    $userLng = session('user_lng');
    // dd($userLat, $userLng);
    $restLat = $product->restaurant->latitude;
    $restLng = $product->restaurant->longitude;

    $distance = $locationService->getDistance($userLat, $userLng, $restLat, $restLng);
@endphp

<div class="item my-2">
    <div class="offer-card p-2 h-100">
        <a href="{{ url('restaurant/product-detail/' . encrypt($product->id)) }}" class="text-decoration-none text-dark d-block">
             @if($badge)
            <span class="{{ $bgColor }}" style="text-shadow:5px 5px 15px; color:green;">
                {{ $badge }}
            </span>
            @endif
            <img src="{{ $imageSrc }}" class="img-fluid mb-2 restaurant-product-image" alt="{{ $product->name }}" >
            <h6 class="text-dark">{{ $product->name }}</h6>
            <p class="mb-0">
                @if($product->getFinalPrice() < $product->price)
                <span class="price">{{ $product->getFinalPrice() }} ETB</span>
                <span class="price-old">{{ $product->price }} ETB</span>
                @else
                <span class="price">{{ $product->price }} ETB</span>
                @endif

            </p>
        </a>
        <div class="hover-buttons">
            <button onclick="window.location.href='{{ url('restaurant/product-detail/' . encrypt($product->id)) }}'" class="btn-view">
                <i class="bi bi-eye-fill"></i>
            </button>
             @if($distance > $product->restaurant->delivery_radius)
            <button class="btn-cart add-to-cart" data-product="{{ $product->id }}" data-product-price="{{ $product->getFinalPrice() }}">
                <i class="bi bi-cart-check-fill"></i>
            </button>
            @else
             <div class="tooltip-wrapper">
                <button class="btn btn-danger" disabled>
                    <i class="bi bi-cart-check-fill"></i>
                </button>
                </div>
            @endif

            <button class="btn-wishlist add-to-wishlist" data-product="{{ $product->id }}">
                <i class="bi bi-heart text-white"></i>
            </button>
        </div>
    </div>
</div>
