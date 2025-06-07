@extends('all_frontend_layouts.layouts')
@section('content')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" />
<link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine@latest/dist/leaflet-routing-machine.css" />
<script src="https://js.pusher.com/7.2/pusher.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/laravel-echo/1.11.1/echo.iife.js"></script>
<script>
    window.Pusher = Pusher;
    window.Echo = new Echo({
        broadcaster: 'pusher',
        key: '{{ env("PUSHER_APP_KEY") }}',
        cluster: '{{ env("PUSHER_APP_CLUSTER") }}',
        forceTLS: true
    });
</script>

<style>
  #map {
    height: 400px;
    border-radius: 12px;
    box-shadow: 0 0 10px rgba(0,0,0,0.1);
  }
</style>
<div class="container py-4">
     <div class="header">
        <button class="btn btn-link text-dark" onclick="history.back()">
            <i class="bi bi-arrow-left"></i>
        </button>
        <h5 class="my-4 text-dark text-center">Track Order</h5>
    </div>
    <div class="row">
        <!-- Map Section -->
         <div class="col-md-6 mb-2">
            <div class="offer-card">
                <div class="card-body">
                    <!-- Order Process -->
                    <div class="track">
                        <div class="step {{ $order->status == 'pending' || $order->status == 'confirmed' || $order->status == 'picked' || $order->status == 'shipped' || $order->status == 'delivered' ? 'active' : '' }}">
                            <span class="icon"><i class="fa fa-check"></i></span>
                            <span class="text">Order Pending</span>
                        </div>
                        <div class="step {{ $order->status == 'confirmed' || $order->status == 'picked' || $order->status == 'shipped' || $order->status == 'delivered' ? 'active' : '' }}">
                            <span class="icon"><i class="fa fa-check"></i></span>
                            <span class="text">Order confirmed</span>
                        </div>
                        <div class="step {{ $order->status == 'picked' || $order->status == 'shipped' || $order->status == 'delivered' ? 'active' : '' }}">
                            <span class="icon"><i class="fa fa-user"></i></span>
                            <span class="text">Picked by courier</span>
                        </div>
                        <div class="step {{ $order->status == 'shipped' || $order->status == 'delivered' ? 'active' : '' }}">
                            <span class="icon"><i class="fa fa-truck"></i></span>
                            <span class="text">On the way</span>
                        </div>
                        <div class="step {{ $order->status == 'delivered' ? 'active' : '' }}">
                            <span class="icon"><i class="fa fa-box"></i></span>
                            <span class="text">Ready for pickup</span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            @if($order->delivery_status !== 'delivered')
                            @if($order->delivery_code)
                            <p><strong>Delivery Code:</strong> {{ $order->delivery_code }}</p>
                            <div class="mb-2">
                                {!! QrCode::size(100)->generate($order->delivery_code) !!}
                            </div>
                            @endif
                            @endif
                        </div>
                        <div class="col-md-6">
                            <!-- Estimated Delivery Time -->
                            <div class="py-4">
                                <h5 class="mb-3 text-center text-muted">Estimated Delivery Time</h5>
                                <div class="text-center mb-3">
                                    <span class="badge bg-primary fs-6">30 mins</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Order Products -->
                    <h6 class="my-3 text-muted">Order Products</h6>
                    <ul class="list-group mb-3">
                        @foreach($order->orderItems as $item)
                        <li class="list-group-item d-flex justify-content-between">
                            <span>
                                @php
                                    $imagePath = $item->product->image
                                    ? str_replace(asset('storage') . '/', '', $item->product->image)
                                    : null;
                                @endphp
                                @if($item->product->image && Storage::disk('public')->exists($imagePath))
                                    <img src="{{ $item->product->image }}"style="max-width: 60px; height:auto;">
                                @else
                                    <img src="{{ asset('restaurant_frontend/default-image.png') }}" style="max-width: 60px; height:auto;">
                                @endif
                                {{ $item->product->name }}
                                <span class="text-dark">Ordered at {{ $order->created_at->format('M d, Y h:i A') }}</span>
                            </span>
                            <span>{{ $item->quantity }} x</span>
                        </li>
                        @endforeach
                    </ul>
                    <!-- Delivery Person Info -->
                    @if($order->deliveryman)
                    <h5 class="mb-3 text-muted">Delivery Person</h5>
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <img src="{{ asset('/storage/delivery_man/'.$order->deliveryman->delivery_man_image) }}" alt="Delivery Man" class="rounded-circle me-3" style="width: 60px; height: 60px;">
                            <h6 class="mb-0">{{ $order->deliveryman->first_name }} {{ $order->deliveryman->last_name }}</h6> &nbsp;
                            {{-- <span class="text-dark">Location</span> --}}
                        </div>
                        <button class="btn bg-light shadow-lg" style="">
                            {{ $order->deliveryman->phone }}  <i class="bi bi-telephone-forward-fill text-primary"></i>
                        </button>
                    </div>
                    @endif
                    <hr>
                     <div class="d-flex justify-content-between align-items-center">
                            <p class="font-bold">
                                Delivery Status: <span><strong>{{ $order->delivery_status }}</strong></span>
                            </p>
                     </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-2">
            @if($order->delivery_status === 'delivering')
            <div class="offer-card">
                <div class="card-body p-3">
                    <p class="mb-4 text-muted">Below is the map showing your delivery destination and the delivery man's real-time location.</p>
                    <div id="map" class="mb-3"></div>
                </div>
            </div>
            @endif
        </div>
        <div class="col-12">
            <a  href="{{ route('user.orders') }}" class="btn btn-outline-primary rounded rounded-1">Back to your orders</a>
        </div>
    </div>
