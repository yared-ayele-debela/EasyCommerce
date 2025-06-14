@extends('all_frontend_layouts.layouts')
@section('content')
<div class="container-fluid">
    <div class="header">
        <button class="btn btn-link text-dark" onclick="history.back()">
            <i class="bi bi-arrow-left"></i>
        </button>
        <h5 class="my-4 text-dark text-center">{{ $name }}</h5>
    </div>
    <div class="row g-3">
        @foreach ($hotels as $hotel)
        <div class="col-md-3 my-2">
            <div class="offer-card h-100">
                <a href="{{ url('hotel/'.$hotel->id.'/detail') }}">
                    @if($hotel->banner_image)
                    <img class="card-img-top img-fluid" src="{{$hotel->banner_image}}" alt="{{ $hotel->name }}" style="height: 200px; object-fit: cover;">
                    @else
                    <img class="card-img-top img-fluid" src="{{ asset('restaurant_frontend/default-image.png') }}" alt="{{ $hotel->name }}" style="height: 200px; object-fit: cover;">
                    @endif
                </a>
                <div class="card-body">
                    <span class="badge bg-primary mt-0">{{ $hotel->category->name }}</span>
                    <h5 class="card-title">{{ $hotel->name }}</h5>
                    <p class="card-text">
                       <a  href="https://www.google.com/maps?q={{ $hotel->latitude }},{{ $hotel->longitude }}"
                         target="_blank" class="small text-muted mb-2">
                        Location: {{ $hotel->state }}, {{ $hotel->city }}, {{ $hotel->location }}
                        </a>
                        <br>
                        Price per Night: <strong>{{ $hotel->price_per_night }} ETB</strong><br>
                        Rating: <strong>{{ $hotel->rating }} <i class="bi bi-star-fill text-primary"></i></strong><br>
                    </p>
                    <p class="card-text">{{ \Illuminate\Support\Str::limit($hotel->description, 60) }}</p>
                </div>
            </div>
        </div>
        @endforeach
        <div class="col-12">
            {{ $hotels->links() }}
        </div>
    </div>
</div>
@endsection
