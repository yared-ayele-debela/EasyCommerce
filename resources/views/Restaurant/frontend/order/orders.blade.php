@extends('all_frontend_layouts.layouts')
@section('content')

<div class="container my-4">
    <h3 class="mb-4 text-dark font-bold">My Orders</h3>

    @if($orders->isEmpty())
    <div class="alert alert-info text-center">
        <p>No orders found. Start ordering your favorite meals!</p>
        <a href="{{ url('/') }}" class="btn btn-primary">Order Now</a>
    </div>
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
                            <p class="text-muted mb-1"> Order Status :  <span class="btn btn-sm text-white @if($order->status == 'completed') bg-success @endif  @if($order->status==='processing') bg-info @endif  @if($order->status == 'canceled') bg-danger @endif
                                @if($order->status == 'pending') bg-warning @endif      ">
                                 {{ ucfirst($order->status) }}
                             </span>
                            </p>
                            <p class="text-muted mb-1"> Delivery Status :  <span class="btn btn-sm text-white @if($order->delivery_status === 'shipped') bg-info @endif  @if($order->delivery_status==='delivered') bg-success @endif
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
                                    <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}" class="img-thumbnail me-3" style="width: 50px; height: 50px; object-fit: cover;">

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
                                <span class="fw-bold">{{ $item->total }} ETB</span>
                            </li>
                        @endforeach
                        </ul>
                        </ul>
                    </div>

                    <div class="text-end mt-3 d-flex justify-content-between align-items-center">
                        <a href="{{ route('order.track', $order->id) }}" class="btn btn-primary btn-sm"><span class="bi bi-pin-map text-white"></span> Track Order</a>
                        <form action="{{ url('restaurant/order-receipt')}}" method="POST" target="_blank">
                            @csrf
                            <input type="hidden" name="order_id" value="{{ $order->id }}">
                            <button type="submit"  class="btn btn-sm bg-primary text-white"><span class="bi bi-printer"></span></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @endif
</div>
@endsection

