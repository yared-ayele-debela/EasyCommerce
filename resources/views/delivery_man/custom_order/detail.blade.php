@extends('delivery_man.admin_dashboard.maindashboard')
@section('delivery_man_dashboard')
@php
$user = Auth::guard('admin')->user();
@endphp
<div class="pagetitle bg-light">
    <nav>
        <ol class="breadcrumb p-3 ">
            <li class="breadcrumb-item font-weight-bold"><a href="{{ url('admin/dashboard') }}">Home</a></li>
            <li class="breadcrumb-item">Custom order</li>
        </ol>
    </nav>
</div>
<section class="section">
    @foreach ($custom_orders as $order)
    <div class="col-lg-4 mb-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <h5 class="card-title p-2 bg-light">Order ID: {{ $order->id }}</h5>
                <div class="p-3 bg-light">
                    <p class="card-text">Customer Name: {{ $order->customer_name }}</p>
                    <p class="card-text">Phone Number: {{ $order->phone_number }}</p>
                    <p class="card-text">Status:
                        @if($order->status=="pending")
                        <span class="btn btn-sm btn-warning text-white">{{ $order->status }}</span>
                        @endif
                        @if($order->status=="approved")
                        <span class="btn btn-sm btn-success text-white">{{ $order->status }}</span>
                        @endif
                    </p>
                    <form action="{{ route('update_delivery_status') }}" method="post">
                        @csrf
                        <input type="hidden" name="custom_order_id" value="{{ $order->id }}">
                        <div class="form-group mb-2 mt-4">
                            <label for="delivery_status" class="mb-2">Update order delivery status</label>
                            <select id="my-select" class="form-control" name="delivery_status">
                                <option selected value="">Select</option>
                                @foreach ($order_status as $status)
                                <option @if($order->delivery_status==$status['name']) selected @endif; value="{{ $status['name'] }}">{{ $status['name'] }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group mb-2" id="user_code" style="display: none;">
                            <label for="user_code">Enter user order_code to verify delivered</label><br>
                            <input type="number" class="form-control" name="user_code" id="user_code">
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">
                            Update delivery status
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <h3 class="mt-4 mb-2">Order Products</h3>
        @foreach ($custom_orders as $product)
        @foreach ($product->custom_order_product as $product)
        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <p class="card-text mt-2"><strong>Product : </strong> {{ $product['product_name'] }}</p>
                    <p class="card-text"><strong>Quantity : </strong>: {{ $product['quantity'] }}</p>
                    <p class="card-text"><strong>Description : </strong> {{ $product['description'] }}</p>
                    <p class="card-text"> <strong>Delivery Address : </strong> {{ $product['delivery_address'] }}</p>
                    <p class="text-sm "><i> <strong> Date : </strong> {{ $product['created_at']->format('d/m/Y') }}</i></p>
                    <form action="{{ route('update_product_delivery_status') }}" method="post">
                        @csrf
                        <input type="hidden" name="custom_order_product_id" value="{{ $product->id }}">
                        <div class="form-group mb-2 mt-4">
                            <label for="delivery_status" class="mb-2">Update order delivery status</label>
                            <select id="my-select-for-vendor" class="form-control" name="product_delivery_status">
                                <option selected value="">Select</option>
                                @foreach ($order_status as $status)
                                <option @if($product['delivery_status']==$status['name']) selected @endif; value="{{ $status['name'] }}">{{ $status['name'] }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group mb-2" id="vendor_code" style="display: none;">
                            <label for="vendor_code">Enter vendor Code to verify shipped</label><br>
                            <input type="number" class="form-control" name="vendor_code" id="vendor_code">
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">
                            Update product delivery status
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
        @endforeach
    </div>
    @endforeach
</section>
@endsection
<script>
    document.addEventListener("DOMContentLoaded", function() {
        function toggleUserCodeVisibility() {
            var deliveryStatus = document.getElementById("my-select").value;
            var delivery_status=document.getElementById("my-select-for-vendor").value;
            var userCodeElement = document.getElementById("user_code");
            var vendorcodeElement=document.getElementById("vendor_code");

            if (deliveryStatus.toLowerCase() === "delivered") {
                userCodeElement.style.display = "block"; // Show the user code input
            } else {
                userCodeElement.style.display = "none"; // Hide the user code input
            }


            if (delivery_status.toLowerCase() === "shipped") {
                vendorcodeElement.style.display = "block"; // Show the user code input
            } else {
                vendorcodeElement.style.display = "none"; // Hide the user code input
            }
        }

        document.getElementById("my-select").addEventListener("change", function() {
            toggleUserCodeVisibility();
        });
        document.getElementById("my-select-for-vendor").addEventListener("change", function() {
            toggleUserCodeVisibility();
        });
        // Initial check on page load
        toggleUserCodeVisibility();
    });

</script>
