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

<div id="map" class="mt-3 rounded shadow-sm"></div>

<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<script src="https://unpkg.com/leaflet-routing-machine/dist/leaflet-routing-machine.min.js"></script>
<script src="https://js.pusher.com/7.2/pusher.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/laravel-echo/1.11.3/echo.iife.js"></script>

<script>
const destinationLatLng = [{{ $latitude }}, {{ $longitude }}];
const deliveryManId = {{ $deliveryManId }};

const map = L.map('map').setView(destinationLatLng, 13);
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 19,
}).addTo(map);

const destination = L.marker(destinationLatLng, {
    icon: L.icon({
        iconUrl: "{{ $destinationIcon }}",
        iconSize: [40, 40],
        iconAnchor: [15, 15]
    })
}).addTo(map).bindPopup("Destination");


let deliveryMarker = null;
let routingControl = null;
let previousCoords = [];
const trail = L.polyline([], { color: 'blue', weight: 3 }).addTo(map);

function speak(text) {
    const utterance = new SpeechSynthesisUtterance(text);
    speechSynthesis.speak(utterance);
}

window.Pusher = Pusher;
window.Echo = new Echo({
    broadcaster: 'pusher',
    key: 'local',
    wsHost: window.location.hostname,
    wsPort: 6001,
    forceTLS: false,
    disableStats: true,
});

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

window.Echo.channel('delivery-locations')
    .listen('.location.updated', (e) => {
        if (e.deliveryManId != deliveryManId) return;

        const currentLatLng = [e.latitude, e.longitude];
        previousCoords.push(currentLatLng);
        trail.setLatLngs(previousCoords);

        if (!deliveryMarker) {
            deliveryMarker = L.marker(currentLatLng, {
                icon: L.icon({
                    iconUrl: '{{ asset('restaurant_frontend/delivery-man.gif') }}',
                    iconSize: [50, 50],
                    iconAnchor: [15, 15]
                })
            }).addTo(map).bindPopup("Your Location");
        } else {
            deliveryMarker.setLatLng(currentLatLng);
        }

        map.panTo(currentLatLng);

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

        routingControl.on('routesfound', function(e) {
            const instructions = e.routes[0].instructions || [];
            if (instructions.length) {
                speak(`Next step: ${instructions[0].text}`);
            }
        });
    });
</script>
