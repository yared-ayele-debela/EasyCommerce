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
                    <span id="discount_value"><strong> {{ $discount }} ETB</strong></span>
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

                        <label type="button" class="payment-method" data-bs-toggle="modal" data-bs-target="#modalId">
                            <input type="radio" name="payment_method" value="manual" class="d-none">
                            <img src="{{ asset('restaurant_frontend/bill.png') }}" width="40" alt="CBE">
                        </label>
                        <label class="payment-method">
                            <input type="radio" name="payment_method" value="cash" class="d-none">
                            <img src="{{ asset('restaurant_frontend/assets/img/Cash (1).png') }}" alt="Cash on Delivery">
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
                                    Close
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

</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
@endsection

