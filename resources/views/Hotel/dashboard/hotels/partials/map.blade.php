<!-- Reusable Map Section -->
<div class="map-section">
    <label class="form-label">Search Address</label>
    <input type="text" class="form-control search-address" placeholder="e.g. Bole Medhane Alem">

    <div class="spinner-border text-primary mt-2 loading-spinner" role="status" style="display: none;"></div>
    <div class="map-search-results list-group mt-1 bg-white shadow-sm rounded"></div>

    <button class="btn btn-outline-primary mt-3 get-location-btn" type="button" onclick="getLocation()">
        <i class="bi bi-map-fill"></i> Get My Current Location
    </button>

    <div class="location-message mt-2 fw-bold"></div>
    <div class="map" style="height: 300px;"></div>

    <input type="hidden" name="delivery_lat" class="delivery-lat">
    <input type="hidden" name="delivery_lng" class="delivery-lng">
    <input type="hidden" name="delivery_address" class="delivery-address">

    <div class="form-group mt-3">
        <label class="form-label">Selected Address:</label>
        <p class="selected-address-text fw-semibold text-success"></p>
    </div>
</div>
