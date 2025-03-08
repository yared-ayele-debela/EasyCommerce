@extends('delivery_man.admin_dashboard.maindashboard')
@section('delivery_man_dashboard')
@php
$user = Auth::guard('deliverymen')->user();
@endphp
<div class="pagetitle">
    <h1>Dashboard</h1>
</div>
<section class="section dashboard">
    <div class="row">
                <h5 class="card-title">Orders </h5>
                <div class="col-xxl-3 col-md-3">
                    <div class="card info-card bg-c-blue sales-card border-0 shadow-sm">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-cart"></i></div>
                                <div class="ps-3">
                                    <p class="text-white small pt-1 fw-bold">Custom orders</p>
                                    <h6 class="text-white"> {{ $custom_order}}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-3 col-md-3">
                    <div class="card info-card bg-c-yellow sales-card border-0 shadow-sm">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center"> <i class="bi bi-cart"></i></div>
                                <div class="ps-3">
                                    <p class="text-white small pt-1 fw-bold">Stock Transfer </p>
                                    <h6 class="text-white"> {{ $stock_transfer_product}}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xxl-3 col-md-3">
                    <div class="card info-card bg-c-pink sales-card border-0 shadow-sm">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center"> <i class="bi bi-cart"></i></div>
                                <div class="ps-3">
                                    <p class="text-white small pt-1 fw-bold">All orders</p>
                                    <h6 class="text-white"> {{ $allorders}}</h6>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-3 col-md-3">
                    <div class="card info-card bg-c-green sales-card border-0 shadow-sm">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center"> <i class="bi bi-cart"></i></div>
                                <div class="ps-3">
                                    <p class="text-white small pt-1 fw-bold">New orders</p>
                                    <h6 class="text-white"> {{ $new_orders}}</h6>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-3 col-md-3">
                    <div class="card info-card bg-c-blue sales-card border-0 shadow-sm">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center"> <i class="bi bi-cart"></i></div>
                                <div class="ps-3">
                                    <p class="text-white small pt-1 fw-bold">Pending order</p>
                                    <h6 class="text-white"> {{ $pending_orders }}</h6>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-3 col-md-3">
                    <div class="card info-card bg-c-yellow sales-card border-0 shadow-sm">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center"> <i class="bi bi-cart"></i></div>
                                <div class="ps-3">
                                    <p class="text-white  pt-1 fw-bold">Shipped order</p>
                                    <h6 class="text-white"> {{ $shipped_orders }}</h6>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-3 col-md-3">
                    <div class="card info-card sales-card bg-c-pink border-0 shadow-sm">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center"> <i class="bi bi-cart"></i></div>
                                <div class="ps-3">
                                    <p class="text-white small pt-1 fw-bold">Deliverd orders</p>
                                    <h6 class="text-white"> {{ $deliverd_orders }}</h6>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-3 col-md-3">
                    <div class="card info-card bg-c-green sales-card border-0 shadow-sm">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center"> <i class="bi bi-cart"></i></div>
                                <div class="ps-3">
                                    <span class="text-white small pt-1 fw-bold">Paid orders</span>
                                    <h6 class="text-white"> {{ $deliverd_orders }}</h6>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
</section>
<div class="container">
    <h5 class="card-title">Latest Orders </h5>
    @if ($user && $user->hasPermissionByRole('view_orders_details'))
    <div class="row">
        @foreach ($orders as $k => $order)
        <div class="col-md-6">
            @if($order['orders_products'])
                <div class="card mb-4 shadow-sm border-0">
                    <div class="card-body">
                        <h5 class="card-title">Order ID: {{ $order['id'] }}</h5>
                        <p class="card-text">Order Date: {{ date('Y-m-d h:i:s', strtotime($order['created_at'])) }}</p>
                        <p class="card-text">Customer Name: {{ $order['name'] }}</p>
                        <p class="card-text">Customer Email: {{ $order['email'] }}</p>
                        <p class="card-text">Ordered Products:
                            @foreach ($order['orders_products'] as $product)
                                {{ $product['product_name'] }} ({{ $product['product_qty'] }}),
                            @endforeach
                        </p>
                        <p class="card-text">Ordered Price: {{ $order['grand_total'] }}</p>
                        <p class="card-text">Payment Method: {{ $order['payment_method'] }}</p>
                        <p class="card-text mb-2">Order Status:
                            <span class="px-2 text-white" style="border-radius: 0.2rem; background-color:rgb(30, 141, 231)">{{ $order['order_status'] }}</span>
                        </p>
                        <div class="">
                            <a href="{{ url('delivery-boy/order-detail/'.$order['id']) }}" class="btn btn-sm btn-outline-primary">View Details</a>
                            <a target="_blank" href="{{ url('delivery-boy/order/invoice/'.$order['id']) }}" class="btn btn-sm btn-outline-secondary ">Print Invoice</a>
                            <a target="_blank" href="{{ url('delivery-boy/order/invoice/pdf/'.$order['id']) }}" class="btn btn-sm btn-outline-secondary  ">Download PDF</a>
                        </div>
                    </div>
                </div>
            @endif
        </div>
        @endforeach
    </div>
    @endif

</div>

@endsection

