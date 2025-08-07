@props(['restaurant'])

<div class="col-lg-6 col-md-6 mb-2 restaurant-card"
     data-lat="{{ $restaurant->latitude }}"
     data-lng="{{ $restaurant->longitude }}"
     data-radius="{{ $restaurant->delivery_radius }}">
    <div class="offer-card h-100 overflow-hidden">
        <div class="row g-0 align-items-stretch">
            <div class="col-4 col-sm-4">
                <a href="{{ url('restaurant/' . $restaurant->id . '/detail') }}" class="h-100 d-block">
                    <img src="{{ asset('storage/' . $restaurant->cover ?? 'restaurant_frontend/default-image.png') }}"
                         alt="{{ $restaurant->name }}"
                         class="img-fluid object-fit-cover w-100 h-100 p-2"
                         style="min-height: 180px; max-height: 230px;" loading="lazy">
                </a>
            </div>
            <div class="col-8 col-sm-8">
                <div class="card-body d-flex flex-column h-100 py-3 px-4">
                    <div class="out-of-range position-absolute top-0 end-0 m-2 d-none">
                        <button class="btn btn-sm btn-outline-danger rounded-pill px-3" disabled>
                            <img src="{{ asset('restaurant_frontend/alert.png') }}" width="20" alt=""> Out of Range
                        </button>
                    </div>

                    <h5 class="card-title mb-1 text-truncate" title="{{ $restaurant->name }}">
                        {{ $restaurant->name }}
                    </h5>

                    <p class="text-muted d-none d-md-block">
                        {{ Str::words($restaurant->description, 20, '...') }}
                    </p>

                    <div class="mb-2 d-flex flex-wrap gap-2">
                        <span class="badge bg-light text-dark px-3 py-2 rounded-pill distance-badge"></span>
                        <span class="badge bg-light text-dark px-3 py-2 rounded-pill time-badge"></span>
                    </div>

                    <a href="https://www.google.com/maps?q={{ $restaurant->latitude }},{{ $restaurant->longitude }}"
                       target="_blank" class="small text-muted mb-2">
                        <i class="bi bi-pin-map-fill text-primary me-1"></i>
                        {{ $restaurant->address }}, {{ $restaurant->city }}, {{ $restaurant->state }}, Ethiopia
                    </a>

                    <div class="mt-auto d-flex justify-content-between align-items-center">
                        <div class="small text-primary">
                            <i class="bi bi-star-fill text-primary me-1"></i>{{ $restaurant->rating }}
                        </div>
                        <div class="d-flex align-items-center gap-2 small text-muted">
                            <img src="{{ asset('restaurant_frontend/assets/img/scooter-02.png') }}"
                                 alt="Delivery" style="width: 22px;">
                            From {{ $restaurant->start_from }} ETB
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
