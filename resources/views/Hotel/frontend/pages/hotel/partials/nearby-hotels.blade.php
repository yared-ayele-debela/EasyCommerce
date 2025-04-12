@if($hotels->count())
<div class="d-flex justify-content-between align-items-center">
    <h4 class="mt-2 mb-2"><img width="30" src="{{ asset('restaurant_frontend/location.gif') }}" alt=""> Nearby Hotels</h4>
    <h5 class="mt-2 mb-2">
        <form action="{{ url('nearby-hotels') }}" method="GET">
            @csrf
            <button type="submit" class="text-dark border-0 bg-white">
                All
            </button>
        </form>
    </h5>
</div><div class="row">
{{-- <div class="row"> --}}
    @foreach ($hotels as $hotel)
    <div class="col-md-3 my-2">
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
                    Distance: {{ round($hotel->distance, 1) }} km
                </p>
                <p class="card-text">{{ \Illuminate\Support\Str::limit($hotel->description, 60) }}</p>
            </div>
        </div>
    </div>
    @endforeach
{{-- </div> --}}
@else
<p>No hotels found nearby.</p>
@endif
