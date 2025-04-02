@extends('all_frontend_layouts.layouts')
@section('content')
@php
use App\Models\Restaurant\Product;
@endphp
<div class="container my-4">

    <div class="checkout-header">
        <a href="{{ url('/') }}">Home</a> / <span>Cart</span>
    </div>

    <div class="row">
        <div class="col-lg-8 mb-2 ">
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
            <a href="{{ url('/') }}" class="btn bg-primary text-white rounded rounded-1">Return To Shop</a>
        </div>

        <!-- Summary Section -->
        <div class="col-lg-4 mb-2">
            {{-- <div class="card delivery-location">
          <div class="d-flex justify-content-between">
            <p>DELIVER TO</p>
            <a href="" class="text-white btn btn-sm bg-primary" data-bs-toggle="modal" data-bs-target="#addressModal">Add New</a>
          </div>
          <span>📍 Addis Ababa, BOLE 123hd33d...</span>
        </div>

        <!-- Promo Code -->
        <div class="promo-code">
          <input type="text" id="coupon_code" class="promo-input" placeholder="Enter Promo Code">
          <button id="apply_coupon"  class="bg-primary">APPLY</button>
        </div>
        <p id="coupon_message" class="text-danger mt-2"></p> <!-- Message for errors/success --> --}}


            <!-- Summary Card -->
            <div class="summary-card mt-3">
                <h4 class="text-left">Summary</h4>
                <div class="d-flex justify-content-between mb-2">
                    @foreach(session('cart') as $key => $item)
                    <img src="{{ asset('storage/' . $product['image']) }}" alt="Product Image" class="me-3" style="width: 60px; height: 60px;">
                    @endforeach
                </div>
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
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

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

