@extends('all_frontend_layouts.layouts')
@section('content')
<div class="container py-4">
    <div class="row">
        <!-- Map Section -->
        <div class="col-md-6 mb-2">
            <div class="card">
                <div class="card-body p-0">
                    <!-- Embed Google Maps showing delivery location -->
                    <iframe src="https://www.google.com/maps/embed?pb={{ $order->delivery_location }}"
                        width="100%" height="500" style="border:0;" allowfullscreen="" loading="lazy">
                    </iframe>
                </div>
            </div>
        </div>

        <!-- Order Process Section -->
        <div class="col-md-6 mb-2">
            <div class="card">
                <div class="card-body">
                    <!-- Order Process -->
                    <div class="track">
                        <div class="step {{ $order->status == 'confirmed' ? 'active' : '' }}">
                            <span class="icon"><i class="fa fa-check"></i></span>
                            <span class="text">Order confirmed</span>
                        </div>
                        <div class="step {{ $order->status == 'picked' ? 'active' : '' }}">
                            <span class="icon"><i class="fa fa-user"></i></span>
                            <span class="text">Picked by courier</span>
                        </div>
                        <div class="step {{ $order->status == 'shipped' ? 'active' : '' }}">
                            <span class="icon"><i class="fa fa-truck"></i></span>
                            <span class="text">On the way</span>
                        </div>
                        <div class="step {{ $order->status == 'delivered' ? 'active' : '' }}">
                            <span class="icon"><i class="fa fa-box"></i></span>
                            <span class="text">Ready for pickup</span>
                        </div>
                    </div>

                    <!-- Estimated Delivery Time -->
                    <div class="py-4">
                        <h5 class="mb-3 text-center text-muted">Estimated Delivery Time</h5>
                        <div class="text-center mb-3">
                            <span class="badge bg-primary fs-6">30 mins</span>
                        </div>
                    </div>

                    <!-- Order Products -->
                    <h5 class="mb-3 text-muted">Order Products</h5>
                    <ul class="list-group mb-3">
                        @foreach($order->orderItems as $item)
                        <li class="list-group-item d-flex justify-content-between">
                            <span>
                                <img src="{{ asset('storage/' . $item->product->image) }}" style="max-width: 60px; height:auto;" alt="">
                                {{ $item->product->name }}
                                <span class="text-dark">Ordered at {{ $order->created_at->format('M d, Y h:i A') }}</span>
                            </span>
                            <span>{{ $item->quantity }} x</span>
                        </li>
                        @endforeach
                    </ul>

                    <!-- Delivery Person Info -->
                    <h5 class="mb-3 text-muted">Delivery Person</h5>
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <img src="{{ asset('storage/' . $order->deliveryPerson->image) }}" alt="Delivery Man" class="rounded-circle me-3" style="width: 60px; height: 60px;">
                            <h6 class="mb-0">{{ $order->deliveryPerson->name }}</h6> &nbsp;
                            <br>
                            <span class="text-dark">{{ $order->deliveryPerson->location }}</span>
                        </div>
                        <button class="btn bg-light shadow-lg" style="border-radius: 50%;">
                            <i class="bi bi-telephone-forward-fill text-primary"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    setInterval(function() {
        fetch("{{ route('order.track', $order->id) }}")
            .then(response => response.json())
            .then(data => {
                document.getElementById('orderStatus').innerText = data.status.charAt(0).toUpperCase() + data.status.slice(1);
            });
    }, 5000);
</script>
@endsection
