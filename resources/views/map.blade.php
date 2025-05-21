@extends('all_frontend_layouts.layouts')

@section('content')
<style>
    #map-search-results {
        display: block;
        max-height: 250px;
        overflow-y: auto;
        z-index: 1000;
        position: absolute;
        width: 100%;
    }

    #loading-spinner {
        display: none;
        text-align: center;
        padding: 10px;
    }

    #loading-spinner .spinner-border {
        width: 1.5rem;
        height: 1.5rem;
    }

</style>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"></script>
<div class="container">
    <div class="offer-card my-4">
        <div class="card-body">

            <div class="form-group">
                <label for="search-address" class=" form-label">Search Address</label>
                <input type="text" id="search-address" class="form-control" placeholder="e.g. Bole Medhane Alem">
                <div id="loading-spinner">
                    <div class="spinner-border text-primary" role="status"></div>
                </div>

                <div id="map-search-results" class="list-group mt-1 bg-white shadow-sm rounded"></div>
            </div>
            <div id="map" style="height: 300px;" class="my-3"></div>
            <!-- Hidden inputs to store the delivery location -->
            <input type="text" name="delivery_lat" id="delivery-lat">
            <input type="text" name="delivery_lng" id="delivery-lng">
            <input type="hidden" name="delivery_address" id="delivery-address">

            <div class="form-group mt-3">
                <label class="form-label">Selected Address:</label>
                <p id="selected-address-text" class="fw-semibold text-success"></p>
            </div>

        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', () => {

        let map = L.map('map').setView([8.9806, 38.7578], 13); // Default: Addis Ababa center
        let marker;

        // Set tile layer
        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);

        // Highlight icon
        const highlightIcon = L.icon({
            iconUrl: 'https://unpkg.com/leaflet@1.9.3/dist/images/marker-icon.png'
            , iconSize: [25, 41]
            , iconAnchor: [12, 41]
            , popupAnchor: [1, -34]
            , shadowUrl: 'https://unpkg.com/leaflet@1.9.3/dist/images/marker-shadow.png'
            , shadowSize: [41, 41]
        });

        // Handle click on map for reverse geocoding
        map.on('click', async function(e) {
            const lat = e.latlng.lat;
            const lon = e.latlng.lng;

            try {
                const res = await fetch(`/api/reverse-geocode?lat=${lat}&lon=${lon}`);
                const data = await res.json();

                if (data.data && data.data.length > 0) {
                    const location = data.data[0];
                    const address = location.name + ", " + location.City;

                    setLocationOnMap(lat, lon, address);
                }
            } catch (err) {
                console.error('Reverse geocode error:', err);
            }
        });

        // Forward geocoding search handler
        document.getElementById('search-address').addEventListener('keyup', async function() {
            const searchText = this.value.trim();
            if (searchText.length < 3) return;

            const container = document.getElementById('map-search-results');
            const spinner = document.getElementById('loading-spinner');

            container.innerHTML = '';
            spinner.style.display = 'block';

            try {
                const res = await fetch(`/api/forward-geocode?name=${encodeURIComponent(searchText)}`);
                const results = await res.json();

                spinner.style.display = 'none';

                if (results.data && results.data.length > 0) {
                    results.data.forEach(loc => {
                        const item = document.createElement('a');
                        item.href = "javascript:void(0)";
                        item.classList.add('list-group-item', 'list-group-item-action');
                        item.textContent = loc.name + ", " + loc.City;

                        item.addEventListener('click', () => {
                            const lat = loc.latitude;
                            const lng = loc.longitude;
                            const address = loc.name + ", " + loc.City;

                            setLocationOnMap(lat, lng, address);
                            container.innerHTML = '';
                            document.getElementById('search-address').value = address;
                        });
                        container.appendChild(item);
                    });
                } else {
                    resultList.innerHTML = '<div class="list-group-item text-muted">No results found</div>';
                }

            } catch (err) {
                console.error('Forward geocode error:', err);
                resultList.innerHTML = '<div class="list-group-item text-danger">Error fetching results</div>';
            } finally {
                spinner.style.display = 'none';
                console.error('Forward geocode error:', err);
            }
        });

        // Function to update map marker and hidden inputs
        function setLocationOnMap(lat, lng, address) {
            map.setView([lat, lng], 15);
            if (marker) map.removeLayer(marker);
            marker = L.marker([lat, lng], {
                    icon: highlightIcon
                }).addTo(map)
                .bindPopup(`<strong>${address}</strong>`)
                .openPopup();
            document.getElementById('selected-address-text').innerText = address;
            document.getElementById('delivery-address').value = address;
            document.getElementById('delivery-lat').value = lat;
            document.getElementById('delivery-lng').value = lng;
        }
    });

</script>
@endsection

