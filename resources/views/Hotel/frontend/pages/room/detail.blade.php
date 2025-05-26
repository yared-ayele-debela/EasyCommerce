@extends('all_frontend_layouts.layouts')
@section('content')
<style>
    <style>
    .amenity-box {
        transition: all 0.3s ease;
        background-color: #fff;

    }

    .amenity-box:hover {
        background-color: #f5f8ff;
        transform: translateY(-3px);
        border: 2px solid #055935 !important;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.08);
    }
</style>

</style>
<div class="container py-4">
    <div class="header">
        <button class="btn btn-link text-dark" onclick="history.back()">
            <i class="bi bi-arrow-left"></i>
        </button>
        <h5 class="my-4 text-dark text-center">{{ $room->room_type }}</h5>
    </div>
    {{-- <div class="container py-4"> --}}
    <div class="row mb-3 align-items-center">
        <div class="col-md-8">
            <h4 class="mb-1">{{ $room->hotel->name }}</h4>
            <p class="text-muted mb-0"><i class="bi bi-geo-alt-fill me-1 text-primary"></i> {{ $room->hotel->location }}</p>
        </div>
        <div class="col-md-4 text-md-end text-start mt-2 mt-md-0">
            <span class="badge bg-light text-dark py-2 px-3">
                <i class="bi bi-map me-1"></i> 1.0 Km
                &nbsp;&nbsp;
                @if($av_rating)
                <i class="bi bi-star-fill text-primary"></i> {{ number_format($av_rating,1) }} Reviews
                @else
                    <span class="text-muted">No reviews yet</span>
                @endif
            </span>
        </div>
    </div>

    <div class="row g-3 mb-4">
        @foreach($room->images as $img)
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-3 h-100">
                <img src="{{ $img->photo_url }}" class="card-img-top rounded-3" alt="Room Image">
            </div>
        </div>
        @endforeach
    </div>

    <div class="row g-3">
        <div class="col-md-8">
            <div class="card shadow-sm p-3 border-0 rounded-3 offer-card h-100">
                <h5 class="mb-2"><i class="bi bi-info-circle-fill text-primary me-1"></i> About Room</h5>
                <p class="text-muted mb-0">{{ $room->description }}</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm border-0 rounded-3 offer-card">
                <div class="card-body">
                    <h5 class="card-title mb-3 text-dark">Start Booking</h5>
                    <p class="text-primary fw-bold fs-5">{{ $room->price }} ETB / Night</p>
                    <form action="{{ route('select_date', encrypt($room->id)) }}" method="GET">
                        @csrf
                        <input type="hidden" name="id" value="{{ $room->id }}">
                        <button type="submit" class="btn btn-primary w-100 shadow-sm">
                            <i class="bi bi-calendar-check me-1"></i> Select Date
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Photo Gallery -->
    <div class="mt-2">
        <h5 class="text-dark mb-3">Amenities</h5>
        <div class="row g-3">
            @foreach ($room->amenities as $am)
                <div class="col-4 col-sm-4 col-md-3 col-lg-1 mb-2">
                    <div class="offer-card p-2 text-center border rounded shadow-sm amenity-box h-100">
                        @php $icon = optional($am)->icon; @endphp
                        <img
                            src="{{ $icon
                                ? $icon
                                : asset('restaurant_frontend/default-image.png')
                            }}"
                            alt="{{ $am->name }}"
                            width="16"
                            height="16"
                            class="my-2"
                        >
                        <p class="mb-0 small fw-semibold text-dark" style="font-size: 11px;">{{ $am->name }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <div class="my-2">
        <div class="row d-flex justify-content-between align-items-center mb-2">
            <div class="col-md-4 col-7">
                <h5 class="text-dark mb-3">Customer Reviews ({{ $room->rating->count() }})</h5>
             </div>
             <div class="col-md-8 col-5 text-end">
                @if(Auth::check() && $is_reserved)
                <button class="btn btn-primary shadow-sm" data-bs-toggle="modal" data-bs-target="#ratingModal">
                    Leave a Review
               </button>
               @endif
             </div>
        </div>
        @if(Auth::check() && $is_reserved)
        @include('Hotel.frontend.pages.room.rating')
        @endif
        <div class="overflow-auto" style="white-space: nowrap;">
            <div class="d-flex gap-3" style="overflow-x: auto; scrollbar-width: thin;">
                @foreach ($room->rating as $rating)
                <div class="offer-card shadow p-3 text-left mb-2" style="min-width: 300px;">
                    <span class="font-italic">Name: {{ $rating->user->name }}</span>
                    <br>
                    <span class="fst-italic">Comment: {{ $rating->review }}</span>
                    <br>
                    <span>
                        @for ($i = 1; $i <= 5; $i++) @if ($i <=$rating->rating)
                            <i class="bi bi-star-fill text-primary"></i>
                            @else
                            <i class="bi bi-star text-primary"></i>
                            @endif
                        @endfor
                    </span>
                </div>
                @endforeach
            </div>
        </div>
    </div>

</div>
@endsection