</div>
@if($order->deliveryman)
<script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"></script>
<script src="https://unpkg.com/leaflet-routing-machine@latest/dist/leaflet-routing-machine.min.js"></script>
<script src="https://js.pusher.com/7.2/pusher.min.js"></script>
$order->address->latitude

<script>
    // Initialize map centered on delivery location
    const deliveryLatLng = [{{ $order->address->latitude }}, {{ $order->address->longitude }}];
    const map = L.map('map').setView(deliveryLatLng, 13);

    // Tile layer
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 18,
    }).addTo(map);

    // Delivery destination marker
    const destinationMarker = L.marker(deliveryLatLng)
        .addTo(map)
        .bindPopup("Delivery Destination");

    // Delivery man marker and trail
    let deliveryMarker = null;
    let trailCoords = [];
    let trailPolyline = L.polyline([], { color: 'blue' }).addTo(map);

    // Route control
    let routeControl = null;

    function updateRoute(startLatLng, endLatLng) {
        if (routeControl) {
            map.removeControl(routeControl);
        }

        routeControl = L.Routing.control({
            waypoints: [
                L.latLng(startLatLng[0], startLatLng[1]),
                L.latLng(endLatLng[0], endLatLng[1])
            ],
            routeWhileDragging: false,
            addWaypoints: false,
            draggableWaypoints: false,
            createMarker: () => null
        }).addTo(map);
    }

    // Initialize Echo with Laravel WebSockets
    window.Pusher = Pusher;
    window.Echo = new Echo({
        broadcaster: 'pusher',
        key: 'localkey',
        wsHost: window.location.hostname,
        wsPort: 6001,
        forceTLS: false,
        disableStats: true
    });

    // Listen to location updates
    window.Echo.channel('delivery-locations')
        .listen('.location.updated', (e) => {
            if (e.deliveryManId == {{ $order->del }}) {
                const latLng = [e.latitude, e.longitude];

                if (!deliveryMarker) {
                    deliveryMarker = L.marker(latLng, {
                        icon: L.icon({
                            iconUrl: 'https://cdn-icons-png.flaticon.com/512/684/684908.png',
                            iconSize: [30, 30]
                        })
                    }).addTo(map).bindPopup("Delivery Man");
                } else {
                    deliveryMarker.setLatLng(latLng);
                }

                // Update trail
                trailCoords.push(latLng);
                trailPolyline.setLatLngs(trailCoords);

                // Update route
                updateRoute(latLng, deliveryLatLng);
            }
        });
</script>

@endif
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
