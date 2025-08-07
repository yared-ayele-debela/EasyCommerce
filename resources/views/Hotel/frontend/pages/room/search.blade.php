@extends('all_frontend_layouts.layouts')
@section('content')
<div class="container-fluid">
    <div class="header">
        <button class="btn btn-link text-dark" onclick="history.back()">
            <i class="bi bi-arrow-left"></i>
        </button>
        <h5 class="my-4 text-dark text-center">Rooms</h5>
    </div>
    <div class="offer-card shadow-sm rounded-4 p-3 mb-4 bg-white">
        <h4 class="mb-3 text-dark"><i class="bi bi-funnel-fill me-2 text-primary"></i> Advanced Room Filters</h4>
        <div class="row g-3 align-items-end">
            <div class="col-md-3">
                <label for="search" class="form-label">Search Room Type</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-search"></i></span>
                    <input type="text" id="search" class="form-control shadow-sm" value="{{ request('search') }}" placeholder="e.g. Deluxe, Standard">
                </div>
            </div>

            <div class="col-md-2">
                <label for="min_price" class="form-label">Min Price</label>
                <div class="input-group">
                    <span class="input-group-text">ETB</span>
                    <input type="number" id="min_price" class="form-control shadow-sm" value="{{ request('min_price') }}" placeholder="1000">
                </div>
            </div>

            <div class="col-md-2">
                <label for="max_price" class="form-label">Max Price</label>
                <div class="input-group">
                    <span class="input-group-text">ETB</span>
                    <input type="number" id="max_price" class="form-control shadow-sm" value="{{ request('max_price') }}" placeholder="5000">
                </div>
            </div>

            <div class="col-md-2">
                <label for="capacity" class="form-label">Min Capacity</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-people"></i></span>
                    <input type="number" id="capacity" class="form-control shadow-sm"  value="{{ request('capacity') }}" placeholder="e.g. 2">
                </div>
            </div>
            <div class="col-md-1">
                <label for="total_adult" class="form-label">Adults</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-people"></i></span>
                    <input type="number" id="total_adult" class="form-control shadow-sm" value="{{ request('total_adult') }}" placeholder="2">
                </div>
            </div>
            <div class="col-md-1">
                <label for="total_child" class="form-label">Children</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-person-walking"></i></span>
                    <input type="number" id="total_child" class="form-control shadow-sm" value="{{ request('total_child') }}" placeholder="2">
                </div>
            </div>
            <div class="col-md-1">
                <label for="total_infant" class="form-label">Infants</label>
                <div class="input-group">
                    <span class="input-group-text"><img src="{{ asset('restaurant_frontend/baby.png') }}" width="20" alt=""></span>
                    <input type="number" id="total_infant" class="form-control shadow-sm" value="{{ request('total_infant') }}" placeholder="2">
                </div>
            </div>

            {{-- <div class="col-md-3 d-grid">
                <button class="btn btn-primary shadow-sm" id="filterBtn">
                    <i class="bi bi-funnel"></i> Apply Filters
                </button>
            </div> --}}
        </div>

        <hr class="my-4">

        <div class="mb-2">
            <label class="form-label text-dark"><strong><i class="bi bi-stars text-primary"></i> Filter by Amenities:</strong></label>
        </div>
        <div class="row g-2">
            @foreach ($amenities as $amenity)
                <div class="col-auto">
                    <div class="form-check form-switch">
                        <input class="form-check-input amenity-filter" type="checkbox" value="{{ $amenity->id }}" id="amenity{{ $amenity->id }}">
                        <label class="form-check-label badge bg-primary text-light px-3 py-2" for="amenity{{ $amenity->id }}">
                            {{ $amenity->name }}
                        </label>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <hr>


    <div class="row" id="room-list"></div>
</div>

<script>
        const storageUrl = "{{ asset('storage') }}";

    function fetchRooms() {
        let selectedAmenities = [];
        $('.amenity-filter:checked').each(function() {
            selectedAmenities.push($(this).val());
        });

        $.ajax({
            url: '{{ route('rooms.filter') }}',
            method: 'GET',
            data: {
                search: $('#search').val(),
                min_price: $('#min_price').val(),
                max_price: $('#max_price').val(),
                capacity: $('#capacity').val(),
                total_adult: $('#total_adult').val(),
                total_child: $('#total_child').val(),
                total_infant: $('#total_infant').val(),
                amenities: selectedAmenities
            },
            success: function(response) {
                let html = '';
                if (response.rooms.length === 0) {
                    html = '<div class="col-12"><p>No rooms found.</p></div>';
                } else {
                    response.rooms.forEach(room => {
                            const room_img = `${storageUrl}/${room.image}`;

                        html += `
                        <div class="col-md-3 mb-4">
                            <div class="offer-card h-100">
                                <a href="{{ url('hotel/room/${room.id}/detail') }}">
                                <img src="${room_img}" class="card-img-top" alt="Room Image" style="height:200px; object-fit:cover;">
                                </a>
                                <div class="card-body">
                                    <h5 class="card-title">${room.room_type} (No: ${room.room_number})</h5>
                                    <p class="card-text">
                                        Floor: ${room.floor}<br>
                                        Guests: ${room.total_adult + room.total_child + room.total_infant}<br>
                                        Capacity: ${room.capacity}<br>
                                        Price: <strong>${room.price} ETB</strong><br>
                                        ${room.is_available ? '<span class="text-priamry">Available</span>' : '<span class="text-danger">Not Available</span>'}
                                    </p>
                                    <p class="card-text">${room.description.substring(0, 60)}...</p>
                                    <div><strong>Amenities:</strong><br>
                                        ${(room.amenities || []).map(a => `<span class="badge bg-primary">${a.name}</span>`).join(' ')}
                                    </div>
                                </div>
                            </div>
                        </div>`;
                    });
                }
                $('#room-list').html(html);
            }
        });
    }

    $('#search, #min_price, #max_price, #capacity, #total_adult, #total_child, #total_infant').on('input', fetchRooms);
    $('.amenity-filter').on('change', fetchRooms);
    $(document).ready(fetchRooms);
    </script>
@endsection

@section('scripts')

@endsection
