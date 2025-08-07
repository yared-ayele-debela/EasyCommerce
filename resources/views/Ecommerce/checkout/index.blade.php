<?php use App\Models\Product; ?>
@extends('all_frontend_layouts.layouts')
@section('content')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<style>
    #map { height: 400px; width: 100%; margin-bottom: 20px; }
</style>
@php
    $user= Auth::user();
@endphp
<div class="container mb-5 mb-md-0">
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
                            <button type="button" class="btn btn-primary fw-bold px-2 py-2 delivery_text" id="loadAddresses">
                                <i class="bi bi-geo-alt"></i> Get My Current Addresses
                            </button>
                            <a href="#" class="btn btn-primary fw-bold d-flex align-items-center delivery_text px-3 py-2 rounded-3" data-bs-toggle="modal" data-bs-target="#addressModal">
                                <i class="bi bi-plus-circle me-1"></i> Add New Address
                            </a>
                        </div>
                    </div>
                    <div class="row" id="addressContainer">
                         <input type="hidden" id="current_lat" name="current_lat">
                         <input type="hidden" id="current_lng" name="current_lng">
                        <input type="hidden" name="tax" value="{{ $totalTax }}">

                        <div class="col-md-12 mb-2">
                            <div class="card shadow-sm p-3 delivery-location">
                                <div class="form-check">
                                    <input class="form-check-input address-radio" type="radio" id="current_address" readonly name="address"
                                        value="current_address">
                                    <label class="form-check-label w-100" for="address">
                                        <strong>My Current location</strong></strong> <br>
                                        <small>
                                        {{ $user->address }}, {{ $user->city }}, {{ $user->country??'' }} <br>
                                        <small>Mobile: {{ $user->mobile }}</small>
                                        </small>
                                    </label>
                                </div>
                            </div>
                        </div>
                       @forelse ($addresses as $ads)
                             <div class="col-md-12 mb-2">
                                <div class="card shadow-sm p-3 delivery-location">
                                    <div class="form-check">
                                        <input class="form-check-input address-radio" type="radio" name="address"
                                            value="{{ $ads->id }}" id="address-{{ $ads->id }}">
                                        <label class="form-check-label w-100" for="address-{{ $ads->id }}">
                                            <strong>{{ $ads->name }}</strong></strong> <br>
                                            <small>
                                            {{ $ads->address }}, {{ $ads->city }}, {{ $ads->sub_city??'-' }}, {{ $ads->street??'' }} <br>
                                            <small>Mobile: {{ $ads->mobile }}</small>
                                            </small>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        @empty
                        <p class="text-muted">Add delivery address</p>
                        @endforelse
                    </div>
                    <span id="address-error" class="text-danger" style="display: none;">Please select a delivery address.</span>
                    <input type="hidden" name="address_id" id="selected_address_id">
                    @error('address_id')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                @php
                 $total_price = 0;
                @endphp

                <div class="d-flex justify-content-between align-items-center mb-3">
                    <button type="button" class="btn btn-outline-primary fw-bold px-4 py-2" id="toggleItems">
                        <i class="bi bi-eye"></i> Show Items
                    </button>
                </div>
                <div id="itemsSection" class="mt-3 d-none">
                    <h4 class="text-dark">Items details</h4>
                    <div class="row my-3">
                        @foreach($getCartItems as $item)
                        <div class="col-md-4">
                            @php
                            if(!empty($cartItems['size'])){
                            $getDiscountAttributePrice = Product::getDiscountAttributePrice($item['product_id'], $item['size']);
                            }else{
                            $getDiscountAttributePrice = Product::getDiscountProductPrice(product_id: $item['product_id']);
                            }
                            $product_quantity = $getDiscountAttributePrice['final_price'] * $item['quantity'];
                            $total_price += $product_quantity;
                            @endphp
                            <div class=" offer-card p-3 mb-3">
                                <div class=" d-flex align-items-center">
                                    <a href="{{ url('product/' . $item['product_id']) }}" class="me-3">
                                        @if($item['product']['product_image'])
                                        <img src="{{ asset('storage/'.$item['product']['product_image']) }}" alt="{{ $item['product']['product_name'] }}" class="rounded" style="width: 60px; height: 60px; object-fit: cover;">
                                        @else
                                        <img src="{{ asset('restaurant_frontend/default-image.png') }}" alt="{{ $item['product']['product_name'] }}" class="rounded" style="width: 60px; height: 60px; object-fit: cover;">

                                        @endif
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
            </div>
              @php
        $discount =session('couponAmount',0);
        $subtotal = $total_price;
        $tax= $totalTax;

        $total = $subtotal + $totalShipping+ $tax - $discount;


        @endphp

            <div class="col-md-4 mb-3">
                <div class="summary-card mt-3">
                    <div class="d-flex justify-content-between mb-2">
                        <span><strong>Subtotal</strong></span>
                        <span><strong id="subtotal_value">{{ number_format($subtotal,2) }} ETB</strong></span>
                    </div>
                     <div class="d-flex justify-content-between mb-2">
                    <span><strong>Discount</strong></span>
                    <span id="discount_value"><strong> {{ $discount }} ETB</strong></span>
                </div>
                      <div class="d-flex justify-content-between mb-2">
                    <span><strong>Shipping Fee</strong></span>
                    <span><strong id="shipping_fee_display">0.00 ETB</strong></span>
                </div>
                   <div class="d-flex justify-content-between mb-2">
                    <span><strong>Tax</strong></span>
                    <span><strong>{{ $tax }} ETB</strong></span>
                </div>
                    <div class="line"></div>

                    <div class="d-flex justify-content-between mb-2">
                    <span><strong>Total (with Tip)</strong></span>
                    <span class="total"><strong id="final_total_display">0.00 ETB</strong></span>
                </div>
                                <input type="hidden" name="delivery_fee" value="">

                    <div class="delivery-location mt-3 p-3">
                        <h6 class="fw-bold text-dark mb-2">Tip For Driver</h6>
                            <input type="hidden" name="tip_option" id="selected_tip" value="0"> <!-- Default selected -->
                            <div class="tip-options" id="tipOptions">
                                <div class="tip-option shadow-sm selected" data-tip="0">No</div>
                                @foreach($tips as $tip)
                                    <div class="tip-option shadow-sm" data-tip="{{ $tip->amount }}">
                                        {{ $tip->amount }} Birr
                                    </div>
                                @endforeach
                                <div class="tip-option shadow-sm" data-tip="custom">Custom</div>
                            </div>
                            <div id="custom-tip-container">
                                <input type="number" name="custom_tip_amount" class="form-control w-100 shadow-sm" id="custom_tip_amount" placeholder="0" min="1">
                            </div>
                        <h6 class="fw-bold text-dark mb-2">Payment Method</h6>
                        <div class="payment-methods">
                            <label type="button" class="payment-method bg-white shadow-sm rounded-3 p-3 text-center" data-bs-toggle="modal" data-bs-target="#modalId">
                                <input type="radio" name="payment_method" value="Bank Transfer" class="d-none">
                                <img src="{{ asset('restaurant_frontend/assets/img/bank.jpg') }}" alt="Bank Transfer" width="200" class="mb-2">
                                <div class="fw-semibold">Bank Transfer</div>
                            </label>
                            <label class="payment-method shadow-sm bg-white rounded-3 p-3 text-center">
                                <input type="radio" name="payment_method" value="Cash On Delivery" class="d-none">
                                <img src="{{ asset('restaurant_frontend/assets/img/cash.png') }}" alt="Cash on Delivery" width="35" class="mb-2">
                                <div class="fw-semibold">Cash on Delivery</div>
                            </label>
                        </div>
                        <div class="invalid-feedback text-danger" id="paymentErrors" style="display: none;">
                            Please select a payment method.
                        </div>
                        @error('payment_geteway')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                        <span id="payment-error" class="text-danger d-none">Please select a payment method.</span>

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
                                        <select class="form-select" name="bank_name" id="bank-select">
                                            <option value="" selected disabled>-- Choose Bank --</option>
                                            @foreach ($banks as $bank)
                                            <option value="{{ $bank->bank_name }}" data-account="{{ $bank->account_number }}">{{ $bank->bank_name }} | {{ $bank->account_number }}</option>
                                            @endforeach
                                        </select>
                                        @error('bank_name')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                     <div id="account-info" class="my-2 alert alert-light" style="display: none;">
                                        <div class="d-flex justify-content-between">
                                        <span>Account Number: <strong id="account-number"></strong></span>
                                        <button type="button" class="btn btn-sm btn-outline-primary ms-2" onclick="copyAccountNumber()"><i class="bi bi-copy"></i></button>
                                        </div>
                                    </div>
                                    <div class="mb-2">
                                        <label for="transaction_number" class="form-label">Transaction Number (Optional)</label>
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
                                        Submit
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
@php
    $safeTotal = is_numeric($total_price) ? $total_price : 0;
    $safeDiscount = is_numeric($discount) ? $discount : 0;
    $safeDelivery = is_numeric($totalShipping) ? $totalShipping : 0;
    $safeTax = is_numeric($totalTax) ? $totalTax : 0;
