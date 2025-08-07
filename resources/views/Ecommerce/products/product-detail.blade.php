<?php use App\Models\Product;
use App\Models\ProductFilter;
$productFilters = ProductFilter::productFilters();
use App\Models\Wishlist;
?>
@extends('all_frontend_layouts.layouts')
@section('content')
<style>
    .color-dot {
        width: 20px;
        height: 20px;
        border-radius: 50%;
        display: inline-block;
        margin-right: 10px;
        cursor: pointer;
    }

    .color-dot.selected {
        outline: 2px solid #000;
    }

    .custom-size-checkbox {
        display: none;
    }

    .custom-size-label {
        border: 1px solid #ddd;
        border-radius: 6px;
        padding: 7px 12px;
        margin: 5px;
        cursor: pointer;
        transition: all 0.3s ease;
        font-weight: bold;
        background-color: #f9f9f9;
    }

    .custom-size-checkbox:checked+.custom-size-label {
        background-color: #055935;
        color: white;
        border-color: #055935;
    }

    .qty-btn {
        width: 40px;
        height: 40px;
    }

</style>
<div class="container-fluid">
    <div class="header">
        <button class="btn btn-link text-dark" onclick="history.back()">
            <i class="bi bi-arrow-left"></i>
        </button>
        <h5 class="my-4 text-dark text-center">{{ $product->product_name }}</h5>
    </div>
    <div class="row g-4 py-4">
        <div class="row">
                <div class="col-12 col-md-5 order-1 order-md-2 mb-3 mb-md-0 mb-2">
                    <img id="mainProductImage" src="{{ asset('storage/' . $product->product_image) ?? asset('restaurant_frontend/default-image.png') }}" class="img-fluid border-0 rounded w-100" alt="{{ $product->product_name }}" />
                </div>

                <!-- Thumbnails -->
                <div class="col-12 col-md-1 d-flex flex-md-column gap-3 order-2 order-md-1 mb-2">
                    @foreach ($product['images'] as $image )
                    <img
                        src="{{asset('storage/' . $image->image) ?? asset('restaurant_frontend/default-image.png') }}"
                        class="img-fluid border rounded thumbnail-image"
                        style="cursor: pointer; max-width: 80px;"
                        alt="{{ $product->product_name }}"
                        onclick="document.getElementById('mainProductImage').src = this.src"
                    />
                    @endforeach
            </div>
            <!-- Product Details -->
            <div class="col-md-6 order-md-3 order-3 mb-2">
                   @php
                      $discountedPrice = number_format(App\Models\Product::getDiscountPrice($product->id),2);
                    @endphp
                <!-- Rating -->
                <div class="mb-2">
                    <span class="text-warning">
                        @if($avgStarRating > 0)
                        <div class="product-rating mb-2">
                            <p>
                                @for ($i = 1; $i <= 5; $i++) @if ($i <=round($avgStarRating)) <i class="bi bi-star-fill text-primary"></i>
                                    {{-- Filled Star --}}
                                    @else
                                    <i class="bi bi-star text-primary"></i>
                                    @endif
                                    @endfor
                                    <span class="text-muted">({{ number_format($avgRating, 1) }})</span>
                            </p>
                        </div>
                        @endif

                    </span>
                    <small class="text-muted">({{$ratings->count() }} Reviews)</small>
                    @if($totalStock>0)
                    <span class="text-primary ms-3"><b>In Stock</b></span>
                    @else
                    <span class="text-danger ms-3"><b>Out of Stock</b></span>

                    @endif
                </div>
                <div class="getAttributePrice mt-3">
                    <div class="price">
                        <h3 class="dynamic-price fw-bolder text-dark"> {{ $discountedPrice }} ETB</h3>
                    </div>
                </div>

                <p class="text-muted">
                    {!!$product['description'] !!}
                </p>
                <hr>
                <p class="text-muted mb-2">Product Code: <strong>{{ $product->product_code }}</strong></p>
                <div class="mb-2">
                    @if($totalStock>0)
                    <span><strong>Only: </strong>{{ $totalStock }} left</span>
                    @endif
                </div>
                @if(isset($productDetails['vendor']) && isset($productDetails['vendor']['vendorbusinessdetails']) && isset($productDetails['vendor']['vendorbusinessdetails']['shop_name']))
                <div class="mb-2">
                    <strong>Seller:</strong>
                    <a href="/products/{{ $productDetails['vendor']['id'] }}">{{ $productDetails['vendor']['vendorbusinessdetails']['shop_name'] }}</a>
                </div>
                @endif
                <!-- Colours -->
                <div class="mb-3">
                    <span><strong>Color: <span class="color-dot selected mb-0" style="background-color: {{ $product->product_color}}"></span> </strong></span>
                </div>
                <!-- Size -->

                @if($product['attributes'])
                <div class="mb-2">
                    <label class="form-label fw-bold d-block">Select Size:</label>
                    <div id="sizeOptions" class="d-flex flex-wrap">
                        @foreach ($product['attributes'] as $index => $attribute)
                        <input type="radio" class="custom-size-checkbox" name="product_size" id="size_{{ $index }}" value="{{ $attribute['size'] }}" product-id="{{ $product->id }}">
                        <label for="size_{{ $index }}" class="custom-size-label">{{ $attribute['size'] }}</label>
                        @endforeach
                    </div>
                </div>
                @endif
                @if($totalStock>0)
                <form id="addToCartForm">
                    <input type="hidden" id="product_id" name="product_id" value="{{ $product->id }}">
                    <input type="hidden" id="final_price_input" name="final_price" value="{{ $discountedPrice }}">
                    <input type="hidden" id="unit_price_hidden" value="{{ $discountedPrice }}">

                    <div class="d-flex align-items-center mb-2">
                        <button type="button" class="btn btn-secondary shadow-sm" id="decrement">−</button>
                        <input type="number" id="quantity" class="form-control mx-2 text-center" value="1" min="1" style="width: 60px;">
                        <button type="button" class="btn bg-primary text-white shadow-sm" id="increment">+</button>
                        <button type="submit" class="btn btn-primary shadow-sm ms-2 px-2 px-sm-4" id="addToCartBtn">Add to Cart</button>

                        <button class="btn btn-outline-primary ms-2 wishlist-btn  shadow-sm" data-product-id="{{ $product->id }}" title="Add to Wishlist">
                            <i class="far fa-heart"></i>
                        </button>
                    </div>
                </form>
                <form action="{{ route('direct.checkout', ['product_id' => $product->id]) }}" method="POST">
                    @csrf

                    <input type="hidden" id="final_price_inputs" name="final_price" value="{{ $discountedPrice }}">
                    <input type="hidden" id="unit_price_hiddens" name="unit_price" value="{{ $discountedPrice }}">
                    <input type="hidden" id="original_price" name="original_price" value="{{ $product->product_price }}">
                    <input type="hidden" id="direct_size" name="size" value="">
                    <button type="submit" class="btn btn-primary shadow-sm">
                        <img src="{{ asset('restaurant_frontend/ordernow.png') }}" height="25" alt="">    Order Now
                    </button>
                </form>
                @else
                <button class="btn btn-outline-primary btn-sm mb-2 notify-vendor-btn" data-product-id="{{ $product->id }}">
                   <i class="bi bi-bell"></i> Notify Vendor
                </button>
                @include('Ecommerce.products.modal.out_of_stock')
                @endif
                <div class="border rounded p-3 my-2">
                    <i class="fas fa-truck me-2"></i><strong>Free Delivery</strong>
                    <p class="mb-0 small text-muted">Enter your postal code for Delivery Availability</p>
                </div>
                @if($product->is_returnable)
                <div class="border rounded p-3">
                    <i class="fas fa-undo me-2"></i><strong>Return Delivery</strong>
                    <p class="mb-0 small text-muted">Free 30 Days Delivery Returns. <a href="{{ url('page/delivery_and_return') }}" target="_blank" class="text-primary">Details</a></p>
                </div>
                @endif
                <div class="my-2 d-flex justify-content-between align-items-center">
                    <p class="mt-3">
                        <a class="btn btn-outline-primary shadow-sm" data-bs-toggle="collapse" href="#RestaurantRating" role="button" aria-expanded="false" aria-controls="RestaurantRating">
                            @php
                            $count= \App\Models\Rating::where('product_id', $product->id)->count();
                            @endphp
                            Customer Reviews ({{ $count? $count:'0' }})
                        </a>
                    </p>
                    @if($check_ordered_by_current_user)
                    <button class="btn btn-primary shadow-sm" data-bs-toggle="modal" data-bs-target="#EcommerceratingModal">
                        Leave a Review
                    </button>
                    @endif
                </div>
                @include('Ecommerce.products.rating.rating')
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
            <div class="col-md-12 order-md-4 order-4">
                <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="pills-Description-tab" data-bs-toggle="pill" data-bs-target="#pills-Description" type="button" role="tab" aria-controls="pills-Description" aria-selected="true">Description</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pills-Specifications-tab" data-bs-toggle="pill" data-bs-target="#pills-Specifications" type="button" role="tab" aria-controls="pills-Specifications" aria-selected="false">Specifications</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pills-Reviews-tab" data-bs-toggle="pill" data-bs-target="#pills-Reviews" type="button" role="tab" aria-controls="pills-Reviews" aria-selected="false">Customer Reviews ({{ $ratings->count() }})</button>
                    </li>

                </ul>
                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="pills-Description" role="tabpanel" aria-labelledby="pills-Description-tab" tabindex="0">
                        <p> {!! $product['description'] !!}</p>
                        @if(!empty($product['product_video']))
                        <video src="{{$product['product_video'] }}" style="width:380px;  box-shadow:1px 1px 2px gray; height:250px" controls></video>
                        @else
                        <h6 class="text-muted">Product Video does not exists</h6>
                        @endif
                    </div>
                    <div class="tab-pane fade" id="pills-Specifications" role="tabpanel" aria-labelledby="pills-Specifications-tab" tabindex="0">
                        <h6 class="text-muted">Product Additional Information</h6>
                        <div class="row row-cols-1 row-cols-md-2 g-3">
                            @foreach ($productFilters as $filter)
                            @if(isset($product['category_id']))
                            @php
                            $filterAvailable = ProductFilter::filterAvailable($filter['id'], $product['category_id']);
                            @endphp

                            @if($filterAvailable == "Yes")
                            @php
                            $valueToShow = '';
                            foreach ($filter['filter_values'] as $value) {
                            if (!empty($product[$filter['filter_column']]) && $value['filter_value'] == $product[$filter['filter_column']]) {
                            $valueToShow = ucwords($value['filter_value']);
                            break;
                            }
                            }
                            @endphp

                            @if($valueToShow)
                            <div class="col">
                                <div class="border rounded p-3 shadow-sm bg-light d-flex justify-content-between align-items-center">
                                    <span class="fw-semibold text-muted">{{ $filter['filter_name'] }}</span>
                                    <span class="fw-bold">{{ $valueToShow }}</span>
                                </div>
                            </div>
                            @endif
                            @endif
                            @endif
                            @endforeach
                        </div>

                    </div>
                    <div class="tab-pane fade" id="pills-Reviews" role="tabpanel" aria-labelledby="pills-Reviews-tab" tabindex="0">
                        <div class="overflow-auto" style="white-space: nowrap;">
                            <div class="d-flex gap-3" style="overflow-x: auto; scrollbar-width: thin;">
                                @if(count($ratings)>0)
                                @foreach($ratings as $rating)
                                <div class="offer-card shadow p-3 text-left mb-2" style="min-width: 300px; white-space: normal; word-wrap: break-word;">
                                    <span class="font-italic">Name: {{ $rating->user->name }}</span>
                                    <br>
                                    <p class="fst-italic">Comment: {{ $rating->review }}</p>
                                    <span>
                                        @for ($i = 1; $i <= 5; $i++) @if ($i <=$rating['rating']) <i class="bi bi-star-fill text-primary"></i>
                                            @else
                                            <i class="bi bi-star text-primary"></i>
                                            @endif
                                            @endfor
                                    </span>
                                    <hr>
                                    <span class="text-muted">Date: {{ date("d-m-Y", strtotime($rating->created_at)) }}</span>
                                </div>

                                @endforeach
                                @else
                                <p><b>Reviews are not available for this product!</b></p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="header">
        <h4 class="my-2 text-dark text-left">Recently Viewed Products</h4>
    </div>
    <div class="row g-4">
        <div class="owl-carousel owl-theme ecommerce_products mt-4">
            @foreach ($recentlyViewedProducts as $product)
             <x-product-card :product="$product" />
            @endforeach
        </div>
    </div>
    <div class="header">
        <h4 class="my-2 text-dark text-left">Similar Products</h4>
    </div>
    <div class="row g-4">
        <div class="owl-carousel owl-theme ecommerce_products mt-4">
            @foreach ($similarProducts as $product)
            <x-product-card :product="$product" />
            @endforeach
        </div>
    </div>
