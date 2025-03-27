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
        <h4 class="my-4 text-dark text-center">All Products</h4>
      </div>
    <div class="row g-3 mb-3">
        <div class="col-md-12 mb-3">
            <div class="row">
                <div class="col-md-3">
                    <div class="card offer-card">
                       <div class="card-body">
                        <form id="filterForm">
                      
                            <div class="col-md-12 mb-3">
                                <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-search"></i></span>
                                <input type="text" name="search" class="form-control" placeholder="Search by name, code, or description">
                                </div>
                            </div>
                
                            <!-- Restaurant Dropdown -->
                            <div class="col-md-12 mb-3">
                                <select name="restaurant_id" class="form-select">
                                    <option value="">🍽️ Select Restaurant</option>
                                    @foreach($restaurants as $restaurant)
                                        <option value="{{ $restaurant->id }}">{{ $restaurant->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                
                            <!-- Category Dropdown -->
                            <div class="col-md-12 mb-3">
                                <select name="category_id" class="form-select">
                                    <option value="">📂 Select Category</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                
                            <!-- Subcategory Dropdown -->
                            <div class="col-md-12 mb-3">
                                <select name="subcategory_id" class="form-select">
                                    <option value="">🔖 Select Subcategory</option>
                                    @foreach($subcategories as $subcategory)
                                        <option value="{{ $subcategory->id }}">{{ $subcategory->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                
                            <!-- City Dropdown -->
                            <div class="col-md-12 mb-3">
                                <select name="city_id" class="form-select">
                                    <option value="">🌍 Select City</option>
                                    @foreach($cities as $city)
                                        <option value="{{ $city->id }}">{{ $city->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                
                            <!-- Menu Dropdown -->
                            <div class="col-md-12 mb-3">
                                <select name="menu_id" class="form-select">
                                    <option value="">📜 Select Menu</option>
                                    @foreach($menus as $menu)
                                        <option value="{{ $menu->id }}">{{ $menu->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                
                            <!-- Discount Type -->
                            <div class="col-md-12 mb-3">
                                <select name="discount_type" class="form-select">
                                    <option value="">💰 Discount Type</option>
                                    <option value="percentage">Percentage</option>
                                    <option value="fixed">Fixed Amount</option>
                                </select>
                            </div>
                
                            <!-- Free Delivery -->
                            <div class="col-md-12 mb-3">
                                <select name="is_free" class="form-select">
                                    <option value="">🚚 Free Delivery?</option>
                                    <option value="1">Yes</option>
                                    <option value="0">No</option>
                                </select>
                            </div>
                
                            <!-- Delivery Fee -->
                            <div class="col-md-12">
                                <label for="delivery_fee" class="form-label">💵 Max Delivery Fee: <span id="deliveryFeeValue">150</span> ETB</label>
                                <input type="range" name="delivery_fee" id="delivery_fee" class="form-range" min="0" max="300" value="150" oninput="updateValue('delivery_fee', 'deliveryFeeValue')">
                            </div>
                            
                            <!-- Delivery Time -->
                            <div class="col-md-12">
                                <label for="delivery_time" class="form-label">⏳ Max Delivery Time: <span id="deliveryTimeValue">50</span> min</label>
                                <input type="range" name="delivery_time" id="delivery_time" class="form-range" min="0" max="100" value="50" oninput="updateValue('delivery_time', 'deliveryTimeValue')">
                            </div>
                
                            <!-- Most Popular -->
                            <div class="col-md-12 mb-3 form-check">
                                <input type="checkbox" name="most_populer" value="1" class="form-check-input">
                                <label class="form-check-label">🔥 Most Popular</label>
                            </div>
                
                            <!-- Best Seller -->
                            <div class="col-md-12 mb-3 form-check">
                                <input type="checkbox" name="best_seller" value="1" class="form-check-input">
                                <label class="form-check-label">🏆 Best Seller</label>
                            </div>
                
                            <!-- Apply Button -->
                            <div class="col-12 text-end">
                                <button type="submit" class="btn btn-primary px-4"><i class="bi bi-check-circle"></i> Apply Filters</button>
                            </div>
                        </form>
                       </div>
                    </div>
                </div>
                <div class="col-md-9">
                    <div id="product-list">
                        @include('Restaurant.frontend.pages.products.partail')
                    </div>
                    
                </div>
            </div>
        </div>
       
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
<script>
$(document).ready(function () {
    $('#filterForm').on('submit', function (e) {
        e.preventDefault();
        $.ajax({
            url: "{{ route('all-restaurant-products') }}",
            method: "GET",
            data: $(this).serialize(),
            success: function (response) {
                $('#product-list').html(response.products);
            },
            error: function (xhr) {
                console.log(xhr.responseText);
            }
        });
    });
});
</script>


@endsection
