<?php use App\Models\Product; ?>

@extends('fontend.layout.layout')
@section('content')
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<style>
 .payment-container {
      padding: 0px;
      border-radius: 10px;
      display: flex;
      flex-direction: row;
      justify-content:space-around ;
    }

    .payment-method {
      padding: 10px; /* Adjust the padding to add space between payment methods */
      background-color: aliceblue;
      display: flex;
      align-items: center;
      margin-bottom: 15px;
      margin-left: 5px;
    }

    .payment-image {
        max-width: 100px; /* Make the image responsive */
        /* height: auto;   Ensure aspect ratio is maintained */
        margin-right: 10px;
    }
    @media (max-width: 767px) {
        .payment-image {
            width: 50px; /* Set a specific width for mobile screens */
        }
    }

    input[type="radio"] {
      margin-right: 5px;
    }

    label {
      cursor: pointer;
    }
</style>


<!-- Checkout-Page -->
<div class="page-checkout u-s-p-t-80 pb-3">
    <div class="container">
    <div class="row">
        <div class="col-md-6">
              <button type="button" class="btn button-primary text-sm add_delivery_address" data-toggle="modal" data-target="#exampleModals">
                Add Delivery Address
            </button>
            <br>
            <!-- Modal -->
            <div class="modal fade" id="exampleModals" tabindex="-1" aria-labelledby="exampleModalLabels" aria-hidden="true">
                <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabels">
                        <h4 class="section-h4 newAddress">Add / Edit Deivery Address</h4>
                        <h4 class="section-h4 deliveryText"></h4>

                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ url('save-delivery-address') }}"  method="post">
                            @csrf
                        <input type="hidden" name="delivery_id">
                        <div class="group-inline u-s-m-b-13">
                            <div class="group-1 u-s-p-r-16">
                                <label for="first-name">First Name
                                    <span class="astk">*</span>
                                </label>
                                <input type="text" id="delivery_name" name="delivery_name" class="text-field" required>
                                @error('delivery_name')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="group-2">
                                <label for="select-country">Country
                                    <span class="astk">*</span>
                                </label>
                                <div class="select-box-wrapper">
                                    <select class="select-box" id="delivery_country" name="delivery_country" required>
                                        @foreach ($countries as $country)
                                        <option value="{{ $country['country_name'] }}" @if($country['country_name']==Auth::user()->country) selected @endif>{{ $country['country_name'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="group-inline u-s-m-b-13">
                            <div class="group-1 u-s-p-r-16">
                            <label for="delivery_city">City
                                <span class="astk">*</span>
                            </label>
                            <div class="select-box-wrapper">
                                <select class="select-box" id="delivery_city" name="delivery_city" required>

                                    @foreach ($city as $city)
                                    <option value="{{ $city->city }}" class="" @if( $city->city==Auth::user()->city) selected @endif>{{ $city->city }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="group-2">
                            <label for="delivery_state">State
                                <span class="astk">*</span>
                            </label>
                            <div class="select-box-wrapper">
                                <select class="select-box" id="delivery_state" name="delivery_state"  required>
                                    @foreach ($state as $state)
                                    <option value="{{ $state->name }}" @if( $state->name==Auth::user()->city) selected @endif>{{ $state->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        </div>

                        <div class="u-s-m-b-13">
                            <label for="delivery_pincode">Pincode
                                <span class="astk">*</span>
                            </label>
                            <input type="text" id="delivery_pincode" name="delivery_pincode" placeholder="pincode" class="text-field">
                            @error('delivery_pincode')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="u-s-m-b-13">
                        <label for="delivery_address">Delivery address
                            <span class="astk">*</span>
                        </label>
                        <input type="text" id="delivery_address" name="delivery_address" class="text-field" required>
                        @error('delivery_address')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                        </div>
                        <div class="u-s-m-b-13">
                            <label for="delivery_mobile">Mobile Number
                                <span class="astk">*</span>
                            </label>
                            <input type="text" id="delivery_mobile" name="delivery_mobile" pattern="[0-9]{10}" title="please add 10 digit phone number" placeholder="delivery_mobile" required class="text-field" required>
                            @error('delivery_mobile')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="button button-primary ">Save Delivery Address</button>
                        </form>
                    </div>
                </div>
                </div>
            </div>
            <br>
            <form name="checkoutForm" action="{{ url('/checkout') }}" method="post">
                @csrf
            <div id="deliveryAddresses">
                {{-- @if(count($deliveryAddresses) > 0)
                <h4 class="section-h4">Delivery Address</h4>
                <!-- Form-Fields /- -->
                @foreach ($deliveryAddresses as $address)
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body" style="display: flex; align-items: center; ">
                                    <div class="control-group" style="margin: 0;">
                                        @php
                                          $symbol = App\Helper\Helper::final_amount_currency_symbol();

                                          $shipping_charges=App\Helper\Helper::final_amount_currency_converter($address['shipping_charges']);

                                          $producttax=App\Helper\Helper::final_amount_currency_converter($address['producttax']);

                                          $total_prices=App\Helper\Helper::final_amount_currency_converter($total_price);

                                          $coupon_amount=App\Helper\Helper::final_amount_currency_converter(Session::get('couponAmount'));

                                        @endphp
                                        <input type="radio" name="address_id" id="address{{ $address['id'] }}" value="{{ $address['id'] }}" shipping_charges="{{ $shipping_charges }}" producttax="{{ $producttax}}" total_price="{{ $total_prices }}" coupon_amount="{{ $coupon_amount }}" symbol={{ $symbol }}>
                                    </div> &nbsp;
                                    <div class="justify-between" style="margin: 0;">
                                        <label class="control-label" style="font-size: 12px;">
                                            {{ $address['name'] }}, {{ $address['address'] }},{{ $address['city'] }}, {{ $address['state'] }}, {{ $address['pincode'] }}, ({{ $address['mobile'] }})
                                        </label>
                                        <a href="{{ url('delete/delivery-address/'.$address['id']) }}" onclick="return confirm('Are you sure to remove this delivery address?')" class="  btn btn-sm float-end ml-1" style="background-color: azure;">Delete</a>
                                        <a href="javascript:void(0);" data-addressid="{{ $address['id'] }}" data-toggle="modal" data-target="#exampleModals" class="editAddress  button button-primary  btn-sm float-end">Edit</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <br>
                @endforeach
                @endif --}}
            </div>
        </div>
        <div class="col-md-6">
            <h4 class="section-h4">Your Order</h4>
            <div class="order-table">
                <table class="u-s-m-b-13">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $total_price=0 @endphp
                        @foreach($getCartItems as $item)
                        <?php $getDiscountAttributePrice=Product::getDiscountAttributePrice($item['product_id'],$item['size']);
                                // echo "<pre>"; print_r($getDiscountAttributePrice); die;
                                ?>
                        <tr>
                            <td>
                                <a href="{{ url('product/'.$item['product_id']) }}">
                                    <img class="lazy" style="width:30px;" alt="" src="{{ asset('/storage/products/'.$item['product']['product_image']) }}" style="">
                                </a>
                                <h6 class="order-h6">{{ $item['product']['product_name'] }} </h6>
                                <span class="order-span-quantity">x {{ $item['quantity'] }}</span>

                            </td>
                            <td>
                                <h6 class="order-h6">
                                    @php $product_quantity= $getDiscountAttributePrice['final_price']* $item['quantity'] @endphp
                                    {{  App\Helper\Helper::currency_converter($product_quantity) }}
                                </h6>
                            </td>
                        </tr>
                        @php $total_price=$total_price+($getDiscountAttributePrice['final_price']* $item['quantity']) @endphp
                        @endforeach
                        <tr>
                            <td>
                                <h3 class="order-h3">Subtotal</h3>
                            </td>
                            <td>
                                <h3 class="order-h3">
                                    {{  App\Helper\Helper::currency_converter($total_price) }}
                                </h3>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <h3 class="order-h3">Shipping</h3>
                            </td>
                            <td>
                                <h3 class="order-h3 shipping_charges">
                                    {{  App\Helper\Helper::currency_converter(0) }}
                                </h3>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <h3 class="order-h3">Coupon Discount</h3>
                            </td>
                            <td>
                                <h3 class="order-h3">
                                    @if(Session::has('couponAmount'))
                                     <span class="couponAmount">
                                       {{  App\Helper\Helper::currency_converter(Session::get('couponAmount')) }}
                                     </span>
                                     @else
                                     {{  App\Helper\Helper::currency_converter(0) }}
                                     @endif
                                </h3>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <h3 class="order-h3">Tax</h3>
                            </td>
                            <td>
                                <h3 class="order-h3"> {{  App\Helper\Helper::currency_converter($totalTax) }}</h3>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <h3 class="order-h3">Total</h3>
                            </td>
                            <td>
                                <h3 class="order-h3 grand_total">
                                    @php $grand_total= $total_price + $totalTax - Session::get('couponAmount') @endphp
                                    {{  App\Helper\Helper::currency_converter($grand_total) }}
                                </h3>
                            </td>
                        </tr>
                    </tbody>
                </table>
                
                @php
                App\Helper\Helper::currency_load();
                $currency_code = session('currency_code');
                $currency_symbol = session('currency_symbol');

                if ($currency_symbol=="") {
                        $system_default_currency_info = session('system_default_currency_info');
                        $currency_symbol = $system_default_currency_info->symbol;
                        $currency_code = $system_default_currency_info->code;
                }
                @endphp
                <div class="payment-container">
                    <div class="payment-method">
                        <input type="radio" id="bitcoin" name="payment_gateway" id="cash-on-delivery" value="COD">
                        <img class="payment-image" src="{{ asset('new_frontend/payment_method/EraseBG1.png') }}" alt="COD">
                      </div>
                    <div class="payment-method">
                      <input type="radio" id="Chapa" name="payment_gateway" value="Chapa">
                      <img class="payment-image" src="{{ asset('new_frontend/payment_method/chapa1.png') }}" alt="Chapa">
                    </div>
                    @if($currency_code=="USD")
                    <div class="payment-method">
                      <input type="radio" id="Paypal" name="payment_gateway" value="Paypal">
                      <img class="payment-image" src="{{ asset('new_frontend/payment_method/PayPal1.png') }}" alt="Paypal">
                    </div>
                    @endif
                </div>
                <br>
                <div class="u-s-m-b-13 ">
                    <input type="checkbox" required class="check-box" id="accept" value="Yes" name="accept" title="Please agree to T&C">
                    <label class="label-text no-color" for="accept">I’ve read and accept the
                        <a href="javascript:void(0);" class="u-c-brand">terms & conditions</a>
                    </label>
                </div>
                <button type="submit" class="button button-primary">Place Order</button>
            </div>
        </form>
        </div>
    </div>
    </div>
</div>
@endsection

@section('script')
<script>
    $(document).ready(function() {

        $(document).on('click', '.editAddress', function() {
            var addressid = $(this).data("addressid");
            //  alert(addressid);
            $.ajax({
                data: {
                    addressid: addressid
                    , _token: '{{csrf_token()}}'
                }
                , url: '/get-delivery-address'
                , type: 'post'
                , success: function(resp) {
                    $("#showdifferent").removeClass("collapse");
                    $('[name=delivery_id]').val(resp.address['id']);
                    $('[name=delivery_name]').val(resp.address['name']);
                    $('[name=delivery_address]').val(resp.address['address']);
                    $('[name=delivery_city]').val(resp.address['city']);
                    $('[name=delivery_state]').val(resp.address['state']);
                    $('[name=delivery_country]').val(resp.address['country']);
                    $('[name=delivery_pincode]').val(resp.address['pincode']);
                    $('[name=delivery_mobile]').val(resp.address['mobile']);
                }
                , error: function() {
                    alert("Error");
                }
            })
        });

        $(document).on('click', '.add_delivery_address', function() {
                    $("#showdifferent").removeClass("collapse");
                    $('[name=delivery_id]').val('');
                    $('[name=delivery_name]').val('');
                    $('[name=delivery_address]').val('');
                    $('[name=delivery_city]').val('');
                    $('[name=delivery_state]').val('');
                    $('[name=delivery_country]').val('');
                    $('[name=delivery_pincode]').val('');
                    $('[name=delivery_mobile]').val('');
        });

        $(document).on('submit', "#addressAddEditForm", function() {
            var formdata = $("#addressAddEditForm").serialize();
            $.ajax({
                url: '/save-delivery-address'
                , type: 'post'
                , headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
                , data: formdata
                , success: function(resp) {
                    //  alert(data);
                    if (resp.type == "error") {
                        $.each(resp.errors, function(i, error) {
                            $("#delivery-" + i).attr('style', 'color:red');
                            $("#delivery-" + i).html(error);
                            setTimeout(function() {
                                $("#delivery-" + i).css({
                                    'display': 'none'
                                });
                            }, 3000);
                        });
                    } else {
                        $('#deliveryAddresses').html(resp.view);
                    }
                }
                , error: function() {
                    alert("Error");
                }
            })

        });

        $(document).on('click', '.removeAddress', function() {
            if (confirm("Are you sure to remove this delivery address")) {
                var addressid = $(this).data("addressid");
                $.ajax({
                    url: '/delete-delivery-address'
                    , type: 'post'
                    , headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                    , data: {
                        addressid: addressid
                    }
                    , success: function(resp) {

                        $('#deliveryAddresses').html(resp.view);
                    }
                    , error: function() {
                        alert("Error");
                    }
                })
            }
        })
        $("input[name=address_id]").bind('change', function() {
            var shipping_charges = $(this).attr("shipping_charges");
            var total_price = $(this).attr("total_price");
            var coupon_amount = $(this).attr("coupon_amount");
            var producttax = $(this).attr("producttax");
            $(".shipping_charges").html(shipping_charges);
            var symbol=$(this).attr("symbol");

            if (coupon_amount == "") {
                coupon_amount = 0;
            }
            var priceWithComma = total_price;
            var total_price = priceWithComma.replace(/,/g, "");

            $(".couponAmount").html(coupon_amount+" "+symbol);

            $(".shipping_charges").html(shipping_charges+" "+symbol);

            var grand_total = parseInt(total_price) + parseInt(shipping_charges) + parseInt(producttax) - coupon_amount;

            $(".grand_total").html(grand_total+" "+symbol);
        })
    });
</script>
@endsection

