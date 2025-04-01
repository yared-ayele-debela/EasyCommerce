@extends('all_frontend_layouts.layouts')
@section('content')

<div class="container py-2">
    <div class="row d-flex justify-content-center align-items-center pt-3">
        <div class="custom-nav-container">
            <nav class="nav justify-content-between custom-nav p-2">
                <a href="#" class="custom-switch nav-link text-white fw-bold nav-active">Order Food</a>
                <a href="#" class="custom-switch nav-link text-dark fw-bold ">Reserve Hotel</a>
                <a href="#" class="custom-switch nav-link text-dark fw-bold">Buy Goods</a>
            </nav>
        </div>
    </div>

</div>

<div class="container-fluid mb-2">
    <div class="owl-carousel owl-theme sliders mt-4">
        @foreach ($banners as $banner)
        <div class="item mb-2 position-relative">
            <img src="{{ asset('storage/' . $banner->image) }}" alt="Product 1" class="img-fluid">
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

    <div class="d-flex justify-content-between align-items-center">
        <h4 class="mt-5 mb-2">Special Offers</h4>
        <h5 class="mt-5 mb-2"><a href="{{ url('restaurant/all-products') }}" class="text-dark">All</a></h5>
    </div>

    <div class="row g-3">
        <div class="owl-carousel owl-theme products mt-4">
            @foreach ($products as $product)
            <div class="item my-2">
                <div class="offer-card p-3 h-100">
                    <a href="{{ url('restaurant/product-detail/'.$product->id) }}">
                        @php
                        $off=$product->price-$product->getFinalPrice();
                        @endphp
                        @if($off>0)
                        <a class="bg-danger badge-offer" style="font-size: 12px;">
                            {{ $off }}
                         ETB OFF
                        </a>
                        @endif
                        <img src="{{ asset('storage/' . $product->image) }}" class="img-fluid mb-2" alt="{{ $product->name }}">
                        <h6 class="text-dark">{{ $product->name }}</h6>
                        <p class="mb-0">
                            <span class="price">{{ $product->getFinalPrice() }} ETB</span>
                            <span class="price-old">{{ $product->price }} ETB</span>
                        </p>
                    </a>
                    <div class="hover-buttons">
                        <button onclick="window.location.href='{{ url('restaurant/product-detail/'.$product->id) }}'" class="btn-view">
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
        <h5 class="mt-5 mb-2"><a href="{{ url('restaurant/all-products') }}" class="text-dark">All</a></h5>
    </div>
    <div class="row g-3">
        <div class="owl-carousel owl-theme products mt-4">
            @foreach ($most_popular_products as $product)
            <div class="item my-2">
                <div class="offer-card p-3 h-100">
                    <a href="{{ url('restaurant/product-detail/'.$product->id) }}">
                        <a class="bg-warning badge-offer" style="font-size: 12px;">
                            Most Popular
                        </a>
                        <img src="{{ asset('storage/' . $product->image) }}" class="img-fluid mb-2" alt="{{ $product->name }}">
                        <h6 class="text-dark">{{ $product->name }}</h6>
                        <p class="mb-0">
                            <span class="price">{{ $product->getFinalPrice() }} ETB</span>
                            <span class="price-old">{{ $product->price }} ETB</span>
                        </p>
                    </a>
                    <div class="hover-buttons">
                        <button onclick="window.location.href='{{ url('restaurant/product-detail/'.$product->id) }}'" class="btn-view">
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
        <h5 class="mt-5 mb-2"><a href="{{ url('restaurant/all-products') }}" class="text-dark">All</a></h5>
    </div>
    <div class="row g-3">
        <div class="owl-carousel owl-theme products mt-4">
            @foreach ($best_seller_products as $product)
            <div class="item my-2">
                <div class="offer-card p-3 h-100">
                    <a href="{{ url('restaurant/product-detail/'.$product->id) }}">
                        <a class="bg-info badge-offer" style="font-size: 12px;">
                            Best Seller
                        </a>
                        <img src="{{ asset('storage/' . $product->image) }}" class="img-fluid mb-2" alt="{{ $product->name }}">
                        <h6 class="text-dark">{{ $product->name }}</h6>
                        <p class="mb-0">
                            <span class="price">{{ $product->getFinalPrice() }} ETB</span>
                            <span class="price-old">{{ $product->price }} ETB</span>
                        </p>
                    </a>
                    <div class="hover-buttons">
                        <button onclick="window.location.href='{{ url('restaurant/product-detail/'.$product->id) }}'" class="btn-view">
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
        <h4 class="mt-5 mb-3"><a href="{{ url('restaurants') }}" class="text-dark">All</a></h4>
    </div>
    <div class="row" id="restaurantContainer">

    </div>
    <div class="row px-2 py-4 d-flex justify-content-center align-items-center flex-nowrap">
        <div class="col-md-4 col-4 text-center">
            <div class="icon-img-bg d-inline-block p-4 bg-primary rounded-circle">
                <img src="{{ asset('restaurant_frontend/assets/img/icon-delivery.png') }}" style="height: 70px;" alt="Delivery Icon">
            </div>
            <h5 class="pt-3 text-primary feature-title">FREE AND FAST DELIVERY</h5>
            <p class="text-primary feature-text">Free delivery for all orders over $140</p>
        </div>
        <div class="col-md-4 col-4 text-center">
            <div class="icon-img-bg d-inline-block p-4 bg-primary rounded-circle">
                <img src="{{ asset('restaurant_frontend/assets/img/Icon-Customer service.png') }}" style="height: 50px;" alt="Customer Service Icon">
            </div>
            <h5 class="pt-3 text-primary feature-title">24/7 CUSTOMER SUPPORT</h5>
            <p class="text-primary feature-text">Friendly 24/7 customer support</p>
        </div>
        <div class="col-md-4 col-4 text-center">
            <div class="icon-img-bg d-inline-block p-4 bg-primary rounded-circle">
                <img src="{{ asset('restaurant_frontend/assets/img/Icon-secure.png') }}" style="height: 50px;" alt="Secure Icon">
            </div>
            <h5 class="pt-3 text-primary feature-title">MONEY BACK GUARANTEE</h5>
            <p class="text-primary feature-text">We return money within 30 days</p>
        </div>
    </div>
