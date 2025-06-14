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

<section class="container">
    <nav class="breadcrumb bg-white shadow-sm py-3 px-4 rounded d-flex justify-content-between align-items-center">
        <button class="btn btn-outline-primary btn-sm d-flex align-items-center" onclick="history.back()">
            <i class="bi bi-arrow-left mr-2"></i> &nbsp;
            <span>Back</span>
        </button>
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item">
                <a href="{{ url('delivery-boy/dashboard') }}">Home</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                Order #{{ $orderDetails['id'] }} Details
            </li>
        </ol>
    </nav>
    <div class="row">
        <div class="col-lg-5">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">
                    <h4 class="card-title mb-4 font-weight-bold">Order Details</h4>
                    <div class="bg-light p-4 rounded">
                        <div class="row">
                            <div class="col-md-12 mb-2">
                                <strong>Order ID:</strong> {{ $orderDetails['id'] }}
                            </div>
                            <div class="col-md-12 mb-2">
                                <strong>Order Date:</strong> {{ $orderDetails['created_at'] ?? '-' }}
                            </div>
                            <div class="col-md-12 mb-2">
                                <strong>Order Status:</strong> {{ $orderDetails['order_status'] }}
                            </div>
                            <div class="col-md-12 mb-2">
                                <strong>Order Total:</strong> {{ $orderDetails['grand_total'] }} ETB
                            </div>
                            <div class="col-md-12 mb-2">
                                <strong>Shipping Charges:</strong> {{ $orderDetails['shipping_charges'] }} ETB
                            </div>
                            <div class="col-md-12 mb-2">
                                <strong>Order Tax:</strong> {{ $orderDetails['tax_charge'] }} ETB
                            </div>
                            @if(!empty($orderDetails['coupon_code']))
                            <div class="col-md-12 mb-2">
                                <strong>Coupon Code:</strong> {{ $orderDetails['coupon_code'] }}
                            </div>
                            <div class="col-md-12 mb-2">
                                <strong>Coupon Amount:</strong> {{ $orderDetails['coupon_amount'] }} ETB
                            </div>
                            @endif
                            @if(!empty($orderDetails['courier_name']))
                            <div class="col-md-12 mb-2">
                                <strong>Courier Name:</strong> {{ $orderDetails['courier_name'] }}
                            </div>
                            <div class="col-md-12 mb-2">
                                <strong>Tracking Number:</strong> {{ $orderDetails['tracking_number'] }}
                            </div>
                            @endif
                            <div class="col-md-12 mb-2">
                                <strong>Payment Method:</strong> {{ $orderDetails['payment_method'] }}
                            </div>
                            <div class="col-md-12 mb-2">
                                <strong>Payment Gateway:</strong> {{ $orderDetails['payment_gateway'] }}
                            </div>
                        </div>
                    </div>
                    @if($user && $user->hasPermissionByRole('update_order_status') && Auth::guard('deliverymen')->user())
                    <hr class="my-4">
                    <h4 class="card-title font-weight-bold">Update Order Status</h4>
                    <form action="{{ url('delivery-boy/update-order-status') }}" method="post" class="mt-3">
                        @csrf
                        <input type="hidden" name="order_id" value="{{ $orderDetails['id'] }}">
                        <div class="form-group">
                            <label for="order_status"><strong>Select Status:</strong></label>
                            <select name="order_status" id="order_status" class="form-control" required>
                                <option value="">-- Select Status --</option>
                                <option value="picked" @if($orderDetails['order_status']==="picked") selected @endif>
                                    Picked
                                </option>
                                <option value="delivering" @if($orderDetails['order_status']==="delivering") selected @endif>
                                    Delivering
                                </option>
                                <option value="delivered" @if($orderDetails['order_status']==="delivered") selected @endif>
                                    Delivered
                                </option>
                                <option value="cancelled" @if($orderDetails['order_status']==="cancelled") selected @endif>
                                    Cancelled
                                </option>
                            </select>
                        </div>

                        <div class="form-group mt-3" style="display: none;" id="user_code">
                            <label for="user_code"><strong>Customer Verification Code</strong></label>
                            <input type="text" name="user_code" class="form-control" id="user_code" placeholder="Enter Customer Code">
                        </div>

                        @if($orderDetails['order_status'] === "delivered")
                        <div class="alert alert-info mt-3">Order delivered successfully!</div>
                        @else
                        <div class="d-flex flex-wrap gap-2 mt-3">
                            <button type="submit" class="btn btn-primary">Update Order Status</button>
                            <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#exampleModal">
                                Update Acceptance
                            </button>
                        </div>
                        @endif
                    </form>

                    <div class="mt-4">
                        <h5 class="mb-3"><strong>Order Status History</strong></h5>
                        @foreach ($orderLog as $log)
                        <div class="border-left pl-3 mb-3">
                            <strong>{{ $log['order_status'] }}</strong>
                            @if($log['order_status'] == "Shipped")
                            @if(!empty($log['order_item_id']))
                            @php $getItemDetails = OrderLog::getItemDetails($log['order_item_id']); @endphp
                            - for item {{ $getItemDetails['product_code'] ?? '-' }}
                            @if(!empty($getItemDetails['courier_name']))
                            <br>Courier: {{ $getItemDetails['courier_name'] }}
                            @endif
                            @if(!empty($getItemDetails['tracking_number']))
                            <br>Tracking #: {{ $getItemDetails['tracking_number'] }}
                            @endif
                            @else
                            @if(!empty($orderDetails['courier_name']))
                            <br>Courier: {{ $orderDetails['courier_name'] }}
                            @endif
                            @if(!empty($orderDetails['tracking_number']))
                            <br>Tracking #: {{ $orderDetails['tracking_number'] }}
                            @endif
                            @endif
                            @endif
                            <br>Date: {{ date('Y-m-d h:i:s', strtotime($log['created_at'])) }}
                            @if(!empty($log['reason']))
                            <br>Reason: {{ $log['reason'] }}
                            @endif
                        </div>
                        @endforeach
                    </div>
                    @else
                    <div class="alert alert-warning mt-4">This feature is restricted.</div>
                    @endif
                </div>
            </div>

        </div>
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h1 class=" card-title">Customer Details</h1>
                        <a href="{{url('delivery-boy/ecommerce/get-customer-location/'.$orderDetails['id'])}}" class="btn btn-primary">
                            Get Customer Location
                        </a>
                    </div>
                </div>
                <div class="card-body pt-3">
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
                    <h1 class="card-title p-3 mt-1 bg-light">Delivery Details</h1>
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
                    </div>

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
                                                            <img src="{{ Product::getProductImage($product['product_id']) }}" style="width:30px; height:30px;" alt="">
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
                                    <th scope="col">Shop Address</th>
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
                                        <strong>{{ $product['item_status'] }}</strong>
                                        @if($product['item_status']==="delivered")
                                        <button class="btn btn-sm btn-success text-white" disabled>Delivered</button>
                                        @else
                                        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#exampleModal{{ $product['id'] }}">
                                            Update
                                        </button>
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
                                                            <select name="order_item_status" id="order_item_status_{{ $product['id'] }}" class="form-control mb-2 order-status-dropdown" required="" data-product-id="{{ $product['id'] }}">
                                                                <option value="">Select</option>
                                                                @foreach ($orderItemStatus as $status)
                                                                <option value="{{ $status['name'] }}" @if(!empty($product['item_status']) && $product['item_status']==$status['name']) selected="" @endif>{{ $status['name'] }}</option>
                                                                @endforeach
                                                            </select>
                                                            <div class="form-group mt-3 item_vendor_code" id="vendor_code_wrapper_{{ $product['id'] }}" style="display: none;">
                                                                <label for="vendor_code"><strong>Vendor Verification Code</strong></label>
                                                                <input type="number" name="vendor_code" class="form-control  mb-2" placeholder="Enter Vendor Code">
                                                            </div>
                                                            @error('vendor_code')
                                                            <br>
                                                            <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                            @if($product['item_status']==="delivered")
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
                                                                <a href="{{ url('delivery-boy/ecommerce/pickup-order/'.$orderDetails['id'].'/'.$vendor->id) }}" class="btn btn-primary">
                                                                    Get Shop Location
                                                                </a>
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
        $("#user_code").hide();
        $("#user_code_lable").hide();
        $("#order_status").on("change", function() {
            if (this.value == "delivered") {
                $("#user_code").show();
                $("#user_code_lable").show();
            } else {
                $("#user_code").hide();
                $("#user_code_lable").hide();
            }
        })
        //show item courier name and tracking nuber in case of shipped order item status
        $('.order-status-dropdown').on('change', function() {
            let productId = $(this).data('product-id');
            let selectedStatus = $(this).val();

            if (selectedStatus === 'picked') {
                $('#vendor_code_wrapper_' + productId).show();
            } else {
                $('#vendor_code_wrapper_' + productId).hide();
            }
        });

        // Optional: Trigger change on page load if needed
        $('.order-status-dropdown').each(function() {
            $(this).trigger('change');
        });
    });

</script>
@endsection

