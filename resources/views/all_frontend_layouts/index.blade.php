@php
use Illuminate\Support\Facades\Storage;
@endphp
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
            @php
            $imagePath = $banner->image
            ? ltrim(parse_url($banner->image, PHP_URL_PATH), '/')
            : null;
            // Remove 'storage/' prefix to match storage/app/public
            $relativePath = $imagePath ? str_replace('storage/', '', $imagePath) : null;
            @endphp

            @if($relativePath && Storage::disk('public')->exists($relativePath))
            <img src="{{ $banner->image }}" alt="{{ $banner->link }}" style="border-radius:8px;" class="img-fluid">
            @else
            <img src="{{ asset('no_banner.png') }}" class="img-fluid" style="border-radius:8px;"  alt="{{ $banner->link }}">
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
             <x-restaurant.category-card :category="$category" />
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
                <x-restaurant.product-card :product="$product" />
            @endforeach
        </div>
    </div>
     @if($after_special_offer_product_list)
     <div class="my-3">
        <a href="{{ $after_special_offer_product_list->adv_links??'' }}" target="_blank" rel="noopener noreferrer" class="text-decoration-none d-block">
            <div class="fix-banner-box rounded-3 overflow-hidden position-relative"
                 style="background: url('{{ $after_special_offer_product_list->image }}') center center / cover no-repeat; min-height: 200px;">
                <span class="visually-hidden">{{ $after_special_offer_product_list->title??'' }}</span>
            </div>
        </a>
    </div>
    @endif
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
            <x-restaurant.normal-product-card :product="$product" badge="Most Popular" bgColor="btn-info" />
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
             <x-restaurant.normal-product-card :product="$product" badge="Best Seller" bgColor="btn-warning" />
            @endforeach
        </div>
    </div>
     @if($after_best_seller_product_list)
     <div class="my-3">
        <a href="{{ $after_best_seller_product_list->adv_links??'' }}" target="_blank" rel="noopener noreferrer" class="text-decoration-none d-block">
            <div class="fix-banner-box rounded-3 overflow-hidden position-relative"
                 style="background: url('{{ $after_best_seller_product_list->image }}') center center / cover no-repeat; min-height: 200px;">
                <span class="visually-hidden">{{ $after_best_seller_product_list->title??'' }}</span>
            </div>
        </a>
    </div>
    @endif
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
              <x-restaurant.normal-product-card :product="$product" badge="Latest" bgColor="btn-danger" />
            @endforeach
        </div>
    </div>
    <div class="d-flex justify-content-between align-items-center">
        <h4 class="mt-5 mb-2">All Products</h4>
    </div>

    <div id="product-container" class="row g-4">
        @include('all_frontend_layouts.partials.product-cards')
    </div>
    <div class="row d-flex justify-content-center align-items-center">
        <div class="col-md-6 text-center">
            <button onclick="loadMoreProducts()" class="btn btn-primary my-3 text-center"><i class="bi bi-arrow-counterclockwise"></i> Load More</button>
        </div>
    </div>

    <div class="text-center my-1" id="loading" style="display: none;">
        <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>


    <div class="d-flex justify-content-between align-items-center">
        <h4 class="mt-5 mb-2">All Restaurants</h4>
    </div>

    <div id="auto-restaurant-container" class="row g-4">
        @include('all_frontend_layouts.partials.restaurant-cards')
    </div>
    <div class="row d-flex justify-content-center align-items-center">
        <div class="col-md-6 text-center">
            <button onclick="loadMoreRestaurants()" class="btn btn-primary my-3 text-center"><i class="bi bi-arrow-counterclockwise"></i> Load More</button>
        </div>
    </div>

    <div class="text-center my-1" id="restaurant_loading" style="display: none;">
        <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>
     @if($after_all_restaurants)
     <div class="my-3">
        <a href="{{ $after_all_restaurants->adv_links??'' }}" target="_blank" rel="noopener noreferrer" class="text-decoration-none d-block">
            <div class="fix-banner-box rounded-3 overflow-hidden position-relative"
                 style="background: url('{{ $after_all_restaurants->image }}') center center / cover no-repeat; min-height: 200px;">
                <span class="visually-hidden">{{ $after_all_restaurants->title??'' }}</span>
            </div>
        </a>
    </div>
    @endif

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
    document.addEventListener('DOMContentLoaded', function() {
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
                    <div class="offer-card mb-4 p-2">
                        <div class="row g-0">
                            <div class="col-md-6">
                            <a href="{{ url('restaurant/${restaurant.id}/detail') }}">
                                <img src="${restaurant.cover}" class="img-fluid rounded-start" alt="Restaurant" style="max-height:230px;"
                                 onerror="this.onerror=null; this.src='{{ asset('restaurant_frontend/default-image.png') }}';"
                                >
                            </a>
                            </div>
                            <div class="col-md-6">
                                <div class="card-body">
                                    <h5 class="card-title">${restaurant.name}</h5>
                                    <p class="mb-1">${restaurant.description.substring(0, 50)}...</p>
                                    <div class="mb-2">
                                        <span class="badge resturant_badge p-2">Around ${ restaurant.distance } km</span>
                                        <span class="badge resturant_badge p-2">Around ${ restaurant.time } min</span>
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
