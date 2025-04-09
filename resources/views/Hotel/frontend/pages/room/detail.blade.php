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
        border: 2px solid #17BE18 !important;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.08);
    }
</style>

</style>
<div class="container-fluid">
    <div class="header">
        <button class="btn btn-link text-dark" onclick="history.back()">
            <i class="bi bi-arrow-left"></i>
        </button>
        <h5 class="my-4 text-dark text-center">{{ $room->room_type }}</h5>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="row">
                <div class="col-md-6">
                    <div class="d-flex">
                        <p> {{ $room->room_type }} </p>
                         <p> laksjfdl lkas fdslak </p>
                    </div>
                </div>
                <div class="col-md-6 text-end">
                    <span class="text-dark">1.0 Km &nbsp; <i class="bi bi-star-fill text-primary"></i> 4.8 Reviews</span>
                </div>
            </div>
        </div>
        @foreach($room->images as $img)
        <div class="col-md-4">
            <img src="{{ asset('storage/'.$img->image_path) }}" class=" img-fluid rounded rounded-3">
        </div>
        @endforeach
        <br>
        <div class="col-12 col-md-8 my-3 ">
            <p><strong>About Room : </strong> {{ $room->description }}</p>
        </div>
        <div class="col-md-4 my-3">
            <div class="offer-card">
                <div class="card-body">
                    <h4 class="card-title">Start Booking</h4>
                    <p class="text-primary my-2" style="font-size: 20px;">{{ $room->price }} ETB Per Night</p>
                    <form action="{{ route('select_date',encrypt($room->id)) }}" method="GET">
                        @csrf
                        <input type="hidden" name="id" value="{{ $room->id }}">
                    <button type="submit" class="btn btn-primary rounded rounded-1 shadow">Select Date</button>
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
                    <div class="offer-card text-center border rounded shadow-sm amenity-box h-100">
                        @php $icon = optional($am)->icon; @endphp
                        <img 
                            src="{{ $icon && Storage::exists('public/' . $icon) 
                                ? asset('storage/' . $icon) 
                                : asset('restaurant_frontend/default-image.png') 
                            }}" 
                            alt="{{ $am->name }}" 
                            width="36" 
                            height="36" 
                            class="my-2"
                        >
                        <p class="mb-0 small fw-semibold text-dark">{{ $am->name }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    
</div>
@endsection

