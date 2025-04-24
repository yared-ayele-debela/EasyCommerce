<?php use App\Models\Product; ?>
<div class="row g-4">
    <!-- Cart Table Section -->
    <div class="col-lg-8">
        <form>
            <div class="table-responsive mb-4">
                <table class="table table-borderless align-middle">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Price</th>
                            <th>Qty</th>
                            <th>Subtotal</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="movecart">
                        @php $total_price = 0; @endphp
                        @foreach($getCartItems as $item)
                            @php
                                $getDiscountAttributePrice = Product::getDiscountAttributePrice($item['product_id'], $item['size']);
                            @endphp
                            <tr>
                                <td>
                                    <a href="{{ url('product/'.$item['product_id']) }}" class="d-flex align-items-center text-decoration-none">
                                        <img src="{{ asset('/storage/products/'.$item['product']['product_image']) }}" alt="Product" class="me-2 img-fluid" style="width: 50px; height: 50px;">
                                        <span class="text-dark">{{ $item['product']['product_name'] }}</span>
                                    </a>
                                </td>
                                <td>
                                    {{ App\Helper\Helper::currency_converter($getDiscountAttributePrice['final_price']) }}
                                </td>
                                <td>
                                    <div class="d-flex align-items-center justify-content-center flex-nowrap">
                                        <a class="btn btn-secondary btn-sm minus-a updateCartItem"
                                           data-cartid="{{ $item['id'] }}" data-qty="{{ $item['quantity'] }}">−</a>
                                        <input type="text"
                                               class="form-control form-control-sm text-center mx-1 qtyPicker"
                                               style="max-width: 60px;"
                                               name="qty"
                                               value="{{ $item['quantity'] }}"
                                               readonly>
                                        <a class="btn btn-primary btn-sm plus-a updateCartItem"
                                           data-cartid="{{ $item['id'] }}" data-qty="{{ $item['quantity'] }}">+</a>
                                    </div>
                                </td>
                                <td>
                                    @php $subtotal = $getDiscountAttributePrice['final_price'] * $item['quantity']; @endphp
                                    {{ App\Helper\Helper::currency_converter($subtotal) }}
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-danger deleteCarts" data-cartid="{{ $item['id'] }}">
                                        <i class="fas fa-trash-alt text-white"></i>
                                    </button>
                                </td>
                            </tr>
                            @php $total_price += $subtotal; @endphp
                        @endforeach
                    </tbody>
                </table>
            </div>
        </form>
        <hr>
        <div class="d-flex justify-content-start align-items-center gap-2">
            <a href="{{ url('/ecommerce') }}" class="btn btn-secondary w-sm-auto">Continue Shopping</a>
        </div>
    </div>

    <!-- Summary Section -->
    <div class="col-lg-4">
        <div class="summary-card p-3 border rounded-2">
            <div class="mb-3">
                <form id="ApplyCoupon" action="javascript:void(0);" method="post" @if(Auth::check()) user="1" @endif>
                    @csrf
                    <div class="row g-2">
                        <div class="col-8">
                            <input type="text" name="code" class="form-control" id="code" placeholder="Enter Coupon Code">
                        </div>
                        <div class="col-4">
                            <button class="btn btn-primary w-100" type="submit">Apply</button>
                        </div>
                    </div>
                </form>
            </div>
            <hr>
            <h4 class="mb-3">Summary</h4>
            <div class="d-flex justify-content-between mb-2">
                <span><strong>Subtotal</strong></span>
                <strong>{{ App\Helper\Helper::currency_converter($total_price) }}</strong>
            </div>
            <div class="d-flex justify-content-between mb-2">
                <span><strong>Coupon Discount</strong></span>
                <strong class="couponAmount">
                    @if(Session::has('couponAmount'))
                        {{ App\Helper\Helper::currency_converter(Session::get('couponAmount')) }}
                    @else
                        {{ App\Helper\Helper::currency_converter(0) }}
                    @endif
                </strong>
            </div>
            <div class="line"></div>
            <div class="d-flex justify-content-between mb-4">
                <span><strong>Total</strong></span>
                @php $total = $total_price - Session::get('couponAmount', 0); @endphp
                <strong>{{ App\Helper\Helper::currency_converter($total) }}</strong>
            </div>
            <div class="mb-2">
                <button type="submit" class="checkout-btn border-0 bg-primary w-100 mt-3">
                    CHECKOUT
                </button>
            </div>
        </div>
    </div>
</div>