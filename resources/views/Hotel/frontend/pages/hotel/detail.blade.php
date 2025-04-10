@extends('all_frontend_layouts.layouts')
@section('content')
<div class="container-fluid">
    <div class="header">
        <button class="btn btn-link text-dark" onclick="history.back()">
            <i class="bi bi-arrow-left"></i>
        </button>
        <h5 class="my-4 text-dark text-center">{{ $hotel->name }}</h5>
    </div>
    <div class="row">
        <div class="col-md-6">
            @if($hotel->banner_image)
                <img id="mainImage"   class="img-fluid rounded" src="{{ asset('storage/'.$hotel->banner_image) }}" alt="{{ $hotel->name }}" >
            @else
                <img  class="img-fluid rounded" src="{{ asset('restaurant_frontend/default-image.png') }}" alt="{{ $hotel->name }}" >
            @endif
        </div>
        <div class="col-md-6">
            <div class="hotel-card ">
                <h2>{{ $hotel->name }}</h2>
                <p><i class="bi bi-geo-alt-fill text-primary"></i> &nbsp;{{$hotel->location}}</p>
                <p><i class="bi bi-telephone-fill text-primary"></i> {{ $hotel->phone }}</p>
                <p>
                    <strong>Room Types:</strong>
                    <span class="badge bg-primary text-light">Presidential Room</span>
                    <span class="badge bg-primary text-light">Sweet Room</span>
                    <span class="badge bg-primary text-light">Family Room</span>
                    <span class="badge bg-primary text-light">Double Room</span>
                    <span class="badge bg-primary text-light">Single Room</span>
                </p>
                <p><strong>Over View:</strong> {{ $hotel->description }}</p>
                <p><strong>Average Price:</strong> <span class="text-primary"><b>{{ $hotel->price_per_night }} ETB / Night </b></span></p>
                <div class="d-flex align-items-center">
                    <span class="badge bg-primary me-2">{{ $hotel->rating }}</span>
                    <i class="bi bi-star-fill text-warning"></i>
                    <i class="bi bi-star-fill text-warning"></i>
                    <i class="bi bi-star-fill text-warning"></i>
                    <i class="bi bi-star-fill text-warning"></i>
                    <i class="bi bi-star-half text-warning"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Photo Gallery -->
    <div class="mt-4">
        <div class="d-flex justify-content-between align-items-center">
            <h4>Photos</h4>
            <a href="{{ url('hotel/'.$hotel->id.'/gallery') }}" class="align-self-center text-primary text-decoration-none">See all</a>
        </div>
        <div class="row d-flex photo-gallery">
            @foreach($hotel->photos as $photo)
            <div class="col-3 col-sm-4 col-md-1 mb-1">
                <img loading="lazy" src="{{ asset('storage/' . $photo->photo_url) }}" alt="{{ $hotel->name }}" class="gallery-image img-fluid">
            </div>
            @endforeach
        </div>

        {{-- <div class="row pt-4">
            <h5 class="text-dark">Amenities</h5>
            <div class=" col-3 col-sm-4 col-md-1 text-center ">
                <img src="assets/hotel/ic_bedroom.png" class="text-center" alt="">
                <p class="text-dark text-center">1 Bedroom</p>
            </div>
            <div class=" col-3 col-sm-4 col-md-1 text-center ">
                <img src="assets/hotel/ic_bedroom.png" class="text-center" alt="">
                <p class="text-dark text-center">1 Bedroom</p>
            </div>
            <div class=" col-3 col-sm-4 col-md-1 text-center ">
                <img src="assets/hotel/ic_bedroom.png" class="text-center" alt="">
                <p class="text-dark text-center">1 Bedroom</p>
            </div>
            <div class=" col-3 col-sm-4 col-md-1 text-center ">
                <img src="assets/hotel/ic_bedroom.png" class="text-center" alt="">
                <p class="text-dark text-center">1 Bedroom</p>
            </div>
            <div class=" col-3 col-sm-4 col-md-1 text-center ">
                <img src="assets/hotel/ic_bedroom.png" class="text-center" alt="">
                <p class="text-dark text-center">1 Bedroom</p>
            </div>
            <div class=" col-3 col-sm-4 col-md-1 text-center ">
                <img src="assets/hotel/ic_bedroom.png" class="text-center" alt="">
                <p class="text-dark text-center">1 Bedroom</p>
            </div>
            <div class=" col-3 col-sm-4 col-md-1 text-center ">
                <img src="assets/hotel/ic_bedroom.png" class="text-center" alt="">
                <p class="text-dark text-center">1 Bedroom</p>
            </div>
            <div class=" col-3 col-sm-4 col-md-1 text-center ">
                <img src="assets/hotel/ic_bedroom.png" class="text-center" alt="">
                <p class="text-dark text-center">1 Bedroom</p>
            </div>
            <div class=" col-3 col-sm-4 col-md-1 text-center ">
                <img src="assets/hotel/ic_bedroom.png" class="text-center" alt="">
                <p class="text-dark text-center">1 Bedroom</p>
            </div>
            <div class=" col-3 col-sm-4 col-md-1 text-center ">
                <img src="assets/hotel/ic_bedroom.png" class="text-center" alt="">
                <p class="text-dark text-center">1 Bedroom</p>
            </div>
            <div class=" col-3 col-sm-4 col-md-1 text-center ">
                <img src="assets/hotel/ic_bedroom.png" class="text-center" alt="">
                <p class="text-dark text-center">1 Bedroom</p>
            </div>
            <div class=" col-3 col-sm-4 col-md-1 text-center ">
                <img src="assets/hotel/ic_bedroom.png" class="text-center" alt="">
                <p class="text-dark text-center">1 Bedroom</p>
            </div>
        </div> --}}

        <!-- Navigation -->
        <div class="row d-flex justify-content-center align-items-center py-4">
            <div class="col-md-8">
                <nav class="nav justify-content-center resturant-detail-nav text-white py-2">
                    <a href="#" class="nav-link mb-1 text-white fw-bold nav-active">All</a>
                    <a href="#" class="nav-link mb-1 text-dark fw-bold ">Chees Burger</a>
                    <a href="#" class="nav-link mb-1 text-dark fw-bold">BBQ Burger</a>
                    <a href="#" class="nav-link mb-1 text-dark fw-bold">Min Burger</a>
                    <a href="#" class="nav-link mb-1 text-dark fw-bold">Tower Burger</a>
                </nav>
            </div>
        </div>

        <div class="row">
            @foreach ($rooms as $room)
            <div class="col-12 col-sm-6 col-md-3 my-4">
                <div class="offer-card h-100">
                    @if($room->cover_image)
                    <a href="{{ url('hotel/room/'.$room->id.'/detail') }}">
                        <img class="card-img-top" src="{{ asset('storage/'.$room->cover_image) }}"
                            alt="{{ $room->room_type }}">
                        @else
                        <img class="card-img-top" src="{{ asset('restaurant_frontend/default-image.png')}}"
                            alt="{{ $room->room_type }}">
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
                        <p class="card-text">
                            {{ \Illuminate\Support\Str::limit($room->description, 60) }}
                        </p>
                        <div><strong>Amenities:</strong><br>
                            @foreach ($room->amenities as $amenity)
                            <span class="badge bg-primary">{{ $amenity->name}}</span>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
