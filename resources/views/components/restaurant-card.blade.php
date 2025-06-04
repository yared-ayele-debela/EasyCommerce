
@props(['restaurant', 'distance', 'time'])
{{-- GRID ITEM --}}
<div class="col-lg-6 col-md-6">
    {{-- CARD --}}
    <div class="offer-card h-100 overflow-hidden">
        <div class="row g-0 align-items-stretch">
            {{-- ⬅️ IMAGE COLUMN --}}
            <div class="col-4 col-sm-4">
                <a href="{{ url('restaurant/' . $restaurant->id . '/detail') }}" class="h-100 d-block">
                    @php
                        $relative = $restaurant->cover
                                   ? str_replace('storage/', '', ltrim(parse_url($restaurant->cover, PHP_URL_PATH) ?? '', '/'))
                                   : null;
                        $imgSrc   = $relative && Storage::disk('public')->exists($relative)
                                   ? $restaurant->cover
                                   : asset('restaurant_frontend/default-image.png');
                    @endphp

                    <img src="{{ $imgSrc }}"
                         alt="{{ $restaurant->name }}"
                         class="img-fluid object-fit-cover w-100 h-100 p-2"
                         style="min-height: 180px; max-height: 230px;">
                </a>
            </div>

            {{-- ➡️ INFO COLUMN --}}
            <div class="col-8 col-sm-8">
                <div class="card-body d-flex flex-column h-100 py-3 px-4">
                    {{-- NAME --}}
                    <h5 class="card-title mb-1 text-truncate" title="{{ $restaurant->name }}">
                        {{ $restaurant->name }}
                    </h5>

                    <p class="text-muted d-none d-md-block">
                      {{ Str::words($restaurant->description, 20, '...') }}
                    </p>
                    {{-- BADGES: distance + time --}}
                    <div class="mb-2 d-flex flex-wrap gap-2">
                        <span class="badge bg-light text-dark px-3 py-2 rounded-pill">
                            <i class="bi bi-geo-alt-fill text-danger me-1"></i>{{ $distance }} km
                        </span>
                        <span class="badge bg-light text-dark px-3 py-2 rounded-pill">
                            <i class="bi bi-clock-fill text-primary me-1"></i>{{ $time }} min
                        </span>
                    </div>

                    {{-- ADDRESS --}}
                    <p class="small text-muted mb-2">
                        <i class="bi bi-pin-map-fill text-primary me-1"></i>{{ $restaurant->address }}
                    </p>

                    {{-- RATING & PRICE (aligned bottom) --}}
                    <div class="mt-auto d-flex justify-content-between align-items-center">
                        <div class="small text-primary">
                            <i class="bi bi-star-fill text-primary me-1"></i>{{ $restaurant->rating }}
                        </div>
                        <div class="d-flex align-items-center gap-2 small text-muted">
                            <img src="{{ asset('restaurant_frontend/assets/img/scooter-02.png') }}"
                                 alt="Delivery"
                                 style="width: 22px;">
                            From {{ $restaurant->start_from }} ETB
                        </div>
                    </div>

                </div>
            </div>

        </div> {{-- /row --}}
    </div>{{-- /card --}}
</div>{{-- /grid item --}}

