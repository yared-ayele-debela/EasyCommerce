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
    <div class="row">
    @foreach ($stock_products as $stock)
    <div class="col-lg-6 mb-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body ">
                <h5 class="card-title bg-light p-3">From : {{ $stock->transfer_stock_product->fromWarehouse->name }}</h5>
                <div class="bg-light p-3">
                    <p class="card-text"><b>Address : </b> {{ $stock->transfer_stock_product->fromWarehouse->address }}</p>
                    <p class="card-text"><b>Mobile Number : </b> {{ $stock->transfer_stock_product->fromWarehouse->phone }}</p>
                    <p class="card-text"><b>Email :</b> {{ $stock->transfer_stock_product->fromWarehouse->email }}</p>
                    <p class="card-text"><b>State :</b> {{ $stock->transfer_stock_product->fromWarehouse->state }}</p>
                    <p class="card-text"><b>Country : </b> {{ $stock->transfer_stock_product->fromWarehouse->country }}</p>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6 mb-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body ">
                <h5 class="card-title bg-light p-3">To : {{ $stock->transfer_stock_product->toWarehouse->name }}</h5>
                <div class="bg-light p-3">
                    <p class="card-text"><b>Address : </b> {{ $stock->transfer_stock_product->toWarehouse->address }}</p>
                    <p class="card-text"><b>Mobile Number : </b> {{ $stock->transfer_stock_product->toWarehouse->phone }}</p>
                    <p class="card-text"><b>Email :</b> {{ $stock->transfer_stock_product->toWarehouse->email }}</p>
                    <p class="card-text"><b>State :</b> {{ $stock->transfer_stock_product->toWarehouse->state }}</p>
                    <p class="card-text"><b>Country : </b> {{ $stock->transfer_stock_product->toWarehouse->country }}</p>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6">
        <div class="card border-0 shadow-sm">
            <div class="card-body ">
                <h5 class="card-title bg-light p-3">Product : {{ $stock->transfer_stock_product->product->product_name }}</h5>
                <div class="bg-light p-3">
                    <p class="card-text"><b>Code : </b> {{ $stock->transfer_stock_product->product->product_code }}</p>
                    <p class="card-text"><b>Category : </b> {{ $stock->transfer_stock_product->product->category->name }}</p>
                    <p class="card-text"><b>Quantity : </b> {{ $stock->transfer_stock_product->quantity }}</p>
                    <p class="card-text"><b>Transfer Notes : </b> {{ $stock->transfer_stock_product->notes }}</p>
                    <p class="card-text"><b>Transfer Date :</b> {{ $stock->transfer_stock_product->transfer_date }}</p>
                    <div class="d-flex">
                        <b>Status : </b> &nbsp;<p class="btn btn-sm btn-primary">{{ $stock->transfer_stock_product->delivery_status }}</p>

                    </div>
                </div>
                <form action="{{ route('updata_stock_transfer_status') }}" method="post">
                    @csrf
                    <input type="hidden" name="stock_transfer_id" value="{{ $stock->transfer_stock_product->id }}">
                    <div class="form-group mb-2 mt-4">
                        <label for="delivery_status">Status</label>
                        <select id="my-select" class="form-control" name="delivery_status">
                            <option selected value="">Select</option>
                            <option @if($stock->transfer_stock_product->delivery_status == "shipped") selected @endif value="shipped">Shipped</option>
                            <option @if($stock->transfer_stock_product->delivery_status == "delivered") selected @endif value="delivered">Delivered</option>
                        </select>
                    </div>
                    <div class="form-group mb-2" id="shipped" style="display: none;">
                        <label for="shipped">Enter Shipped Confirmation Number</label><br>
                     <input type="number" class="form-control" name="shipped_code" id="shipped">
                    </div>
                    <div class="form-group mb-2" id="delivered" style="display: none;">
                        <label for="user_code">Enter Delivered Confirmation Number</label><br>
                     <input type="number" class="form-control" name="delivered_code" id="delivered">
                    </div>
                    <button type="submit" class="btn btn-primary btn-block" >
                        Update delivery status
                    </button>
                </form>
            </div>
        </div>
        </div>
    </div>

    @endforeach
    </div>
</section>
@endsection
<script>
    document.addEventListener("DOMContentLoaded", function () {
        function toggleUserCodeVisibility() {
            var deliveryStatus = document.getElementById("my-select").value;
            var delivered = document.getElementById("delivered");
            var shipped=document.getElementById("shipped")

            if (deliveryStatus.toLowerCase() === "delivered") {
                delivered.style.display = "block";  // Show the user code input
            } else {
                delivered.style.display = "none";   // Hide the user code input
            }

            if (deliveryStatus.toLowerCase() === "shipped") {
                shipped.style.display = "block";  // Show the user code input
            } else {
                shipped.style.display = "none";   // Hide the user code input
            }
        }
        document.getElementById("my-select").addEventListener("change", function () {
            toggleUserCodeVisibility();
        });
        // Initial check on page load
        toggleUserCodeVisibility();
    });
</script>

