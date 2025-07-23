@extends('all_frontend_layouts.layouts')
@section('content')
<style>
    .size-option {
        position: relative;
        width: 50px;
        height: 50px;
        border-radius: 50%;
        border: 2px solid #055935;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        font-size: 18px;
        color: #055935;
        cursor: pointer;
    }

    .size-option input {
        position: absolute;
        opacity: 0;
        width: 100%;
        height: 100%;
        cursor: pointer;
    }

    .size-option input:checked+span {
        background-color: #055935;
        color: white;
        border-radius: 50%;
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

</style>
<div class="container">
    <div class="header">
        <button class="btn btn-link text-dark" onclick="history.back()">
            <i class="bi bi-arrow-left"></i>
        </button>
        <h5 class="my-4 text-dark text-center">Product Detail</h5>
    </div>
    <div class="row align-items-center mb-3">
        <!-- Product Image -->
        <div class="col-md-5 text-center">
            <div class="image-container position-relative">
                <div class="image-container position-relative">
                    <img src="{{ asset('restaurant_frontend/assets/img/product_background.png') }}" alt="Background" class="background-image img-fluid">
                    <img id="mainProductImage"
                         src="{{ $product->image ? $product->image : asset('restaurant_frontend/default-image.png') }}"
                         alt="Product"
                         class="product-image img-fluid position-absolute top-50 start-50 translate-middle">
                </div>
            </div>
            <div class="d-flex justify-content-center mt-3">
                @foreach($product->images as $key => $image)
                <img src="{{ $image->image_path}}" width="50" class="thumbnail mx-2 p-2 border rounded" alt="Product Image" style="cursor: pointer;">
                @endforeach
            </div>
            @if($product->sizes->count() > 0)
            <div class="d-flex d-lg-none justify-content-center my-3">
                @foreach($product->sizes as $size)
                <label class="size-option mx-2">
                    <input type="radio" name="size" value="{{ $size->final_price }}" data-price="{{ $size->final_price }}" data-size="{{ $size->size }}" class="size-selector">
                    <span>{{ strtoupper(substr($size->size, 0, 1)) }}</span>
                </label>
                @endforeach
            </div>
            @endif
        </div>
        <div class="col-1 d-none d-lg-block">
            <div class="d-flex align-items-start flex-column bd-highlight mb-3" style="height: 200px;">
                @foreach($product->sizes as $size)
                <label class="size-option mx-2 mb-3">
                    <input type="radio" name="size" value="{{ $size->final_price }}" data-price="{{ $size->final_price }}" data-size="{{ $size->size }}" class="size-selector">
                    <span>{{ strtoupper(substr($size->size, 0, 1)) }}</span>
                </label>
                @endforeach
            </div>
        </div>

        <!-- Product Details -->
        <div class="col-md-6">
            <div class="offer-card p-3 shadow-sm">
                <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
                    <h2 class="card-title text-dark">{{ $product->name }}</h2>
                    <h1 class="text-primary" id="product-price" data-base-price="{{ $product->getFinalPrice() }}">
                        {{ $product->getFinalPrice() }} Birr
                    </h1>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-center mb-3">
                        <button class="btn btn-secondary" id="decrement">−</button>
                        <input type="number" id="quantity" class="form-control mx-2 text-center" value="1" min="1" style="width: 60px;">
                        <button class="btn bg-primary text-white" id="increment">+</button>
                    </div>

                    <h4 class="card-title d-flex justify-content-between align-items-center">
                        <span class="text-dark">
                            <img src="{{ $product->image }}" style="width: 50px; height: auto;" alt="">
                            {{ $product->restaurant->name ?? 'Unknown Restaurant' }}
                        </span>
                        <span class="text-dark star">
                            @php
                            $averageRating = \App\Models\Restaurant\ProductRating::where('product_id', $product->id)->avg('rating');
                            @endphp
                            <span><span class="bi bi-star-fill text-primary"></span> {{ number_format($averageRating, 1) }}</span>
                        </span>
                        @if($product->delivery_time>0)
                        <span class="text-dark">{{ $product->delivery_time}} min</span>
                        @endif
                    </h4>
                    <p class="card-text text-dark">{{ $product->description }}</p>
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <div class="">
                            <button class="btn bg-primary text-white rounded shadow" id="addToCart" data-product-id="{{ $product->id }}">Add To Cart</button>
                            @php
                            $isInWishlist = Auth::check() && \App\Models\Restaurant\Wishlist::where('user_id', Auth::id())->where('product_id', $product->id)->exists();
                            @endphp
                            <button class="btn shadow add-to-wishlist" data-product="{{ $product->id }}">
                                <i class=" bi text-success bi-{{ $isInWishlist ? 'heart-fill' : 'heart' }}"></i>
                            </button>
                        </div>
                    {{-- @if($distance <= $product->restaurant->delivery_radius)
                        <form action="{{ route('restaurant.checkout.orderNow') }}" method="POST">
                            @csrf
                            <input type="hidden" id="p_product_id" name="product_id" value="{{ $product->id }}">
                            <input type="hidden" id="p_size" name="size" value="">
                            <input type="hidden" id="p_qty" name="qty" value="">
                            <input type="hidden" id="p_price" name="price" value="">

                            <button class="btn shadow btn-primary">
                                <i class=" bi bi-shop-window"></i> Order Now
                            </button>
                        </form>
                    @endif --}}
                    </div>
                    <div id="location-check"
                        data-restaurant-lat="{{ $product->restaurant->latitude }}"
                        data-restaurant-lng="{{ $product->restaurant->longitude }}"
                        data-delivery-radius="{{ $product->restaurant->delivery_radius }}">

                        {{-- Order Form (Initially Hidden) --}}
                        <form action="{{ route('restaurant.checkout.orderNow') }}" method="POST" id="orderForm" class="d-none">
                            @csrf
                            <input type="hidden" id="p_product_id" name="product_id" value="{{ $product->id }}">
                            <input type="hidden" id="p_size" name="size" value="">
                            <input type="hidden" id="p_qty" name="qty" value="">
                            <input type="hidden" id="p_price" name="price" value="">

                            <button class="btn shadow btn-primary">
                                <i class="bi bi-shop-window"></i> Order Now
                            </button>
                        </form>

                        {{-- Warning Message (Initially Hidden) --}}
                        <div class="alert alert-warning shadow mt-2 d-none" id="outOfRangeAlert">
                            Sorry, this restaurant is <span id="distanceKm"></span> km away from you.
                            Ordering is disabled for distant locations.
                        </div>
                        <button class="btn btn-primary shadow d-none" id="disabledOrderBtn" disabled>Order Now</button>
                    </div>

                </div>
            </div>
            <div class="my-2 d-flex justify-content-between align-items-center">
                <p class="mt-3">
                    <a class="btn btn-outline-primary shadow-sm" data-bs-toggle="collapse" href="#RestaurantRating" role="button" aria-expanded="false" aria-controls="RestaurantRating">
                        @php
                        $count= \App\Models\Restaurant\ProductRating::where('product_id', $product->id)->count();
                        @endphp
                        Customer Reviews ({{ $count? $count:'0' }})
                    </a>
                </p>
                @if($hasOrdered)
                <button class="btn btn-primary shadow-sm" data-bs-toggle="modal" data-bs-target="#ratingModal">
                    Leave a Review
                </button>
                @endif
            </div>
            @include('Restaurant.frontend.pages.products.rate')
            <div class="collapse mb-2 show" id="RestaurantRating">
                <div class="overflow-auto" style="white-space: nowrap;">
                    <div class="d-flex gap-3" style="overflow-x: auto; scrollbar-width: thin;">
                        @foreach ($product->ratings as $rating)
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
    <div class="row g-1">
        <div class="col-12">
            <h4 class="text-dark">Related Products</h4>
        </div>
        <div class="owl-carousel owl-theme products mt-4">
            @foreach ($related_products as $product)
             <x-restaurant.product-card :product="$product" />
            @endforeach
        </div>
    </div>
</div>

<script>
function haversineDistance(lat1, lon1, lat2, lon2) {
    const toRad = deg => deg * Math.PI / 180;
    const R = 6371;
    const dLat = toRad(lat2 - lat1);
    const dLon = toRad(lon2 - lon1);
    const a = Math.sin(dLat / 2) * Math.sin(dLat / 2) +
              Math.cos(toRad(lat1)) * Math.cos(toRad(lat2)) *
              Math.sin(dLon / 2) * Math.sin(dLon / 2);
    const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
    return R * c;
}

document.addEventListener("DOMContentLoaded", function () {
    const container = document.getElementById("location-check");
    if (!container) return;

    const restLat = parseFloat(container.dataset.restaurantLat);
    const restLng = parseFloat(container.dataset.restaurantLng);
    const deliveryRadius = parseFloat(container.dataset.deliveryRadius);

    const orderForm = document.getElementById("orderForm");
    const alertBox = document.getElementById("outOfRangeAlert");
    const distanceSpan = document.getElementById("distanceKm");
    const disabledBtn = document.getElementById("disabledOrderBtn");

    function showForm() {
        orderForm.classList.remove("d-none");
    }

    function showWarning(distance) {
        distanceSpan.innerText = distance.toFixed(1);
        alertBox.classList.remove("d-none");
        disabledBtn.classList.remove("d-none");
    }

    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function (position) {
            const userLat = position.coords.latitude;
            const userLng = position.coords.longitude;

            const distance = haversineDistance(userLat, userLng, restLat, restLng);

            if (distance <= deliveryRadius) {
                showForm();
            } else {
                showWarning(distance);
            }

        }, function (err) {
            console.warn("Geolocation error:", err);
            showWarning(999); // fallback
        });
    } else {
        console.warn("Geolocation not supported.");
        showWarning(999); // fallback
    }
});
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
    document.getElementById('addToCart').addEventListener('click', function () {
        let productId = this.getAttribute('data-product-id');
        let selectedSize = document.querySelector('input[name="size"]:checked');
        let quantity = document.getElementById('quantity').value;
        let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        // Handle null selectedSize
        let size = selectedSize ? selectedSize.getAttribute('data-size') : null;
        let price = selectedSize ? selectedSize.getAttribute('data-price') : document.getElementById("product-price").getAttribute("data-base-price");

        fetch("{{ route('restaurant.cart.add') }}", {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": token,
                "Content-Type": "application/json"
            },
            body: JSON.stringify({
                product_id: productId,
                size: size,
                price: price,
                quantity: quantity
            })
        })
        .then(response => response.json())
        .then(data => {
            showAlert(data.status, data.message);
            updateCartCount();
        })
        .catch(error => console.error("Error:", error));
    });
});
function updateCartCount() {
        fetch("{{ route('cart.count') }}")
            .then(response => response.json())
            .then(data => {
                document.getElementById("cart-count").innerText = data.total;
            })
            .catch(error => {
                console.error('Error fetching cart count:', error);
                document.getElementById("cart-count").innerText = '0';
            });
    }

