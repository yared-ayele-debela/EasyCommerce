@extends('all_frontend_layouts.layouts')
@section('content')
<div class="container py-2">
    <div class="row d-flex justify-content-center align-items-center pt-3">
        <div class="custom-nav-container">
            <nav class="nav justify-content-between custom-nav p-2">
                <a href="{{ url('/') }}" class="custom-switch nav-link text-white fw-bold {{ request()->is('/')?'nav-active':'' }}">Order Food</a>
                <a href="{{ url('/hotel') }}" class="custom-switch nav-link text-dark fw-bold {{ request()->is('/hotel')?'nav-active':'' }}">Reserve Hotel</a>
                <a href="{{ url('/ecommerce') }}" class="custom-switch nav-link text-dark fw-bold {{ request()->is('ecommerce')?' text-white nav-active':'' }}">Buy Goods</a>
            </nav>
        </div>
    </div>
</div>
<div class="container-fluid mb-2">
    <div class="owl-carousel owl-theme sliders mt-4">
        @foreach ($banners as $banner)
        <div class="item mb-2 position-relative">
            @if ($banner && $banner->image && Storage::exists('public/' . $banner->image))
                <img src="{{ asset('storage/' . $banner->image) }}" alt="{{ $banner->link }}" class="img-fluid">
            @else
                <img src="{{asset('no_banner.png') }}" class="img-fluid" alt="{{ $banner->link }}"> <!-- Optionally display a fallback message or image -->
            @endif
                <div class="overlay-text position-absolute text-white p-3">
                <h3>{{ $banner->title }}</h3>
                <p>{{ $banner->description }}</p>
                <a href="{{ $banner->link }}" class="btn bg-primary text-white" target="_blank">Buy Now</a>
            </div>
        </div>
       @endforeach
    </div>
</div>

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center">
        <h4 class="mt-5 mb-2">Categories</h4>
        <h5 class="mt-5 mb-2"><a href="{{ route('restaurant.categories') }}" class="text-dark">All</a></h5>
    </div>
       <div class="row g-3 my-1">
        <div class="owl-carousel owl-theme categories mt-4">
            @foreach ($categories as $category)
            <div class="item mb-2">
                <div class="category-item">
                    <a href="{{ url('restaurant/category/'.$category->id) }}">
                        <img src="{{ asset('storage/' . $category->image) }}" class="p-2 shadow" style="border:4px solid rgb(162, 159, 159);" alt="American">
                        <p class="text-dark">{{ $category->name }}</p>
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    @include('all_frontend_layouts.add_to_cart_modal')
    <div class="d-flex justify-content-between align-items-center">
        <h4 class="mt-3 mb-2">Special Offers</h4>
        <h5 class="mt-3 mb-2">
            <form action="{{ route('all-restaurant-products') }}" method="GET">
                @csrf
                <input type="hidden" name="type" value="specail_offer">
                <button type="submit" class="text-dark border-0 bg-white">
                    All
                </button>
            </form>
        </h5>
    </div>
    <div class="row g-3">
        <div class="owl-carousel owl-theme products mt-4">
            @foreach ($products as $product)
            <div class="item my-2">
                <div class="offer-card p-3 h-100">
                    <a href="{{ url('restaurant/product-detail/'.encrypt($product->id)) }}" class="text-decoration-none text-dark d-block">
                        @php
                            $off = $product->price - $product->getFinalPrice();
                        @endphp
                        @if($off > 0)
                            <div class="btn btn-sm btn-primary">
                                {{ $off }} ETB OFF
                            </div>
                        @endif
                        <img src="{{ asset('storage/' . $product->image) }}" class="img-fluid mb-2" alt="{{ $product->name }}">
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
        </div>
    </div>
    <div class="d-flex justify-content-between align-items-center">
        <h4 class="mt-5 mb-2">Most Popular</h4>
        <h5 class="mt-5 mb-2">
            <form action="{{ route('all-restaurant-products') }}" method="GET">
                @csrf
                <input type="hidden" name="type" value="most_popular">
                <button type="submit" class="text-dark border-0 bg-white">
                    All
                </button>
            </form>
        </h5>
    </div>
    <div class="row g-3">
        <div class="owl-carousel owl-theme products mt-4">
            @foreach ($most_popular_products as $product)
            <div class="item my-2">
                <div class="offer-card p-3 h-100">
                    <a href="{{ url('restaurant/product-detail/'.encrypt($product->id)) }}" class="text-decoration-none text-dark d-block">

                        <span class="btn btn-sm btn-info text-white">
                            Popular
                        </span>
                        <img src="{{ asset('storage/' . $product->image) }}" class="img-fluid mb-2" alt="{{ $product->name }}">
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
        </div>
    </div>
    <div class="d-flex justify-content-between align-items-center">
        <h4 class="mt-5 mb-2">Best Seller</h4>
        <h5 class="mt-5 mb-2">
             <form action="{{ route('all-restaurant-products') }}" method="GET">

                @csrf
                <input type="hidden" name="type" value="best_seller">
                <button type="submit" class="text-dark border-0 bg-white">
                    All
                </button>
            </form>
        </h5>
    </div>
    <div class="row g-3">
        <div class="owl-carousel owl-theme products mt-4">
            @foreach ($best_seller_products as $product)
            <div class="item my-2">
                <div class="offer-card p-3 h-100">
                    <a href="{{ url('restaurant/product-detail/'.encrypt($product->id)) }}" class="text-decoration-none text-dark d-block">

                            <span class="btn btn-sm btn-warning text-white">
                                Best seller
                            </span>
                        <img src="{{ asset('storage/' . $product->image) }}" class="img-fluid mb-2" alt="{{ $product->name }}">
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
        </div>
    </div>
    <div class="d-flex justify-content-between align-items-center">
        <h4 class="mt-5 mb-2">Latest Product</h4>
        <h5 class="mt-5 mb-2">
             <form action="{{ url('restaurant/all-products') }}" method="GET">

                @csrf
                <input type="hidden" name="type" value="best_seller">
                <button type="submit" class="text-dark border-0 bg-white">
                    All
                </button>
            </form>
        </h5>
    </div>
    <div class="row g-3">
        <div class="owl-carousel owl-theme products mt-4">
            @foreach ($latest_products as $product)
            <div class="item my-2">
                <div class="offer-card p-3 h-100">
                    <a href="{{ url('restaurant/product-detail/'.encrypt($product->id)) }}" class="text-decoration-none text-dark d-block">
                            <div class="btn btn-sm btn-danger text-white">
                              Latest
                            </div>
                        <img src="{{ asset('storage/' . $product->image) }}" class="img-fluid mb-2" alt="{{ $product->name }}">
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
        </div>
    </div>
    <div class="d-flex justify-content-between align-items-center">
        <h4 class="mt-5 mb-3">All Restaurants Nearby</h4>
        <h5 class="mt-5 mb-3"><a href="{{ url('restaurants') }}" class="text-dark">All</a></h5>
    </div>
    <div class="row" id="restaurant-container">
        <!-- Placeholder Cards -->
        <div class="col-md-6">
            <div class="card placeholder-glow mb-3 p-2">
                <div class="row g-0">
                    <div class="col-md-6">
                        <div class="placeholder rounded w-100 h-100" style="height: 150px;"></div>
                    </div>
                    <div class="col-md-6">
                        <div class="card-body">
                            <h5 class="placeholder col-6"></h5>
                            <p class="placeholder col-10"></p>
                            <p class="placeholder col-10"></p>
                            <p class="placeholder col-10"></p>
                            <p class="placeholder col-8"></p>
                            <span class="placeholder col-4"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card placeholder-glow mb-3 p-2">
                <div class="row g-0">
                    <div class="col-md-6">
                        <div class="placeholder rounded w-100 h-100" style="height: 150px;"></div>
                    </div>
                    <div class="col-md-6">
                        <div class="card-body">
                            <h5 class="placeholder col-6"></h5>
                            <p class="placeholder col-10"></p>
                            <p class="placeholder col-10"></p>
                            <p class="placeholder col-10"></p>
                            <p class="placeholder col-8"></p>
                            <span class="placeholder col-4"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('all_frontend_layouts.partial_index')
