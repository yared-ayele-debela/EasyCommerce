@extends('all_frontend_layouts.layouts')
@section('content')
<style>
    .size-option {
        position: relative;
        width: 50px;
        height: 50px;
        border-radius: 50%;
        border: 2px solid #12f512;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        font-size: 18px;
        color: #12f512;
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
        background-color: #12f512;
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
                @php
                        $imagePath = $product->image
                        ? str_replace(asset('storage') . '/', '', $product->image)
                        : null;
                @endphp
                <img src="{{ asset('restaurant_frontend/assets/img/product_background.png') }}" alt="Background" class="background-image img-fluid">
                @if($product->image && Storage::disk('public')->exists($imagePath))
                <img id="mainProductImage" src="{{ $product->image }}" alt="Product" class="product-image img-fluid position-absolute top-50 start-50 translate-middle">
                @else
                <img id="mainProductImage" src="{{ asset('restaurant_frontend/default-image.png') }}" alt="Product" class="product-image img-fluid position-absolute top-50 start-50 translate-middle">
                @endif
            </div>
            <div class="d-flex justify-content-center mt-3">
                @foreach($product->images as $key => $image)
                <img src="{{ asset($image->image_path)}}" width="50" class="thumbnail mx-2 p-2 border rounded" alt="Product Image" style="cursor: pointer;">
                @endforeach
            </div>
            @if($product->sizes->count() > 0)
            <div class="d-flex d-lg-none justify-content-center my-3">
                @foreach($product->sizes as $size)
                <label class="size-option mx-2">
                    <input type="radio" name="size" value="{{ $size->price }}" data-price="{{ $size->price }}" data-size="{{ $size->size }}" class="size-selector">
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
                    <input type="radio" name="size" value="{{ $size->price }}" data-price="{{ $size->price }}" data-size="{{ $size->size }}" class="size-selector">
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
                    <h1 class="text-primary" id="product-price">
                        {{ $product->sizes->first()->price ?? $product->price }} Birr
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
                            <img src="{{ asset('restaurant_frontend/assets/img/category.png') }}" style="width: 50px; height: auto;" alt="">
                            {{ $product->restaurant->name ?? 'Unknown Restaurant' }}
                        </span>
                        <span class="text-dark star">
                            @php
                            $averageRating = \App\Models\Restaurant\ProductRating::where('product_id', $product->id)->avg('rating');
                            @endphp
                            <span><span class="bi bi-star-fill text-primary"></span> {{ number_format($averageRating, 1) }}</span>
                        </span>
                        <span class="text-dark">20min</span>
                    </h4>
                    <p class="card-text text-dark">{{ $product->description }}</p>
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="">
                            <button class="btn bg-primary text-white rounded shadow" id="addToCart" data-product-id="{{ $product->id }}">Add To Cart</button>
                            @php
                            $isInWishlist = Auth::check() && \App\Models\Restaurant\Wishlist::where('user_id', Auth::id())->where('product_id', $product->id)->exists();
                            @endphp
                            <button class="btn shadow add-to-wishlist" data-product="{{ $product->id }}">
                                <i class=" bi text-success bi-{{ $isInWishlist ? 'heart-fill' : 'heart' }}"></i>
                            </button>
                        </div>
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
                <button class="btn btn-primary shadow-sm" data-bs-toggle="modal" data-bs-target="#ratingModal">
                    Leave a Review
                </button>
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
            <div class="item my-2">
                <div class="offer-card p-3 h-100">
                    <a href="{{ url('restaurant/product-detail/'.encrypt($product->id)) }}" class="text-decoration-none text-dark d-block">
                        @php
                        $off = $product->price - $product->getFinalPrice();
                        @endphp
                        @if($off > 0)
                        <div class="btn btn-sm btn-primary">
                            {{ $off }} ETB OFF
                        </div>
                        @endif
                        @php
                                $imagePath = $product->image
                                ? str_replace(asset('storage') . '/', '', $product->image)
                                : null;
                        @endphp

                        @if($product->image && Storage::disk('public')->exists($imagePath))
                            <img src="{{ $product->image }}" class="img-fluid mb-2" alt="{{ $product->name }}">
                        @else
                            <img src="{{ asset('restaurant_frontend/default-image.png') }}" class="img-fluid mb-2" alt="No Image">
                        @endif
                        <h6 class="text-dark">{{ $product->name }}</h6>
                        <p class="mb-0">
                            <span class="price">{{ $product->getFinalPrice() }} ETB</span>
                            <span class="price-old">{{ $product->price }} ETB</span>
                        </p>
                    </a>
                    <div class="hover-buttons">
                        <button onclick="window.location.href='{{ url('restaurant/product-detail/'.encrypt($product->id)) }}'" class="btn-view">
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
</div>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        let priceDisplay = document.getElementById("product-price");
        let quantityInput = document.getElementById("quantity");
        let incrementBtn = document.getElementById("increment");
        let decrementBtn = document.getElementById("decrement");
        let sizeSelectors = document.querySelectorAll(".size-selector");
        let selectedPrice = parseFloat(sizeSelectors[0] ? .getAttribute("data-price") || "{{ $product->price }}");

        function updatePrice() {
            let selectedSize = document.querySelector('input[name="size"]:checked');
            let size = selectedSize ? selectedSize.getAttribute('data-size') : '';
            let quantity = parseInt(quantityInput.value);
            let totalPrice = selectedPrice * quantity;
            priceDisplay.textContent = totalPrice.toFixed(2) + " Birr";

            document.getElementById('p_size').value = size;
            document.getElementById('p_qty').value = quantity;
            document.getElementById('p_price').value = totalPrice.toFixed(2); // Set price to 2 decimal places

        }
        // Handle size selection
        sizeSelectors.forEach(button => {
            button.addEventListener("change", function() {
                selectedPrice = parseFloat(this.getAttribute("data-price"));
                updatePrice();
            });
        });

        incrementBtn.addEventListener("click", function() {
            quantityInput.value = parseInt(quantityInput.value) + 1;
            updatePrice();
        });

        decrementBtn.addEventListener("click", function() {
            if (quantityInput.value > 1) {
                quantityInput.value = parseInt(quantityInput.value) - 1;
                updatePrice();
            }
        });
        // Update price initially
        updatePrice();
    });
    const mainImage = document.getElementById('mainProductImage');
    document.querySelectorAll('.thumbnail').forEach(thumbnail => {
        thumbnail.addEventListener('click', function() {
            mainImage.src = this.src; // Set main image to clicked thumbnail
        });
    });
    document.getElementById('addToCart').addEventListener('click', function() {

        let productId = this.getAttribute('data-product-id');
        let selectedSize = document.querySelector('input[name="size"]:checked');
        let quantity = document.getElementById('quantity').value;


        let price = selectedSize.getAttribute('data-price');
        let size = selectedSize.getAttribute('data-size');

        fetch("{{ route('restaurant.cart.add') }}", {
                method: "POST"
                , headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    , "Content-Type": "application/json"
                }
                , body: JSON.stringify({
                    product_id: productId
                    , size: size
                    , price: price
                    , quantity: quantity
                })
            })
            .then(response => response.json())
            .then(data => {
                showAlert(data.status, data.message);
                updateCartCount();
            })
            .catch(error => console.error("Error:", error));
    });

</script>
@endsection