</div>
<script>
   document.addEventListener("DOMContentLoaded", function () {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function (position) {
                let latitude = position.coords.latitude;
                let longitude = position.coords.longitude;

                // Fetch nearby restaurants from the Laravel backend
                fetchNearbyRestaurants(latitude, longitude);
            }, function (error) {
                console.error("Geolocation error:", error);
            });
        } else {
            alert("Geolocation is not supported by this browser.");
        }
    });

    function fetchNearbyRestaurants(lat, lng) {
        fetch(`/nearby-restaurants?lat=${lat}&lng=${lng}`)
            .then(response => response.json())
            .then(data => {
                let restaurantContainer = document.getElementById("restaurantContainer");
                restaurantContainer.innerHTML = ""; // Clear previous content

                data.forEach(restaurant => {
                    let restaurantCard = `
                        <div class="col-md-6">
                            <div class="resturant_card card mb-3 p-2">
                                <div class="row g-0">
                                    <div class="col-md-6">
                                        <a href="{{ url('restaurant/${restaurant.id}/detail') }}" class="">
                                        <img src="/storage/${restaurant.cover}" class="img-fluid rounded-start" alt="Restaurant">
                                        </a>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="card-body">
                                            <h5 class="card-title">${restaurant.name}</h5>
                                            <p class="mb-1">${restaurant.description.substring(0, 50)}...</p>
                                            <div class="mb-2">
                                                <span class="badge resturant_badge p-2">Around  km</span>
                                                <span class="badge resturant_badge p-2">Around min</span>
                                            </div>
                                            <p class="mb-1"><i class="bi bi-pin-map-fill text-primary"></i> ${restaurant.address}</p>
                                            <div class="d-flex justify-content-between align-items-center mt-3">
                                                <div class="text-warning me-2">
                                                    <span><span class="bi bi-star-fill text-primary"></span> ${restaurant.rating}</span>
                                                </div>
                                                <div><img src="/restaurant_frontend/assets/img/scooter-02.png" style="width: 20%;" alt=""> From 60 ETB</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>`;
                    restaurantContainer.innerHTML += restaurantCard;
                });
            })
            .catch(error => console.error("Error fetching restaurants:", error));
    }
</script>
@endsection

