@extends('Restaurant.dashboard.layouts')
@section('restaurant-dashboard')
@php
$user = Auth::guard('admin')->user();
@endphp
<div class="container">
    <nav class="breadcrumb bg-white shadow-sm py-3 px-4 rounded d-flex justify-content-between align-items-center">
        <button class="btn btn-outline-primary btn-sm d-flex align-items-center" onclick="history.back()">
            <i class="bi bi-arrow-left mr-2"></i> &nbsp;
            <span>Back</span>
        </button>
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item">
                <a href="{{ route('restaurant.dashboard') }}">Home</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">Order detail</li>
        </ol>
    </nav>
    <h4>Order #{{ $order->id }} Details</h4>
    <div class="row">
        <!-- User Info Card -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5>User Information</h5>
                </div>
                <div class="card-body">
                    @if($order->user->profile_photo_path)
                    <img src="{{ asset('storage/' . $order->user->profile_photo_path) }}" width="100" class="rounded-circle py-2" alt="Profile Image">
                    @endif
                    <p><strong>Name:</strong> {{ $order->user->name }}</p>
                    <p><strong>Email:</strong> {{ $order->user->email }}</p>
                    <p><strong>Phone:</strong> {{ $order->user->mobile }}</p>
                    <p><strong>City:</strong> {{ $order->user->city }}</p>
                    <p><strong>State:</strong> {{ $order->user->state }}</p>
                    <p><strong>Country:</strong> {{ $order->user->country }}</p>
                    <p><strong>Address:</strong> {{ $order->user->address }}</p>
                </div>
            </div>
        </div>
        <!-- Order Items Card -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5>Order Items</h5>
                </div>
                <div class="card-body">
                    <ul>
                        @foreach ($order->orderItems as $item)
                        <div class="card mt-2 shadow-none p-0 m-0">
                            <div class="card-body">
                                <img src="{{ $item->product->image }}" width="50">
                                <strong>{{ $item->product->name }}</strong> ({{ $item->quantity }} x {{ $item->product->price }} ETB)
                            </div>
                        </div>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5>Delivery Address Information</h5>
                </div>
                <div class="card-body mt-2">
                    <p><strong>Address:</strong> {{ $order->address->address }}</p>
                    <p><strong>City:</strong> {{ $order->address->city }}</p>
                    <p><strong>Sub City:</strong> {{ $order->address->sub_city }}</p>
                    <p><strong>Street:</strong> {{ $order->address->street }}</p>
                    <p><strong>State:</strong> {{ $order->address->state }}</p>
                    <p><strong>Country:</strong> {{ $order->address->country }}</p>
                    <p><strong>Pincode:</strong> {{ $order->address->pincode }}</p>
                </div>
            </div>
        </div>
        <!-- Order Status and Update Form Card -->
        <div class="col-md-12">
            @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
            @endif
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5>Order Status</h5>
                </div>
                <div class="card-body mt-2">
                    <p><strong>Current Order Status:</strong> <button class="btn btn-sm btn-primary">{{ $order->status }}</button></p>
                    <p><strong>Current Delivery Status:</strong>  <button class="btn btn-sm btn-outline-primary">{{ $order->delivery_status }}</button></p>
                    <!-- Status Update Form -->
                    <h6>UPDATE STATUS</h6>
                   
                    <form action="{{ route('restaurant.orders.updateStatus', $order->id) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="order_status" class="form-label">Order Status</label>
                            <select name="order_status" id="order_status" class="form-select">
                                <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Processing</option>
                                <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Completed</option>
                                <option value="canceled" {{ $order->status == 'canceled' ? 'selected' : '' }}>Canceled</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="delivery_status" class="form-label">Delivery Status</label>
                            <select name="delivery_status" id="delivery_status" class="form-select">
                                <option value="pending" {{ $order->delivery_status == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="shipped" {{ $order->delivery_status == 'shipped' ? 'selected' : '' }}>Shipped</option>
                                <option value="delivered" {{ $order->delivery_status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-success">Update Status</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5>Assign Order to Delivery man</h5>
                </div>
                <div class="card-body mt-2">
                    @if(empty($order->delivery_man_id))
                    <form action="{{ route('restaurant.assignToDeliveryMan', $order->id) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="delivery_man_id" class="form-label">Delivery Man</label>
                            <select name="delivery_man_id" id="delivery_man_id" class="form-select">
                                @foreach ($delivery_mans as $man)
                                <option value="{{ $man->id }}">{{ $man->first_name }} {{ $man->last_name }} | {{ $man->phone }}</option>                  
                                @endforeach        
                            </select>
                        </div>
                        <button type="submit" class="btn btn-success">Assign To Delivery Man</button>
                    </form>
                    @else
                    <div class="alert alert-warning" role="alert">
                        <strong>Order already assigned to {{ $delivery_man->first_name }}</strong>
                    </div>
                     <p class="text-dark card-text"><img src="{{ $delivery_man->delivery_man_image }}" style="width: 50px; height:50px" alt=""></p>
                     <h5>Name: {{ $delivery_man->first_name }} {{ $delivery_man->last_name }}</h5>
                     <p class="text-dark card-text">Mobile Number: {{ $delivery_man->phone }}</p>
                     <p class="text-dark card-text">Email: {{ $delivery_man->email }}</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
