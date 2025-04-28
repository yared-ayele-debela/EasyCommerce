@extends('all_frontend_layouts.layouts')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <button class="btn me-3" onclick="history.back()">
            <i class="bi bi-arrow-left"></i>
        </button>
        <h5 class="mb-0 text-center text-dark">My Custom Orders</h5>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="offer-card p-4">
                <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold text-primary">User Code: {{ $custom_order->user_code }}</h5>
                </div>
                <div class="card-body">
                    <h5 class="card-title text-secondary mb-3">Order ID: #{{ $custom_order->id }}</h5>
                    <ul class="list-unstyled mb-4">
                        <li><strong>Customer Name:</strong> {{ $custom_order->customer_name }}</li>
                        <li><strong>Phone Number:</strong> {{ $custom_order->phone_number }}</li>
                    </ul>
                    <h5 class="text-primary mb-3">Order Products</h5>
                    @foreach ($custom_order->custom_order_product as $product)
                        <div class="border-start border-4 border-primary ps-3 mb-4">
                            <h6 class="fw-semibold">{{ $product['product_name'] }}</h6>
                            <p class="mb-1"><strong>Quantity:</strong> {{ $product['quantity'] }}</p>
                            <p class="mb-1"><strong>Description:</strong> {{ $product['description'] }}</p>
                            <p class="mb-1"><strong>Delivery Address:</strong> {{ $product['delivery_address'] }}</p>
                            <small class="text-muted d-block mt-2"><i>Date: {{ $product['created_at']->format('d/m/Y') }}</i></small>
                        </div>
                    @endforeach
                </div>
                <div class="card-footer">
                    <div class="d-flex justify-content-start align-items-center">
                        <span class="text-muted">Status:   
                            @if($custom_order->status == 'pending')
                                <span class="btn btn-sm text-white btn-warning">Pending</span>
                            @elseif($custom_order->status == 'approved')
                                <span class="btn btn-sm text-white btn-success">Approved</span>
                            @elseif($custom_order->status == 'declined')
                                <span class="btn btn-sm text-white btn-danger">Declined</span>
                            @endif
                        </span> &nbsp;&nbsp;
                        <span class="text-muted">Delivery Status:   
                            @if($custom_order->delivery_status == 'Pending')
                                <span class="btn btn-sm text-white btn-warning">Pending</span>
                            @elseif($custom_order->delivery_status == 'Delivered')
                                <span class="btn btn-sm text-white btn-success">Delivered</span>
                            @elseif($custom_order->delivery_status == 'declined')
                                <span class="btn btn-sm text-white btn-danger">Declined</span>
                            @endif
                        </span>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection
