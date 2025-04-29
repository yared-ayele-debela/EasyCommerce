@extends('all_frontend_layouts.layouts')
@section('content')
@php
use App\Models\Restaurant\Product;

@endphp
<div class="container my-4">
    <div class="header">
        <button class="btn btn-link text-dark" onclick="history.back()">
            <i class="bi bi-arrow-left"></i>
        </button>
        <h5 class="my-4 text-dark text-center">My Cart</h5>
    </div>

    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="pills-cart-tab" data-bs-toggle="pill" data-bs-target="#pills-cart" type="button" role="tab" aria-controls="pills-cart" aria-selected="true">Restaurant Cart</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="pills-ecommerce-tab" data-bs-toggle="pill" data-bs-target="#pills-ecommerce" type="button" role="tab" aria-controls="pills-ecommerce" aria-selected="false">Ecommerce Cart</button>
        </li>
    </ul>
    <div class="tab-content" id="pills-tabContent">
        <div class="tab-pane fade show active" id="pills-cart" role="tabpanel" aria-labelledby="pills-cart-tab">
            @if(session('cart') && count(session('cart')) > 0)
            <div class="row">
                <div class="col-lg-8 mb-2">
                    <div class="table-responsive">
                        <table class="table table-borderless">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Subtotal</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                $subtotal = 0;
                                $delivery_fee = 15; // Set default delivery fee
                                $discount = 50; // Example discount amount
                                @endphp

                                @if(session('cart') && count(session('cart')) > 0)
                                @foreach(session('cart') as $key => $item)
                                @php
                                $itemSubtotal = $item['price'] * $item['quantity'];
                                $subtotal += $itemSubtotal;
                                $product=Product::find($item['product_id']);
                                @endphp
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="{{ asset('storage/' . $product['image']) }}" alt="Product Image" class="me-3" style="width: 60px; height: 60px;">
                                            <span>{{ $product['name'] }}</span>
                                        </div>
                                    </td>
                                    <td>{{ $item['price'] }} ETB</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <button class="btn btn-secondary subtract" data-key="{{ $key }}">-</button>
                                            <span class="mx-2">{{ $item['quantity'] }}</span>
                                            <button class="btn bg-primary add text-white" data-key="{{ $key }}">+</button>
                                        </div>
                                    </td>
                                    <td>{{ $itemSubtotal }} ETB</td>
                                    <td>
                                    <td>
                                        <button class="btn btn-danger btn-sm btn remove-item" data-key="{{ $key }}"><i class="bi bi-trash-fill"></i></button>
                                    </td>
                                    </td>
                                </tr>
                                @endforeach
                                @else
                                <tr>
                                    <td colspan="4" class="text-center">Your cart is empty.</td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                    <hr>
                    <a href="{{ url('/') }}" class="btn bg-primary text-white rounded rounded-1">Continue Shop</a>
                </div>

                <!-- Summary Section -->
                <div class="col-lg-4 mb-2">
                    <div class="summary-card mt-3">
                        <h4 class="text-left">Summary</h4>
                       <hr>
                        <div class="d-flex justify-content-between mb-2">
                            <span><strong>SubTotal</strong></span>
                            <span><strong>{{ $subtotal }} ETB</strong></span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span><strong>Discount</strong></span>
                            <span id="discount_value"><strong>{{ session('discount', 0) }} ETB</strong></span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span><strong>Delivery fee</strong></span>
                            <span><strong>{{ $delivery_fee }} ETB</strong></span>
                        </div>
                        <div class="line"></div>
                        <div class="d-flex justify-content-between">
                            <span><strong>Total</strong></span>
                            <span class="total">
                                {{ session()->has('cart_subtotal')
                                ? session('cart_subtotal') - session('discount', 0) + $delivery_fee
                                : ($subtotal - session('discount', 0) + $delivery_fee) }} ETB
                            </span>
                        </div>
                        <form action="{{ route('restaurant.checkout') }}" method="GET">
                            @csrf
                            <button type="submit" class="checkout-btn border-0 bg-primary w-100 mt-3">
                                CHECKOUT
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @else
            <p class="text-dark text-left">
                Your cart is empty.
            </p>
            @endif
        </div>
        <div class="tab-pane fade" id="pills-ecommerce" role="tabpanel" aria-labelledby="pills-ecommerce-tab">
            <div class="row">
                <div class="col-lg-12" id="appendCartItems">
                    @include('Restaurant.frontend.cart.cart_item')
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    $(document).ready(function() {
        $(document).on('submit', '#ApplyCoupon', function(event) {
            event.preventDefault();
            var user = $(this).attr("user");
            if (user == 1) {

            } else {
                alert("Please login to apply Coupon!");
                return false;
            }
            var code = $("#code").val();
            $.ajax({
                type: 'post'
                , data: {
                    code: code
                    , _token: '{{csrf_token()}}'
                }
                , url: '/apply-coupon'
                , success: function(resp) {
                    // alert(resp.couponAmount);
                    if (resp.message != "") {
                        showAlert('info',resp.message);
                    }
                    $(".totalCartItems").html(resp.totalCartItems);
                    $("#appendCartItems").html(resp.view);
                    $("#appendHeaderCartItems").html(resp.headerview);
                    if (resp.couponAmount > 0) {
                        $(".couponAmount").text("" + resp.couponAmount);
                    } else {
                        $(".couponAmount").text("0");
                    }
                    if (resp.grand_total > 0) {
                        $(".grand_total").text("" + resp.grand_total);
                    }
                }
                , error: function() {
                    showAlert('info','Error');
                }

            })
        });
    });

