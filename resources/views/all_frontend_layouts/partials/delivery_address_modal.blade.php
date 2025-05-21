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

<div class="modal fade" id="addressModal" tabindex="-1" aria-labelledby="addressModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addressModalLabel">Add Delivery Address</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-7">
                         <div class="form-group mb-2">
                            <label for="search-address" class=" form-label">Search Address</label>
                            <input type="text" id="search-address" class="form-control" placeholder="e.g. Bole Medhane Alem">
                            <div id="loading-spinner">
                                <div class="spinner-border text-primary" role="status"></div>
                            </div>
                            <div id="map-search-results" class="list-group mt-1 bg-white shadow-sm rounded"></div>
                        </div>
                        <div class="mb-3">
                            <button type="button" class="btn btn-outline-primary mb-3" id="getLocationBtn"> <i class="bi bi-map-fill"></i> Get My Current Location</button>
                        </div>
                        <div class="mb-3">
                            <div id="locationMessage" style="margin-top: 10px; font-weight: bold;"></div>
                            <div id="map"></div>
                        </div>
                          <input type="hidden" name="delivery_lat" id="delivery-lat">
                        <input type="hidden" name="delivery_lng" id="delivery-lng">
                        <input type="hidden" name="delivery_address" id="delivery-address">

                        <div class="form-group mt-3">
                            <label class="form-label">Selected Address:</label>
                            <p id="selected-address-text" class="fw-semibold text-success"></p>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <form action="{{ url('/addresses') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label class="form-label">Full Name</label>
                                        <input type="text" class="form-control" name="name" required>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label class="form-label">Address</label>
                                        <input type="text" class="form-control" name="address" id="address" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="country" class="form-label">Country</label>
                                        <select id="country" class="form-select" name="country">
                                            <option value="">Select Country</option>
                                            @foreach ($countries as $country)
                                            <option value="{{ $country->id }}">{{ $country->country_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="state" class="form-label">State</label>
                                        <select id="state" class="form-select" name="state">
                                            <option value="">Select State</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="city" class="form-label">City</label>
                                        <select id="city" class="form-select" name="city">
                                            <option value="">Select City</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="sub_city" class="form-label">Sub City</label>
                                        <select id="sub_city" class="form-select" name="sub_city">
                                            <option value="">Select Sub City</option>
                                        </select>
                                    </div>

                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="street" class="form-label">Street</label>
                                        <select id="street" class="form-select" name="street">
                                            <option value="">Select Street</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="mb-3">
                                        <label class="form-label">Pincode</label>
                                        <input type="text" class="form-control w-100" name="pincode">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label class="form-label">Mobile</label>
                                        <input type="number" class="form-control w-100" name="mobile" required>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-2">
                                <label for="latitude" class="form-label">Latitude:</label>
                                <input type="text" id="latitude" class="form-control" name="latitude" readonly>
                                </div>

                                <div class="col-md-6 mb-2">
                                    <label for="longitude" class="form-label">Longitude:</label>
                                   <input type="text" id="longitude" class="form-control" name="longitude" readonly>
                                </div>
                            </div>
                            <button type="submit" class="btn bg-primary text-white">Save Address</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {

        let map = L.map('map').setView([8.9806, 38.7578], 13); // Default: Addis Ababa center
        let marker;

        // Set tile layer
        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);

        const highlightIcon = L.icon({
            iconUrl: 'https://unpkg.com/leaflet@1.9.3/dist/images/marker-icon.png',
            iconSize: [25, 41],
            iconAnchor: [12, 41],
            popupAnchor: [1, -34],
            shadowUrl: 'https://unpkg.com/leaflet@1.9.3/dist/images/marker-shadow.png',
            shadowSize: [41, 41]
        });

        // Reverse geocoding on map click
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

        // Forward geocoding via search
        document.getElementById('search-address').addEventListener('keyup', async function () {
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
                    container.innerHTML = '<div class="list-group-item text-muted">No results found</div>';
                }

            } catch (err) {
                console.error('Forward geocode error:', err);
                container.innerHTML = '<div class="list-group-item text-danger">Error fetching results</div>';
            } finally {
                spinner.style.display = 'none';
            }
        });

        // Set marker and form fields
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
            document.getElementById('latitude').value = lat;
            document.getElementById('longitude').value = lng;
            document.getElementById('address').value=address;
        }

        // ✅ Fix for modal map rendering
        document.addEventListener('shown.bs.modal', function (event) {
            if (event.target.id === 'addressModal') {
                setTimeout(() => {
                    map.invalidateSize();
                }, 300); // Delay ensures modal animation completes
            }
        });
    });
</script>

<script>
    document.getElementById('getLocationBtn').addEventListener('click', function () {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function (position) {
                document.getElementById('latitude').value = position.coords.latitude;
                document.getElementById('longitude').value = position.coords.longitude;
            }, function (error) {
                alert('Error fetching location: ' + error.message);
            });
        } else {
            alert('Geolocation is not supported by this browser.');
        }
    });
</script>
