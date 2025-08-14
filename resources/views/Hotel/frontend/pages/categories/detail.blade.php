@extends('all_frontend_layouts.layouts')
@section('content')

<div class="container-fluid">
    <div class="header">
        <button class="btn btn-link text-dark" onclick="history.back()">
            <i class="bi bi-arrow-left"></i>
         </button>
        <h5 class="my-4 text-dark text-center">{{ $category->name }}</h5>
    </div>

        <div class="row g-3">
            {{-- <div class="owl-carousel owl-theme hotel mt-4"> --}}
                @foreach ($hotels as $hotel)
                <div class="col-md-3 mt-2 mb-4">
                    <div class="card h-100">
                        @if($hotel->banner_image)
                            <img class="card-img-top img-fluid" src="{{ asset('storage/'.$hotel->banner_image) }}" alt="{{ $hotel->name }}"style="height: 200px; object-fit: cover;">
                        @else
                            <img class="card-img-top img-fluid" src="{{ asset('restaurant_frontend/default-image.png') }}" alt="{{ $hotel->name }}" style="height: 200px; object-fit: cover;">
                        @endif
                        <div class="card-body">
                            <button class="btn-sm btn btn-primary">{{ $hotel->category->name }}</button><br>
                            <span class="card-text text-dark star">1.0 Km . &nbsp; <i class="bi bi-star-fill"></i> 4.8 Reviews </span>
                            <h4 class="card-title">{{ $hotel->name }}</h4>
                            <p class="card-text text-dark"><i class="bi bi-pin-map-fill text-primary"></i> {{ $hotel->location }}</p>
                            <h5 class="text-primary">{{ $hotel->price_per_night }} ETB / Night</h5>
                        </div>
                    </div>
                </div>
              @endforeach
            {{-- </div> --}}
           <div class="col-12">
            {{ $hotels->links() }}
           </div>
        </div>
    </div>
@endsection
