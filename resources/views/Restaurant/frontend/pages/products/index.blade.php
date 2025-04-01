@extends('all_frontend_layouts.layouts')
@section('content')
<style>
    .card{
        border: 1px solid #b2f7b2 !important;
    }
    /* Style the range input track */
input[type="range"] {
    -webkit-appearance: none;
    width: 100%;
    height: 6px;
    border-radius: 5px;
    background: linear-gradient(90deg, #12f512 50%, #ddd 50%);
    outline: none;
    transition: background 0.3s;
}

/* Customize the thumb (the draggable part) */
input[type="range"]::-webkit-slider-thumb {
    -webkit-appearance: none;
    width: 18px;
    height: 18px;
    border-radius: 50%;
    background: #12f512;
    cursor: pointer;
    transition: transform 0.2s;
}

input[type="range"]::-moz-range-thumb {
    width: 18px;
    height: 18px;
    border-radius: 50%;
    background: #12f512;
    cursor: pointer;
}

/* Change thumb size on hover */
input[type="range"]::-webkit-slider-thumb:hover {
    transform: scale(1.2);
}

/* Update track background dynamically */
input[type="range"] {
    background-size: 50% 100%;
    background-repeat: no-repeat;
}


</style>
<div class="container-fluid">
    <div class="header">
        <button class="btn btn-link text-dark">
          <a href="{{ url('/') }}" class="text-dark"><i class="bi bi-arrow-left"></i></a>
        </button>
        <h5 class="my-4 text-dark text-center">All Products</h5>
      </div>
    <div class="row g-3 mb-3">
        <div class="col-md-12 mb-3">
            <div class="row">
                <div class="col-md-3">
                    <div class="card offer-card">
                       <div class="card-body">
                        <div class="row">
                            <!-- Search Input -->
                            <div class="col-md-12 mb-3">
                                <div class="input-group">
                                    <input type="text" id="search" class="form-control" placeholder="Search by name, code, or description">
                                    <span class="input-group-text"><i class="bi bi-search"></i></span>
                                </div>
                            </div>
                        
                            <!-- Restaurant Dropdown -->
                            <div class="col-md-12 mb-3">
                                <select id="restaurant_id" class="form-select">
                                    <option value="">Select Restaurant</option>
                                    @foreach($restaurants as $restaurant)
                                        <option value="{{ $restaurant->id }}">{{ $restaurant->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        
                            <!-- Category Dropdown -->
                            <div class="col-md-12 mb-3">
                                <select id="category_id" class="form-select">
                                    <option value="">Select Category</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        
                            <!-- Subcategory Dropdown -->
                            <div class="col-md-12 mb-3">
                                <select id="subcategory_id" class="form-select">
                                    <option value="">Select Subcategory</option>
                                    @foreach($subcategories as $subcategory)
                                        <option value="{{ $subcategory->id }}">{{ $subcategory->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        
                            <!-- City Dropdown -->
                            <div class="col-md-12 mb-3">
                                <select id="city_id" class="form-select">
                                    <option value="">Select City</option>
                                    @foreach($cities as $city)
                                        <option value="{{ $city->id }}">{{ $city->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        
                            <!-- Discount Type -->
                            <div class="col-md-12 mb-3">
                                <select id="discount_type" class="form-select">
                                    <option value="">Discount Type</option>
                                    <option value="percentage">Percentage</option>
                                    <option value="fixed">Fixed Amount</option>
                                </select>
                            </div>
                        
                            <!-- Free Delivery -->
                            <div class="col-md-12 mb-3">
                                <select id="is_free" class="form-select">
                                    <option value="">Free Delivery?</option>
                                    <option value="1">Yes</option>
                                    <option value="0">No</option>
                                </select>
                            </div>
                        
                            <!-- Max Delivery Fee -->
                            <div class="col-md-12 mb-3">
                                <label for="delivery_fee" class="form-label">Max Delivery Fee: <span id="deliveryFeeValue">150</span> ETB</label>
                                <input type="range" id="delivery_fee" class="form-range" min="0" max="300" value="0" oninput="updateValue('delivery_fee', 'deliveryFeeValue')">
                            </div>
                        
                            <!-- Max Delivery Time -->
                            <div class="col-md-12 mb-3">
                                <label for="delivery_time" class="form-label">Max Delivery Time: <span id="deliveryTimeValue">50</span> min</label>
                                <input type="range" id="delivery_time" class="form-range" min="0" max="100" value="0" oninput="updateValue('delivery_time', 'deliveryTimeValue')">
                            </div>
                        
                            <!-- Most Popular -->
                            <div class="col-md-12 mb-3 form-check">
                                <input type="checkbox" id="most_popular" value="1" class="form-check-input">
                                <label class="form-check-label"  for="most_popular">Most Popular</label>
                            </div>
                        
                            <!-- Best Seller -->
                            <div class="col-md-12 mb-3 form-check">
                                <input type="checkbox" id="best_seller" value="1" class="form-check-input">
                                <label class="form-check-label" for="best_seller">Best Seller</label>
                            </div>
                            <!-- Best Seller -->
                            <div class="col-md-12 mb-3 form-check">
                                <input type="checkbox" id="discounted" value="1" class="form-check-input">
                                <label class="form-check-label" for="discounted">Discounted</label>
                            </div>
                        </div>
                        
                        
                        
                       </div>
                    </div>
                </div>
                <div class="col-md-9">
                    <!-- Product List -->
                    <div class="row" id="product-list">
                        @include('Restaurant.frontend.pages.products.partail', ['products' => $products])
                    </div>
                    {{-- <div class="row">
                        @forelse ($products as $product)
                            <div class="col-md-3 col-6 my-2">
                                <div class="offer-card p-3 h-100">
                                    <a href="{{ url('restaurant/product-detail/'.$product->id) }}">
                                        @php
                                            $off = $product->price - $product->getFinalPrice();
                                        @endphp
                                        @if($off > 0)
                                            <span class="badge-offer">
                                                {{ $off }} ETB OFF
                                            </span>
                                        @endif
                                        <img src="{{ asset('storage/' . $product->image) }}" class="img-fluid mb-2" alt="{{ $product->name }}">
                                        <h6 class="text-dark">{{ $product->name }}</h6>
                                        <p class="mb-0">
                                            <span class="price">{{ $product->getFinalPrice() }} ETB</span>
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
                            <p class="text-center text-muted">No products found.</p>
                        @endforelse
                    </div> --}}
                </div>
            </div>
        </div>

    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll("select, input").forEach((element) => {
        element.addEventListener("change", filterProducts);
    });

    function filterProducts() {
        let data = {
            search: document.getElementById("search").value,
            restaurant_id: document.getElementById("restaurant_id").value,
            category_id: document.getElementById("category_id").value,
            subcategory_id: document.getElementById("subcategory_id").value,
            city_id: document.getElementById("city_id").value,
            discount_type: document.getElementById("discount_type").value,
            is_free: document.getElementById("is_free").value,
            delivery_fee: document.getElementById("delivery_fee").value,
            delivery_time: document.getElementById("delivery_time").value,
            most_popular: document.getElementById("most_popular").checked ? 1 : 0,
            best_seller: document.getElementById("best_seller").checked ? 1 : 0,
            discounted: document.getElementById("discounted").checked ? 1 : 0,
        };

        fetch("{{ route('filter-restaurant-products') }}", {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": "{{ csrf_token() }}",
                "Content-Type": "application/json",
            },
            body: JSON.stringify(data),
        })
            .then((response) => response.text())
            .then((html) => {
                document.getElementById("product-list").innerHTML = html;
            })
            .catch((error) => console.error("Error:", error));
    }
});

</script>
<script>
    function updateValue(inputId, displayId) {
        document.getElementById(displayId).innerText = document.getElementById(inputId).value;
    }
    document.querySelectorAll('input[type="range"]').forEach(slider => {
    slider.addEventListener('input', function () {
        let percentage = ((this.value - this.min) / (this.max - this.min)) * 100;
        this.style.background = `linear-gradient(90deg, #007bff ${percentage}%, #ddd ${percentage}%)`;
    });
});

</script>
@endsection
