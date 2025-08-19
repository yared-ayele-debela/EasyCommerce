@foreach($auto_scroll_products as $product)
@php
    $off = $product->price - $product->getFinalPrice();
    $restLat = $product->restaurant->latitude;
    $restLng = $product->restaurant->longitude;
    $radius = $product->restaurant->delivery_radius;
@endphp
                <div class="ecom-product">

<div class="product-card"
     data-restaurant-lat="{{ $restLat }}"
     data-restaurant-lng="{{ $restLng }}"
     data-delivery-radius="{{ $radius }}"
     data-product-id="{{ $product->id }}">


    {{-- Product Image --}}
    <a href="{{ url('restaurant/product-detail/' . encrypt($product->id)) }}" class="text-decoration-none">
        <img src="{{ asset('storage/'.$product->image) ?? asset('images/default-product.jpg') }}"
             alt="{{ $product->name }}" class="product-image" >
    </a>

    {{-- Product Info --}}
    <div class="product-info">
        <div class="product-name">{{ $product->name }}</div>
        <div class="product-pricing">
            @if($product->getFinalPrice() < $product->price)
                <span class="old-price">{{ $product->price }} ETB</span>
                <span class="new-price">{{ $product->getFinalPrice() }} ETB</span>
            @else
                <span class="new-price">{{ $product->price }} ETB</span>
            @endif
        </div>
    </div>

    {{-- Action Buttons --}}
    <div class="action-buttons">
        <button class="action-btn add-to-wishlist" data-product="{{ $product->id }}" aria-label="Add to Wishlist" title="Add to Wishlist">
            <i class="fas fa-heart"></i>
        </button>

        <button class="action-btn add-to-cart" data-product="{{ $product->id }}" data-product-price="{{ $product->getFinalPrice() }}" aria-label="Add to Cart" title="Add to Cart">
            <i class="fas fa-shopping-cart"></i>
        </button>

        <button class="action-btn" onclick="window.location.href='{{ url('restaurant/product-detail/' . encrypt($product->id)) }}'"
                aria-label="View Details" title="View Details">
            <i class="fas fa-eye"></i>
        </button>
    </div>
</div>
                </div>
@endforeach
