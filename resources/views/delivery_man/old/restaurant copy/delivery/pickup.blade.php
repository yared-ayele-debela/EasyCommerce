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
            <li class="breadcrumb-item active" aria-current="page">Live Route Tracker</li>
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
                    <button id="startDrivingBtn" class="btn btn-success btn-sm">Start Driving</button>
                   </div>
                </div>
                <div class="card-body">
                    
                    <div id="map" class="mt-3"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Scripts -->
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<script src="https://unpkg.com/leaflet-routing-machine/dist/leaflet-routing-machine.min.js"></script>
<script src="https://js.pusher.com/7.2/pusher.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/laravel-echo/1.11.3/echo.iife.js"></script>

<script>
  
  

    const destinationLatLng = [{{ $restaurant->latitude }}, {{ $restaurant->longitude }}];
    const deliveryManId = {{ $order->delivery_man_id }};
    let startedDriving = false;

    const map = L.map('map').setView(destinationLatLng, 13);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
    }).addTo(map);

    // Restaurant marker
    const destinationMarker = L.marker(destinationLatLng, {
        icon: L.icon({
            iconUrl: '{{ asset('restaurant_frontend/hotel.gif') }}',
            iconSize: [40, 40],
            iconAnchor: [15, 15]
        })
    }).addTo(map).bindPopup("Restaurant").openPopup();

    let deliveryMarker = null;
    let routeControl = null;

    // Start Driving button
    document.getElementById('startDrivingBtn').addEventListener('click', () => {
        startedDriving = true;

        if (deliveryMarker) {
            const currentLatLng = deliveryMarker.getLatLng();
            map.setView(currentLatLng, 15); // or use map.flyTo for smooth animation
        }
    });

    // Laravel Echo Setup
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
            if (e.deliveryManId == deliveryManId) {
                const currentLatLng = [e.latitude, e.longitude];

                // Create or move marker
                if (!deliveryMarker) {
                    deliveryMarker = L.marker(currentLatLng, {
                        icon: L.icon({
                            iconUrl: '{{ asset('restaurant_frontend/delivery-man.gif') }}',
                            iconSize: [50, 50],
                            iconAnchor: [25, 25]
                        })
                    }).addTo(map).bindPopup("You");
                } else {
                    deliveryMarker.setLatLng(currentLatLng);
                }

                // Only draw route when "Start Driving" is clicked
                if (startedDriving) {
                    if (routeControl) {
                        map.removeControl(routeControl);
                    }

                    routeControl = L.Routing.control({
                        waypoints: [
                            L.latLng(currentLatLng),
                            L.latLng(destinationLatLng)
                        ],
                        createMarker: () => null,
                        show: false,
                        addWaypoints: false,
                        draggableWaypoints: false,
                        fitSelectedRoutes: true,
                        lineOptions: {
                            styles: [{ color: 'green', weight: 5, opacity: 0.8 }]
                        }
                    }).addTo(map);
                    routeControl.on('routesfound', function(e) {
                        const instructions = e.routes[0].instructions || e.routes[0].segments || [];
                        let spokenInstructions = e.routes[0].instructions || [];

                        if ('speechSynthesis' in window) {
                            spokenInstructions.forEach((instr, idx) => {
                                setTimeout(() => {
                                    const utterance = new SpeechSynthesisUtterance(instr.text || instr.instruction || '');
                                    utterance.lang = 'en-US';
                                    window.speechSynthesis.speak(utterance);
                                }, idx * 4000); // 4 seconds gap between steps
                            });
                        } else {
                            console.warn("This browser does not support Speech Synthesis");
                        }
                    });
                }
            }
        });
</script>
@endsection