</div>
<script>
    // JavaScript to show modal with product ID
$(document).on('click', '.notify-vendor-btn', function () {
    const productId = $(this).data('product-id');
    $('#notify-product-id').val(productId);
    $('#notifyVendorModal').modal('show');
});



</script>
<script>
    $(document).ready(function() {
        $("input[name='product_size']").on("change", function() {
            var size = $(this).val();
            var product_id = $(this).attr("product-id");
            if (size !== "") {
                $.ajax({
                    url: '/get-product-price'
                    , type: 'POST'
                    , data: {
                        size: size
                        , product_id: product_id
                        , _token: $('meta[name="csrf-token"]').attr('content')
                    }
                    , success: function(response) {
                        let unitPrice = parseFloat(response.final_price_product_detail);

                        $('.dynamic-price').html(unitPrice + " ETB");
                        $('#final_price_input').val(unitPrice);
                        $('#unit_price_hidden').val(unitPrice);
                        $('#final_price_inputs').val(unitPrice);
                        $('#unit_price_hiddens').val(unitPrice);
                        $('#direct_size').val(size);

                        updateFinalPrice();
                    }
                    , error: function() {
                        alert('Error fetching price. Please try again.');
                    }
                });
            }
        });

        // Quantity Increment
        $('#increment').click(function() {
            let quantity = parseInt($('#quantity').val()) || 1;
            $('#quantity').val(quantity + 1);
            updateFinalPrice();
        });

        // Quantity Decrement
        $('#decrement').click(function() {
            let quantity = parseInt($('#quantity').val()) || 1;
            if (quantity > 1) {
                $('#quantity').val(quantity - 1);
                updateFinalPrice();
            }
        });

        // Quantity Manual Input
        $('#quantity').on('input', function() {
            updateFinalPrice();
        });

        // Update Final Price
        function updateFinalPrice() {
            let quantity = parseInt($('#quantity').val()) || 1;
            let unitPrice = parseFloat($('#unit_price_hidden').val()) || 0;
            let finalPrice = quantity * unitPrice;
            $('.dynamic-price').html(finalPrice.toFixed(2) + " ETB");
            $('#final_price_input').val(finalPrice.toFixed(2));
            $('#final_price_inputs').val(finalPrice.toFixed(2));
        }
    });
    $('#addToCartBtn').on('click', function(e) {
        e.preventDefault();
        let product_id = $('#product_id').val();
        let size = $('input[name="product_size"]:checked').val() || null;
        let quantity = parseInt($('#quantity').val()) || 1;

        $.ajax({
            url: '/add-to-cart'
            , type: 'POST'
            , data: {
                _token: $('meta[name="csrf-token"]').attr('content')
                , product_id: product_id
                , size: size
                , quantity: quantity
            }
            , success: function(response) {
                if (response.status === 'success') {
                    showAlert('success', 'Product added to cart');
                } else if(response.status==="error") {
                    showAlert('info', response.message);
                }
                updateCartCount();
            }
            , error: function(xhr) {
                if (xhr.status === 422) {
                    showAlert('error', 'Validation failed: ' + xhr.responseJSON.message);
                } else {
                    showAlert('error', 'Error adding product to cart.');
                }
            }
        });
    });
</script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const thumbnails = document.querySelectorAll('.thumbnail-image');
        const mainImage = document.getElementById('mainProductImage');

        thumbnails.forEach(thumbnail => {
            thumbnail.addEventListener('click', function() {
                mainImage.src = this.src;
            });
        });
    });

</script>
@endsection

