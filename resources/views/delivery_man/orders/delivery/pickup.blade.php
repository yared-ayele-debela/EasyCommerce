@extends('delivery_man.admin_dashboard.maindashboard')
@section('delivery_man_dashboard')

@php
$delivery_men = Auth::guard('deliverymen')->user();
@endphp

<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine/dist/leaflet-routing-machine.css" />

<style>
    #map { height: 500px; }
    .leaflet-routing-container {
        background: white;
        border-radius: 8px;
        padding: 5px;
    }
</style>

<div class="container">
    <nav class="breadcrumb bg-white shadow-sm py-3 px-4 rounded d-flex justify-content-between align-items-center">
        <button class="btn btn-outline-primary btn-sm d-flex align-items-center" onclick="history.back()">
            <i class="bi bi-arrow-left mr-2"></i> &nbsp;
            <span>Back</span>
        </button>
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ url('delivery-boy/dashboard') }}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Shop Route Tracker</li>
        </ol>
    </nav>

    <div class="row g-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                   <div class="d-flex justify-content-between justify-items-center">
                     <div class="">
                        <button class="btn btn-sm btn-primary" onclick="window.speechSynthesis.resume()">Resume Voice</button>
                        <button class="btn btn-sm btn-warning" onclick="window.speechSynthesis.pause()">Pause Voice</button>
                        <button class="btn btn-sm btn-danger" onclick="window.speechSynthesis.cancel()">Stop Voice</button>
                    </div>
                   </div>
                </div>
                <div class="card-body">
                    
                    <div id="map" class="mt-3"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<script src="https://unpkg.com/leaflet-routing-machine/dist/leaflet-routing-machine.min.js"></script>
<script src="https://js.pusher.com/7.2/pusher.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/laravel-echo/1.11.3/echo.iife.js"></script>

<script>
const destinationLatLng = [{{ $vendor->latitude }}, {{ $vendor->longitude }}];
const map = L.map('map').setView(destinationLatLng, 13);

// Tile layer
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 19,
}).addTo(map);

// Destination marker
const destination = L.marker(destinationLatLng, {
    icon: L.icon({
        iconUrl: '{{ asset('restaurant_frontend/store.gif') }}',
        iconSize: [40, 40],
        iconAnchor: [15, 15]
    })
}).addTo(map).bindPopup("Hotel Location");

// Delivery marker, routing control, and trail
let deliveryMarker = null;
let routingControl = null;
let previousCoords = [];
const trail = L.polyline([], { color: 'blue', weight: 3 }).addTo(map);

// Voice setup
function speak(text) {
    const utterance = new SpeechSynthesisUtterance(text);
    speechSynthesis.speak(utterance);
}

// Laravel Echo setup (WebSocket)
window.Pusher = Pusher;
window.Echo = new Echo({
    broadcaster: 'pusher',
    key: 'local',
    wsHost: window.location.hostname,
    wsPort: 6001,
    forceTLS: false,
    disableStats: true,
});

// Start Driving Button
const startDrivingBtn = L.control({ position: 'topright' });
startDrivingBtn.onAdd = () => {
    const btn = L.DomUtil.create('button', 'btn btn-success m-3');
    btn.innerHTML = 'Start Driving';
    btn.onclick = () => {
        if (deliveryMarker) {
            map.setView(deliveryMarker.getLatLng(), 15);
        }
    };
    return btn;
};
startDrivingBtn.addTo(map);

// Echo listen
window.Echo.channel('delivery-locations')
    .listen('.location.updated', (e) => {
        if (e.deliveryManId != {{ $order->delivery_boy_id }}) return;

        const currentLatLng = [e.latitude, e.longitude];
        previousCoords.push(currentLatLng);
        trail.setLatLngs(previousCoords);

        // Add/update delivery marker
        if (!deliveryMarker) {
            deliveryMarker = L.marker(currentLatLng, {
                icon: L.icon({
                    iconUrl: '{{ asset('restaurant_frontend/delivery-man.gif') }}',
                    iconSize: [50, 50],
                    iconAnchor: [15, 15]
                })
            }).addTo(map).bindPopup("Your Location");
        } else {
            // Animate movement
            deliveryMarker.setLatLng(currentLatLng);
        }

        // Auto-follow delivery man
        map.panTo(currentLatLng);

        // Routing update
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
                styles: [{ color: 'green', opacity: 0.9, weight: 6 }]
            }
        }).addTo(map);

        // Speak turn-by-turn instructions
        routingControl.on('routesfound', function(e) {
            const instructions = e.routes[0].instructions || [];
            if (instructions.length) {
                speak(`Next step: ${instructions[0].text}`);
            }
        });
    });
</script>

@endsection
