@extends('all_frontend_layouts.layouts')
@section('content')
<style>
    .category-filter {
        color: #343a40;
        /* Bootstrap text-dark default */
    }

    .category-filter.nav-active {
        color: white !important;
    }

</style>
<div class="container my-4">

    <div class="header">
        <button class="btn btn-link text-dark" onclick="history.back()">
            <a class="text-dark"><i class="bi bi-arrow-left"></i></a>
        </button>
        <h6>{{ $restaurant->name }}</h6>
    </div>

    <div class="row g-3">
        <div class="col-md-12 col-12">
            <div class="restaurants-card">
                <img id="mainProductImage" src="{{ asset('storage/' . $restaurant->cover) ?? asset('restaurant_frontend/default-image.png') }}" alt="Restaurant">

                <div class="info">
                    <h4>{{ $restaurant->name }}</h4>
                    <p>
                         <a class="text-white" href="https://www.google.com/maps?q={{ $restaurant->latitude }},{{ $restaurant->longitude }}" target="_blank">
                        {{ $restaurant->address }}, {{ $restaurant->city }}, {{ $restaurant->state }}, Ethiopia
                        </a>
                    </p>
                    <div class="d-flex align-items-center gap-2">
                        @php
                        $averageRating = \App\Models\Restaurant\RestaurantRating::where('restaurant_id', $restaurant->id)->avg('rating');
                        @endphp
                        <span><span class="bi bi-star-fill text-primary"></span> {{ number_format($averageRating, 1) }}</span>
                        <span class="bi bi-bicycle text-primary" style="font-size: 28px;"> </span><span>Free</span>
                        <span class="bi bi-clock-fill text-primary"> </span><span>20 min</span>
                    </div>
                    <!-- Add a rating button here -->

                    <button class="btn btn-outline-primary mt-3" data-bs-toggle="modal" data-bs-target="#ratingModal">
                        Leave a Review
                    </button>
                    @include('Restaurant.frontend.pages.restaurants.rating_modal')
                </div>
            </div>
        </div>
        <div class="d-flex justify-content-start mt-3">
            <img src="{{ asset('storage/' . $restaurant->cover) ?? asset('restaurant_frontend/default-image.png') }}" width="100" class="thumbnail mx-2 p-2 border rounded" alt="{{ $restaurant->name }}" style="cursor: pointer;">
            @foreach($restaurant->images as $key => $image)
            <img src="{{ asset('storage/' . $image->image_path) ?? asset('restaurant_frontend/default-image.png') }}" width="100" class="thumbnail mx-2 p-2 border rounded" alt="{{ $restaurant->name }}" style="cursor: pointer;">
            @endforeach
        </div>
        <h4>{{ $restaurant->name }}</h4>
        <div class="row pb-4 d-flex justify-content-between align-items-center">
            <div class="col-md-3 col-12 col-sm-6">
                <a class="text-dark" href="https://www.google.com/maps?q={{ $restaurant->latitude }},{{ $restaurant->longitude }}" target="_blank">
                <span> <i class="bi bi-geo-alt-fill text-primary"></i> {{ $restaurant->address }}, {{ $restaurant->city }}, {{ $restaurant->state }}, Ethiopia</span>
                </a>
            </div>
            <div class="col-md-3 col-12 col-sm-6">
                <span> <i class="bi bi-clock-fill text-primary"></i> From {{ $restaurant->opening_time }} - {{ $restaurant->closing_time }}</span>
            </div>
            <div class="col-md-3 col-12 col-sm-6">
                <span><i class="bi bi-telephone-fill text-primary"></i> {{ $restaurant->phone }}</span>
            </div>

        </div>
    </div>
    <div class="row d-flex justify-content-center align-items-center">
        <div class="col-12 ">
            <p>
                <a class="btn btn-outline-primary" data-bs-toggle="collapse" href="#RestaurantDescription" role="button" aria-expanded="false" aria-controls="RestaurantDescription">
                    Descriptions
                </a>
                <a class="btn btn-outline-primary" data-bs-toggle="collapse" href="#RestaurantRating" role="button" aria-expanded="false" aria-controls="RestaurantRating">
                    @php
                    $count= \App\Models\Restaurant\RestaurantRating::where('restaurant_id', $restaurant->id)->count();
                    @endphp
                    Customer Feedback ({{ $count? $count:'0' }})
                </a>
            </p>
            <div class="collapse mb-2 show" id="RestaurantDescription">
                <div class="offer-card card-body">
                    {{ $restaurant->description }}
                </div>
            </div>
            <div class="collapse mb-2 show" id="RestaurantRating">
                <div class="overflow-auto m-1" style="white-space: nowrap;">
                    <div class="d-flex gap-3" style="overflow-x: auto; scrollbar-width: thin;">
                        @foreach ($restaurant->ratings as $rating)
                        <div class="offer-card shadow p-3 text-left mb-2" style="min-width: 300px; max-width: 350px;">
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
    </div>


    <div class="row d-flex justify-content-center align-items-center py-4">
        <div class="col-md-8">
            <nav class="nav justify-content-center resturant-detail-nav text-white py-2">
                <a href="#" class="nav-link text-dark fw-bold category-filter {{ request('category_id') ? 'text-dark' : 'nav-active' }}" data-id="">
                    All
                </a>
                @forelse($categories as $category)
                <a href="#" class="nav-link fw-bold category-filter text-dark {{ request('category_id') == $category->id ? 'nav-active text-white' : 'text-white' }}" data-id="{{ $category->id }}">
                    {{ $category->name }}
                </a>
                @empty
                @endforelse
            </nav>
        </div>
    </div>
    <div class="row g-3 py-4" id="product-list">
        @forelse ($products as $product)
        <div class="col-md-2">
             <x-restaurant.normal-product-card :product="$product" bgColor="btn-info" />
        </div>
        @empty
        <div class="col-md-12 text-center">
            <img src="{{ asset('no-product-found..png') }}" alt="No Product Found" class="img-fluid mb-2">
            <h6 class="text-dark">No Product Found</h6>
        </div>
        @endforelse
    </div>
</div>
@forelse ($products as $product)

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const mainImage = document.getElementById('mainProductImage');
        document.querySelectorAll('.thumbnail').forEach(thumbnail => {
            thumbnail.addEventListener('click', function() {
                mainImage.src = this.src; // Set main image to clicked thumbnail
            });
        });

            $(document).on('click', '.category-filter', function(e) {
                e.preventDefault();
                var categoryId = $(this).data('id');

                $('.category-filter').removeClass('nav-active text-white').addClass('text-dark');
                $(this).addClass('nav-active text-white');

                $.ajax({
                    url: "{{ route('restaurant.filter.products') }}",
                    type: "GET",
                    data: { category_id: categoryId },
                    success: function(response) {
                        $('#product-list').html(response);
                    }
                });
            });
    });

</script>
@empty
@endforelse
@endsection

