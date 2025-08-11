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
            <img src="{{ asset('storage/' . $banner->image)??asset('no_banner.png') }}" alt="{{ $banner->link }}" style="border-radius:8px;" class="img-fluid" loading="lazy" >
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
    <div class="row justify-content-center">
        <div class="col-12 col-md-12">
            <div class="card border-0 rounded-3 shadow-sm overflow-hidden">
                <a href="{{ $after_special_offer_product_list->adv_links??'' }}" target="_blank">
                    <img src="{{ asset('storage/' . $after_special_offer_product_list->image) }}" alt="{{ $after_special_offer_product_list->title??'' }}" class="img-fluid w-100 d-block" style="max-height: 250px; ">
                </a>
            </div>
        </div>
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
    <div class="row justify-content-center">
        <div class="col-12 col-md-12">
            <div class="card border-0 rounded-3 shadow-sm overflow-hidden">
                <a href="{{ $after_best_seller_product_list->adv_links??'' }}" target="_blank">
                    <img src="{{ asset('storage/' . $after_best_seller_product_list->image) }}" alt="{{ $after_best_seller_product_list->title??'' }}" class="img-fluid w-100 d-block" style="max-height: 250px; ">
                </a>
            </div>
        </div>
    </div>
    @endif

    <div class="d-flex justify-content-between align-items-center">
        <h4 class="mt-5 mb-2">Latest Product</h4>
        <h5 class="mt-5 mb-2">
            <form action="{{ route('all-restaurant-products') }}" method="GET">
                @csrf
                <input type="hidden" name="type" value="latest">
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
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center">
            <h4 class="mt-2 mb-2">All Products</h4>
            <h4 class="mt-2 mb-2">
                <form action="{{ url('restaurant/all-products') }}" method="GET">
                    @csrf
                    <input type="hidden" name="type" value="best_seller">
                    <button type="submit" class="btn btn-outline-primary btn-sm">
                        <i class="bi bi-funnel"></i> Filter Products
                    </button>
                </form>
                </h3>
        </div>
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
        <a href="{{ url('restaurants') }}" class="btn btn-outline-primary btn-sm">
            <i class="bi bi-funnel"></i> Filter Restaurants
        </a>
    </div>

    <div id="auto-restaurant-container" class="row g-4">
    @include('all_frontend_layouts.partials.restaurant-cards')
</div>

<div class="row d-flex justify-content-center align-items-center">
    <div class="col-md-6 text-center">
        <button onclick="loadMoreRestaurants()" class="btn btn-primary my-3 text-center">
            <i class="bi bi-arrow-counterclockwise"></i> Load More
        </button>
        <div id="restaurant_loading" class="my-2 text-muted" style="display: none;">Loading...</div>
    </div>
</div>

    <div class="text-center my-1" id="restaurant_loading" style="display: none;">
        <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>

    @if($after_all_restaurants)
    <div class="row justify-content-center">
        <div class="col-12 col-md-12">
            <div class="card border-0 rounded-3 shadow-sm overflow-hidden">
                <a href="{{ $after_all_restaurants->adv_links??'' }}" target="_blank">
                    <img src="{{ asset('storage/' . $after_all_restaurants->image) }}" alt="{{ $after_all_restaurants->title??'' }}" class="img-fluid w-100 d-block" style="max-height: 250px; ">
                </a>
            </div>
        </div>
    </div>
    @endif

    <div class="d-flex justify-content-between align-items-center">
<h4 class="mt-5 mb-3">Nearby Restaurants</h4>
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
    document.addEventListener("DOMContentLoaded", function() {
        const isMobile = /iPhone|iPad|iPod|Android/i.test(navigator.userAgent);
        const splashShown = localStorage.getItem('splashShown');

        if (isMobile && !splashShown) {
            const splash = document.getElementById('splash-screen');
            splash.style.display = 'flex';

            setTimeout(() => {
                splash.style.display = 'none';
                localStorage.setItem('splashShown', 'true');
            }, 3000); // show for 3 seconds
        }
    });

</script>

<script>
    let lastFetchTime = 0;

function fetchNearbyRestaurants(lat, lng) {
    fetch(`/restaurants/nearby?latitude=${lat}&longitude=${lng}`)
        .then(response => response.json())
        .then(data => {
            if (data.success && data.restaurants) {
                renderRestaurants(data.restaurants);
                console.log(`Fetched restaurants at ${new Date().toLocaleTimeString()}`);
            } else {
                console.warn('No restaurants data received.');
            }
        })
        .catch(error => console.error('Error fetching restaurants:', error));
}

