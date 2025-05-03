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
<div class="container mb-4">
    <div class="header">
        <button class="btn btn-link text-dark" onclick="history.back()">
            <i class="bi bi-arrow-left"></i>
        </button>
        <h5 class="my-4 text-dark text-center">Checkout</h5>
    </div>

    <div class="row">
        <div class="col-12 col-md-8">
            @session('success')
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="close btn" data-dismiss="alert" aria-label="Close
                ">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @endif
            @session('error')
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="close btn" data-dismiss="alert" aria-label="Close
                ">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @endif
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
            <form action="{{ route('restaurant.checkout.placeOrder') }}" id="checkoutForm" method="POST" enctype="multipart/form-data">
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
                                            @php $subtotal = 0; @endphp
                                            @foreach(session('cart') as $key => $item)
                                                @php
                                                    $itemSubtotal = $item['price'];
                                                    $subtotal += $itemSubtotal;
                                                    $product = Product::find($item['product_id']);
                                                @endphp
                                                <tr>
                                                    <td class="d-flex align-items-center">
                                                        <img src="{{ $product['image'] }}" alt="{{ $product['name'] }}" class="img-fluid rounded shadow-sm border me-3" style="width: 40px; height: 40px;">
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
                        <p>Your cart is empty</p>
                    @endif
                    </div>
                </div>

        </div>


        <div class="col-lg-4 mb-2">
            <!-- Promo Code Input -->
            <div class="promo-code">
                <input type="text" id="coupon_code" class="promo-input" placeholder="Enter Promo Code">
                <button id="apply_coupon" class="bg-primary text-white">APPLY</button>
            </div>
            <p id="coupon_message" class="text-primary mt-2"></p> <!-- Coupon error/success message -->
            <p id="coupon_error_message" class="text-danger mt-2"></p> <!-- Coupon error/success message -->
            <!-- Order Summary -->
            <div class="summary-card mt-3">
                <div class="d-flex justify-content-between mb-2">
                    <span><strong>SubTotal</strong></span>
                    <span><strong id="subtotal_value">{{ session('cart_subtotal', 0) }} ETB</strong></span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span><strong>Discount</strong></span>
                    <span id="discount_value"><strong>{{ session('discount', 0) }} ETB</strong></span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span><strong>Delivery Fee</strong></span>
                    <span><strong>15.00 ETB</strong></span>
                </div>
                <div class="line"></div>
                <div class="d-flex justify-content-between">
                    <span><strong>Total</strong></span>
                    <span class="total"><strong>{{ $total = max($subtotal - session('discount', 0), 0) + 15 }} ETB</strong></span>
                </div>

                <!-- Payment Method Selection -->
                <div class="delivery-location mt-3 p-3">
                    <h6 class="fw-bold text-dark mb-2">Payment Method</h6>
                    <div class="payment-methods">
                        <label type="button" class="payment-method shadow-sm rounded-3 p-3 text-center" data-bs-toggle="modal" data-bs-target="#modalId">
                            <input type="radio" name="payment_method" value="bank_transfer" class="d-none">
                            <img src="{{ asset('restaurant_frontend/assets/img/bank.png') }}" alt="Bank Transfer" width="35" class="mb-2">
                            <div class="fw-semibold">Bank Transfer</div>
                        </label>

                        <label class="payment-method shadow-sm rounded-3 p-3 text-center">
                            <input type="radio" name="payment_method" value="cash_on_delivery" class="d-none">
                            <img src="{{ asset('restaurant_frontend/assets/img/cash.png') }}" alt="Cash on Delivery" width="35" class="mb-2">
                            <div class="fw-semibold">Cash on Delivery</div>
                        </label>
                    </div>

                    <span id="payment-error" class="text-danger d-none">Please select a payment method.</span>
                </div>
            </div>
            <div class="modal fade" id="modalId" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
                <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalTitleId">
                                Manual Payment
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-2">
                                <input type="hidden" name="id" value="">
                                <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                                <label for="bank" class="form-label">Select Bank</label>
                                <select class="form-select" name="bank_name" required>
                                    <option value="" selected disabled>-- Choose Bank --</option>
                                    <option value="CBE">Commercial Bank of Ethiopia</option>
                                    <option value="Awash">Awash Bank</option>
                                    <option value="Dashen">Dashen Bank</option>
                                </select>
                                @error('bank_name')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-2">
                                <label for="transaction_number" class="form-label">Transaction Number</label>
                                <input type="text" name="transaction_number" class="form-control" required>
                                @error('transaction_number')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-2">
                                <label for="receipt" class="form-label">Upload Receipt</label>
                                <input type="file" name="receipt" class="form-control" accept="image/*,application/pdf" required>
                                @error('receipt')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                Submit
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Optional: Place to the bottom of scripts -->
            <script>
                const myModal = new bootstrap.Modal(
                    document.getElementById("modalId")
                    , options
                , );
            </script>
            <!-- Place Order Button -->
            <button type="submit" class="checkout-btn border-0 bg-primary w-100 mt-3" id="placeOrder">Place Order</button>
        </div>
    </div>
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

        var map = L.map('map').setView([9.03, 38.74], 12);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);
        var marker;
        map.on('click', function(e) {
            var lat = e.latlng.lat.toFixed(6);
            var lng = e.latlng.lng.toFixed(6);
            updateMarker(lat, lng);

        });
        var mapModal = document.getElementById('addressModal');
        mapModal.addEventListener('shown.bs.modal', function() {
            if (!map) {
                initMap(); // Initialize map only once
            } else {
                setTimeout(() => {
                    map.invalidateSize(); // Fix hidden modal issue
                }, 200); // Delay ensures proper resizing
            }
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
     document.getElementById('apply_coupon').addEventListener('click', function() {
        let coupon_code = document.getElementById('coupon_code').value;
        fetch("{{ route('restaurant.checkout.orderNow.applyCoupon') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            body: JSON.stringify({ coupon_code: coupon_code })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showAlert('success','Coupon applied successfully!');
                location.reload();
            } else {
                document.getElementById('coupon_error_message').innerHTML = data.message;
            }
        });
    });
</script>
@endsection

