@extends('all_frontend_layouts.layouts')
@section('content')
@php
use App\Models\Restaurant\Product;
@endphp
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<style>
    #map { height: 400px; width: 100%; margin-bottom: 20px; }
</style>
<style>
    .card {
        box-shadow: none !important;
        border: 1px solid #2222 !important;
        margin: 5px !important;
    }
    @php
        $user= Auth::user();
    @endphp
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
                    <button type="button" class="btn btn-primary fw-bold px-4 py-2 delivery_text" >
                        <i class="bi bi-geo-alt"></i> Get My Current Addresses
                    </button>

                    <a href="#" class="btn btn-primary fw-bold d-flex align-items-center delivery_text px-3 py-2 rounded-3" data-bs-toggle="modal" data-bs-target="#addressModal">
                        <i class="bi bi-plus-circle me-1"></i> Add New Address
                    </a>
                </div>
            </div>
            <form action="{{ route('restaurant.checkout.placeOrder') }}" id="checkoutForm" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="tax" value="{{ $totalTax }}">
                <input type="hidden" id="current_lat" name="current_lat">
                <input type="hidden" id="current_lng" name="current_lng">
                <span id="location_status" style="font-size: 14px; color: gray;"></span>

                <div class="row" id="addressContainer">
                    <div class="col-md-12 mb-2">
                    <div class="card shadow-sm p-3 delivery-location">
                        <div class="form-check">
                            <input class="form-check-input address-radio" type="radio" id="current_address" name="address"
                                value="current_address" >
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
                   @forelse ($addresses as $address)
                             <div class="col-md-12 mb-2">
                                <div class="card shadow-sm p-3 delivery-location">
                                    <div class="form-check">
                                        <input class="form-check-input address-radio" type="radio" name="address"
                                            value="{{ $address->id }}" id="address-{{ $address->id }}"  data-lat="{{ $address->latitude }}"
       data-lng="{{ $address->longitude }}">
                                        <label class="form-check-label w-100" for="address-{{ $address->id }}">
                                            <strong>{{ $address->name }}</strong></strong> <br>
                                            <small>
                                            {{ $address->address }}, {{ $address->city }}, {{ $address->sub_city??'-' }}, {{ $address->street??'' }} <br>
                                            <small>Mobile: {{ $address->mobile }}</small>
                                            </small>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        @empty
                        <p class="text-muted">Add delivery address</p>
                        @endforelse
                </div>
                <span id="address-error" class="text-danger d-none">Please select a delivery address.</span>

                <input type="hidden" name="address_id" id="selected_address_id">
                <div class="d-flex justify-content-between align-items-center">
                    <button type="button" class="btn btn-outline-primary fw-bold px-4 py-2" id="toggleItems">
                        <i class="bi bi-eye"></i> Show Items ({{ count($cart,0) }})
                    </button>
                </div>
                <div id="itemsSection" class="mt-3 d-none">
                    <h4 class="text-dark">Items details</h4>
                    <div class="row my-3">
                        @if($cart)
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
                                            @foreach($cart as $key => $item)
                                            @php
                                            $itemSubtotal = $item['price'] * $item['quantity'];
                                            $subtotal += $itemSubtotal;
                                            $product = Product::find($item['product_id']);
                                            @endphp
                                            <tr>
                                                <td class="d-flex align-items-center">
                                                    <img src="{{ asset('storage/'.$product->image) ?? asset('restaurant_frontend/default-image.png') }}" class="img-fluid rounded shadow-sm border me-3" style="width: 40px; height: 40px;">

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
        $discount = session('discount', 0);
        $subtotal = session('cart_subtotal', 0);
        $tax= $totalTax;

        $total = max(($subtotal - $discount), 0) + $tax ;
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
                        <label type="button" class="payment-method shadow-sm bg-white rounded-3 p-3 text-center" data-bs-toggle="modal" data-bs-target="#modalId">
                            <input type="radio" name="payment_method" value="Bank Transfer" class="d-none">
                            <img src="{{ asset('restaurant_frontend/assets/img/bank.jpg') }}" alt="Bank Transfer" width="200" class="mb-2">
                            <div class="fw-semibold">Bank Transfer</div>
                        </label>
                        <label class="payment-method shadow-sm rounded-3 bg-white p-3 text-center">
                            <input type="radio" name="payment_method" value="Cash On Delivery" class="d-none">
                            <img src="{{ asset('restaurant_frontend/assets/img/cash.png') }}" alt="Cash on Delivery" width="35" class="mb-2">
                            <div class="fw-semibold">Cash on Delivery</div>
                        </label>
                    </div>
                    <span id="payment-error" class="text-danger d-none">Please select a payment method.</span>

                </div>

                <!-- Modal Body -->
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
                                    <label for="transaction_number" class="form-label">Transaction Number</label>
                                    <input type="text" name="transaction_number" class="form-control">
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
              <button type="button" class="checkout-btn border-0 bg-primary w-100 mt-3" id="placeOrder">Place Order</button>
        </form>
    </div>
</div>

</div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
@include('all_frontend_layouts.partials.delivery_address_modal')
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
            url: "{{ route('calculate.shipping.fee') }}",
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


    function handleCouponApply() {
        document.getElementById("apply_coupon").addEventListener("click", function () {
            const couponCode = document.getElementById("coupon_code").value;
            const messageDiv = document.getElementById("coupon_message");

            fetch("{{ route('restaurant.apply.coupon') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({ coupon_code: couponCode })
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        messageDiv.classList.remove("text-danger");
                        messageDiv.classList.add("text-success");
                        messageDiv.innerText = "Coupon applied successfully!";
                        document.getElementById("discount_value").innerText = `-${data.discount} ETB`;
                        updateTotal(elements.selectedTipInput.value || 0);
                    } else {
                        messageDiv.classList.remove("text-success");
                        messageDiv.classList.add("text-danger");
                        messageDiv.innerText = data.message;
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

    function handlePlaceOrderValidation() {
        document.getElementById("placeOrder").addEventListener("click", function () {
            let selectedPayment = document.querySelector("input[name='payment_method']:checked");
            let selectedAddress = document.querySelector("input[name='address']:checked");

            let paymentError = document.getElementById("payment-error");
            let addressError = document.getElementById("address-error");

            paymentError.classList.add("d-none");
            addressError.classList.add("d-none");

            if (!selectedAddress) {
                addressError.classList.remove("d-none");
                showAlert('error', 'Please select delivery address');
                return;
            }
            if (!selectedPayment) {
                paymentError.classList.remove("d-none");
                showAlert('error', 'Please select Payment Method');
                return;
            }
            document.getElementById("checkoutForm").submit();
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
        handleCouponApply();
        handlePaymentSelection();
        handlePlaceOrderValidation();
        handleAddressForm();
        initLocationDropdowns();
    }

    document.addEventListener('DOMContentLoaded', init);
})();
</script>

@endsection

