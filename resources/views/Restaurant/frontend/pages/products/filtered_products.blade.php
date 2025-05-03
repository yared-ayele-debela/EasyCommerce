@extends('all_frontend_layouts.layouts')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="header">
            <button class="btn btn-link text-dark" onclick="history.back()">
                <i class="bi bi-arrow-left"></i>
             </button>
            <h5 class="my-4 text-dark text-center">{{ ucfirst(str_replace('_', ' ', $filter)) }} Products</h5>
        </div>
        @forelse ($products as $product)
        <div class="col-md-2 col-6 my-2">
            <div class="offer-card p-3 h-100">
                <a href="{{ url('restaurant/product-detail/'.encrypt($product->id)) }}">
                    @php
                    $off = $product->price - $product->getFinalPrice();
                    @endphp
                    @if($off > 0)
                    <span class="badge-offer">
                        {{ $off }} ETB OFF
                    </span>
                    @endif
                    @php
                        // Safely extract relative storage path from full URL or asset path
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
                    <button class="btn-cart add-to-cart" data-product="{{ $product->id }}"  data-product-price="{{ $product->price }}">
                        <i class="bi bi-cart-check-fill"></i>
                    </button>
                    <button class="btn-wishlist add-to-wishlist" data-product="{{ $product->id }}">
                        <i class="bi bi-heart text-white"></i>
                    </button>
                </div>
            </div>
        </div>
        @empty
        <p class="text-center text-muted">No products found.</p>
        @endforelse
    </div>
</div>
@endsection

