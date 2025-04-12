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
        <i class="bi bi-search search-icon"></i>
    </div>

    <div class="row g-3">
        <div class="col-md-12 col-12">
            <div class="restaurants-card">
                    <img id="mainProductImage" src="{{ asset('storage/' . $restaurant->cover) }}" alt="Restaurant">

                <div class="info">
                    <h4>{{ $restaurant->name }}</h4>
                    <p>{{ $restaurant->address }}</p>
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
            <img src="{{ asset('storage/' . $restaurant->cover) }}"  width="100"
            class="thumbnail mx-2 p-2 border rounded"
            alt="{{ $restaurant->name }}"
            style="cursor: pointer;">
            @foreach($restaurant->images as $key => $image)
                <img src="{{ asset('storage/' . $image->image_path) }}"
                    width="100"
                    class="thumbnail mx-2 p-2 border rounded"
                    alt="{{ $restaurant->name }}"
                    style="cursor: pointer;">
            @endforeach
        </div>
        <h4>Grub On Burger</h4>
        <div class="row pb-4 d-flex justify-content-between align-items-center">
            <div class="col-md-3 col-12 col-sm-6">
                <span> <i class="bi bi-geo-alt-fill text-primary"></i> {{ $restaurant->address }}</span>
            </div>
            <div class="col-md-3 col-12 col-sm-6">
                <span> <i class="bi bi-clock-fill text-primary"></i> From 5pm - 1 Am</span>
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
                                    @for ($i = 1; $i <= 5; $i++)
                                        @if ($i <= $rating->rating)
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
        <div class="col-md-2 col-6 my-2 product-item">
            <div class="offer-card p-3 h-100">
                <a href="{{ url('restaurant/product-detail/'.$product->id) }}">
                    @php
                    $off = $product->price - $product->getFinalPrice();
                    @endphp
                    @if($off > 0)
                    <a class="badge-offer">
                        {{ $off }} ETB OFF
                    </a>
                    @endif
                    <img src="{{ asset('storage/' . $product->image) }}" class="img-fluid mb-2" alt="{{ $product->name }}">
                    <h6 class="text-dark">{{ $product->name }}</h6>
                    <p class="mb-0"><span class="price">{{ $product->getFinalPrice() }} ETB</span>
                        <span class="price-old">{{ $product->price }} ETB</span>
                    </p>
                </a>
                <div class="hover-buttons">
                    <button onclick="window.location.href='{{ url('restaurant/product-detail/'.$product->id) }}'" class="btn-view">
                        <i class="bi bi-eye-fill"></i>
                    </button>
                    <button class="btn-cart add-to-cart" data-product="{{ $product->id }}">
                        <i class="bi bi-cart-check-fill"></i>
                    </button>
                    <button class="btn-wishlist add-to-wishlist" data-product="{{ $product->id }}">
                        <i class="bi bi-heart text-white"></i>
                    </button>
                </div>
            </div>
        </div>
        @empty
        <div class="col-md-12 text-center">
            <img src="{{ asset('no-product-found..png') }}" alt="No Product Found"
            class="img-fluid mb-2">
            <h6 class="text-dark">No Product Found</h6>
            </div>
        @endforelse
      </div>
</div>
@forelse ($products as $product)

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const mainImage = document.getElementById('mainProductImage');
        // Get all thumbnails and add a click event
        document.querySelectorAll('.thumbnail').forEach(thumbnail => {
            thumbnail.addEventListener('click', function () {
                mainImage.src = this.src; // Set main image to clicked thumbnail
            });
        });

        document.querySelectorAll(".category-filter").forEach(button => {
            button.addEventListener("click", function(event) {
                event.preventDefault();
                let categoryId = this.getAttribute("data-id");
                let restaurantId = "{{ $restaurant->id }}"; // Pass restaurant ID dynamically

                // Remove active class from all and add to clicked one
                document.querySelectorAll(".category-filter").forEach(nav => nav.classList.remove("nav-active", "text-white"));
                this.classList.add("nav-active", "text-white");

                fetch("{{ route('restaurant.products.filter') }}", {
                        method: "POST"
                        , headers: {
                            "X-CSRF-TOKEN": "{{ csrf_token() }}"
                            , "Content-Type": "application/json"
                        }
                        , body: JSON.stringify({
                            category_id: categoryId
                            , restaurant_id: restaurantId
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        let productList = document.getElementById("product-list");
                        productList.innerHTML = "";

                        if (data.products.length === 0) {
                            productList.innerHTML = "<p class='text-center'>No products found.</p>";
                            return;
                        }
                        data.products.forEach(product => {
                            let discount = product.price - product.final_price;
                            productList.innerHTML += `
                        <div class="col-md-2 col-6 my-2 product-item">
                            <div class="offer-card p-3 h-100">
                                <a href="/restaurant/product-detail/${product.id}">
                                    ${discount > 0 ? `<span class="badge-offer">${discount} ETB OFF</span>` : ""}
                                    <img src="/storage/${product.image}" class="img-fluid mb-2" alt="${product.name}">
                                    <h6 class="text-dark">${product.name}</h6>
                                    <p class="mb-0">
                                        <span class="price">${product.final_price} ETB</span>
                                        <span class="price-old">${product.price} ETB</span>
                                    </p>
                                </a>
                                 <div class="hover-buttons">
                                        <button onclick="window.location.href='{{ url('restaurant/product-detail/'.$product->id) }}'" class="btn-view">
                                            <i class="bi bi-eye-fill"></i>
                                        </button>
                                        <button class="btn-cart add-to-cart" data-product="{{ $product->id }}">
                                            <i class="bi bi-cart-check-fill"></i>
                                        </button>
                                        <button class="btn-wishlist add-to-wishlist" data-product="{{ $product->id }}">
                                            <i class="bi bi-heart text-white"></i>
                                        </button>
                                    </div>
                            </div>
                        </div>`;
                        });
                    });
            });
        });
    });

</script>
@empty
@endforelse
@endsection

