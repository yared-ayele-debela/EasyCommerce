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
                    <img src="{{ $order->user->profile_photo_path }}" width="100" class="rounded-circle py-2" alt="">
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

        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5>Order Status</h5>
                </div>
                <div class="card-body mt-2">
                    <h6 class="text-muted">Delivery Confirmation code # {{ $order->delivery_code }}</h6>
                    <hr>
                    <p><strong>Current Order Status:</strong> <button class="btn btn-sm btn-primary">{{ $order->status }}</button></p>
                    <p><strong>Current Delivery Status:</strong> <button class="btn btn-sm btn-outline-primary">{{ $order->delivery_status }}</button></p>
                    <!-- Status Update Form -->
                    <h6>UPDATE STATUS</h6>

                    <form action="{{ route('restaurant.orders.updateStatus', $order->id) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="order_status" class="form-label">Order Status</label>
                            <select name="order_status" id="order_status" class="form-select">
                                <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="confirmed" {{ $order->status == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                <option value="picked" {{ $order->status == 'picked' ? 'selected' : '' }}>picked</option>
                                <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>shipped</option>
                                <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="delivery_status" class="form-label">Delivery Status</label>
                            <select name="delivery_status" id="delivery_status" class="form-select">
                                <option value="pending" {{ $order->delivery_status == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="accepted" {{ $order->delivery_status == 'accepted' ? 'selected' : '' }}>Accepted</option>
                                <option value="declined" {{ $order->delivery_status == 'declined' ? 'selected' : '' }}>Declined</option>
                                <option value="delivering" {{ $order->delivery_status == 'delivering' ? 'selected' : '' }}>Delivering</option>
                                <option value="delivered" {{ $order->delivery_status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-success">Update Status</button>
                    </form>
                </div>
            </div>
        </div>
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
                    <p class="text-dark card-text"><img src="{{ asset('/storage/delivery_man/'.$delivery_man->delivery_man_image) }}" style="width: 50px; height:50px" alt=""></p>
                    <h5>Name: {{ $delivery_man->first_name }} {{ $delivery_man->last_name }}</h5>
                    <p class="text-dark card-text">Mobile Number: {{ $delivery_man->phone }}</p>
                    <p class="text-dark card-text">Email: {{ $delivery_man->email }}</p>
                    @endif
                </div>
            </div>
        </div>
        <hr>
        <div class="col-md-12">
            <div class="row mb-3">
                @foreach($order->orderItems->groupBy('product.restaurant_id') as $restaurantId => $items)
                    <div class="col-md-4 mb-4">
                        <div class="card h-100 shadow border-0">
                            <div class="card-body">
                                <!-- Restaurant Info -->
                                <h5 class="my-3">Restaurant: {{ $items->first()->product->restaurant->name }}</h5>
                                <p class="text-muted mb-1">{{ $items->first()->product->restaurant->email }} | {{ $items->first()->product->restaurant->phone }}</p>
                                <p class="text-muted mb-3">Address: {{ $items->first()->product->restaurant->address }}</p>
                                <div class="d-flex gap-2 mb-3">
                                    <img src="{{ $items->first()->product->restaurant->logo }}" class="rounded" style="width: 40px; height: 40px; object-fit: cover;">
                                    <img src="{{ $items->first()->product->restaurant->cover }}" class="rounded" style="width: 60px; height: 40px; object-fit: cover;">
                                </div>

                                <hr>

                                <!-- Products from this restaurant -->
                                <h6 class="mb-3">Items from this restaurant:</h6>
                                @foreach($items as $item)
                                    <div class="d-flex align-items-center mb-2">
                                        <img src="{{ $item->product->image }}" class="rounded me-3" style="width: 60px; height: 60px; object-fit: cover;">
                                        <div>
                                            <h6 class="mb-0">{{ $item->product->name }}</h6>
                                            <small class="text-muted">{{ $item->quantity }} x {{ number_format($item->price, 2) }} ETB</small>
                                        </div>
                                    </div>
                                     <p class="text-muted">Delivery Zone <b>{{  $item->product->restaurant->zone }}</b></p>
                                @endforeach
                                <hr>
                                @php
                                    $status = $items->every(fn($item) => $item->picked_status === 'picked') ? 'Picked' : 'Pending';
                                    $firstCode = $items->first()->picked_code? $items->first()->picked_code : null;
                                @endphp

                                <div class="text-center mt-3">
                                    <p>Pickup Status: <strong class="{{ $status === 'Picked' ? 'text-success' : 'text-danger' }}">{{ $status }}</strong></p>
                                    @if($firstcode)
                                     {!! QrCode::size(130)->generate($firstCode) !!}
                                    <p class="mt-2 mb-0"><strong>Pickup Code:</strong> {{ $firstCode }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <hr>
        <div class="col-md-12 card p-2">
            <h5 class="text-muted">Assign histories</h5>
            <table class="table ">
                <thead>
                    <tr>
                        <th>Delivery Man Information</th>
                        <th>Status</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($notifications as $notification)
                    <tr>
                        <td scope="row">Name: {{ $notification->deliveryman->first_name }}
                            {{ $notification->deliveryman->first_name }} | {{ $notification->deliveryman->phone }}
                        </td>
                        <td>
                            <div class="btn btn-secondary btn-sm ">
                                {{ $notification->status }}
                            </div>
                        </td>
                        <td>{{ $notification->created_at }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

