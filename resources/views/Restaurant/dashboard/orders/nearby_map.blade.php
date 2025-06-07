@extends('Restaurant.dashboard.layouts')
@section('restaurant-dashboard')
@php
$user = Auth::guard('admin')->user();
@endphp

<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<style>
    #map {
        height: 500px;
        width: 100%;
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
                <a href="{{ route('restaurant.dashboard') }}">Home</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">Nearby Deliverymen</li>
        </ol>
    </nav>
    <div class="row">
        <div class="col-md-12">
           <div class="card">
            <div class="card-header">
            <h4>Assign Deliveryman to Order #{{ 23 }}</h4>
            </div>
            <div class="card-body">
                 <div id="map"></div>
            </div>
           </div>
        </div>
        <div class="col-md-12">
           <div class="card">
            <div class="card-header">
                <h5>Nearby Deliverymen</h5>
            </div>
            <div class="card-body">
            <div class="row mt-4" id="deliveryman-list"></div>
            </div>
           </div>
        </div>
    </div>
</div>

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    const orderId = '23';
    const restaurantLat = 8.989510024774304;
    const restaurantLng = 38.74631106110676;

    const map = L.map('map').setView([restaurantLat, restaurantLng], 14);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors'
    }).addTo(map);

    const restaurantIcon = new L.Icon({
        iconUrl: 'https://cdn-icons-png.flaticon.com/512/684/684908.png'
        , iconSize: [30, 30]
    , });

    const deliveryIcon = new L.Icon({
        iconUrl: 'https://cdn-icons-png.flaticon.com/512/2219/2219633.png'
        , iconSize: [35, 35]
    , });

    // Add restaurant marker
    L.marker([restaurantLat, restaurantLng], {
            icon: restaurantIcon
        })
        .addTo(map)
        .bindPopup("Restaurant Location")
        .openPopup();

    // Fetch deliverymen nearby
    fetch(`/admin/restaurant/api/orders/${orderId}/nearby-deliverymen`)
        .then(res => res.json())
        .then(deliverymen => {
            const listDiv = document.getElementById('deliveryman-list');
            listDiv.innerHTML = '';

            if (deliverymen.length === 0) {
                listDiv.innerHTML = '<div class="alert alert-warning">No deliverymen found nearby.</div>';
                return;
            }

            deliverymen.forEach(dm => {
                const marker = L.marker([dm.current_lat, dm.current_lng], {
                        icon: deliveryIcon
                    }).addTo(map)
                    .bindPopup(`${dm.first_name}<br>Distance: ${dm.distance.toFixed(2)} km<br>
                        <button class="btn btn-sm btn-success mt-2" onclick="assignDeliveryman(${dm.id})">Assign</button>`);

                listDiv.innerHTML += `
                    <div class="col-md-3">
                   <div class="card mb-3 h-100 shadow-sm border-2 rounded-4">
                    <div class="row g-0 d-flex justify-content-center align-items-center p-3">
                        <div class="col-md-12">
                            <img src="${dm.delivery_man_image ?? 'https://placehold.co/30x30'}" alt="Delivery Man" class="rounded-circle border" width="80" height="80">
                        </div>
                        <div class="col-md-12">
                            <h6 class="mb-1 fw-bold">${dm.first_name} ${dm.last_name}</h6>
                            <p class="mb-1 text-muted small">
                                <i class="bi bi-telephone-fill me-1"></i> ${dm.phone}<br>
                                <i class="bi bi-geo-alt-fill me-1"></i> ${dm.address}<br>
                                <i class="bi bi-signpost-2-fill me-1"></i> Distance: ${dm.distance.toFixed(2)} km
                            </p>
                            <button class="btn btn-sm btn-primary w-100" onclick="assignDeliveryman(${dm.id})">
                                Assign
                            </button>
                        </div>
                    </div>
                </div>
                    </div>
                `;
            });
        })
        .catch(err => {
            console.error(err);
            alert('Error loading deliverymen.');
        });

</script>
@endsection
