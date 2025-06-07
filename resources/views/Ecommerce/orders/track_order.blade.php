@extends('all_frontend_layouts.layouts')
@section('content')

<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine/dist/leaflet-routing-machine.css" />
<style>
    #map { height: 500px; }
</style>
@php
    use App\Models\Product;
@endphp
<div class="container">
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
                    @php
                    $status = $order->order_status;

                    $steps = [
                    ['label' => 'Order New', 'icon' => 'fa-check', 'active_statuses' => ['new', 'pending', 'confirmed', 'picked', 'delivered', 'delivering', 'cancelled']],
                    ['label' => 'Order Pending', 'icon' => 'fa-check', 'active_statuses' => ['pending', 'confirmed', 'picked', 'delivered', 'delivering', 'cancelled']],
                    ['label' => 'Order Confirmed', 'icon' => 'fa-check', 'active_statuses' => ['confirmed', 'picked', 'delivered', 'delivering', 'cancelled']],
                    ['label' => 'Picked by delivery man', 'icon' => 'fa-user', 'active_statuses' => ['picked', 'delivered', 'delivering', 'cancelled']],
                    ['label' => 'On the way', 'icon' => 'fa-truck', 'active_statuses' => ['delivering', 'delivered']],
                    ['label' => 'Ready for pickup', 'icon' => 'fa-box', 'active_statuses' => ['delivered']],
                    ];
                    @endphp

                    <div class="track">
                        @foreach ($steps as $step)
                        <div class="step {{ in_array($status, $step['active_statuses']) ? 'active' : '' }}">
                            <span class="icon"><i class="fa {{ $step['icon'] }}"></i></span>
                            <span class="text">{{ $step['label'] }}</span>
                        </div>
                        @endforeach
                    </div>

                    <div class="row">
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
                   @foreach ($order->orders_products as $product)
                    <div class="d-flex align-items-center mb-3">
                        <img src="{{ Product::getProductImage($product['product_id'])??asset('restaurant_frontend/default-image.png') }}" alt="Product Image" class="rounded me-3" style="width: 60px; height: 60px; object-fit: cover;">
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
                    <hr>
                    <div class="d-flex justify-content-between align-items-center">
                        <p class="font-bold">
                            Delivery Status: <span class="btn btn-secondary btn-sm"><strong>{{ $order->order_status }}</strong></span>
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-2">
            {{-- @if($order->order_status === 'delivering') --}}
            <div class="offer-card">
                <div class="card-body p-3">
                    <p class="mb-4 text-muted">Below is the map showing your delivery destination and the delivery man's real-time location.</p>
                    <div id="map" class="mb-3"></div>
                </div>
            </div>
            {{-- @endif --}}
        </div>
        <div class="col-12">
            <a  href="{{ route('user.orders') }}" class="btn btn-outline-primary rounded rounded-1">Back to your orders</a>
    </div>
</div>
</div>

<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<script src="https://unpkg.com/leaflet-routing-machine/dist/leaflet-routing-machine.min.js"></script>
<script src="https://js.pusher.com/7.2/pusher.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/laravel-echo/1.11.3/echo.iife.js"></script>
{{-- @if($order->order_status==="delivering") --}}
<script>
    const destinationLatLng = [{{ $order->latitude }}, {{ $order->longitude }}];
    const map = L.map('map').setView(destinationLatLng, 13);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
    }).addTo(map);

    // Destination marker
    const destination = L.marker(destinationLatLng,{
         icon: L.icon({
        iconUrl: '{{ asset('restaurant_frontend/placeholder.gif') }}',
        iconSize: [50, 50],
        iconAnchor: [15, 15]
    })
    })
        .addTo(map)
        .bindPopup("Delivery Destination")
        .openPopup();

    let deliveryMarker = null;
    let routingControl = null;
    // let trailPolyline = L.polyline([], { color: 'blue' }).addTo(map);
    let previousCoords = [];

    // Laravel Echo setup
    window.Pusher = Pusher;
    window.Echo = new Echo({
        broadcaster: 'pusher',
        key: 'local',
        wsHost: window.location.hostname,
        wsPort: 6001,
        forceTLS: false,
        disableStats: true,
    });

    window.Echo.channel('delivery-locations')
        .listen('.location.updated', (e) => {
            if (e.deliveryManId == {{ $order->delivery_boy_id }}) {
                const currentLatLng = [e.latitude, e.longitude];

                // Add trail
                previousCoords.push(currentLatLng);
                // trailPolyline.setLatLngs(previousCoords);

                if (!deliveryMarker) {
                    deliveryMarker = L.marker(currentLatLng, {
                        icon: L.icon({
                            iconUrl: '{{ asset('restaurant_frontend/delivery-man.gif') }}',
                            iconSize: [50, 50],
                            iconAnchor: [15, 15]
                        })
                    }).addTo(map).bindPopup("Delivery Man");
                } else {
                    deliveryMarker.setLatLng(currentLatLng);
                }
                if (routingControl) {
                    map.removeControl(routingControl);
                }
                routingControl = L.Routing.control({
                    waypoints: [
                        L.latLng(currentLatLng[0], currentLatLng[1]),
                        L.latLng(destinationLatLng[0], destinationLatLng[1])
                    ],
                    routeWhileDragging: false,
                    draggableWaypoints: false,
                    addWaypoints: false,
                    show: false,
                    fitSelectedRoutes: false,
                    createMarker: () => null,
                     lineOptions: {
                    styles: [
                        {
                            color: 'green',      // 💡 Change this to your preferred color
                            opacity: 0.8,
                            weight: 4          // 💡 Change this to adjust thickness
                        }
                    ]
                }
                }).addTo(map);
            }
        });
</script>
{{-- @endif --}}
@endsection