</script>
<script>
      const mainImage = document.getElementById('mainProductImage');
    document.querySelectorAll('.thumbnail').forEach(thumbnail => {
        thumbnail.addEventListener('click', function() {
            mainImage.src = this.src; // Set main image to clicked thumbnail
        });
    });
</script>
<script>
   document.addEventListener("DOMContentLoaded", function () {
    let priceDisplay = document.getElementById("product-price");
    let quantityInput = document.getElementById("quantity");
    let incrementBtn = document.getElementById("increment");
    let decrementBtn = document.getElementById("decrement");
    let sizeSelectors = document.querySelectorAll(".size-selector");

    // Store base product price from the element
    let basePrice = parseFloat(priceDisplay.getAttribute("data-base-price") || "{{ $product->getFinalPrice() }}");

    function updatePrice() {
        let selectedSize = document.querySelector('input[name="size"]:checked');
        let price = selectedSize ? parseFloat(selectedSize.getAttribute('data-price')) : basePrice;
        let size = selectedSize ? selectedSize.getAttribute('data-size') : '';
        let quantity = parseInt(quantityInput.value);
        let totalPrice = price * quantity;

        priceDisplay.textContent = totalPrice.toFixed(2) + " Birr";

        document.getElementById('p_size').value = size;
        document.getElementById('p_qty').value = quantity;
        document.getElementById('p_price').value = totalPrice.toFixed(2);
    }

    sizeSelectors.forEach(button => {
        button.addEventListener("change", function () {
            updatePrice();
        });
    });

    incrementBtn.addEventListener("click", function () {
        quantityInput.value = parseInt(quantityInput.value) + 1;
        updatePrice();
    });

    decrementBtn.addEventListener("click", function () {
        if (quantityInput.value > 1) {
            quantityInput.value = parseInt(quantityInput.value) - 1;
            updatePrice();
        }
    });
    updatePrice();
});

</script>

@endsection

