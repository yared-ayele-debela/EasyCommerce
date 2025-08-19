@extends('Restaurant.dashboard.layouts')
@section('restaurant-dashboard')
@php
$user = Auth::guard('admin')->user();
@endphp
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>
<link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />

<style>
    #map { height: 250px; }
    .cart-total { font-size: 1.2em; font-weight: bold; }
    .btn-remove { color: #fff; background: #dc3545; border: none; padding: 2px 8px; border-radius: 3px;}
</style>

<div class="container">
    <h2 class="mb-3">Call Center Order</h2>
    <div class="row">
        <!-- Select Restaurant and Product List -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <div class="mb-3">
                <label for="restaurantSelect"><strong>Select Restaurant:</strong></label>
                <select id="restaurantSelect" class="form-control">
                    <option value="">-- Select --</option>
                    @foreach($restaurants as $restaurant)
                        <option value="{{ $restaurant->id }}"
                            data-lat="{{ $restaurant->latitude }}"
                            data-lon="{{ $restaurant->longitude }}"
                        >{{ $restaurant->name }}</option>
                    @endforeach
                </select>
            </div>

                </div>
            </div>
        </div>
        <!-- Cart Sidebar -->
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
 <h4>Select Customer Location</h4>
            <div id="map"></div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div id="productSection" style="display:none;">
                <h4>Products</h4>
                <div id="productList" class="row"></div>
            </div>
        </div>
    </div>
    <!-- Customer Info and Map -->
    <div class="row mt-4">
        <div class="col-md-6">
            <h4>Customer Info</h4>
            <input type="text" id="customerName" placeholder="Customer Name" class="form-control mb-2">
            <input type="text" id="customerPhone" placeholder="Customer Phone" class="form-control mb-2">
            <input type="text" id="address" placeholder="Address" class="form-control mb-2">
            <input type="text" id="latitude" placeholder="Latitude" class="form-control mb-2" readonly>
            <input type="text" id="longitude" placeholder="Longitude" class="form-control mb-2" readonly>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="cart-sidebar">
                <h4>Cart</h4>
                <ul id="cartItems" class="list-group"></ul>
                <div class="mt-2 cart-total">
                    Subtotal: $<span id="cartSubtotal">0.00</span><br>
                    Shipping: $<span id="cartShipping">0.00</span><br>
                    <strong>Total: $<span id="cartTotal">0.00</span></strong>
                </div>
            </div>
                </div>
            </div>
        </div>
    </div>
    <button id="placeOrderBtn" class="btn btn-primary mt-3">Place Order</button>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

<script>
let cart = [];
let restaurantLat = null, restaurantLon = null;

document.getElementById('restaurantSelect').addEventListener('change', function() {
    let id = this.value;
    if (!id) {
        document.getElementById('productSection').style.display = 'none';
        cart = [];
        updateCartUI();
        return;
    }
    let selected = this.options[this.selectedIndex];
    restaurantLat = parseFloat(selected.getAttribute('data-lat'));
    restaurantLon = parseFloat(selected.getAttribute('data-lon'));
    cart = []; // Reset cart when changing restaurant
    updateCartUI();
    fetch(`/admin/restaurant/call-center/restaurant/${id}/products`)
    .then(res => res.json())
    .then(products => {
        let html = '';
        products.forEach(p => {
            html += `
                <div class="col-md-2 mb-3">
                    <div class="card h-100 p-2">
                        <p><b>${p.name}</b></p>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                        <img src="${p.image ? `/storage/${p.image}` : '/images/no-image.png'}" width="30" class="img-flui" alt="${p.name}">
                        <p>Price: $${p.price}</p>
                        </div>
                        <input type="number" value="1" min="1" id="qty_${p.id}" class="form-control mb-2">
                        <button class="btn btn-sm btn-success" onclick="addToCart(${p.id}, '${p.name}', ${p.price})">Add</button>
                    </div>
                </div>
            `;
        });
        document.getElementById('productList').innerHTML = html;
        document.getElementById('productSection').style.display = 'block';
    });
});

window.addToCart = function(productId, name, price) {
    let qty = parseInt(document.getElementById(`qty_${productId}`).value) || 1;
    let idx = cart.findIndex(i => i.product_id === productId);
    if (idx !== -1) {
        cart[idx].quantity += qty;
        cart[idx].total += price * qty;
    } else {
        cart.push({ product_id: productId, name, price, quantity: qty, total: price * qty });
    }
    updateCartUI();
};

function removeCartItem(productId) {
    cart = cart.filter(i => i.product_id !== productId);
    updateCartUI();
}

function updateCartUI() {
    let list = document.getElementById('cartItems');
    list.innerHTML = '';
    let subtotal = cart.reduce((sum, item) => sum + item.total, 0);
    cart.forEach(item => {
        let li = document.createElement('li');
        li.className = 'list-group-item d-flex justify-content-between align-items-center';
        li.innerHTML = `
            <span>
                ${item.name} x${item.quantity} ($${item.price} each)
            </span>
            <span>
                $${item.total.toFixed(2)}
                <button class="btn-remove ml-3" onclick="removeCartItem(${item.product_id})">Remove</button>
            </span>
        `;
        list.appendChild(li);
    });
    document.getElementById('cartSubtotal').textContent = subtotal.toFixed(2);

    // Calculate and display shipping fee if both lat/lon are present
    let shipping = 0;
    let userLat = parseFloat(document.getElementById('latitude').value);
    let userLon = parseFloat(document.getElementById('longitude').value);
    if (cart.length && restaurantLat && restaurantLon && userLat && userLon) {
        shipping = calculateShippingFee(restaurantLat, restaurantLon, userLat, userLon);
    }
    document.getElementById('cartShipping').textContent = shipping.toFixed(2);
    document.getElementById('cartTotal').textContent = (subtotal + shipping).toFixed(2);
}

// Calculate distance in KM, then $1 per KM
function calculateShippingFee(lat1, lon1, lat2, lon2) {
    const earthRadius = 6371;
    const dLat = (lat2 - lat1) * Math.PI / 180;
    const dLon = (lon2 - lon1) * Math.PI / 180;
    const a = Math.sin(dLat / 2) ** 2 +
        Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) *
        Math.sin(dLon / 2) ** 2;
    const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
    const distance = earthRadius * c;
    return Math.round(distance * 100) / 100; // $1 per km
}

