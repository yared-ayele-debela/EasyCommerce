<!-- resources/views/amenities/index.blade.php -->
@extends('Hotel.dashboard.layouts')
@section('hotel-dashboard')
<style>
    .hotel-card {
        border: none;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        margin-bottom: 40px;
        overflow: hidden;
        background: #fff;
    }
    .banner {
        width: 100%;
        height: 300px;
        object-fit: cover;
    }

    .carousel-inner img {
        height: 200px;
        object-fit: cover;
    }

    .carousel-indicators [data-bs-target] {
        background-color: #000;
    }

    .badge-custom {
        background-color: #17BE18;
        color: #fff;
        font-size: 12px;
        padding: 5px 10px;
        border-radius: 20px;
    }

    .room-card {
        border: 1px solid #eee;
        border-radius: 10px;
        margin-bottom: 20px;
        background: #fefefe;
    }

    .room-card img {
        border-radius: 10px 10px 0 0;
    }

</style>
<div class="pagetitle shadow-sm">
    <nav class=" p-2 text-center">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.html">Home</a></li>
            <li class="breadcrumb-item active">My Hotel</li>
        </ol>
    </nav>
</div>
<div class="container py-2">
    <div class="hotel-card">
        @if($hotel->banner_image || (!empty($hotel->banner_image) && \Illuminate\Support\Facades\Storage::exists('public/'.$hotel->banner_image)))
        <img src="{{ asset('storage/' . $hotel->banner_image) }}" class="banner w-100" alt="{{ $hotel->name }}">
        @else
        <img src="{{ asset('restaurant_frontend/default-image.png') }}" class="banner w-100" alt="{{ $hotel->name }}">
        @endif
        <div class="p-4">
            <div class="d-flex justify-content-between align-items-center">
                <h3>{{ $hotel->name }}</h3>
                @if($hotel->is_featured)
                <span class="badge-custom">Featured</span>
                @endif
            </div>
            <p class="mb-1 text-muted">{{ $hotel->location }} | 📞 {{ $hotel->phone }}</p>
            <p class="text-muted">{{ $hotel->description }}</p>
            <p><strong>Price per Night:</strong> ETB {{ number_format($hotel->price_per_night, 2) }}</p>
            <p><strong>Rating:</strong> ⭐ {{ $hotel->rating }} ({{ $hotel->reviews_count }} reviews)</p>


            @if ($hotel->photos->count())
            <div id="carouselHotel{{ $hotel->id }}" class="carousel slide mb-3" data-bs-ride="carousel">
                <div class="carousel-inner">
                    @foreach ($hotel->photos as $index => $photo)
                    <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                        @if($photo->photo_url || (!empty($photo->photo_url) && \Illuminate\Support\Facades\Storage::exists('public/'.$photo->photo_url)))
                        <img src="{{ asset('storage/' . $photo->photo_url) }}" class="d-block w-100" alt="Hotel Photo">
                        @else
                        <img src="{{ asset('restaurant_frontend/default-image.png') }}" class="d-block w-100">
                        @endif
                    </div>
                    @endforeach
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselHotel{{ $hotel->id }}" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon"></span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselHotel{{ $hotel->id }}" data-bs-slide="next">
                    <span class="carousel-control-next-icon"></span>
                </button>
            </div>
            @endif

            <h5 class="mt-4">Rooms</h5>
            <div class="row">
                @foreach ($hotel->rooms as $room)
                <div class="col-md-6 col-lg-4">
                    <div class="room-card">
                        @if($room->cover_image || (!empty($room->cover_image) && \Illuminate\Support\Facades\Storage::exists('public/'.$room->cover_image)))
                        <img src="{{ asset('storage/' . $room->cover_image) }}" class="w-100" height="180" alt="Room Image">
                        @else
                        <img src="{{ asset('restaurant_frontend/default-image.png') }}" class="w-100" height="180" alt="Room Image">
                        @endif
                        <div class="p-3">
                            <h6 class="fw-bold">{{ $room->room_type }}</h6>
                            <p class="text-muted">Capacity: {{ $room->capacity }} | ETB {{ number_format($room->price, 2) }}</p>
                            <p>{{ $room->description }}</p>
                            <p>Status: <span class="badge {{ $room->is_available ? 'bg-success' : 'bg-danger' }}">{{ $room->is_available ? 'Available' : 'Booked' }}</span></p>
                            <p>Amenites:</p>
                            @foreach ($room->amenities as $key => $am)

                            <a href="javascript:void(0);" class="mb-1 rounded rounded-3 btn-outline-primary list-inline-item">
                                @php $icon = optional($am)->icon; @endphp
                                @if($icon && Storage::exists('public/' . $icon))
                                <img src="{{ asset('storage/' . $icon) }}" alt="{{ $am->name }}" width="24" height="24">
                                @else
                                <img src="{{ asset('restaurant_frontend/default-image.png') }}" alt="{{ $am->name }}" width="24" height="24">
                                @endif
                                <small>{{ $am->name }}</small>
                            </a>
                            @endforeach
                            @if ($room->images->count())
                            <div id="carouselRoom{{ $room->id }}" class="carousel slide" data-bs-ride="carousel">
                                <div class="carousel-inner">
                                    @foreach ($room->images as $index => $img)
                                    <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                                        @if($img->image_path || (!empty($img->image_path) && \Illuminate\Support\Facades\Storage::exists('public/'.$img->image_path)))
                                        <img src="{{ asset('storage/' . $img->image_path) }}" class="d-block w-100" height="150" style="object-fit: cover;">
                                        @else
                                        <img src="{{ asset('restaurant_frontend/default-image.png') }}" class="d-block w-100">
                                        @endif
                                    </div>
                                    @endforeach
                                </div>
                                <button class="carousel-control-prev" type="button" data-bs-target="#carouselRoom{{ $room->id }}" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon"></span>
                                </button>
                                <button class="carousel-control-next" type="button" data-bs-target="#carouselRoom{{ $room->id }}" data-bs-slide="next">
                                    <span class="carousel-control-next-icon"></span>
                                </button>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection

