@extends('all_frontend_layouts.layouts')
@section('content')
@php
use App\Models\Restaurant\Product;
@endphp

<style>
    .card {
        box-shadow: none !important;
        border: 1px solid #2222 !important;
        margin: 5px !important;
    }

</style>
<div class="container my-4">

    <div class="checkout-header">
        <a href="{{ url('/') }}">Home</a> / <span>Checkout</span>
    </div>

    <div class="row">
        <div class="col-12 col-md-8">
            <div class="delivery-location mb-2">
                <div class="d-flex justify-content-between align-items-center">
                    <button type="button" class="btn btn-outline-primary fw-bold px-4 py-2 delivery_text" id="loadAddresses">
                        <i class="bi bi-geo-alt"></i> Load Delivery Addresses
                    </button>

                    <a href="#" class="btn btn-primary fw-bold d-flex align-items-center delivery_text px-3 py-2 rounded-3" data-bs-toggle="modal" data-bs-target="#addressModal">
                        <i class="bi bi-plus-circle me-1"></i> Add New Address
                    </a>
                </div>
            </div>
            <form action="{{ route('restaurant.checkout.placeOrder') }}" id="checkoutForm" method="POST">
                @csrf
                <div class="row" id="addressContainer">
                    <p class="text-muted text-center">Click "Load Addresses" to view your addresses.</p>
                </div>
                <span id="address-error" class="text-danger d-none">Please select a delivery address.</span>

                <input type="hidden" name="address_id" id="selected_address_id">
                <div class="d-flex justify-content-between align-items-center">
                    <button type="button" class="btn btn-outline-primary fw-bold px-4 py-2" id="toggleItems">
                        <i class="bi bi-eye"></i> Show Items ({{ count(session('cart', [])) }})
                    </button>
                </div>
                <div id="itemsSection" class="mt-3 d-none">
                    <h4 class="text-dark">Items details</h4>
                    <div class="row my-3">
                        @if(session('cart') && count(session('cart')) > 0)
                        <div class="col-md-8">
                            <div class="card border-0 shadow-sm rounded-3">
                                <div class="card-body p-1 table-responsive">
                                    <table class="table table-hover align-middle">
                                        <thead class="table-light">
                                            <tr>
                                                <th scope="col">Product</th>
                                                <th scope="col" class="text-center">Quantity</th>
                                                <th scope="col" class="text-end">Total Price</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach(session('cart') as $key => $item)
                                            @php
                                            $itemSubtotal = $item['price'] * $item['quantity'];
                                            $subtotal += $itemSubtotal;
                                            $product = Product::find($item['product_id']);
                                            @endphp
                                            <tr>
                                                <td class="d-flex align-items-center">
                                                    <img src="{{ asset('storage/' . $product['image']) }}" alt="{{ $product['name'] }}" class="img-fluid rounded shadow-sm border me-3" style="width: 40px; height: 40px;">
                                                    <span class="fw-semibold">{{ $product['name'] }}</span>
                                                </td>
                                                <td class="text-center">
                                                    <span class="badge bg-primary">{{ $item['quantity'] }}</span>
                                                </td>
                                                <td class="text-end fw-bold text-dark">{{ number_format($itemSubtotal, 2) }} ETB</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        @else
                        Your cart is empty
                        @endif
                    </div>
                </div>

        </div>
        @php
        $delivery_fee = 15;
        $discount = session('discount', 0);
        $subtotal = session('cart_subtotal', 0);
        $total = max(($subtotal - $discount), 0) + $delivery_fee;
        @endphp

        <div class="col-lg-4 mb-2">
            <!-- Promo Code -->
            <div class="promo-code">
                <input type="text" id="coupon_code" class="promo-input" placeholder="Enter Promo Code">
                <button id="apply_coupon" class="bg-primary text-white">APPLY</button>
            </div>
            <p id="coupon_message" class="text-danger mt-2"></p> <!-- Error/Success Message -->

            <!-- Summary Card -->
            <div class="summary-card mt-3">
                <div class="d-flex justify-content-between mb-2">
                    <span><strong>SubTotal</strong></span>
                    <span><strong id="subtotal_value">{{ $subtotal }} ETB</strong></span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span><strong>Discount</strong></span>
                    <span id="discount_value"><strong>-{{ $discount }} ETB</strong></span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span><strong>Delivery Fee</strong></span>
                    <span><strong>{{ $delivery_fee }} ETB</strong></span>
                </div>
                <div class="line"></div>
                <div class="d-flex justify-content-between">
                    <span><strong>Total</strong></span>
                    <span class="total"><strong>{{ $total }} ETB</strong></span>
                </div>
                <div class="delivery-location mt-3 p-3">
                    <h6 class="fw-bold text-dark mb-2">Payment Method</h6>
                    <div class="payment-methods">
                        <label class="payment-method">
                            <input type="radio" name="payment_method" value="telebirr" class="d-none">
                            <img src="{{ asset('restaurant_frontend/assets/img/Telebirr 2.png') }}" alt="Telebirr">
                        </label>
                        <label class="payment-method">
                            <input type="radio" name="payment_method" value="cbe" class="d-none">
                            <img src="{{ asset('restaurant_frontend/assets/img/CBE_SA 2.png') }}" alt="CBE">
                        </label>
                        <label class="payment-method">
                            <input type="radio" name="payment_method" value="cash" class="d-none">
                            <img src="{{ asset('restaurant_frontend/assets/img/Cash (1).png') }}" alt="Cash on Delivery">
                        </label>
                    </div>
                    <span id="payment-error" class="text-danger d-none">Please select a payment method.</span>
                </div>
              <button type="button" class="checkout-btn border-0 bg-primary w-100 mt-3" id="placeOrder">Place Order</button>
        </form>
    </div>
</div>

</div>
</div>
<!-- Address Modal -->
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
                        <div class="mb-3">
                            <input type="text" id="searchBox" class="form-control" placeholder="Search for an address..." />
                        </div>
                        <div id="map" style="height: 600px;"></div>
                    </div>
                    <div class="col-md-5">
                        <form id="addressForm">
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
                                        <input type="text" class="form-control" name="address" required>
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
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Latitude</label>
                                        <input type="number" class="form-control w-100" name="latitude" id="latitude" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Longitude</label>
                                        <input type="number" class="form-control w-100" name="longitude" id="longitude" readonly>
                                    </div>
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
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>

<script>
    // JavaScript to handle payment method selection
    document.querySelectorAll('.payment-method').forEach(method => {
    method.addEventListener('click', function() {
        document.querySelectorAll('.payment-method').forEach(el => el.classList.remove('selected'));
        this.classList.add('selected');
        this.querySelector('input').checked = true; // Set the radio input as checked
        document.getElementById("payment-error").classList.add("d-none"); // Hide error on selection

        });
    });

    // JavaScript to handle tip selection
    document.querySelectorAll('.tip-option').forEach((tip) => {
        tip.addEventListener('click', function() {
            document.querySelectorAll('.tip-option').forEach((el) => el.classList.remove('selected'));
            this.classList.add('selected');
        });
    });
    document.getElementById("placeOrder").addEventListener("click", function() {
    let selectedPayment = document.querySelector("input[name='payment_method']:checked");
    let selectedAddress = document.querySelector("input[name='address']:checked");

    let paymentError = document.getElementById("payment-error");
    let addressError = document.getElementById("address-error");
    paymentError.classList.add("d-none");
    addressError.classList.add("d-none");



    if (!selectedAddress) {
        addressError.classList.remove("d-none");
        return;
    }
    if (!selectedPayment) {
        paymentError.classList.remove("d-none");
        return;
    }
    document.getElementById("checkoutForm").submit();


});
</script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        $("#toggleItems").click(function() {
            $("#itemsSection").toggleClass("d-none");
            let isVisible = !$("#itemsSection").hasClass("d-none");
            $(this).html(isVisible ? '<i class="bi bi-eye-slash"></i> Hide Items ({{ count(session('
                cart ', [])) }})' : '<i class="bi bi-eye"></i> Show Items ({{ count(session('
                cart ', [])) }})');
        });

        var map = L.map('map').setView([9.03, 38.74], 12); // Default view

        // Add OpenStreetMap tiles
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        var marker;

        // Handle manual click to add marker
        map.on('click', function(e) {
            var lat = e.latlng.lat.toFixed(6);
            var lng = e.latlng.lng.toFixed(6);
            updateMarker(lat, lng);
        });

        function updateMarker(lat, lng, address = null) {
            // Remove existing marker
            if (marker) {
                map.removeLayer(marker);
            }
            // Add new marker
            marker = L.marker([lat, lng]).addTo(map)
                .bindPopup(address ? address : `Latitude: ${lat}<br>Longitude: ${lng}`)
                .openPopup();

            // Update hidden fields
            document.getElementById('latitude').value = lat;
            document.getElementById('longitude').value = lng;
        }

            // Initialize Leaflet Control Geocoder for address search
            var geocoder = L.Control.geocoder({
                defaultMarkGeocode: false
            }).on('markgeocode', function(e) {
                var latlng = e.geocode.center;
                map.setView(latlng, 14);
                updateMarker(latlng.lat, latlng.lng, e.geocode.name);
                document.getElementById('searchBox').value = e.geocode.name; // Fill input with searched address
            }).addTo(map);

            // Handle input search box manually
            document.getElementById('searchBox').addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    geocoder.options.geocoder.geocode(this.value, function(results) {
                        if (results.length > 0) {
                            var latlng = results[0].center;
                            map.setView(latlng, 14);
                            updateMarker(latlng.lat, latlng.lng, results[0].name);
                        }
                    });
                }
            });
        var mapModal = document.getElementById('addressModal');
        mapModal.addEventListener('shown.bs.modal', function() {
            setTimeout(() => {
            map.invalidateSize();
        }, 200);
        });
    });

</script>
<script>
    $(document).ready(function() {
        $('#loadAddresses').click(function() {
            $.ajax({
                url: "{{ url('/addresses') }}"
                , method: "GET"
                , success: function(response) {
                    let cards = "";
                    if (response.length > 0) {
                        response.forEach(function(address) {
                            cards += `
                                <div class="col-md-12 mb-1">
                                    <div class="card shadow-sm p-3 delivery-location">
                                        <div class="form-check">
                                            <input class="form-check-input address-radio" type="radio" name="address"
                                                value="${address.id}" id="address-${address.id}">
                                            <label class="form-check-label w-100" for="address-${address.id}">
                                                <strong>${address.name}</strong> <br>
                                                <small>
                                                ${address.address}, ${address.city}, ${address.sub_city || '-'}, ${address.street || '-'} <br>
                                                <small>Mobile: ${address.mobile}</small>
                                                </small>
                                            </label>
                                        </div>
                                    </div>
                                </div>`;
                        });
                    } else {
                        cards = `<p class="text-muted text-center">No addresses found.</p>`;
                    }
                    $('#addressContainer').html(cards);
                }
                , error: function() {
                    alert("Error fetching addresses.");
                }
            });
        });

        // Listen for address selection
        $(document).on("change", ".address-radio", function() {
            let selectedAddress = $(this).val();
            $("#selected_address_id").val(selectedAddress);
            $("#placeOrderBtn").prop("disabled", false); // Enable Place Order button
        });

        // Delete address
        $(document).on('click', '.delete-address', function() {
            let addressId = $(this).data('id');
            if (confirm("Are you sure you want to delete this address?")) {
                $.ajax({
                    url: `/addresses/${addressId}`
                    , method: "DELETE"
                    , data: {
                        _token: "{{ csrf_token() }}"
                    }
                    , success: function(response) {
                        alert(response.success);
                        $(`#address-${addressId}`).remove();
                    }
                    , error: function() {
                        alert("Error deleting address.");
                    }
                });
            }
        });

        $('#country').change(function() {
            let countryId = $(this).val();
            $('#state').html('<option value="">Loading...</option>');
            $.get(`/states/${countryId}`, function(data) {
                $('#state').html('<option value="">Select state</option>');
                data.forEach(state => {
                    $('#state').append(`<option value="${state.id}">${state.name}</option>`);
                });
            });
        });
        $('#state').change(function() {
            let stateId = $(this).val();
            $('#city').html('<option value="">Loading...</option>');
            $.get(`/cities/${stateId}`, function(data) {
                $('#city').html('<option value="">Select City</option>');
                data.forEach(city => {
                    $('#city').append(`<option value="${city.id}">${city.name}</option>`);
                });
            });
        });

        $('#city').change(function() {
            let cityId = $(this).val();
            $('#sub_city').html('<option value="">Loading...</option>');
            $.get(`/sub-cities/${cityId}`, function(data) {
                $('#sub_city').html('<option value="">Select Sub City</option>');
                data.forEach(subCity => {
                    $('#sub_city').append(`<option value="${subCity.id}">${subCity.name}</option>`);
                });
            });
        });

        $('#sub_city').change(function() {
            let subCityId = $(this).val();
            $('#street').html('<option value="">Loading...</option>');
            $.get(`/streets/${subCityId}`, function(data) {
                $('#street').html('<option value="">Select Street</option>');
                data.forEach(street => {
                    $('#street').append(`<option value="${street.name}">${street.name}</option>`);
                });
            });
        });
    });
    $(document).ready(function() {
        $('#addressForm').submit(function(e) {
            e.preventDefault();

            $.ajax({
                url: "{{ url('/addresses') }}"
                , method: "POST"
                , data: $(this).serialize()
                , success: function(response) {
                    showAlert('success', response.success);
                    $('#addressModal').modal('hide');
                    $('#addressForm')[0].reset();
                }
                , error: function(xhr) {
                    alert("Error saving address!");
                }
            });
        });
    });