</script>
<script>
    $(document).ready(function() {
        $(document).on('click', '.updateCartItem', function() {
            if ($(this).hasClass('plus-a')) {
                var quantity = $(this).data('qty');
                new_qty = parseInt(quantity) + 1;
            }
            if ($(this).hasClass('minus-a')) {
                var quantity = $(this).data('qty');
                if (quantity <= 1) {
                    showAlert('Oops...', 'Item quantity must be 1 or greater!');
                    return false;
                }
                new_qty = parseInt(quantity) - 1;
            }
            var cartid = $(this).data('cartid');
            $.ajax({
                data: {
                    cartid: cartid
                    , qty: new_qty
                    , _token: '{{csrf_token()}}'
                }
                , url: '/cart/update/'
                , type: 'post'
                , success: function(resp) {
                    $(".totalCartItems").html(resp.totalCartItems);

                    if (resp.status == false) {
                        showAlert('Oops...', resp.message);
                    }
                    $("#appendCartItems").html(resp.view);
                    $("#appendHeaderCartItems").html(resp.headerview);
                }
                , error: function() {
                    showAlert('Oops...', 'Error');
                }
            })
        });
        $(document).on('click', '.deleteCarts', function(e) {
            e.preventDefault();
            var cartid = $(this).data('cartid');

            // Proceed directly to deletion without confirmation
            $.ajax({
                data: {
                    cartid: cartid
                    , _token: '{{ csrf_token() }}'
                }
                , url: '/cart/delete'
                , type: 'post'
                , success: function(resp) {
                    $(".totalCartItems").html(resp.totalCartItems);
                    $("#appendCartItems").html(resp.view);
                    $("#appendHeaderCartItems").html(resp.headerview);
                    showAlert('Success', 'Item successfully deleted from your cart.');
                }
                , error: function() {
                    showAlert('Oops...', 'Error');
                }
            });
        });
    });
</script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        document.querySelectorAll(".remove-item").forEach(button => {
            button.addEventListener("click", function() {
                let key = this.getAttribute("data-key");

                fetch(`/restaurant/cart/remove/${key}`, {
                        method: "GET"
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            location.reload(); // Refresh the cart page
                        } else {
                            alert("Failed to remove item from cart.");
                        }
                    });
            });
        });
        document.querySelectorAll(".add, .subtract").forEach(button => {
            button.addEventListener("click", function() {
                let key = this.getAttribute("data-key");
                let action = this.classList.contains("add") ? "increase" : "decrease";
                fetch(`/restaurant/cart/update/${key}/${action}`, {
                        method: "GET"
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            location.reload();
                        }
                    });
            });
        });
    });
</script>
@endsection