</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(position => {
                const latitude = position.coords.latitude;
                const longitude = position.coords.longitude;

                fetch(`/restaurants/nearby?latitude=${latitude}&longitude=${longitude}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            renderRestaurants(data.restaurants);
                        }
                    })
                    .catch(error => console.error('Error fetching restaurants:', error));
            }, () => {
                alert("Location access denied. Enable GPS to find nearby restaurants.");
            });
        } else {
            alert("Geolocation is not supported by your browser.");
        }
    });

    function renderRestaurants(restaurants) {
        const container = document.getElementById('restaurant-container');
        container.innerHTML = '';

        restaurants.forEach(restaurant => {
            container.innerHTML += `
                <div class="col-md-6">
                    <div class=" offer-card mb-3 p-2">
                        <div class="row g-0">
                            <div class="col-md-6">
                            <a href="{{ url('restaurant/${restaurant.id}/detail') }}">
                                <img src="/storage/${restaurant.cover}" class="img-fluid rounded-start" alt="Restaurant">
                            </a>
                            </div>
                            <div class="col-md-6">
                                <div class="card-body">
                                    <h5 class="card-title">${restaurant.name}</h5>
                                    <p class="mb-1">${restaurant.description.substring(0, 50)}...</p>
                                    <div class="mb-2">
                                        <span class="badge resturant_badge p-2">Around ${restaurant.distance.toFixed(2)} km</span>
                                    </div>
                                    <p class="mb-1"> <i class="bi bi-pin-map-fill text-primary"></i> ${restaurant.address}</p>
                                    <div class="d-flex justify-content-between align-items-center mt-3">
                                    <div class="text-warning me-2">

                                        <span><span class="bi bi-star-fill text-primary"></span> ${restaurant.rating}</span>
                                    </div>
                                    <div><img src="{{ asset('restaurant_frontend/assets/img/scooter-02.png') }}" style="width: 20%;" alt=""> From ${restaurant.start_from} ETB</div>
                                </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            `;
        });
    }
    </script>

@endsection

