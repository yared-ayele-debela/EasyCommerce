@extends('delivery_man.admin_dashboard.maindashboard')
@section('delivery_man_dashboard')
@php
$delivery_men = Auth::guard('deliverymen')->user();
@endphp
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<style>
         #instructions {
        max-height: 250px;
        overflow-y: auto;
        z-index: 1000;
    }

        #map {
            width: 100%;
            height: 70vh;
            border-radius: 10px;
        }

        .info-card {
            background: #f8f9fa;
            border-radius: 10px;
            box-shadow: 0 0.75rem 1.5rem rgba(0, 0, 0, 0.1);
        }

        .info-card h5 {
            font-weight: bold;
            color: #2ddb27;
        }

        .text-primary {
            color: #2ddb27 !important;
        }

        .metric {
            font-size: 1.1rem;
            font-weight: 600;
        }

        .metric small {
            font-weight: 400;
            font-size: 0.9rem;
            color: #666;
        }

    </style>
 <div class="container">
    <nav class="breadcrumb bg-white shadow-sm py-3 px-4 rounded d-flex justify-content-between align-items-center">
        <button class="btn btn-outline-primary btn-sm d-flex align-items-center" onclick="history.back()">
            <i class="bi bi-arrow-left mr-2"></i> &nbsp;
            <span>Back</span>
        </button>
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item">
                <a href="{{ url('delivery-boy/dashboard') }}">Home</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">Live Route Tracker</li>
        </ol>
    </nav>
        {{-- <div class="row mb-4">
            <div class="col-md-8 mx-auto text-center">
                <h1 class="display-5 fw-bold text-primary">🚗 Live Route Tracker</h1>
                <p class="lead">Real-time vehicle animation with total distance and estimated time</p>
            </div>
        </div> --}}

        <div class="row g-4">
            <div class="col-md-8">
                <div class="info-card p-2">
                    <div id="map"></div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="p-4 info-card">
                    <h5>Route Summary</h5>
                    <hr>
                    <p class="metric"><i class="bi bi-pin-map-fill text-primary"></i> Start: <span id="startPoint">-</span></p>
                    <p class="metric"><i class="bi bi-geo-alt-fill text-primary"></i> End: <span id="endPoint">-</span>
                    </p>
                    <p class="metric"><i class="bi bi-rulers text-primary"></i> Distance: <span id="totalDistance">-</span> km</p>
                    <p class="metric"><i class="bi bi-clock-fill text-primary"></i> Time: <span id="estimatedTime">-</span></p>
                </div>
                <div class="p-4 info-card mt-4">
                    <h5>📋 Step-by-Step Instructions</h5>
                    <ul class="list-group list-group-flush" id="instructions"></ul>
                </div>

            </div>
        </div>
    </div>

     <!-- Bootstrap & Leaflet JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

    <script>
    const destinationLat = "{{ $restaurant->latitude }}";
    const destinationLng = "{{ $restaurant->longitude }}";
    const restaurant_name = "{{ $restaurant->name }}";
    const destination = `${destinationLat},${destinationLng}`;

    const restaurantIcon = L.icon({
        iconUrl: '{{ $restaurant->cover?$restaurant->cover:asset('restaurant_frontend/no-image.jpg') }}',
        iconSize: [38, 38],
        iconAnchor: [19, 38],
        popupAnchor: [0, -38]
    });

     const deliveryManIcon = L.icon({
        iconUrl: '{{ $delivery_men->delivery_man_image?asset('/storage/delivery_man/'.Auth::guard('deliverymen')->user()->delivery_man_image):asset('restaurant_frontend/no-image.jpg') }}',
        iconSize: [38, 38],
        iconAnchor: [19, 38],
        popupAnchor: [0, -38]
    });

    let map, vehicle;

    async function initMap() {
        // Get user's current location
        navigator.geolocation.getCurrentPosition(async (position) => {
            const originLat = "{{ $delivery_men->current_lat }}";
            const originLng = "{{ $delivery_men->current_lng }}";
            const origin = `${originLat},${originLng}`;

            try {
                const res = await fetch(`/order/route?origin=${origin}&destination=${destination}`);
                const data = await res.json();

                if (!data.direction) {
                    alert("No route found.");
                    return;
                }

                const coords = data.direction.map(([lat, lng]) => [parseFloat(lat), parseFloat(lng)]);
                map = L.map('map').setView(coords[0], 14);

                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    maxZoom: 19,
                    attribution: '&copy; OpenStreetMap contributors'
                }).addTo(map);

                const polyline = L.polyline(coords, { color: 'green', weight: 5 }).addTo(map);
                map.fitBounds(polyline.getBounds());

                const start = coords[0];
                const end = coords[coords.length - 1];

                L.marker(start, {icon: deliveryManIcon}).addTo(map).bindPopup("Your Location").openPopup();
                L.marker(end, { icon: restaurantIcon }).addTo(map).bindPopup(`<b>${restaurant_name}</b>`);

                // Define a custom Leaflet icon
                const turnIcon = L.icon({
                    iconUrl: 'https://cdn-icons-png.flaticon.com/512/684/684908.png', // Example icon (map direction arrow)
                    iconSize: [20, 20],  // width, height
                    iconAnchor: [15, 30],  // point of the icon which will correspond to marker's location
                    popupAnchor: [0, -30]  // point from which the popup should open relative to the iconAnchor
                });

                            (data.instruction || []).forEach((instruction, index) => {
                    const lat = parseFloat(instruction.turning_latitude);
                    const lng = parseFloat(instruction.turning_longitude);

                    L.marker([lat, lng], { icon: turnIcon })
                        .addTo(map)
                        .bindPopup(`<strong>Step ${index + 1}</strong>: ${instruction.path} <br><small>${instruction.distance.toFixed(1)} m</small>`);
                });

                // Display route stats
                document.getElementById('startPoint').innerText = `${start[0].toFixed(4)}, ${start[1].toFixed(4)}`;
                document.getElementById('endPoint').innerText = `${end[0].toFixed(4)}, ${end[1].toFixed(4)}`;
                document.getElementById('totalDistance').innerText = (data.totalDistance / 1000).toFixed(2); // km
                document.getElementById('estimatedTime').innerText = formatDuration(data.timetaken); // in sec

                // Route Instructions
                const instructions = document.getElementById('instructions');
                instructions.innerHTML = "";
                if (data.instruction && data.instruction.length > 0) {
                    data.instruction.forEach((step, index) => {
                        const li = document.createElement('li');
                        li.className = "list-group-item d-flex justify-content-between align-items-start";
                        const icon = document.createElement('span');
                        icon.className = "me-2 text-primary";
                        icon.innerHTML = `<i class="bi bi-geo-alt-fill"></i>`;
                        const stepText = document.createElement('div');
                        stepText.className = "fw-semibold";
                        stepText.innerHTML = `${index + 1}. ${step.path}`;
                        const badge = document.createElement('span');
                        badge.className = "badge bg-secondary rounded-pill";
                        badge.innerText = `${step.distance.toFixed(1)} m`;
                        li.appendChild(icon);
                        li.appendChild(stepText);
                        li.appendChild(badge);
                        instructions.appendChild(li);
                    });
                } else {
                    instructions.innerHTML = `<li class="list-group-item text-muted">No instructions available.</li>`;
                }

                // Add animated vehicle
                const vehicleIcon = L.icon({
                    iconUrl: 'https://cdn-icons-png.flaticon.com/512/744/744465.png',
                    iconSize: [40, 40],
                    iconAnchor: [20, 20]
                });

                vehicle = L.marker(start, { icon: vehicleIcon }).addTo(map);
                animateVehicle(coords);
                startLiveTracking();
            } catch (error) {
                console.error("Route fetch failed:", error);
                alert("Error loading route.");
            }
        }, (error) => {
            alert("Geolocation failed: " + error.message);
        });
    }

    // Animate vehicle across route
    function animateVehicle(coords) {
        let i = 0;
        function move() {
            if (i < coords.length) {
                vehicle.setLatLng(coords[i]);
                i++;
                requestAnimationFrame(move);
            }
        }
        move();
    }

    // Format seconds as readable time
    function formatDuration(seconds) {
        const minutes = Math.floor(seconds / 60);
        if (minutes < 60) {
            return `${minutes} mins`;
        } else {
            const hrs = Math.floor(minutes / 60);
            const mins = minutes % 60;
            return `${hrs} hr ${mins} min`;
        }
    }

    // Live tracking updates
    function startLiveTracking() {
        setInterval(async () => {
            try {
                const res = await fetch('/live-location');
                const data = await res.json();

                if (data.lat && data.lng && vehicle) {
                    vehicle.setLatLng([parseFloat(data.lat), parseFloat(data.lng)]);
                }
            } catch (err) {
                console.warn("Live location error:", err);
            }
        }, 10000); // Every 10 seconds
    }

    window.onload = initMap;
</script>

@endsection
