@extends('all_frontend_layouts.layouts')
@section('content')
<div class="container py-2">
    <div class="row d-flex justify-content-center align-items-center pt-3">
        <div class="custom-nav-container">
            <nav class="nav justify-content-between custom-nav p-2">
                <a href="{{ url('/') }}" class="custom-switch nav-link fw-bold {{ request()->is('/')?' text-white nav-active':'text-dark' }}">Order
                    Food</a>
                <a href="{{ url('/hotel') }}" class="custom-switch nav-link fw-bold {{ request()->is('hotel')?' text-white nav-active':'' }}">Reserve
                    Hotel</a>
                    <a href="{{ url('/ecommerce') }}" class="custom-switch nav-link text-dark fw-bold {{ request()->is('ecommerce')?' text-white nav-active':'' }}">Buy Goods</a>
                </nav>
        </div>
    </div>
</div>
<div class="container-fluid py-2">
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="offer-card p-3 rounded-3 shadow-sm bg-white">
                <form action="{{ route('room.indexs') }}" method="GET">
                    <div class="row g-3 align-items-end">
                        <div class="col-md-3 col-12">
                            <label for="search" class="form-label fw-semibold">Room Type</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="bi bi-search"></i></span>
                                <input type="text" name="search" id="search" class="form-control" placeholder="e.g. Deluxe, Standard">
                            </div>
                        </div>
                        <div class="col-md-2 col-6">
                            <label for="min_price" class="form-label fw-semibold">Min Price (ETB)</label>
                            <div class="input-group">
                                <span class="input-group-text">ETB</span>
                                <input type="number" id="min_price" class="form-control shadow-sm" placeholder="1000">
                            </div>
                        </div>
                        <div class="col-md-2 col-6">
                            <label for="max_price" class="form-label fw-semibold">Max Price (ETB)</label>
                            <div class="input-group">
                                <span class="input-group-text">ETB</span>
                                <input type="number" id="max_price" class="form-control shadow-sm" placeholder="5000">
                            </div>
                        </div>
                        <div class="col-md-1 col-6">
                            <label for="capacity" class="form-label fw-semibold">Min Capacity</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-people"></i></span>
                                <input type="number" id="capacity" class="form-control shadow-sm" placeholder="e.g. 2">
                            </div>
                        </div>
                        <div class="col-md-1 col-6">
                            <label for="total_adult" class="form-label fw-semibold">Adults</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-people"></i></span>
                                <input type="number" id="total_adult" class="form-control shadow-sm" placeholder="2">
                            </div>
                        </div>
                        <div class="col-md-1 col-6">
                            <label for="total_child" class="form-label fw-semibold">Children</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-person-walking"></i></span>
                                <input type="number" id="total_child" class="form-control shadow-sm" placeholder="2">
                            </div>
                        </div>
                        <div class="col-md-1 col-6">
                            <label for="total_infant" class="form-label fw-semibold">Infants</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">
                                    <img src="{{ asset('restaurant_frontend/baby.png') }}" width="20" alt="Baby Icon">
                                </span>
                                <input type="number" name="total_infant" id="total_infant" class="form-control w-50" placeholder="2">
                            </div>
                        </div>
                        <div class="col-md-1 col-6">
                            <button type="submit" class="btn btn-primary ">
                                <i class="bi bi-search"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>

<div class="container-fluid ">
    <div class="owl-carousel owl-theme sliders mt-4">
        @foreach ($banners as $banner)
        <div class="item mb-2 position-relative">
            <a href="{{ $banner->link }}" target="_blank" class="text-decoration-none text-white">
            <img src="{{ asset('storage/' . $banner->image) }}" alt="Product 1" class="img-fluid">
            <div class="overlay-text position-absolute text-white p-3">
                <h3>{{ $banner->title }}</h3>
                <p>{{ $banner->description }}</p>
                <a href="{{ $banner->link }}" class="btn bg-primary text-white" target="_blank">Buy Now</a>
            </div>
        </a>
        </div>
        @endforeach
    </div>
