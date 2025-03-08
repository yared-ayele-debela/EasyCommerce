@extends('admindashboard.maindashboard')
@section('dashboard')
@php
$user = Auth::guard('admin')->user();
@endphp
<div class="pagetitle bg-light">
    <nav>
        <ol class="breadcrumb p-3 ">
            <li class="breadcrumb-item font-weight-bold"><a href="{{ url('admin/dashboard') }}">Home</a></li>
            <li class="breadcrumb-item">Add FAQ</li>
        </ol>
    </nav>
</div>
<section class="section">
    @foreach ($custom_order as $order)
    <div class="col-lg-4 mb-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header border-0">
                <strong>User Code : {{ $order->user_code }}</strong>
            </div>
            <div class="card-body">
                <h5 class="card-title">Order ID: {{ $order->id }}</h5>

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
                @if ($user && $user->hasPermissionByRole('update custom order status'))
                <form action="{{ url('admin/custom-orders/update-fast-order-status') }}" method="post">
                    @csrf
                    <input type="hidden" name="order_id" value="{{ $order->id }}">
                    <div class="form-group mb-2 mt-4">
                        <label for="my-select">Update Order Status</label>
                        <select id="my-select" class="form-control" name="order_status">
                            <option selected value="">Select</option>
                            <option value="pending" @if($order->status=="pending") selected @endif>Pending</option>
                            <option value="approved" @if($order->status=="approved") selected @endif>Approved</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary float-right mb-3" data-toggle="modal" data-target="#attachPaymentModal">
                        Update
                    </button>
                </form>
                @endif

                @if ($user && $user->hasPermissionByRole('assign custom order to deliveryman'))
                <form action="{{ url('admin/custom-orders/assign_to_delivery_boy') }}" method="post">
                    @csrf
                    <input type="hidden" name="order_id" value="{{ $order->id }}">
                    <div class="form-group mb-2 mt-4">
                        <label for="my-select">Assing to delivery boy</label>
                        <select id="my-select" class="form-control" name="delivery_boy_id">
                            <option selected value="">Select</option>
                            @foreach ($alldelivery_boys as $boy )
                            <option @if($order->delivery_boy_id == $boy->id) selected @endif value="{{ $boy->id }}" >{{ $boy->first_name }} {{ $boy->last_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary float-right">
                      @if($order->delivery_boy_id!=null)  Update Delivery Boy @else Assign Delivery Boy @endif
                    </button>
                </form>
                @endif
            </div>
        </div>
    </div>

    <div class="row">
        <h3 class="mt-4 mb-2">Order Products</h3>
        @foreach ($custom_order as $product)
        @foreach ($product->custom_order_product as $product)
        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <p class="card-text mt-2"><strong>Product : </strong> {{ $product['product_name'] }}</p>
                    <p class="card-text"><strong>Quantity : </strong>: {{ $product['quantity'] }}</p>
                    <p class="card-text"><strong>Description : </strong> {{ $product['description'] }}</p>
                    <p class="card-text"> <strong>Delivery Address : </strong> {{ $product['delivery_address'] }}</p>
                    <p class="text-sm text-right"><i>Date: {{ $product['created_at']->format('d/m/Y') }}</i></p>
                </div>
            </div>
        </div>

        @endforeach
        @endforeach
    </div>
    @endforeach
    {{-- <div class="row">
                    <div class="col-md-6">
                        <h5 class="card-title">Order ID: {{ $fast_orders->id }}</h5>
    <p class="card-text">Product: {{ $fast_orders->product_name }}</p>
    <p class="card-text">Quantity: {{ $fast_orders->quantity }}</p>
    <p>Phone Number: {{ $fast_orders->phone_number }}</p>
    <p class="card-text">Delivery Address: {{ $fast_orders->delivery_address }}</p>
    <p class="card-text">Status:
        @if($fast_orders->status=="pending")
        <span class=" btn btn-sm btn-danger">{{ $fast_orders->status }}</span>
        @endif
        @if($fast_orders->status=="approved")
        <span class="btn btn-sm btn-success ">{{ $fast_orders->status }}</span>
        @endif
    </p>
    <p class="card-text"> <b>Description:</b> {{ $fast_orders->description }}</p>

    <form action="{{ url('admin/fast-orders/update-fast-order-status') }}" method="post">
        @csrf
        <input type="hidden" name="order_id" value="{{ $fast_orders->id }}">
        <div class="form-group mb-2 mt-4">
            <label for="my-select">Update Order Status</label>
            <select id="my-select" class="form-control" name="order_status">
                <option selected value="">Select</option>
                <option value="pending" @if($fast_orders->status=="pending") selected @endif>Pending</option>
                <option value="approved" @if($fast_orders->status=="approved") selected @endif>Approved</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary float-right mb-3" data-toggle="modal" data-target="#attachPaymentModal">
            Update
        </button>
    </form>
    <form action="{{ url('admin/fast-orders/assign_to_delivery_boy') }}" method="post">
        @csrf
        <input type="hidden" name="order_id" value="{{ $fast_orders->id }}">
        <div class="form-group mb-2 mt-4">
            <label for="my-select">Assing to delivery boy</label>
            <select id="my-select" class="form-control" name="delivery_boy_id">
                <option selected value="">Select</option>
                @foreach ($alldelivery_boys as $boy )
                <option @if($fast_orders->delivery_boy_id == $boy->id) selected @endif value="{{ $boy->id }}">{{ $boy->first_name }} {{ $boy->last_name }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary float-right">
            Assing
        </button>
    </form>
    </div>

    <div class="col-md-6">
        <h5 class="card-title">User ID: {{ $fast_orders->user->id }}</h5>
        <p class="card-text">Customer Name: {{ $fast_orders->user->name }} </p>
        <p class="card-text">Phone Number: {{ $fast_orders->user->mobile }} </p>
        <p class="card-text">Email: {{ $fast_orders->user->email }} </p>
        <p class="card-text">Address: {{ $fast_orders->user->address }} </p>
        <p class="card-text">City: {{ $fast_orders->user->city }} </p>
        <p class="card-text">State: {{ $fast_orders->user->state }} </p>
        <p class="card-text">Country: {{ $fast_orders->user->country }} </p>
    </div>
    </div> --}}
    </div>
    </div>

    </div>
</section>
@endsection

