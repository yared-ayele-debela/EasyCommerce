
@props(['restaurant', 'distance', 'time'])
<div class="col-md-6">
    <div class="offer-card p-2">
        <div class="row g-0">
            <div class="col-md-6">
                <a href="{{ url('restaurant/' . $restaurant->id . '/detail') }}">
                    @php
                        $parsedPath = $restaurant->cover ? parse_url($restaurant->cover, PHP_URL_PATH) : null;
                        $relativePath = $parsedPath ? str_replace('storage/', '', ltrim($parsedPath, '/')) : null;
                    @endphp

                    @if ($relativePath && Storage::disk('public')->exists($relativePath))
                        <img src="{{ $restaurant->cover }}" class="img-fluid rounded-start" alt="{{ $restaurant->name }}" style="max-height:230px;">
                    @else
                        <img src="{{ asset('restaurant_frontend/default-image.png') }}" style="max-height:230px;" class="img-fluid rounded-start" alt="No Image">
                    @endif
                </a>
            </div>
            <div class="col-md-6">
                <div class="card-body">
                    <h5 class="card-title">{{ $restaurant->name }}</h5>
                    <p class="mb-1">{{ Str::words($restaurant->description, 10, '...') }}</p>
                    <div class="mb-2">
                        <span class="badge resturant_badge p-2">Around {{ $distance }}km</span>
                        <span class="badge resturant_badge p-2">Around {{ $time }} min</span>
                    </div>
                    <p class="mb-1">
                        <i class="bi bi-pin-map-fill text-primary"></i> {{ $restaurant->address }}
                    </p>
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <div class="text-warning me-2">
                            <span><i class="bi bi-star-fill text-primary"></i> {{ $restaurant->rating }}</span>
                        </div>
                        <div>
                            <img src="{{ asset('restaurant_frontend/assets/img/scooter-02.png') }}" style="width: 20%;" alt="">
                            From {{ $restaurant->start_from }} ETB
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