// Leaflet Map Setup
let map = L.map('map').setView([9.0054, 38.7636], 13); // Default Addis Ababa
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '© OpenStreetMap contributors'
}).addTo(map);

let marker = null;

// Leaflet geocoder (search)
if (typeof L.Control.Geocoder === 'function') {
    let geocoder = L.Control.geocoder({
        defaultMarkGeocode: false
    })
    .on('markgeocode', function(e) {
        let latlng = e.geocode.center;
        if (marker) map.removeLayer(marker);
        marker = L.marker(latlng).addTo(map);
        document.getElementById('latitude').value = latlng.lat.toFixed(6);
        document.getElementById('longitude').value = latlng.lng.toFixed(6);
        updateCartUI();
        map.setView(latlng, 15);
    })
    .addTo(map);
}

// Click on map to set location
map.on('click', function(e) {
    if (marker) map.removeLayer(marker);
    marker = L.marker(e.latlng).addTo(map);
    document.getElementById('latitude').value = e.latlng.lat.toFixed(6);
    document.getElementById('longitude').value = e.latlng.lng.toFixed(6);
    updateCartUI();
});

// Auto-update shipping fee when lat/lon changes
document.getElementById('latitude').addEventListener('input', updateCartUI);
document.getElementById('longitude').addEventListener('input', updateCartUI);

document.getElementById('placeOrderBtn').addEventListener('click', function() {
    let restaurantId = document.getElementById('restaurantSelect').value;
    if (!restaurantId) return alert("Please select a restaurant.");
    if (!cart.length) return alert("Your cart is empty.");
    let userLat = parseFloat(document.getElementById('latitude').value);
    let userLon = parseFloat(document.getElementById('longitude').value);
    if (!userLat || !userLon) return alert("Please select customer location on the map.");

    let data = {
        orders: { [restaurantId]: { items: cart } },
        name: document.getElementById('customerName').value,
        phone: document.getElementById('customerPhone').value,
        address: document.getElementById('address').value,
        latitude: userLat,
        longitude: userLon
    };

    fetch(`/admin/restaurant/call-center/store`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify(data)
    }).then(res => res.json())
      .then(res => {
          alert(res.message);
          if (res.success) {
              cart = [];
              updateCartUI();
          }
      });
});
</script>
@endsection
