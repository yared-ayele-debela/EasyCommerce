<?php use App\Models\Product; ?>
@extends('all_frontend_layouts.layouts')
@section('content')
<div class="container">
    <div class="header">
        <button class="btn btn-link text-dark" onclick="history.back()">
            <i class="bi bi-arrow-left"></i>
        </button>
        <h5 class="my-4 text-dark text-center">Checkout</h5>
    </div>

    <form id="placeOrderForm" enctype="multipart/form-data">
        <div class="row">
            <div class="col-md-8">
                @csrf
                <div class="mb-4 p-2">
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
                    <div class="row" id="addressContainer">
                        <p class="text-muted text-center">Click "Load Addresses" to view your addresses.</p>
                    </div>
                    <span id="address-error" class="text-danger" style="display: none;">Please select a delivery address.</span>
                    <input type="hidden" name="address_id" id="selected_address_id">

                    @error('address_id')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                @php $total_price = 0; @endphp
                <div class="row">
                    @foreach($getCartItems as $item)
                    <div class="col-md-4">
                        @php
                        $getDiscountAttributePrice = Product::getDiscountAttributePrice($item['product_id'], $item['size']);
                        $product_quantity = $getDiscountAttributePrice['final_price'] * $item['quantity'];
                        $total_price += $product_quantity;
                        @endphp
                        <div class="border border-1 card mb-3 shadow-none">
                            <div class="card-body d-flex align-items-center">
                                <a href="{{ url('product/' . $item['product_id']) }}" class="me-3">
                                    <img src="{{ $item['product']['product_image']}}" alt="{{ $item['product']['product_name'] }}" class="rounded" style="width: 60px; height: 60px; object-fit: cover;">
                                </a>
                                <div class="flex-grow-1">
                                    <h6 class="mb-1">{{ $item['product']['product_name'] }}</h6>
                                    <small class="text-muted">Quantity: x {{ $item['quantity'] }}</small>
                                </div>
                                <div>
                                    <h6 class="mb-0">
                                        {{ App\Helper\Helper::currency_converter($product_quantity) }}
                                    </h6>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

            </div>
            <div class="col-md-4 mb-3">
                <div class="summary-card mt-3">
                    <div class="d-flex justify-content-between mb-2">
                        <span><strong>Subtotal</strong></span>
                        <span><strong>{{ App\Helper\Helper::currency_converter($total_price) }}</strong></span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span><strong>Shipping</strong></span>
                        <span class="shipping_charges"><strong>{{ App\Helper\Helper::currency_converter(0) }}</strong></span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span><strong>Coupon Discount</strong></span>
                        <span>
                            <strong>
                                @if(Session::has('couponAmount'))
                                <span class="couponAmount">{{ App\Helper\Helper::currency_converter(Session::get('couponAmount')) }}</span>
                                @else
                                {{ App\Helper\Helper::currency_converter(0) }}
                                @endif
                            </strong>
                        </span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span><strong>Tax</strong></span>
                        <span><strong>{{ App\Helper\Helper::currency_converter($totalTax) }}</strong></span>
                    </div>
                    <div class="line"></div>
                    @php $grand_total = $total_price + $totalTax - Session::get('couponAmount'); @endphp
                    <div class="d-flex justify-content-between">
                        <span><strong>Total</strong></span>
                        <span class="grand_total"><strong>{{ App\Helper\Helper::currency_converter($grand_total) }}</strong></span>
                    </div>
                    <div class="delivery-location mt-3 p-3">
                        <h6 class="fw-bold text-dark mb-2">Payment Method</h6>
                        <div class="payment-methods">
                            <label type="button" class="payment-method" data-bs-toggle="modal" data-bs-target="#modalId">
                                <input type="radio" name="payment_gateway" value="manual" class="d-none">
                                <img src="{{ asset('restaurant_frontend/bill.png') }}" width="40" alt="CBE">
                            </label>
                            <label class="payment-method">
                                <input type="radio" name="payment_gateway" value="cash" class="d-none">
                                <img src="{{ asset('restaurant_frontend/assets/img/Cash (1).png') }}" alt="Cash on Delivery">
                            </label>

                        </div>
                        <div class="invalid-feedback text-danger" id="paymentErrors" style="display: none;">
                            Please select a payment method.
                        </div>
                        @error('payment_gateway')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                        <span id="payment-error" class="text-danger d-none">Please select a payment method.</span>
                    </div>

                    <div class="form-check mt-2">
                        <input class="form-check-input" type="checkbox" name="accept" id="accept" required>
                        <label class="form-check-label" for="accept">
                            I agree to the <a href="#" class="text-primary">Terms & Conditions</a>
                        </label>
                        @error('accept')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
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
                                        <select class="form-select" name="bank_name">
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
                                        <input type="text" name="transaction_number" class="form-control">
                                        @error('transaction_number')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="mb-2">
                                        <label for="receipt" class="form-label">Upload Receipt</label>
                                        <input type="file" name="receipt" class="form-control" accept="image/*,application/pdf">
                                        @error('receipt')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                        Close
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="checkout-btn border-0 bg-primary w-100 mt-3 text-white py-2">Place Order</button>
                    <div id="orderResponse"></div>

                </div>
            </div>
        </div>
    </form>
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
<!-- Optional: Place to the bottom of scripts -->
<script>
    const myModal = new bootstrap.Modal(
        document.getElementById("modalId")
        , options
    , );
</script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
     $('#placeOrderForm').on('submit', function(e) {
    e.preventDefault();

    const form = this;

    const selected = document.querySelector('input[name="payment_gateway"]:checked');
    const error = document.getElementById('paymentErrors');
    const addressError = document.getElementById('address-error');
    const selectedAddress = document.querySelector("input[name='address']:checked");

    if (!selectedAddress) {
        addressError.style.display = 'block';
        return;
    } else {
        addressError.style.display = 'none';
    }

    if (!selected) {
        error.style.display = 'block';
        return;
    } else {
        error.style.display = 'none';
    }

    // ✅ Use FormData to support file upload
    const formData = new FormData(form);

    $.ajax({
        url: "{{ route('ecommerce.checkout.placeOrder') }}",
        method: "POST",
        data: formData,
        processData: false, // Don't process the files
        contentType: false, // Let the browser set it
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        beforeSend: function() {
            $('#orderResponse').text('Processing your order...');
        },
        success: function(response) {
            const { status, data, message, redirect_url } = response;
            if (status === 'error') {
                showAlert('error', data?.message || message || 'An error occurred.');
                if (redirect_url) window.location.href = redirect_url;
                return;
            }
            if (status === 'success') {
                showAlert('success', data?.message || message || 'Success!');
                if (redirect_url) window.location.href = redirect_url;
                return;
            }
            showAlert('info', message || 'Unexpected response received.');
        },
        error: function(xhr) {
            showAlert('error', 'Something went wrong during order placement.');
        }
    });
});


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
        let selectedPayment = document.querySelector("input[name='payment_gateway']:checked");
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
                                <div class="col-md-12 mb-2">
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
@endsection
