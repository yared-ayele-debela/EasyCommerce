<?php use App\Models\Product; ?>

<form>  <!-- Products-List-Wrapper -->
    <div class="table-wrapper u-s-m-b-60">
        <table>
            <thead>
                <tr>
                    <th >Product</th>
                    <th >Price</th>
                    <th >Qty</th>
                    <th >Subtotal</th>
                    <th >Action</th>
                </tr>
            </thead>
            <tbody id="movecart">
                @php
                     $total_price=0 @endphp
                                @foreach($getCartItems as $item)
                                <?php $getDiscountAttributePrice=Product::getDiscountAttributePrice($item['product_id'],$item['size']);
                                // echo "<pre>"; print_r($getDiscountAttributePrice); die;
                ?>
                <tr id="">
                    <td>
                        <div class="cart-anchor-image">
                            <a href="{{ url('product/'.$item['product_id']) }}">
                                <img class="lazy" alt="" src="{{ asset('/storage/products/'.$item['product']['product_image']) }}" style="">
                                <h6 class="justify-content-center">{{ $item['product']['product_name'] }}
                               </h6>

                            </a>
                        </div>
                    </td>
                    <td>
                        <div class="cart-price">
                            @if($getDiscountAttributePrice['discount']>0)
                                {{  App\Helper\Helper::currency_converter($getDiscountAttributePrice['final_price']) }}
                            @else
                                {{  App\Helper\Helper::currency_converter($getDiscountAttributePrice['final_price']) }}</span>
                            @endif
                        </div>
                    </td>

                    <td>
                        <div class="cart-quantity">
                            <div class="quantity">
                                <input type="text" class="quantity-text-field qtyPicker" type="number" name="qty" data-min="1" min="1" data-max="99900" max="99900" data-max-allowed="100" value="{{ $item['quantity'] }}" readonly="">
                                <a class="plus-a updateCartItem " type="button" data-cartid="{{ $item['id'] }}" data-qty="{{ $item['quantity'] }}">&#43;</a>
                                <a class="minus-a updateCartItem" type="button" data-cartid="{{ $item['id'] }}" data-qty="{{ $item['quantity'] }}" >&#45;</a>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="cart-price">
                            @php $getDiscountAttributePrices =$getDiscountAttributePrice['final_price']* $item['quantity'] @endphp

                            {{  App\Helper\Helper::currency_converter($getDiscountAttributePrices) }}
                        </div>
                    </td>
                    <td>
                        <div class="action-wrapper">
                            {{-- <button class="button button-outline-secondary fas fa-sync btnEdit cartEditpage"></button> --}}
                            <button class="button button-outline-secondary fas fa-trash deleteCarts" data-cartid="{{ $item['id'] }}"></button>
                        </div>
                    </td>
                </tr>
                @php $total_price=$total_price+($getDiscountAttributePrice['final_price']* $item['quantity']) @endphp
                @endforeach
            </tbody>
        </table>
    </div>
</form>

    <!-- Products-List-Wrapper /- -->
    <!-- Coupon -->
    <div class="coupon-continue-checkout u-s-m-b-60">
        {{-- <div class="coupon-area">
            <h6>Enter your coupon code if you have one.</h6>
        <form  id="ApplyCoupon" action="javascript:void(0);" method="post"  @if(Auth::check()) user="1" @endif>
                @csrf
            <div class="coupon-field">
                <label class="sr-only" for="coupon-code">Apply Coupon</label>
                <input id="coupon-code"  type="text" name="code" id="code" class="text-field" placeholder="Coupon Code">
                <button type="submit" name="submit" class="button">Apply Coupon</button>
            </div>
        </form>
        </div> --}}

        <div class="coupon-area">
            <h6>Enter your coupon code if you have one.</h6>
            <div class="flex">
            <form  id="ApplyCoupon" action="javascript:void(0);" method="post" class="d-flex"  @if(Auth::check()) user="1" @endif>
                @csrf
                <input type="text" name="code" class="form-control mr-70" id="code" placeholder="Enter Coupon Code">&nbsp;
                <button class="btn border " type="submit" name="submit">Apply Coupon</button>
            </form>
            </div>
        </div>
        <div class="button-area">
            <a href="{{ url('/') }}" class="continue">Continue Shopping</a>
            <a href="{{ url('checkout') }}" class="checkout">Proceed to Checkout</a>
        </div>
    </div>
    <!-- Coupon /- -->
<!-- Billing -->
<div class="calculation u-s-m-b-60">
    <div class="table-wrapper-2">
        <table>
            <thead>
                <tr>
                    <th colspan="2">Cart Totals</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <h3 class="calc-h3 u-s-m-b-0">Subtotal</h3>
                    </td>
                    <td>
                        <span class="calc-text"><strong>{{  App\Helper\Helper::currency_converter($total_price) }}</strong></span>
                    </td>
                </tr>
                <tr>
                    <td>
                        <h3 class="calc-h3 u-s-m-b-0">Coupon Discount</h3>
                    </td>
                    <td class="couponAmount">
                        <span class="calc-text">
                            @if(Session::has('couponAmount'))
                            {{  App\Helper\Helper::currency_converter( Session::get('couponAmount') ) }}
                            @else
                            {{  App\Helper\Helper::currency_converter(0) }}
                            @endif
                        </span>
                    </td>
                </tr>
                <tr>
                    <td>
                        <h3 class="calc-h3 u-s-m-b-0">Total</h3>
                    </td>
                    <td>
                        @php
                         $total=$total_price - Session::get('couponAmount');
                        @endphp
                        <span class="calc-text"><strong> {{  App\Helper\Helper::currency_converter($total) }}</strong></span>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<!-- Billing /- -->