</script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        document.querySelectorAll(".remove-item").forEach(button => {
            button.addEventListener("click", function() {
                let key = this.getAttribute("data-key");

                fetch(`/restaurant/cart/remove/${key}`, {
                        method: "GET"
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            location.reload(); // Refresh the cart page
                        } else {
                            alert("Failed to remove item from cart.");
                        }
                    });
            });
        });
        document.getElementById("apply_coupon").addEventListener("click", function() {
            let couponCode = document.getElementById("coupon_code").value;
            let messageDiv = document.getElementById("coupon_message");

            fetch("{{ route('restaurant.apply.coupon') }}", {
                    method: "POST"
                    , headers: {
                        "Content-Type": "application/json"
                        , "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    }
                    , body: JSON.stringify({
                        coupon_code: couponCode
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        messageDiv.classList.remove("text-danger");
                        messageDiv.classList.add("text-success");
                        messageDiv.innerText = "Coupon applied successfully!";

                        document.querySelector(".total").innerText = data.new_total + " ETB"; // Update total
                        document.getElementById("discount_value").innerText = "-" + data.discount + " ETB"; // Update discount
                    } else {
                        messageDiv.classList.remove("text-success");
                        messageDiv.classList.add("text-danger");
                        messageDiv.innerText = data.message; // Show error message
                    }
                });
        });
    });
    document.addEventListener("DOMContentLoaded", function() {
        document.querySelectorAll(".add, .subtract").forEach(button => {
            button.addEventListener("click", function() {
                let key = this.getAttribute("data-key");
                let action = this.classList.contains("add") ? "increase" : "decrease";
                fetch(`/restaurant/cart/update/${key}/${action}`, {
                        method: "GET"
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            location.reload();
                        }
                    });
            });
        });
    });
</script>
@endsection