@endphp

@include('all_frontend_layouts.partials.delivery_address_modal')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
{{--
<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.payment-method').forEach(method => {
            method.addEventListener('click', function () {
                document.querySelectorAll('.payment-method').forEach(el => el.classList.remove('selected'));
                this.classList.add('selected');
                this.querySelector('input').checked = true;
                document.getElementById("payment-error").classList.add("d-none");
            });
        });

    });
    const myModal = new bootstrap.Modal(
        document.getElementById("modalId")
        , options
    , );
</script> --}}
<script>
(function () {
    const subtotal = parseFloat(@json($subtotal));
    const discount = parseFloat(@json($discount));
    const tax = parseFloat(@json($tax));
    let shippingFee = 0;

    const elements = {
        tipOptions: document.querySelectorAll('.tip-option'),
        selectedTipInput: document.getElementById('selected_tip'),
        customTipContainer: document.getElementById('custom-tip-container'),
        customTipField: document.getElementById('custom_tip_amount'),
        shippingFeeDisplay: document.getElementById('shipping_fee_display'),
        finalTotalDisplay: document.getElementById('final_total_display')
    };

    function updateTotal(tipAmount = 0) {
    let usedSubtotal = typeof window.discountedSubtotal !== 'undefined'
        ? window.discountedSubtotal
        : subtotal;

const total = Math.max(usedSubtotal - discount) + tax + shippingFee + parseFloat(tipAmount || 0);

    elements.finalTotalDisplay.innerHTML = `<strong>${total.toFixed(2)} ETB</strong>`;
}


    function fetchShippingFee(addressId, tip = 0) {
         const data = {
            address_id: addressId,
            _token: '{{ csrf_token() }}'
        };

        if (addressId === 'current_address') {
            data.current_lat = localStorage.getItem('user_lat');  // Or get from geolocation
            data.current_lng = localStorage.getItem('user_lng');
        }

        $.ajax({
            url: "{{ route('ecommerce.checkout.shipping.calculation') }}",
            method: 'POST',
            data,
            success: function (res) {
                if (res.success) {
                    shippingFee = parseFloat(res.shipping_fee);
                    const totalWithoutTip = parseFloat(res.total_amount);
                    const finalTotal =   Math.max(totalWithoutTip - discount) + tax+ parseFloat(tip || 0);

                    elements.shippingFeeDisplay.textContent = `${shippingFee.toFixed(2)} ETB`;
                    elements.finalTotalDisplay.innerHTML = `<strong>${finalTotal.toFixed(2)} ETB</strong>`;
                    $('input[name="delivery_fee"]').val(shippingFee);
                }
            }
        });
    }

    function handleTipSelection() {
        elements.tipOptions.forEach(option => {
            option.addEventListener('click', function () {
                elements.tipOptions.forEach(opt => opt.classList.remove('selected'));
                this.classList.add('selected');

                const tipValue = this.dataset.tip;
                if (tipValue === 'custom') {
                    elements.selectedTipInput.value = elements.customTipField.value || 'custom';
                    elements.customTipContainer.style.display = 'block';
                    elements.customTipField.focus();
                    updateTotal(elements.customTipField.value);
                } else {
                    elements.selectedTipInput.value = tipValue;
                    elements.customTipContainer.style.display = 'none';
                    updateTotal(tipValue);
                }
            });
        });

        elements.customTipField.addEventListener('input', function () {
            if (document.querySelector('.tip-option.selected')?.dataset.tip === 'custom') {
                elements.selectedTipInput.value = this.value;
                updateTotal(this.value);
            }
        });

        // Initial total with selected tip
        const initialTip = document.querySelector('.tip-option.selected')?.dataset.tip || 0;
        updateTotal(initialTip);
    }

    function handleAddressSelection() {
        $(document).on('change', '.address-radio', function () {
            const addressId = $(this).val();
            const tip = parseFloat(elements.selectedTipInput.value) || 0;
            fetchShippingFee(addressId, tip);
            $('#selected_address_id').val(addressId);
            $('#placeOrderBtn').prop('disabled', false);
        });

        // Load initial shipping fee
        const selectedAddressId = $('.address-radio:checked').val();
        const selectedTip = parseFloat(elements.selectedTipInput.value) || 0;
        if (selectedAddressId) {
            fetchShippingFee(selectedAddressId, selectedTip);
        }
    }

    function handleLocationDetection() {
    document.getElementById("current_address")?.addEventListener("click", function () {
        const status = document.getElementById("location_status");
        document.getElementById("current_lat").value = localStorage.getItem('user_lat');
        document.getElementById("current_lng").value = localStorage.getItem('user_lng');
        status.innerText = "Location detected.";

    });
}

    function handlePlaceOrderValidation() {
        $('#placeOrderForm').on('submit', function(e) {
      e.preventDefault();
    const form = this;
    let selected = document.querySelector("input[name='payment_method']:checked");

    const error = document.getElementById('paymentErrors');
    const addressError = document.getElementById('address-error');
    const selectedAddress = document.querySelector("input[name='address']:checked");

    if (!selectedAddress) {
        showAlert('error','Please select delivery address');
        addressError.style.display = 'block';
        return;
    } else {
        addressError.style.display = 'none';
    }

    if (!selected) {
        showAlert('error','Please select Payment Method');
        error.style.display = 'block';
        return;
    } else {
        error.style.display = 'none';
    }
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
    }

    function handleAddressForm() {
        $('#addressForm').submit(function (e) {
            e.preventDefault();
            $.ajax({
                url: "{{ url('/addresses') }}",
                method: "POST",
                data: $(this).serialize(),
                success: function (response) {
                    showAlert('success', response.success);
                    $('#addressModal').modal('hide');
                    $('#addressForm')[0].reset();
                },
                error: function () {
                    alert("Error saving address!");
                }
            });
        });
    }

      function handlePaymentSelection() {
        document.querySelectorAll('.payment-method').forEach(method => {
            method.addEventListener('click', function () {
                document.querySelectorAll('.payment-method').forEach(el => el.classList.remove('selected'));
                this.classList.add('selected');
                this.querySelector('input').checked = true;
                document.getElementById("payment-error").classList.add("d-none");
            });
        });
    }

    function initLocationDropdowns() {
        $('#country').change(function () {
            let countryId = $(this).val();
            $('#state').html('<option value="">Loading...</option>');
            $.get(`/states/${countryId}`, function (data) {
                $('#state').html('<option value="">Select state</option>');
                data.forEach(state => {
                    $('#state').append(`<option value="${state.id}">${state.name}</option>`);
                });
            });
        });

        $('#state').change(function () {
            let stateId = $(this).val();
            $('#city').html('<option value="">Loading...</option>');
            $.get(`/cities/${stateId}`, function (data) {
                $('#city').html('<option value="">Select City</option>');
                data.forEach(city => {
                    $('#city').append(`<option value="${city.id}">${city.name}</option>`);
                });
            });
        });

        $('#city').change(function () {
            let cityId = $(this).val();
            $('#sub_city').html('<option value="">Loading...</option>');
            $.get(`/sub-cities/${cityId}`, function (data) {
                $('#sub_city').html('<option value="">Select Sub City</option>');
                data.forEach(subCity => {
                    $('#sub_city').append(`<option value="${subCity.id}">${subCity.name}</option>`);
                });
            });
        });

        $('#sub_city').change(function () {
            let subCityId = $(this).val();
            $('#street').html('<option value="">Loading...</option>');
            $.get(`/streets/${subCityId}`, function (data) {
                $('#street').html('<option value="">Select Street</option>');
                data.forEach(street => {
                    $('#street').append(`<option value="${street.name}">${street.name}</option>`);
                });
            });
        });
    }

    function init() {
        handleTipSelection();
        handleAddressSelection();
        handleLocationDetection();
        handlePaymentSelection();
        handlePlaceOrderValidation();
        handleAddressForm();
        initLocationDropdowns();
    }

    document.addEventListener('DOMContentLoaded', init);
})();
</script>

@endsection
