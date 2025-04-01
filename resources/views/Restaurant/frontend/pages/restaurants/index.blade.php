@extends('all_frontend_layouts.layouts')
@section('content')
<div class="container-fluid">
    <h3 class="my-4 text-dark text-center">All Restaurants</h3>
    <div class="row">
        @foreach ($restaurants as $restaurant)
        <div class="col-md-6">
            <div class="resturant_card card mb-3 p-2">
                <div class="row g-0">
                    <div class="col-md-6">
                        <img src="{{ asset('storage/' . $restaurant->cover) }}" class="img-fluid rounded-start" alt="Restaurant">
                    </div>
                    <div class="col-md-6">
                        <div class="card-body">
                            <h5 class="card-title">{{ $restaurant->name }}</h5>
                            <p class="mb-1">{{ Str::words($restaurant->description,10,'....') }}</p>

                            <div class="mb-2">
                                <span class="badge resturant_badge p-2">Around 1.5km</span>
                                <span class="badge resturant_badge p-2">Around 45 min</span>
                            </div>
                            <p class="mb-1"> <i class="bi bi-pin-map-fill text-primary"></i> {{ $restaurant->address }}</p>
                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <div class="text-warning me-2">
                                    @php
                                        $averageRating = \App\Models\Restaurant\RestaurantRating::where('restaurant_id', $restaurant->id)->avg('rating');
                                    @endphp
                                    <span><span class="bi bi-star-fill text-primary"></span> {{ number_format($averageRating, 1) }}</span>
                                </div>
                                <div><img src="{{ asset('restaurant_frontend/assets/img/scooter-02.png') }}" style="width: 20%;" alt=""> From 60 ETB</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
        <div class="col-12">
            {{ $restaurants->links() }}
        </div>
    </div>

</div>
@endsection