function startNearbyRestaurantTracking() {
    if ('geolocation' in navigator) {
        navigator.geolocation.watchPosition(
            position => {
                const now = Date.now();
                if (now - lastFetchTime >= 5000) { // every 5 seconds
                    lastFetchTime = now;

                    const latitude = position.coords.latitude;
                    const longitude = position.coords.longitude;

                    localStorage.setItem('user_lat', latitude);
                    localStorage.setItem('user_lng', longitude);

                    fetchNearbyRestaurants(latitude, longitude);
                }
            },
            error => {
                console.error('Geolocation error:', error.message);
            },
            {
                enableHighAccuracy: true,
                maximumAge: 0,
                timeout: 5000
            }
        );
    } else {
        console.warn('Geolocation is not supported by this browser.');
    }
}

// Call this function when your page loads
document.addEventListener('DOMContentLoaded', () => {
    startNearbyRestaurantTracking();
});


        const storageUrl = "{{ asset('storage') }}";

    function renderRestaurants(restaurants) {
        const container = document.getElementById('restaurant-container');
        container.innerHTML = '';

        restaurants.forEach(restaurant => {

            const bannerSrc = restaurant.cover
            ? `${storageUrl}/${restaurant.cover}`
            : 'restaurant_frontend/default-image.png'; // adjust path as needed


            const isOutOfRange = parseFloat(restaurant.diff_distance) > parseFloat(restaurant.delivery_radius);

            const outOfRangeHTML = isOutOfRange ?
                `
            <div class="position-absolute top-0 end-0 m-2">
                <button class="btn btn-sm btn-outline-danger rounded-pill px-3" disabled>
                    <img src="{{ asset('restaurant_frontend/alert.png') }}" width="20" alt=""> Out of Range
                </button>
            </div>
          ` :
                '';
            container.innerHTML += `
                <div class="col-lg-6 col-md-6">
    <div class="offer-card overflow-hidden mb-4">
        <div class="row g-0 align-items-stretch">
                            <div class="col-md-4 col-4">
                            <a href="{{ url('restaurant/${restaurant.id}/detail') }}">
                                <img src="${bannerSrc}"  class="img-fluid object-fit-cover w-100 h-100 p-2"
                         style="min-height: 180px; max-height: 230px;"
                                 onerror="this.onerror=null; this.src='{{ asset('restaurant_frontend/default-image.png') }}';"
                                >
                            </a>
                            </div>
                            <div class="col-8 col-sm-8">
                               <div class="card-body d-flex flex-column h-100 py-3 px-4">
                                   ${outOfRangeHTML}
                                      <h5 class="card-title mb-1 text-truncate" title="${restaurant.name}">
                                        ${restaurant.name}</h5>
                                   <p class="text-muted d-none d-md-block">${restaurant.description.substring(0, 60)}...</p>
                                    <div class="mb-2 d-flex flex-wrap gap-2">
                                    <span class="badge bg-light text-dark px-3 py-2 rounded-pill">
                                        <i class="bi bi-geo-alt-fill text-danger me-1"></i>${restaurant.distance} km
                                    </span>
                                    <span class="badge bg-light text-dark px-3 py-2 rounded-pill">
                                        <i class="bi bi-clock-fill text-primary me-1"></i>${restaurant.time} min
                                    </span>
                                </div>

                                   <a  href="https://www.google.com/maps?q=${restaurant.latitude},${restaurant.longitude}"
                         target="_blank" class="small text-muted mb-2">
                                    <i class="bi bi-pin-map-fill text-primary me-1"></i>
                                       ${restaurant.address} , ${restaurant.city}, ${restaurant.state}, Ethiopia
                                </a>

                                <div class="mt-auto d-flex justify-content-between align-items-center">
                                    <div class="small text-primary">
                                        <i class="bi bi-star-fill text-primary me-1"></i>${restaurant.rating}
                                    </div>
                                    <div class="d-flex align-items-center gap-2 small text-muted">
                                        <img src="{{ asset('restaurant_frontend/assets/img/scooter-02.png') }}" alt="Delivery" style="width: 22px;">
                                        From ${restaurant.start_from} ETB
                                    </div>
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

