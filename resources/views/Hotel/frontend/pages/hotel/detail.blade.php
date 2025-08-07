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
                <img id="mainImage"   class="img-fluid rounded" src="{{ asset('storage/' . $hotel->banner_image) }}" loading="lazy" alt="{{ $hotel->name }}" >
            @else
                <img  class="img-fluid rounded" src="{{ asset('restaurant_frontend/default-image.png') }}" alt="{{ $hotel->name }}" >
            @endif
        </div>
        <div class="col-md-6">
            <div class="hotel-card ">
                <h2>{{ $hotel->name }}</h2>
                <p>
                     <a  href="https://www.google.com/maps?q={{ $hotel->latitude }},{{ $hotel->longitude }}"
                         target="_blank" class="small text-muted mb-2">
                                             <i class="bi bi-geo-alt-fill text-primary"></i> &nbsp; {{$hotel->state}}, {{$hotel->city}}, {{$hotel->location}}
                        </a>
                </p>
                <p><i class="bi bi-telephone-fill text-primary"></i> {{ $hotel->phone }}</p>
                <p>
                    <strong>Room Types:</strong>
                    @if($hotel->rooms)
                    @foreach($hotel->rooms as $room)
                    <span class="badge bg-primary text-light">{{ $room->room_type }}</span>
                    @endforeach
                    @else
                    <span class="badge bg-primary text-light">No Room Type</span>
                    @endif

                </p>
                <p><strong>Over View:</strong> {{ $hotel->description }}</p>
                <p><strong>Average Price:</strong> <span class="text-primary"><b>{{ $hotel->price_per_night }} ETB / Night </b></span></p>
                <div class="d-flex align-items-center">
                    <span class="badge bg-primary me-2">{{ $hotel->rating }}</span>

                    @php
                        $fullStars = floor($hotel->rating); // Full stars
                        $halfStar = ($hotel->rating - $fullStars) >= 0.5; // Half star
                        $emptyStars = 5 - $fullStars - ($halfStar ? 1 : 0); // Remaining stars
                    @endphp

                    {{-- Full stars --}}
                    @for ($i = 0; $i < $fullStars; $i++)
                        <i class="bi bi-star-fill text-primary"></i>
                    @endfor

                    {{-- Half star --}}
                    @if ($halfStar)
                        <i class="bi bi-star-half text-primary"></i>
                    @endif

                    {{-- Empty stars --}}
                    @for ($i = 0; $i < $emptyStars; $i++)
                        <i class="bi bi-star text-primary"></i>
                    @endfor

                </div>
            </div>
        </div>
    </div>

    <!-- Photo Gallery -->
    <div class="mt-4">
        <div class="d-flex justify-content-between align-items-center">
            <h4>Photos</h4>
            @if($hotel->photos->count() > 0)
            <a href="{{ url('hotel/'.$hotel->id.'/gallery') }}" class="align-self-center text-primary text-decoration-none">See all</a>
            @endif
        </div>
        <div class="row d-flex photo-gallery">
            @foreach($hotel->photos as $photo)
            <div class="col-3 col-sm-4 col-md-1 mb-1">
                <img loading="lazy" src="{{ asset('storage/' . $photo->photo_url) }}" alt="{{ $hotel->name }}" class="gallery-image img-fluid rounded rounded-2">
            </div>
            @endforeach
        </div>


        <!-- Navigation -->
        <div class="row d-flex justify-content-center align-items-center py-4">
            <div class="col-md-8">
                <nav class="nav justify-content-center resturant-detail-nav text-white pb-2 pt-4">
                    <a href="#" class="nav-link mb-1 text-white fw-bold nav-active" data-filter="all">All</a>
                    @if($hotel->rooms)
                        @foreach ($hotel->rooms->unique('room_type') as $room)
                            <a href="#" class="nav-link mb-1 text-dark fw-bold" data-filter="{{ $room->room_type }}">
                                {{ $room->room_type }}
                            </a>
                        @endforeach
                    @else
                        <a href="#" class="nav-link mb-1 text-dark fw-bold">No Room Type</a>
                    @endif
                </nav>
            </div>
        </div>

        <div class="row" id="roomContainer">
            @foreach ($rooms as $room)
                <div class="col-12 col-sm-6 col-md-3 my-4 room-card" data-room-type="{{ $room->room_type }}">
                    <div class="offer-card h-100">
                        @if($room->image)
                            <a href="{{ url('hotel/room/'.$room->id.'/detail') }}">
                                <img class="card-img-top" src="{{ asset('storage/' . $room->image) }}"
                                    alt="{{ $room->room_type }}" loading="lazy">
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
                                <span class="{{ $room->is_available ? 'text-primary' : 'text-danger' }}">
                                    {{ $room->is_available ? 'Available' : 'Not Available' }}
                                </span>
                            </p>
                            <p class="card-text">
                                {{ \Illuminate\Support\Str::limit($room->description, 60) }}
                            </p>
                            <div><strong>Amenities:</strong><br>
                                @foreach ($room->amenities as $amenity)
                                    <span class="badge bg-primary">{{ $amenity->name }}</span>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

    </div>
</div>
<script>
    $(document).ready(function() {
        $('.resturant-detail-nav .nav-link').on('click', function(e) {
            e.preventDefault();
            var filter = $(this).data('filter');
            $('.resturant-detail-nav .nav-link').removeClass('nav-active text-white').addClass('text-dark');
            $(this).addClass('nav-active text-white').removeClass('text-dark');

            if (filter === 'all') {
                $('.room-card').show();
            } else {
                $('.room-card').hide();
                $('.room-card[data-room-type="' + filter + '"]').show();
            }
        });
    });
</script>

@endsection
