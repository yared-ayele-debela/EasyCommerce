<!DOCTYPE html>
<html>
<head>
    <title>Delivery Real-Time Tracker</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <style>
        #map {
            height: 500px;
            width: 100%;
            margin: 20px auto;
        }
    </style>
</head>
<body>

<h2 style="text-align:center;">Delivery Man Real-Time Location</h2>
<div id="map"></div>

<!-- Leaflet JS -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<!-- Pusher + Laravel Echo -->
<script src="https://js.pusher.com/7.2/pusher.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/laravel-echo@1.11.3/dist/echo.iife.js"></script>

<script>
    // Initialize Echo with WebSocket settings
    window.Pusher = Pusher;

    window.Echo = new Echo({
        broadcaster: 'pusher',
        key: 'local',
        wsHost: window.location.hostname,
        wsPort: 6001,
        forceTLS: false,
        disableStats: true,
    });

    // Initialize the Leaflet map centered in Addis Ababa
    const map = L.map('map').setView([9.03, 38.74], 13);

    // Add OpenStreetMap tile layer
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: 'Map data © OpenStreetMap contributors'
    }).addTo(map);

    // Create and store delivery man markers by ID
 const deliveryMarkers = {};
const deliveryPaths = {};
const animationDuration = 1000;

function animateMarker(marker, newLatLng) {
    const startLatLng = marker.getLatLng();
    const startTime = performance.now();

    function animate(time) {
        const progress = Math.min((time - startTime) / animationDuration, 1);
        const currentLat = startLatLng.lat + (newLatLng.lat - startLatLng.lat) * progress;
        const currentLng = startLatLng.lng + (newLatLng.lng - startLatLng.lng) * progress;
        marker.setLatLng([currentLat, currentLng]);

        if (progress < 1) {
            requestAnimationFrame(animate);
        }
    }
    requestAnimationFrame(animate);
}

    // Listen for location updates
    window.Echo.channel('delivery-locations')
    .listen('.location.updated', (e) => {
        const { deliveryManId, latitude, longitude } = e;
        const newLatLng = L.latLng(latitude, longitude);
        if (!deliveryMarkers[deliveryManId]) {
            const marker = L.marker(newLatLng)
                .addTo(map)
                .bindPopup(`Delivery Man #${deliveryManId}`);
            deliveryMarkers[deliveryManId] = marker;
            deliveryPaths[deliveryManId] = L.polyline([newLatLng], {
                color: 'blue',
                weight: 4,
                opacity: 0.7,
            }).addTo(map);
        } else {
            const marker = deliveryMarkers[deliveryManId];
            // Animate to new position
            animateMarker(marker, newLatLng);
            // Add new point to trail
            deliveryPaths[deliveryManId].addLatLng(newLatLng);
        }
    });


</script>

</body>
</html>
