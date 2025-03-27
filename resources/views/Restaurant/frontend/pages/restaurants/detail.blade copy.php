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
                <img src="{{ asset('storage/' . $restaurant->cover) }}" alt="Restaurant">
                <div class="info">
                    <h4>{{ $restaurant->name }}</h4>
                    <p>{{ $restaurant->address }}</p>
                    <div class="d-flex align-items-center gap-2">
                        <span>⭐ 4.7</span>
                        <span>🚴 Free</span>
                        <span>⏱ 20 min</span>
                    </div>
                </div>
            </div>
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
            <div class="col-md-3 col-12 col-sm-6">
                <!-- Modal trigger button -->
                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#ratingModal">
                    Rating
                </button>

                <!-- Modal Body -->
                <!-- if you want to close by clicking outside the modal, delete the last endpoint:data-bs-backdrop and data-bs-keyboard -->
                <!-- Modern Rating Modal -->
            <div class="modal fade" id="ratingModal" tabindex="-1" aria-labelledby="ratingModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-sm">
                    <div class="modal-content shadow-lg border-0 rounded-4">
                        <div class="modal-header bg-primary text-white">
                            <h5 class="modal-title " id="ratingModalLabel">Rate the Restaurant</h5>
                            <button type="button" class="btn-close text-white" data-bs-dismiss="modal" aria-label="Close" id="ratingClosed"></button>
                        </div>
                        <div class="modal-body text-center p-4">
                            <p class="fs-5 text-muted">How was your experience?</p>
                            <div class="rating mb-3 text-center">
                                <input type="radio" id="star5" name="rating" value="5">
                                <label for="star5">★</label>
                                <input type="radio" id="star4" name="rating" value="4">
                                <label for="star4">★</label>
                                <input type="radio" id="star3" name="rating" value="3">
                                <label for="star3">★</label>
                                <input type="radio" id="star2" name="rating" value="2">
                                <label for="star2">★</label>
                                <input type="radio" id="star1" name="rating" value="1">
                                <label for="star1">★</label>
                            </div>
                            <input type="hidden" name="restaurant_id" id="restaurant_id" value="{{ $restaurant->id }}">
                            <p class="small text-muted">Tap a star to rate.</p>
                        </div>
                        <div class="modal-footer d-flex justify-content-center">
                            <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">Cancel</button>
                            <button type="button" class="btn btn-primary px-4" id="submitRating">Submit</button>
                        </div>
                    </div>
                </div>
            </div>


                <!-- Optional: Place to the bottom of scripts -->
                <script>
                    const myModal = new bootstrap.Modal(
                        document.getElementById("modalId")
                        , options
                    , );

                </script>

            </div>
        </div>
    </div>


    <div class="row d-flex justify-content-center align-items-center py-4">
        <div class="col-md-8">
            <nav class="nav justify-content-center resturant-detail-nav text-white py-2">
                <a href="#" class="nav-link text-dark fw-bold category-filter {{ request('category_id') ? 'text-dark' : 'nav-active' }}" data-id="">
                    All
                </a>
                @foreach($categories as $category)
                <a href="#" class="nav-link fw-bold category-filter text-dark {{ request('category_id') == $category->id ? 'nav-active text-white' : 'text-white' }}" data-id="{{ $category->id }}">
                    {{ $category->name }}
                </a>
                @endforeach
            </nav>
        </div>
    </div>
    <div class="row g-3 py-4" id="product-list">
        @foreach ($products as $product)
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
        @endforeach
    </div>
</div>
<script>
    document.addEventListener("DOMContentLoaded", function() {
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
@endsection