</div>

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center">
        <h4 class="mt-2 mb-2">Hotel Categories</h4>
        <h5 class="mt-2 mb-2"><a href="{{ route('hotel.categories') }}" class="text-dark">All</a></h5>
    </div>
    <div class="row g-3 my-1">
        <div class="owl-carousel owl-theme categories mt-4">
            @foreach ($categories as $category)
            <div class="item mb-2">
                <div class="category-item">
                    <a href="{{ url('hotel/categories/'.$category->id) }}">
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
        <h4 class="mt-2 mb-2">Discounted Hotels</h4>
        <h5 class="mt-2 mb-2">
            <form action="{{ url('hotel/discounted-hotels') }}" method="GET">
                @csrf
                <button type="submit" class="text-dark border-0 bg-white">
                    All
                </button>
            </form>
        </h5>
    </div>
    <div class="row g-3">
        <div class="owl-carousel owl-theme hotel mt-4">
            @foreach ($hotels as $hotel)
            <div class="item my-2">
                <div class="offer-card h-100">
                    <a href="{{ url('hotel/'.$hotel->id.'/detail') }}">
                        @if($hotel->banner_image)
                        <img class="card-img-top img-fluid" src="{{ asset('storage/'.$hotel->banner_image) }}" alt="{{ $hotel->name }}" style="height: 200px; object-fit: cover;">
                        @else
                        <img class="card-img-top img-fluid" src="{{ asset('restaurant_frontend/default-image.png') }}" alt="{{ $hotel->name }}" style="height: 200px; object-fit: cover;">
                        @endif
                    </a>
                    <div class="card-body">
                        <span class="badge bg-primary mt-0">{{ $hotel->category->name }}</span>
                        <h5 class="card-title">{{ $hotel->name }}</h5>
                        <p class="card-text">
                            Location: {{ $hotel->state }}, {{ $hotel->city }}, {{ $hotel->location }}<br>
                            Price per Night: <strong>{{ $hotel->price_per_night }} ETB</strong><br>
                            Rating: <strong>{{ $hotel->rating }} <i class="bi bi-star-fill text-primary"></i></strong><br>
                        </p>
                        <p class="card-text">{{ \Illuminate\Support\Str::limit($hotel->description, 60) }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

<div class="container-fluid p-0">
    <div id="nearby-hotels">
        <p>Loading nearby hotels...</p>
    </div>
</div>

<div class="d-flex justify-content-between align-items-center">
    <h4 class="mt-2 mb-2">Latest Hotels</h4>
    <h5 class="mt-2 mb-2">
        <form action="{{ url('hotels') }}" method="GET">
            @csrf
            <button type="submit" class="text-dark border-0 bg-white">
                All
            </button>
        </form>
    </h5>
</div>
<div class="row g-3">
    <div class="owl-carousel owl-theme hotel mt-4">
        @foreach ($hotels as $hotel)
        <div class="item my-2">
            <div class="offer-card h-100">
                <a href="{{ url('hotel/'.$hotel->id.'/detail') }}">
                    @if($hotel->banner_image)
                    <img class="card-img-top img-fluid" src="{{ asset('storage/'.$hotel->banner_image) }}" alt="{{ $hotel->name }}" style="height: 200px; object-fit: cover;">
                    @else
                    <img class="card-img-top img-fluid" src="{{ asset('restaurant_frontend/default-image.png') }}" alt="{{ $hotel->name }}" style="height: 200px; object-fit: cover;">
                    @endif
                </a>
                <div class="card-body">
                    <span class="badge bg-primary mt-0">{{ $hotel->category->name }}</span>
                    <h5 class="card-title">{{ $hotel->name }}</h5>
                    <p class="card-text">
                        Location: {{ $hotel->state }}, {{ $hotel->city }}, {{ $hotel->location }}<br>
                        Price per Night: <strong>{{ $hotel->price_per_night }} ETB</strong><br>
                        Rating: <strong>{{ $hotel->rating }} <i class="bi bi-star-fill text-primary"></i></strong><br>
                    </p>
                    <p class="card-text">{{ \Illuminate\Support\Str::limit($hotel->description, 60) }}</p>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

<div class="d-flex justify-content-between align-items-center">
    <h4 class="mt-2 mb-2">Latest Rooms</h4>
    <h5 class="mt-2 mb-2">
        <form action="{{ url('hotel/rooms') }}" method="GET">
            @csrf
            <button type="submit" class="text-dark border-0 bg-white">
                All
            </button>
        </form>
    </h5>
</div>
<div class="row g-3">
    <div class="owl-carousel owl-theme hotel mt-4">
        @foreach ($rooms as $room)
        <div class="item my-2">
            {{-- <div class="col-md-3 mb-4"> --}}
            <div class="offer-card h-100">
                @if($room->cover_image)
                <a href="{{ url('hotel/room/'.$room->id.'/detail') }}">
                    <img class="card-img-top" src="{{ asset('storage/'.$room->cover_image) }}" alt="{{ $room->room_type }}">
                    @else
                    <img class="card-img-top" src="{{ asset('restaurant_frontend/default-image.png')}}" alt="{{ $room->room_type }}">
                    @endif
                </a>
                <div class="card-body">
                    <h5 class="card-title">{{ $room->room_type }} (No: {{ $room->room_number }})</h5>
                    <p class="card-text">
                        Floor: {{ $room->floor }}<br>
                        Guests: {{ $room->total_adult+ $room->total_child + $room->total_infant }}<br>
                        Capacity: {{ $room->capacity }}<br>
                        Price: <strong>{{ $room->price }} ETB</strong><br>
                        <span class="{{ $room->is_available? 'text-primary':'text-danger'}}">{{ $room->is_available?'Available':'Not Available'}}</span>
                    </p>
                    <p class="card-text">{{ \Illuminate\Support\Str::limit($room->description, 60) }}
                    </p>
                    <div><strong>Amenities:</strong><br>
                        @foreach ($room->amenities as $amenity)
                        <span class="badge bg-primary">{{ $amenity->name}}</span>
                        @endforeach
                    </div>
                </div>
            </div>
            {{-- </div> --}}
        </div>
        @endforeach
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
                    <div class="offer-card mb-3 p-2">
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
<script>
    document.addEventListener("DOMContentLoaded", function() {
        if ("geolocation" in navigator) {
            navigator.geolocation.getCurrentPosition(function(position) {
                const lat = position.coords.latitude;
                const lng = position.coords.longitude;

                fetch(`/get-nearby-hotels?lat=${lat}&lng=${lng}`)
                    .then(response => response.json())
                    .then(data => {
                        const container = document.getElementById("nearby-hotels");
                        container.innerHTML = data.html; // server will send pre-rendered HTML
                        $('.owl-carousel.hotel').owlCarousel({
                            loop: true,
                            margin: 10,
                            nav: false,
                            responsive: {
                                0: {
                                    items: 1
                                },
                                600: {
                                    items: 2
                                },
                                1000: {
                                    items: 4
                                }
                            }
                        });
                });
            });
        } else {
            console.log("Geolocation not supported");
        }
    });

</script>
@endsection

