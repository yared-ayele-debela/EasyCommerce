<?php
use App\Models\Product;
// $getCartItem=getCartItems();
// $getCartItems=getCartItems();
?>
@php  $getCartItems= App\Helper\Helper::getCartItems(); @endphp
<div class="mini-cart-wrapper">
    <div class="mini-cart">
        <div class="mini-cart-header">
            YOUR CART
            <button type="button" class="button ion ion-md-close" id="mini-cart-close"></button>
        </div>
        @php $total_price=0 @endphp
        @foreach($getCartItems as $item)
        <?php $getDiscountAttributePrice=Product::getDiscountAttributePrice($item['product_id'],$item['size']);
        // echo "<pre>"; print_r($getDiscountAttributePrice); die;
        ?>
        <ul class="mini-cart-list">

            <li class="clearfix">
                <a href="single-product.html">
                    <img src="{{ asset('/storage/products/'.$item['product']['product_image']) }}" alt="Product">
                    <span class="mini-item-name">{{ $item['product']['product_name'] }}</span>
                    <span class="small">Product Code : &nbsp;{{ $item['product']['product_code'] }}</span>
                    <span class="mini-item-price">{{  App\Helper\Helper::currency_converter($getDiscountAttributePrice['final_price']) }}</span>
                    <span class="mini-item-quantity"> x {{ $item['quantity'] }} </span>
                </a>
            </li>

        </ul>
        @php

        $total_price=$total_price + ($getDiscountAttributePrice['final_price'] * $item['quantity'])
        @endphp

        @endforeach
        <div class="mini-shop-total clearfix">
            <span class="mini-total-heading float-left">Total:</span>
            <span class="mini-total-price float-right">
                {{  App\Helper\Helper::currency_converter($total_price) }}

                </span>
        </div>
        <div class="mini-action-anchors">
            <a href="{{ url('cart') }}" class="cart-anchor">View Cart</a>
            <a href="{{ url('checkout') }}" class="checkout-anchor">Checkout</a>
        </div>
    </div>
</div>
