<?php
use App\Models\Product;
use App\Models\OrderLog;
use App\Models\Vendor;
use App\Models\Coupon;
// if(Auth::guard('admin')->user()->type=="vendor"){
// $getVendorCommission=Vendor::getVendorCommission(Auth::guard('admin')->user()->vendor_id);
// }
?>
@extends('delivery_man.admin_dashboard.maindashboard')
@section('delivery_man_dashboard')
@php
$user = Auth::guard('deliverymen')->user();
@endphp
<div class="pagetitle bg-light mb-3">
    <h1 class="breadcrumb-item font-weight-bold"><a href="">Order #{{ $orderDetails['id'] }} Details</a></h1>
    <a href="{{ url('delivery_man/dashboard') }}" class=" link-primary ">Back to Orders</a>
</div>
<section class="section ">
    <div class="row">
        <div class="col-lg-5">
            <div class="card border-0 shadow-sm">
                <div class="card-body pt-3">
                    <h1 class=" card-title bg-light"> <b>Order Details</b> </h1>
                    <div class="bg-light p-3">
                        <div class="col-md-8 pt-1">
                            <label for="" class="form-label"><b>Order ID:</b></label>
                            <label for="">{{ $orderDetails['id'] }} </label>
                        </div>
                        <div class="col-md-8 pt-1">
                            <label for="" class="form-label"><b>Order Date:</b></label>
                            <label for="">{{ $orderDetails['id'] }}</label>
                        </div>
                        <div class="col-md-8 pt-1">
                            <label for="" class="form-label"><b>Order Status:</b></label>
                            <label for="">{{ $orderDetails['order_status'] }}</label>
                        </div>
                        <div class="col-md-8 pt-1">
                            <label for="" class="form-label"><b>Order Total:</b></label>
                            <label for="">{{ $orderDetails['grand_total'] }} .Birr</label>
                        </div>
                        <div class="col-md-8 pt-1">
                            <label for="" class="form-label"><b>Shipping Charges:</b></label>
                            <label for="">{{ $orderDetails['shipping_charges'] }} .Birr</label>
                        </div>
                        <div class="col-md-8 pt-1">
                            <label for="" class="form-label"><b>Order Tax:</b></label>
                            <label for="">{{ $orderDetails['tax_charge'] }} .Birr</label>
                        </div>
                        @if(!empty($orderDetails['coupon_amount']))
                        <div class="col-md-8 pt-1">
                            <label for="" class="form-label"><b>Coupon Code:</b></label>
                            <label for="">{{ $orderDetails['coupon_amount'] }}</label>
                        </div>
                        <div class="col-md-8 pt-1">
                            <label for="" class="form-label"><b>Coupon Amount:</b></label>
                            <label for="">{{ $orderDetails['coupon_amount'] }} .Birr</label>
                        </div>
                        @endif
                        @if($orderDetails['courier_name']!="")
                        <div class="col-md-8 pt-1">
                            <label for="" class="form-label"><b>Courier Name:</b></label>
                            <label for="">{{ $orderDetails['courier_name'] }}</label>
                        </div>
                        <div class="col-md-8 pt-1">
                            <label for="" class="form-label"><b>Tracking Number:</b></label>
                            <label for="">{{ $orderDetails['tracking_number'] }} .Birr</label>
                        </div>
                        @endif
                        <div class="col-md-8 pt-1">
                            <label for="" class="form-label"><b>Payment Method:</b></label>
                            <label for="">{{ $orderDetails['payment_method'] }}</label>
                        </div>
                        <div class="col-md-8 pt-1">
                            <label for="" class="form-label"><b>Payment Gateway:</b></label>
                            <label for="">{{ $orderDetails['payment_gateway'] }}</label>
                        </div>
                    </div>

                    <hr>
                    <h1 class=" card-title">Update Order Status</h1>
                    @if ($user && $user->hasPermissionByRole('update_order_status'))
                    @if(Auth::guard('deliverymen')->user())
                    <form action="{{ url('delivery-boy/update-order-status') }}" class="mt-4" method="post">
                        @csrf
                        <div class="form-group">
                            <input type="hidden" name="order_id" value="{{ $orderDetails['id'] }}">
                            <select name="order_status" id="order_status" class="form-control" required="">
                                <option value="" selected>Select</option>
                                @foreach ($orderStatus as $status )
                                <option value="{{ $status['name'] }}" @if(!empty($orderDetails['order_status']) && $orderDetails['order_status']==$status['name']) selected="" @endif>{{ $status['name'] }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group mt-3">
                            <input type="text" style="display: none;" name="courier_name" class="form-control" id="courier_name" placeholder="Courier Name">
                        </div>
                        <div class="form-group mt-3">
                            <input type="text" style="display: none;" name="tracking_number" class="form-control" id="tracking_number" placeholder="Tracking Number">
                        </div>
                        <div class="form-group mt-3" style="display: none;" id="user_code">
                            <label for="user_code" class="pb-2" id="user_code_label">Enter Customer Order Code to Verify Order Delivered</label>
                            <input type="text" name="user_code" class="form-control" id="user_code" placeholder="Enter Customer Code">
                        </div>
                        <br>
                        @if($orderDetails['order_status']==="Completed")
                        <p class="text-lg p-2 btn-success shadow-none text-white text-center rounded w-50">Order Completed Successfully!</p>
                        @else
                        <input class="mt-3 btn btn-primary " type="submit" value="Update order status">
                        <button type="button" class="btn btn-primary  mt-3" style="width: 200px;" data-toggle="modal" data-target="#exampleModal">
                            Update Acceptance
                        </button>
                        @endif
                    </form>

                    <br>
                    @foreach ( $orderLog as $key=>$log)
                    {{-- <?php echo "<pre>";  print_r($log['orders_products'][$key]['product_code']); die;?> --}}
                    <strong>{{ $log['order_status'] }}</strong>
                    @if($log['order_status']=="Shipped")
                    @if(isset($log['order_item_id'])&&$log['order_item_id']>0)
                    @php $getItemDetails=OrderLog::getItemDetails($log['order_item_id']) @endphp
                    - for item {{$getItemDetails['product_code']}}
                    @if(!empty($getItemDetails['courier_name']))
                    <br><span>Courier Name: {{ $getItemDetails['courier_name'] }}</span>
                    @endif
                    @if(!empty($getItemDetails['tracking_number']))
                    <br><span>Tracking Number: {{ $getItemDetails['tracking_number'] }}</span>
                    @endif
                    @else
                    @if(!empty($orderDetails['courier_name']))
                    <br><span>Courier Name: {{ $orderDetails['courier_name'] }}</span>
                    @endif
                    @if(!empty($orderDetails['tracking_number']))
                    <br><span>Tracking Number: {{ $orderDetails['tracking_number'] }}</span>
                    @endif
                    @endif
                    @endif
                    <br> Date:
                    {{$log['reason']}}
                    {{ date('Y-m-d h:i:s', strtotime($log['created_at'])); }} <br>
                    <br>
                    @endforeach
                    @else
                    This feature is restricted
                    @endif
                    @endif
                </div>
            </div>
        </div>
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm">
                <div class="card-body pt-3">
                    <h1 class=" card-title  bg-light">Customer Details</h1>
                    <div class="p-3 bg-light">
                        <div class="col-md- pt-1">
                            <label for="" class="form-label"><b>Name:</b></label>
                            <label for="">{{ $userDetails['name'] }}</label>
                        </div>
                        @if(!empty($userDetails['address']))
                        <div class="col-md- pt-1">
                            <label for="" class="form-label"><b>Address:</b></label>
                            <label for="">{{ $userDetails['address'] }}</label>
                        </div>
                        @endif
                        @if(!empty($userDetails['city']))
                        <div class="col-md- pt-1">
                            <label for="" class="form-label"><b>City:</b></label>
                            <label for="">{{ $userDetails['city'] }}</label>
                        </div>
                        @endif
                        @if(!empty($userDetails['state']))
                        <div class="col-md- pt-1">
                            <label for="" class="form-label"><b>State:</b></label>
                            <label for="">{{ $userDetails['state'] }}</label>
                        </div>
                        @endif
                        @if(!empty($userDetails['country']))
                        <div class="col-md- pt-1">
                            <label for="" class="form-label"><b>Country:</b></label>
                            <label for="">{{ $userDetails['country'] }}</label>
                        </div>
                        @endif
                        @if(!empty($userDetails['pincode']))
                        <div class="col-md- pt-1">
                            <label for="" class="form-label"><b>Pin:</b></label>
                            <label for="">{{ $userDetails['pincode'] }}</label>
                        </div>
                        @endif
                        @if(!empty($userDetails['mobile']))
                        <div class="col-md- pt-1">
                            <label for="" class="form-label"><b>Mobile:</b></label>
                            <label for="">{{ $userDetails['mobile'] }}</label>
                        </div>
                        @endif

                    </div>
                    <hr class=" hr pt-0 mt-4">
                    {{-- <h1 class="card-title p-3 mt-1 bg-light">Delivery Details</h1>
                    <div class="p-3 bg-light">
                        <div class="col-md-8 ">
                            <div class="col-md-">
                                <label for="" class="form-label"><b>Name:</b></label>
                                <label for="">{{ $orderDetails['name'] }}</label>
                            </div>
                            @if(!empty($userDetails['address']))
                            <div class="col-md- pt-1">
                                <label for="" class="form-label"><b>Address:</b></label>
                                <label for="">{{ $orderDetails['address'] }}</label>
                            </div>
                            @endif
                            @if(!empty($userDetails['city']))
                            <div class="col-md- pt-1">
                                <label for="" class="form-label"><b>City:</b></label>
                                <label for="">{{ $orderDetails['city'] }}</label>
                            </div>
                            @endif
                            @if(!empty($userDetails['state']))
                            <div class="col-md- pt-1">
                                <label for="" class="form-label"><b>State:</b></label>
                                <label for="">{{ $orderDetails['state'] }}</label>
                            </div>
                            @endif
                            @if(!empty($userDetails['country']))
                            <div class="col-md- pt-1">
                                <label for="" class="form-label"><b>Country:</b></label>
                                <label for="">{{ $orderDetails['country'] }}</label>
                            </div>
                            @endif
                            @if(!empty($userDetails['pincode']))
                            <div class="col-md- pt-1">
                                <label for="" class="form-label"><b>Pin:</b></label>
                                <label for="">{{ $orderDetails['pincode'] }}</label>
                            </div>
                            @endif
                            @if(!empty($userDetails['mobile']))
                            <div class="col-md- pt-1">
                                <label for="" class="form-label"><b>Mobile:</b></label>
                                <label for="">{{ $orderDetails['mobile'] }}</label>
                            </div>
                            @endif

                        </div>
                    </div> --}}

                </div>
            </div>
        </div>

        <div class="container">
            <h2 class="card-title pt-4">Order Item Details</h2>
            <div class="row">
                <div class="col-md-12">
                    <div class="card  shadow-sm border-0 p-3">

                        <!-- Modal -->
                        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Update Acceptance</h5>
                                        <button type="button" class="close btn" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <table id="" class="table">
                                            <thead>
                                                <tr>
                                                    <th scope="col">IMG</th>
                                                    <th scope="col">Name</th>
                                                    <th scope="col">Price</th>
                                                    <th scope="col">Qty</th>
                                                    <th scope="col">Total Price</th>
                                                    <th scope="col">Accepted</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($orderDetails['orders_products'] as $product)
                                                <tr>
                                                    <td>
                                                        @php $getProductImage=Product::getProductImage($product['product_id']) @endphp
                                                        <a target="_blank" href="javascript:void(0);">
                                                            <img src="{{ asset('/storage/products/'.Product::getProductImage($product['product_id'])) }}" style="width:30px; height:30px;" alt="">
                                                        </a>
                                                    </td>
                                                    <td>{{ $product['product_name']}}</td>
                                                    </td>
                                                    <td>
                                                        {{ $product['product_price'] }}
                                                    </td>
                                                    <td>
                                                        {{ $product['product_qty'] }}
                                                    </td>
                                                    <td>
                                                        @if($product['vendor_id']>0)
                                                        @if($orderDetails['coupon_amount']>0)

                                                        @php
                                                        $couponDetails=Coupon::couponDetails($orderDetails['coupon_code'])
                                                        @endphp

                                                        @if($couponDetails['vendor_id']>0)
                                                        {{$total_price= $product['product_price'] * $product['product_qty']-$item_discount }}
                                                        @else
                                                        {{$total_price= $product['product_price'] * $product['product_qty'] }}
                                                        @endif

                                                        @else
                                                        {{$total_price= $product['product_price'] * $product['product_qty'] }}
                                                        @endif

                                                        @else
                                                        {{$total_price= $product['product_price'] * $product['product_qty'] }}
                                                        @endif
                                                    </td>
                                                    <form action="{{ route('update_acceptance_order') }}" method="post">
                                                        @csrf
                                                        <td>
                                                            <input type="hidden" name="order_id" value="{{ $orderDetails['id'] }}">
                                                            <input type="hidden" name="product_prices[{{ $product['product_id'] }}]" value="{{ $total_price }}">
                                                            <input type="checkbox" style="width: 20px;height:20px;" @if($product['accepted']==="accepted" ) checked @endif value="{{ $product['product_id'] }}" name="accepted_products[]">
                                                        </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                        <button type="submit" class="btn btn-primary btn-sm">Update Status</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <table id="" class="table datatable">
                            <thead>
                                <tr>
                                    <th scope="col">IMG</th>
                                    <th scope="col">Product Name</th>
                                    <th scope="col">Code</th>
                                    <th scope="col">Size</th>
                                    <th scope="col">Color</th>
                                    <th scope="col">Unique Price </th>
                                    <th scope="col">Qty</th>
                                    <th scope="col">Total Price</th>
                                    <th scope="col">Acceptance</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Added By</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($orderDetails['orders_products'] as $product)
                                <tr>
                                    <td>
                                        @php $getProductImage=Product::getProductImage($product['product_id']) @endphp
                                        <a target="_blank" href="{{ url('product/'.$product['product_id']) }}">
                                            <img src="{{ Product::getProductImage($product['product_id']) }}" style="width:30px; height:30px;" alt="">
                                        </a>

                                    </td>
                                    <td>{{ $product['product_name']}}</td>
                                    <td>{{ $product['product_code'] }}</td>
                                    <td>{{ $product['product_size'] }}</td>
                                    <td>
                                        {{ $product['product_color'] }}
                                    </td>

                                    <td>
                                        {{ $product['product_price'] }}
                                    </td>
                                    <td>
                                        {{ $product['product_qty'] }}
                                    </td>
                                    <td>
                                        @if($product['vendor_id']>0)
                                        @if($orderDetails['coupon_amount']>0)
                                        @php
                                        $couponDetails=Coupon::couponDetails($orderDetails['coupon_code'])
                                        @endphp
                                        @if($couponDetails['vendor_id']>0)
                                        {{$total_price= $product['product_price'] * $product['product_qty']-$item_discount }}
                                        @else
                                        {{$total_price= $product['product_price'] * $product['product_qty'] }}
                                        @endif
                                        @else
                                        {{$total_price= $product['product_price'] * $product['product_qty'] }}
                                        @endif
                                        @else
                                        {{$total_price= $product['product_price'] * $product['product_qty'] }}
                                        @endif
                                    </td>
                                    <td>
                                        @if($product['accepted']==="accepted")
                                        <div class="btn btn-sm btn-success">Accepted</div>
                                        @else
                                        <div class="btn btn-sm btn-danger">Not Accepted</div>
                                        @endif
                                    </td>
                                    <td>
                                        @if($product['item_status']==="Completed")
                                        <button class="btn btn-sm btn-success text-white" disabled>Completed</button>
                                        @else
                                        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#exampleModal{{ $product['id'] }}">
                                            Update
                                        </button>
                                        <!-- Modal -->
                                        <div class="modal fade" id="exampleModal{{ $product['id'] }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel{{ $product['id'] }}" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel{{ $product['id'] }}">Update Order Item Status</h5>
                                                        <button type="button" class="close btn" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        @if ($user && $user->hasPermissionByRole('update_order_item_status'))
                                                        <form action="{{ url('delivery-boy/update-order-item-status') }}" class="" method="post">
                                                            @csrf
                                                            <input type="hidden" name="order_item_id" value="{{ $product['id'] }}">
                                                            <select name="order_item_status" id="order_item_status" class="form-control mb-2" required="">
                                                                <option value="">Select</option>
                                                                @foreach ($orderItemStatus as $status)
                                                                <option value="{{ $status['name'] }}" @if(!empty($product['item_status']) && $product['item_status']==$status['name']) selected="" @endif>{{ $status['name'] }}</option>
                                                                @endforeach
                                                            </select>
                                                            <input type="number" name="vendor_code" style="display: none;" class="form-control item_courier_name mb-2" placeholder="Enter Vendor Code">
                                                            <input type="text" name="item_courier_name" style="display: none;" class="form-control item_courier_name mb-2" placeholder="Item Courier Name" @if(!empty($product['item_courier_name'])) value="{{ $product['courier_name'] }}" @endif>
                                                            <input type="text" name="item_tracking_number" style="display: none;" class="form-control item_tracking_number mb-2" placeholder="Item Tracking Number">
                                                            @if($product['item_status']==="Completed")
                                                            @else
                                                            <input class="ml-2 btn btn-primary text-white " type="submit" value="Update Order Status">
                                                            @endif
                                                        </form>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endif
                                    </td>
                                    <td>
                                        @php
                                             $vendor=Vendor::where('id',$product['vendor_id'])->first();
                                        @endphp

                                        <button type="button" class="btn btn-secondary btn-sm" data-toggle="modal" data-target="#vendor{{ $vendor['id'] }}">
                                            <i class="ri-eye-fill"></i>
                                        </button>
                                        <!-- Modal -->
                                        <div class="modal fade" id="vendor{{ $vendor['id'] }}" tabindex="-1" role="dialog" aria-labelledby="vendorLabel{{ $vendor['id'] }}" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="vendorLabel{{ $vendor['id'] }}">Vendor Detail</h5>
                                                        <button type="button" class="close btn" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <p><strong>Name :</strong> {{ $vendor->name }}</p>
                                                                <p><strong>Address :</strong> {{ $vendor->address }}</p>
                                                                <p><strong>City :</strong> {{ $vendor->city }}</p>
                                                                <p><strong>State :</strong> {{ $vendor->state }}</p>
                                                                <p><strong>Country :</strong> {{ $vendor->country }}</p>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <p><strong>Mobile :</strong> {{ $vendor->mobile }}</p>
                                                                <p><strong>Email :</strong> {{ $vendor->email }}</p>
                                                                <!-- Add more details here if needed -->
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- Add footer if needed -->
                                                </div>
                                            </div>

                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>

                    </div>
                </div>

            </div>
        </div>
</section>
@endsection
@section('script')
<script>
    $(document).ready(function() {
        $("#courier_name").hide();
        $("#tracking_number").hide();
        $("#order_status").on("change", function() {
            if (this.value == "Picked") {
                $("#courier_name").show();
                $("#tracking_number").show();
            } else {
                $("#courier_name").hide();
                $("#tracking_number").hide();
            }
        })

        $("#user_code").hide();
        $("#user_code_lable").hide();
        $("#order_status").on("change", function() {
            if (this.value == "Delivered" || this.value == "Paid") {
                $("#user_code").show();
                $("#user_code_lable").show();
            } else {
                $("#user_code").hide();
                $("#user_code_lable").hide();
            }
        })
        //show item courier name and tracking nuber in case of shipped order item status
        // order_item_status
        $(".item_courier_name").hide();
        $(".item_tracking_number").hide();
        $("#order_item_status").on("change", function() {
            if (this.value == "Picked") {
                $(".item_courier_name").show();
                $(".item_tracking_number").show();
            } else {
                $(".item_courier_name").hide();
                $(".item_tracking_number").hide();
            }
        })
    });

</script>
@endsection
