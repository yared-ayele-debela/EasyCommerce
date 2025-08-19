@extends('Restaurant.dashboard.layouts')
@section('restaurant-dashboard')
@php
$user = Auth::guard('admin')->user();
@endphp
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>
<link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

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

    #map { height: 250px; }
    .cart-total { font-size: 1.2em; font-weight: bold; }
    .btn-remove { color: #fff; background: #dc3545; border: none; padding: 2px 8px; border-radius: 3px;}
    .restaurant-cart { margin-bottom: 20px; border-bottom: 1px solid #eee; padding-bottom: 10px;}
</style>

<div class="container">
    <h2 class="mb-3">Call Center Order</h2>
    <div class="row">
        <!-- Select Restaurant and Product List -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h4>Select Restaurant</h4>
                </div>
                <div class="card-body py-2">
                    <div class="mb-3">
                        <label for="restaurantSelect"><strong>Select Restaurant:</strong></label>
                        <select id="restaurantSelect" class="form-control ">
                            <option value="">-- Select --</option>
                            @foreach($restaurants as $restaurant)
                                <option value="{{ $restaurant->id }}"
                                    data-lat="{{ $restaurant->latitude }}"
                                    data-lon="{{ $restaurant->longitude }}"
                                    data-name="{{ $restaurant->name }}"
                                >{{ $restaurant->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <!-- Map -->
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4>Select Customer Location</h4>
                </div>
                <div class="card-body py-2">
<div class="form-group mb-2">
                            <label for="search-address" class=" form-label">Search Address</label>
                            <input type="text" id="search-address" class="form-control" placeholder="e.g. Kezira">
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
                        </div>                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div id="productSection" style="display:none;">
                <h4>Products</h4>
                <div id="productList" class="row"></div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                        <h4>Cart (Multiple Restaurants)</h4>
                </div>
                <div class="card-body py-2">
                    <div class="cart-sidebar">
                        <div id="cartItems"></div>
                        <div class="mt-2 cart-total">
                            <strong>Total: <span id="cartTotal">0.00</span> ETB</strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Customer Info and Cart -->
    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4>Customer Info</h4>
                </div>
                <div class="card-body py-2">
                    <label for="customerPhone" class="form-label">Customer Phone Number:</label>
            <input type="text" id="customerPhone" placeholder="Customer Phone" class="form-control mb-2">
                    <label for="address" class="form-label">Customer Address:</label>
            <input type="text" id="customer_address" placeholder="Customer ADdress" class="form-control mb-2">

            <input type="text" id="latitude" placeholder="Latitude" class="form-control mb-2" readonly>
            <input type="text" id="longitude" placeholder="Longitude" class="form-control mb-2" readonly>
                </div>
            </div>
        </div>

    </div>
    <button id="placeOrderBtn" class="btn btn-primary mt-3">Place Order</button>
</div>

<script>
let cart = {}; // { [restaurantId]: { restaurant, items: [] } }
let restaurants = {}; // { [id]: {lat, lon, name} } for shipping fee calc

// Populate restaurants info for shipping calculation
@foreach($restaurants as $restaurant)
    restaurants[{{ $restaurant->id }}] = {
        lat: {{ $restaurant->latitude }},
        lon: {{ $restaurant->longitude }},
        name: "{{ $restaurant->name }}"
    };
@endforeach

document.getElementById('restaurantSelect').addEventListener('change', function() {
    let id = this.value;
    if (!id) {
        document.getElementById('productSection').style.display = 'none';
        return;
    }
    fetch(`/admin/restaurant/call-center/restaurant/${id}/products`)
    .then(res => res.json())
    .then(products => {
        let html = '';
        products.forEach(p => {
            html += `
                <div class="col-md-3 mb-3">
                    <div class="card h-100 p-2">
                        <h5>${p.name}</h5>
                         <img src="${p.image ? `/storage/${p.image}` : '/images/no-image.png'}" width="30" class="img-flui" alt="${p.name}">
                        <p>Price: ${p.price} ETB</p>
                        <p>Tax: ${p.product_tax ? p.product_tax : 0}%</p>
                        <input type="number" value="1" min="1" id="qty_${id}_${p.id}" class="form-control mb-2">
                        <button class="btn btn-sm btn-success" onclick="addToCart(${id}, ${p.id}, '${p.name}', ${p.price}, ${p.product_tax ? p.product_tax : 0})">Add</button>
                    </div>
                </div>
            `;
        });
        document.getElementById('productList').innerHTML = html;
        document.getElementById('productSection').style.display = 'block';
    });
});

// Add to cart per restaurant
window.addToCart = function(restaurantId, productId, name, price, productTax) {
    if (!cart[restaurantId]) {
        cart[restaurantId] = {
            restaurant: restaurants[restaurantId],
            items: []
        };
    }
    let qty = parseInt(document.getElementById(`qty_${restaurantId}_${productId}`).value) || 1;
    let idx = cart[restaurantId].items.findIndex(i => i.product_id === productId);
    let taxAmount = (price * qty) * (productTax / 100);
    if (idx !== -1) {
        cart[restaurantId].items[idx].quantity += qty;
        cart[restaurantId].items[idx].total += price * qty;
        cart[restaurantId].items[idx].tax += taxAmount;
    } else {
        cart[restaurantId].items.push({ product_id: productId, name, price, quantity: qty, total: price * qty, tax: taxAmount, product_tax: productTax });
    }
    updateCartUI();
};

// Remove item from cart by restaurant and product
window.removeCartItem = function(restaurantId, productId) {
    if (!cart[restaurantId]) return;
    cart[restaurantId].items = cart[restaurantId].items.filter(i => i.product_id !== productId);
    if (cart[restaurantId].items.length === 0) delete cart[restaurantId];
    updateCartUI();
};

function updateCartUI() {
    let container = document.getElementById('cartItems');
    container.innerHTML = '';
    let grandTotal = 0;

    let userLat = parseFloat(document.getElementById('latitude').value);
    let userLon = parseFloat(document.getElementById('longitude').value);

    Object.keys(cart).forEach(restaurantId => {
        let data = cart[restaurantId];
        let subtotal = data.items.reduce((sum, item) => sum + item.total, 0);
        let totalTax = data.items.reduce((sum, item) => sum + item.tax, 0);
        let shipping = 0;
        if (userLat && userLon) {
            shipping = calculateShippingFee(data.restaurant.lat, data.restaurant.lon, userLat, userLon);
        }
        let total = subtotal + totalTax + shipping;
        grandTotal += total;

        let html = `
        <div class="restaurant-cart">
            <h5>${data.restaurant.name}</h5>
            <ul class="list-group mb-2">
        `;
        data.items.forEach(item => {
            html += `
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <span>
                        ${item.name} x${item.quantity} (${item.price} ETB each, Tax: ${item.product_tax}%)
                    </span>
                    <span>
                        ${item.total.toFixed(2)} ETB
                        <br>
                        <small>Tax: ${item.tax.toFixed(2)} ETB</small>
                        <button class="btn-remove ml-3" onclick="removeCartItem(${restaurantId}, ${item.product_id})">Remove</button>
                    </span>
                </li>
            `;
        });
        html += `
            </ul>
            <div>
                Subtotal: ${subtotal.toFixed(2)} ETB<br>
                Tax: ${totalTax.toFixed(2)} ETB<br>
                Shipping: ${shipping.toFixed(2)} ETB<br>
                <strong>Total: ${total.toFixed(2)} ETB</strong>
            </div>
        </div>
        `;
        container.innerHTML += html;
    });
    document.getElementById('cartTotal').textContent = grandTotal.toFixed(2);
}

// Calculate distance in KM, then $1 per KM
// Pass your delivery settings from backend to JS
const DELIVERY_BASE_AMOUNT = {{ $delivery_settings->base_amount }};
const DELIVERY_FEE_PER_KM = {{ $delivery_settings->fee_per_km }};

function calculateShippingFee(lat1, lon1, lat2, lon2) {
    const earthRadius = 6371;
    const dLat = (lat2 - lat1) * Math.PI / 180;
    const dLon = (lon2 - lon1) * Math.PI / 180;
    const a = Math.sin(dLat / 2) ** 2 +
        Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) *
        Math.sin(dLon / 2) ** 2;
    const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
    const distance = earthRadius * c;

    let deliveryFee;
    if (distance > 1) {
        deliveryFee = DELIVERY_BASE_AMOUNT + ((distance - 1) * DELIVERY_FEE_PER_KM);
    } else {
        deliveryFee = DELIVERY_BASE_AMOUNT;
    }
    // Round to 2 decimals
    return Math.round(deliveryFee * 100) / 100;
}

        let map = L.map('map').setView([9.6040976, 41.8207994], 13);
    let marker;

    // Set tile layer
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors'
    }).addTo(map);

    const highlightIcon = L.icon({
        iconUrl: 'https://unpkg.com/leaflet@1.9.3/dist/images/marker-icon.png',
        iconSize: [25, 41],
        iconAnchor: [12, 41],
        popupAnchor: [1, -34],
        shadowUrl: 'https://unpkg.com/leaflet@1.9.3/dist/images/marker-shadow.png',
        shadowSize: [41, 41]
    });

    // Helper to set marker and update lat/lon fields, plus address display
    function setLocationOnMap(lat, lon, address = '') {
        if (marker) map.removeLayer(marker);
        marker = L.marker([lat, lon], { icon: highlightIcon }).addTo(map);
        map.setView([lat, lon], 15);

        document.getElementById('latitude').value = lat.toFixed(6);
        document.getElementById('longitude').value = lon.toFixed(6);

        // If address field exists, update it
        if (document.getElementById('address')) {
            document.getElementById('address').value = address;
        }
        updateCartUI();
    }

    // Reverse geocoding on map click
    map.on('click', async function(e) {
        const lat = e.latlng.lat;
        const lon = e.latlng.lng;

        try {
            const res = await fetch(`/api/reverse-geocode?lat=${lat}&lon=${lon}`);
            const data = await res.json();

            if (data.data && data.data.length > 0) {
                const location = data.data[0];
                const address = location.name + (location.City ? `, ${location.City}` : '');
                setLocationOnMap(lat, lon, address);
            } else {
                setLocationOnMap(lat, lon, '');
            }
        } catch (err) {
            console.error('Reverse geocode error:', err);
            setLocationOnMap(lat, lon, '');
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
            const bounds = '41.766,9.550,41.920,9.640';
            const apiKey = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJjb21wYW55bmFtZSI6IkVhc3kgZS1jb21tZXJjZSBob3RlbCBib29raW5nIGFuZCBkZWxpdmVyeSIsImRlc2NyaXB0aW9uIjoiMGU4ZDhhZDMtZmJhYy00OTJkLWE4OWYtZGFiZjQxNTFlNDc2IiwiaWQiOiI3OWY1ODRlYy0yZDA3LTRjNWQtYTI2Ny00MjBhNzVlMDY2NzMiLCJ1c2VybmFtZSI6ImJlZmk3NzU2In0.JgSoBiAoa4Te6ccg-jSJSifq26PZV4FnGbkhQKiTnuo';

            const res = await fetch(`https://mapapi.gebeta.app/api/v1/route/geocoding?name=${encodeURIComponent(searchText)}&apiKey=${apiKey}&bounds=${bounds}`);
            const results = await res.json();

            spinner.style.display = 'none';

            if (results.data && results.data.length > 0) {
                results.data.forEach(loc => {
                    const item = document.createElement('a');
                    item.href = "javascript:void(0)";
                    item.classList.add('list-group-item', 'list-group-item-action');
                    item.textContent = loc.name + (loc.City ? `, ${loc.City}` : '');

                    item.addEventListener('click', () => {
                        const lat = loc.latitude;
                        const lng = loc.longitude;
                        const address = loc.name + (loc.City ? `, ${loc.City}` : '');

                        setLocationOnMap(lat, lng, address);
                        container.innerHTML = '';
                        document.getElementById('search-address').value = address;
                        document.getElementById('customer_address').value = address;

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

    // Auto-update shipping fee when lat/lon changes
    document.getElementById('latitude').addEventListener('input', updateCartUI);
    document.getElementById('longitude').addEventListener('input', updateCartUI);

document.getElementById('placeOrderBtn').addEventListener('click', function() {
    if (Object.keys(cart).length === 0) return alert("Your cart is empty.");
    let userLat = parseFloat(document.getElementById('latitude').value);
    let userLon = parseFloat(document.getElementById('longitude').value);
    if (!userLat || !userLon) return alert("Please select customer location on the map.");

    // Prepare order data as backend expects
    let orders = {};
    Object.keys(cart).forEach(restaurantId => {
        orders[restaurantId] = {
            items: cart[restaurantId].items
        };
    });

    let data = {
        orders,
        phone: document.getElementById('customerPhone').value,
        address: document.getElementById('customer_address') ? document.getElementById('customer_address').value : '',
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
              cart = {};
              updateCartUI();
          }
      });
});
</script>
@endsection
