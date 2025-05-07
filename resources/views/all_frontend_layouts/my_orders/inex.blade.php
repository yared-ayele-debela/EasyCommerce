<?php
use App\Models\Product;
use App\Models\Order;
?>
@extends('all_frontend_layouts.layouts')
@section('content')

<div class="container my-1">
    <div class="header">
        <button class="btn btn-link text-dark" onclick="history.back()">
            <i class="bi bi-arrow-left"></i>
        </button>
        <h5 class="my-4 text-dark text-center">My Orders</h5>
    </div>
    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="pills-reservation-tab" data-bs-toggle="pill" data-bs-target="#pills-reservation" type="button" role="tab" aria-controls="pills-reservation" aria-selected="true">My Reservations ({{ $orders->count() }})</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="pills-room-tab" data-bs-toggle="pill" data-bs-target="#pills-room" type="button" role="tab" aria-controls="pills-room" aria-selected="false">My Rooms ({{ $reservations->count() }})</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="pills-goods-tab" data-bs-toggle="pill" data-bs-target="#pills-goods" type="button" role="tab" aria-controls="pills-goods" aria-selected="false">My Goods ({{ $good_orders->count() }})</button>
        </li>
    </ul>
    <div class="tab-content" id="pills-tabContent">
        <div class="tab-pane fade show active" id="pills-reservation" role="tabpanel" aria-labelledby="pills-reservation-tab">
            @if($orders->isEmpty())
            {{-- <div class="alert alert-info text-center"> --}}
                <p class="text-dark">No orders found. Start ordering your favorite meals!</p>
            {{-- </div> --}}
            @else
            <div class="row">
                @foreach($orders as $order)
                <div class="col-md-4">
                    <div class="offer-card mb-3 shadow-sm">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h5 class="text-dark">Order #{{ $order->id }}</h5>
                                    <p class="text-muted mb-1">Placed on: {{ $order->created_at->format('M d, Y h:i A') }}</p>
                                    <p class="text-muted mb-1"> Order Status : <span class="btn btn-sm text-white @if($order->status == 'completed') bg-success @endif  @if($order->status==='processing') bg-info @endif  @if($order->status == 'canceled') bg-danger @endif
                                @if($order->status == 'pending') bg-warning @endif      ">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </p>
                                    <p class="text-muted mb-1"> Delivery Status : <span class="btn btn-sm text-white @if($order->delivery_status === 'shipped') bg-info @endif  @if($order->delivery_status==='delivered') bg-success @endif
                                @if($order->delivery_status === 'pending') bg-warning @endif">
                                            {{ ucfirst($order->delivery_status) }}
                                        </span>
                                    </p>

                                </div>
                                <div class="text-end">
                                    <strong class="text-primary">Total: {{ $order->total }} ETB</strong>
                                </div>
                            </div>

                            <button class="btn btn-outline-primary btn-sm mt-3" type="button" data-bs-toggle="collapse" data-bs-target="#orderDetails-{{ $order->id }}">
                                View Details
                            </button>

                            <div id="orderDetails-{{ $order->id }}" class="collapse mt-3">
                                <ul class="list-group">
                                    @foreach($order->orderItems as $item)
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <div class="d-flex align-items-center">
                                            <!-- Product Image -->
                                            <img src="{{ $item->product->image }}" alt="{{ $item->product->name }}" class="img-thumbnail me-3" style="width: 50px; height: 50px; object-fit: cover;">

                                            <div>
                                                <strong>{{ $item->product->name }}</strong> (x{{ $item->quantity }})
                                                <p class="text-muted small mb-0">
                                                    <span class="badge bg-secondary">{{ $item->product->category->name }}</span>
                                                    @if($item->product->subcategory)
                                                    <span class="badge bg-info">{{ $item->product->subcategory->name }}</span>
                                                    @endif
                                                </p>
                                            </div>
                                        </div>
                                        <span class="fw-bold">{{ $item->price }} ETB</span>
                                    </li>
                                    @endforeach
                                </ul>
                                </ul>
                            </div>

                            <div class="text-start mt-3 d-flex justify-content-between align-items-center">
                                @if($order->paymentInfo)
                                <div class="d-flex justify-content-around align-items-center">
                                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#Reservation{{ $order->id }}">
                                        <i class="bi bi-eye-fill"></i> Payment information
                                    </button> &nbsp;
                                </div>
                                <div class="modal fade" id="Reservation{{ $order->id }}" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-scrollable" role="document">
                                        <div class="modal-content ">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Payment Detail</h5>
                                                <button type="button" class="close btn" data-bs-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body text-left">
                                                <p>Receipt:</p>
                                                @if($order->paymentInfo->receipt)
                                                <img src="{{ $order->paymentInfo->receipt }}" class="img-fluid" alt="{{ $order->paymentInfo->bank_name }}">
                                                @else
                                                <img src="{{ asset('restaurant_frontend/default-image.png') }}" class="img-fluid" alt="{{ $order->paymentInfo->bank_name }}">
                                                @endif
                                                <p class="card-text"><strong>Bank Name :</strong> {{ $order->paymentInfo->bank_name }}</p>
                                                <p class="card-text"><strong>Transaction Number :</strong> <strong>{{ $order->paymentInfo->transaction_number }}</strong></p>
                                                <p class="card-text"><strong>Amount Paid :</strong> {{ $order->paymentInfo->amount_paid }} ETB</p>
                                                <p class="card-text text-dark"><strong>Payment Status :</strong> <span class="btn btn-sm btn btn-secondary">{{ $order->paymentInfo->payment_status }}</span></p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @else
                                @endif
                                <a href="{{ route('order.track', $order->id) }}" class="btn btn-primary btn-sm"><span class="bi bi-pin-map text-white"></span> Track Order</a>
                                <form action="{{ url('restaurant/order-receipt')}}" method="POST" target="_blank">
                                    @csrf
                                    <input type="hidden" name="order_id" value="{{ $order->id }}">
                                    <button type="submit" class="btn btn-sm bg-primary text-white"><span class="bi bi-printer"></span></button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @endif
        </div>
        <div class="tab-pane fade" id="pills-room" role="tabpanel" aria-labelledby="pills-room-tab">
            @if ($reservations->isEmpty())
            <div class="alert alert-info">
                You haven't made any reservations yet.
            </div>
            @else
            <div class="row">
                @foreach ($reservations as $reservation)
                <div class="col-md-4 mb-4">
                    <div class="card shadow-sm">
                        <div class="card-header pb-3 bg-primary text-white d-flex justify-content-between">
                            <span>{{ $reservation->hotel->name }}</span>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">{{ $reservation->room->room_type }} (Room No: {{ $reservation->room->room_number }})</h5>
                            <p class="card-text mb-1"><strong>Check-in:</strong> {{ \Carbon\Carbon::parse($reservation->check_in_date)->format('M d, Y') }}</p>
                            <p class="card-text mb-1"><strong>Check-out:</strong> {{ \Carbon\Carbon::parse($reservation->check_out_date)->format('M d, Y') }}</p>
                            <p class="card-text mb-1"><strong>Reserved days:</strong> {{ $reservation->total_night }}</p>
                            <p class="card-text mb-1"><strong>Guests:</strong> {{ $reservation->total_adult }} Adults, {{ $reservation->total_child }} Children, {{ $reservation->total_infant }} Infants</p>
                            <p class="card-text"><strong>Total:</strong> {{ number_format($reservation->final_price, 2) }} ETB</p>
                            <hr>
                            <p class="card-text mb-1"><strong>Reservation Status: <span class=" badge bg-secondary">{{ $reservation->status }}</span></strong></p>
                            <p class="card-text mb-1"><strong>Pyament Status: <span class="badge bg-info">{{ $reservation->payment_status }}</span></strong> </p>
                            <button class="btn btn-outline-primary btn-sm mt-3" type="button" data-bs-toggle="collapse" data-bs-target="#orderDetails-{{ $reservation->id }}">
                                View Details
                            </button>

                            <div id="orderDetails-{{ $reservation->id }}" class="collapse mt-3">
                                <ul class="list-group">
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <div class="d-flex align-items-center">
                                            @if($reservation->room->cover_image)
                                            <a href="{{ url('hotel/room/'.$reservation->room->id.'/detail') }}">
                                                <img src="{{ $reservation->room->cover_image }}" class="img-thumbnail me-3" style="width: 50px; height: 50px; object-fit: cover;">
                                            </a>
                                            @endif
                                            <div>
                                                <p class="text-muted mb-1">Room Number #: {{ $reservation->room->room_number }}</p>
                                                <p class="text-muted mb-1">Capacity : {{ $reservation->room->capacity }}</p>
                                                <p class="text-muted mb-1">Floor: {{ $reservation->room->floor }}</p>
                                            </div>
                                            <span class="fw-bold">{{ $reservation->room->price }} ETB <small class="fw-normal">/ Night</small></span>
                                        </div>
                                    </li>
                                </ul>
                                </ul>
                            </div>
                        </div>
                        <div class="card-footer d-flex justify-content-between align-items-center">
                            @if($reservation->hotel_reservation_payment_info)
                            <div class="d-flex justify-content-around align-items-center">
                                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#Reservation{{ $reservation->id }}">
                                    <i class="bi bi-eye-fill"></i> Payment information
                                </button> &nbsp;
                                <form action="{{ route('reservations.receipt') }}" method="GET" target="_blank">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ encrypt($reservation->id) }}">
                                    <button type="submit" class="btn btn-outline-secondary btn-sm "><i class="bi bi-printer-fill"></i></button>
                                </form>
                            </div>
                            <div class="modal fade" id="Reservation{{ $reservation->id }}" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Payment Detail</h5>
                                            <button type="button" class="close btn" data-bs-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <p>Receipt:</p>
                                            @if($reservation->hotel_reservation_payment_info->receipt)
                                            <img src="{{ $reservation->hotel_reservation_payment_info->receipt }}" class="img-fluid" alt="{{ $reservation->hotel_reservation_payment_info->bank_name }}">
                                            @else
                                            <img src="{{ asset('restaurant_frontend/default-image.png') }}" class="img-fluid" alt="{{ $reservation->hotel_reservation_payment_info->bank_name }}">
                                            @endif
                                            <p class="card-text"><strong>Bank Name :</strong> {{ $reservation->hotel_reservation_payment_info->bank_name }}</p>
                                            <p class="card-text"><strong>Transaction Number :</strong> <strong>{{ $reservation->hotel_reservation_payment_info->transaction_number }}</strong></p>
                                            <p class="card-text"><strong>Amount Paid :</strong> {{ $reservation->hotel_reservation_payment_info->amount_paid }} ETB</p>
                                            <p class="card-text text-dark"><strong>Payment Status :</strong> <span class="btn btn-sm btn btn-secondary">{{ $reservation->hotel_reservation_payment_info->payment_status }}</span></p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @else
                            @endif

                            <a href="{{ url('hotel/'.$reservation->hotel->id.'/detail') }}" class="btn btn-sm btn-primary">
                                View Hotel
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            @endif
        </div>
        <div class="tab-pane fade" id="pills-goods" role="tabpanel" aria-labelledby="pills-goods-tab">
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4 mb-2">
                @foreach ($good_orders as $order)
                @if($order['orders_products'])
                <div class="col-md-4">
                    <div class="offer-card h-100 rounded-3">
                        <div class="card-body">
                            <h5 class="card-title mb-3">
                                <span class="text-muted">Order ID:</span>
                                <a href="{{ url('user/orders/'.$order['id']) }}" class="text-decoration-none text-dark">
                                    #{{ $order['id'] }}
                                </a>
                            </h5>

                            <p class="mb-2">
                                <span class="fw-semibold text-muted">Ordered Products:</span><br>
                                @foreach ($order['orders_products'] as $product)
                                <span class="badge bg-light text-dark border me-1 mb-1">
                                    {{ $product['product_code'] }}
                                </span>
                                @endforeach
                            </p>
                            <p class="mb-1"><strong class="text-muted">Payment Method:</strong> {{ $order['payment_method'] }}</p>
                            <p class="mb-1"><strong class="text-muted">Grand Total:</strong> {{ $order['grand_total'] }}</p>
                            <p class="mb-3"><strong class="text-muted">Date:</strong> {{ $order->created_at->format('d M Y, h:i A') }}</p>
                            <button class="btn btn-outline-primary btn-sm " type="button" data-bs-toggle="collapse" data-bs-target="#goodsorderDetails{{ $order->id }}">
                                View Ordered Products
                            </button>

                            <div id="goodsorderDetails{{ $order->id }}" class="collapse mt-3">
                                <div class="border rounded-2 p-2 bg-light">
                                    @foreach ($order['orders_products'] as $product)
                                    <div class="d-flex align-items-center mb-3">
                                        <img src="{{ asset('/storage/products/' . Product::getProductImage($product['product_id'])) }}" alt="Product Image" class="rounded me-3" style="width: 60px; height: 60px; object-fit: cover;">
                                        <div class="flex-grow-1">
                                            <h6 class="mb-1">{{ $product['product_name'] }}</h6>
                                            <small class="text-muted">Code: {{ $product['product_code'] }}</small><br>
                                            <small class="text-muted">Size: {{ $product['product_size'] }} | Color: {{ $product['product_color'] }}</small>
                                        </div>
                                        <span class="badge bg-primary-subtle text-dark ms-3">
                                            Qty: {{ $product['product_qty'] }}
                                        </span>
                                    </div>
                                    @endforeach
                                </div>
                            </div>

                            <div class="d-flex justify-content-between align-items-center">
                                <div class="text-start mt-3 d-flex justify-content-between align-items-center">
                                    @if($order->paymentInfo)
                                    <div class="d-flex justify-content-around align-items-center">
                                        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#Reservation{{ $order->id }}">
                                            <i class="bi bi-eye-fill"></i> Payment information
                                        </button> &nbsp;
                                    </div>
                                    <div class="modal fade" id="Reservation{{ $order->id }}" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-scrollable" role="document">
                                            <div class="modal-content ">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Payment Detail</h5>
                                                    <button type="button" class="close btn" data-bs-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body text-left">
                                                    <p>Receipt:</p>
                                                    @if($order->paymentInfo->receipt)
                                                    <img src="{{ asset('storage/'.$order->paymentInfo->receipt) }}" class="img-fluid" alt="{{ $order->paymentInfo->bank_name }}">
                                                    @else
                                                    <img src="{{ asset('restaurant_frontend/default-image.png') }}" class="img-fluid" alt="{{ $order->paymentInfo->bank_name }}">
                                                    @endif
                                                    <p class="card-text"><strong>Bank Name :</strong> {{ $order->paymentInfo->bank_name }}</p>
                                                    <p class="card-text"><strong>Transaction Number :</strong> <strong>{{ $order->paymentInfo->transaction_number }}</strong></p>
                                                    <p class="card-text"><strong>Amount Paid :</strong> {{ $order->paymentInfo->amount_paid }} ETB</p>
                                                    <p class="card-text text-dark"><strong>Payment Status :</strong> <span class="btn btn-sm btn btn-secondary">{{ $order->paymentInfo->payment_status }}</span></p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @else
                                    @endif
                                </div>
                                <a href="{{ url('ecommerce/orders/'.encrypt($order['id'])) }}" class="btn btn-sm btn-primary mt-3">
                                    <i class="fas fa-eye me-1"></i> View Full Order
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection

