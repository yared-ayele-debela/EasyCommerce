<?php  use App\Models\Product;
        use App\Models\OrderLog;
        use App\Models\Vendor;
        use App\Models\Coupon;
        if(Auth::guard('admin')->user()->type=="vendor"){
        $getVendorCommission=Vendor::getVendorCommission(Auth::guard('admin')->user()->vendor_id);
}
?>
@extends('admindashboard.maindashboard')
@php
$user = Auth::guard('admin')->user();
@endphp
@section('dashboard')
<div class="pagetitle bg-light mb-3">
    <h1 class="breadcrumb-item font-weight-bold"><a href="javascript:void(0);">Order #{{ $orderDetails['id'] }} Details</a></h1>
    <a href="{{ url('admin/orders') }}" class=" link-primary ">Back to Orders</a>
</div>
<section class="section ">
    <div class="row">
        <div class="col-lg-5">
            <div class="card shadow-sm border-0">
                <div class="card-body pt-1">
                    <h1 class=" card-title"> <b>Order Details</b> </h1>
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
                    <hr>
                    @if ($user && $user->hasPermissionByRole('assing_delivery_boy_to_order'))
                    <h1 class="card-title mb-3">Assign Delivery Boy</h1>
                    <form action="{{ url('admin/assign-to-delivery-boy') }}" class="d-flex flex-column" method="post">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="order_id" value="{{ $orderDetails['id'] }}">
                        <input type="hidden" name="order_status" value="{{ $orderDetails['order_status'] }}">
                        <div class="form-group mb-2 ">
                            <select name="delivery_boy_id" id="delivery_boy_id" class="form-control select-delivery-zone" required="">
                                <option value="" selected>Select</option>
                                @foreach ($alldelivery_boys as $boys )
                                <option value="{{ $boys['id'] }}" @if(!empty($orderDetails['delivery_boy_id']) && $orderDetails['delivery_boy_id']==$boys['id']) selected @endif >{{ $boys['first_name'] }} &nbsp; {{ $boys['phone'] }}</option>
                                @endforeach
                            </select>
                        </div>
                        <input class="btn btn-primary d-block " type="submit" value="Update">
                    </form>
                    @endif

                @if ($user && $user->hasPermissionByRole('update_order_status'))
                    <h1 class="card-title mb-2">Update Order Status</h1>
                        @if(Auth::guard('admin')->user())
                        <form action="{{ url('admin/update-order-status') }}" class="d-flex flex-column" method="post">
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
                            @if($orderDetails['order_status']==="Completed")
                            <p class="text-lg p-2 btn-success shadow-none text-white text-center rounded w-50">Order Completed Successfully!</p>
                            @else
                            <input class="mt-3 btn btn-primary " type="submit" value="Update order status">
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
                    <br>
                     Date:
                    {{ date('Y-m-d h:i:s', strtotime($log['created_at'])) }} <br>
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
                <div class="card-body pt-1">
                    <h1 class=" card-title p-3 bg-light">Customer Details</h1>
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
                    @if(!empty($userDetails['email']))
                    <div class="col-md- pt-1">
                        <label for="" class="form-label"><b>Email:</b></label>
                        <label for="">{{ $userDetails['email'] }}</label>
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
                            @if(!empty($orderDetails['address']))
                            <div class="col-md- pt-1">
                                <label for="" class="form-label"><b>Address:</b></label>
                                <label for="">{{ $orderDetails['address'] }}</label>
                            </div>
                            @endif
                            @if(!empty($orderDetails['city']))
                            <div class="col-md- pt-1">
                                <label for="" class="form-label"><b>City:</b></label>
                                <label for="">{{ $orderDetails['city'] }}</label>
                            </div>
                            @endif
                            @if(!empty($orderDetails['state']))
                            <div class="col-md- pt-1">
                                <label for="" class="form-label"><b>State:</b></label>
                                <label for="">{{ $orderDetails['state'] }}</label>
                            </div>
                            @endif
                            @if(!empty($orderDetails['country']))
                            <div class="col-md- pt-1">
                                <label for="" class="form-label"><b>Country:</b></label>
                                <label for="">{{ $orderDetails['country'] }}</label>
                            </div>
                            @endif
                            @if(!empty($orderDetails['pincode']))
                            <div class="col-md- pt-1">
                                <label for="" class="form-label"><b>Pin:</b></label>
                                <label for="">{{ $orderDetails['pincode'] }}</label>
                            </div>
                            @endif
                            @if(!empty($orderDetails['mobile']))
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
            <h2 class="card-title pt-4 mb-4">Product Details</h2>
            <div class="row">
                @foreach ($orderDetails['orders_products'] as $product)
                <div class="col-md-6">
                    <div class="card mb-4 shadow-sm border-0">
                        <div class="card-body bg-light m-3">
                            <div class="row">
                                {{-- <?php

                            $vendor=Vendor::find($product['vendor_id']);

                            $lat1 = $orderDetails['latitude'];
                            $lon1 = $orderDetails['longitude'];
                            $lat2 = $vendor->latitude;
                            $lon2 = $vendor->longitude;

                            $earthRadius = 6371; // Radius of the Earth in kilometers

                            $latFrom = deg2rad($lat1);
                            $lonFrom = deg2rad($lon1);
                            $latTo = deg2rad($lat2);
                            $lonTo = deg2rad($lon2);

                            $latDelta = $latTo - $latFrom;
                            $lonDelta = $lonTo - $lonFrom;

                            $angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) +
                                cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)));

                            $distance = $earthRadius * $angle;
                            ?> --}}
                            {{-- <div class="col-md-12 mb-4 pt-3">
                                <div class="card shadow-none">
                                    <div class="card-body">
                                        <h5 class="card-title">Distance Information</h5>
                                        <p class="card-text">
                                            <strong>Customer Name:</strong> {{ $userDetails['name'] }}<br>
                                            <strong>Customer Location:</strong>
                                            <a class="btn bg-light shadow-sm" href="https://www.google.com/maps?q={{ $userDetails['latitude'] }},{{ $userDetails['longitude'] }}" target="_blank">
                                                <svg id='Home_Address_16' width='16' height='16' viewBox='0 0 16 16' xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink'><rect width='16' height='16' stroke='none' fill='#000000' opacity='0'/>
                                                    <g transform="matrix(0.44 0 0 0.44 8 8)" >
                                                    <path style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-dashoffset: 0; stroke-linejoin: miter; stroke-miterlimit: 4; fill: rgb(0,0,0); fill-rule: nonzero; opacity: 1;" transform=" translate(-15, -15.5)" d="M 15 2 C 8.925 2 4 6.925 4 13 C 4 20.234 11.152828 23.697906 12.048828 24.503906 C 12.963828 25.326906 13.718437 27.170797 14.023438 28.216797 C 14.171437 28.724797 14.588 28.981188 15 28.992188 C 15.413 28.980187 15.828563 28.723797 15.976562 28.216797 C 16.281562 27.170797 17.036172 25.327906 17.951172 24.503906 C 18.847172 23.697906 26 20.234 26 13 C 26 6.925 21.075 2 15 2 z M 15.001953 8 C 15.107453 8 15.211781 8.0331094 15.300781 8.0996094 L 19.300781 11.099609 C 19.520781 11.265609 19.565391 11.579781 19.400391 11.800781 C 19.302391 11.931781 19.151 12 19 12 L 19 17 L 16 17 L 16 14 L 14 14 L 14 17 L 11 17 L 11 11.990234 C 10.848 11.990234 10.697609 11.931781 10.599609 11.800781 C 10.434609 11.579781 10.480172 11.265609 10.701172 11.099609 L 14.701172 8.0996094 C 14.790172 8.0331094 14.896453 8 15.001953 8 z" stroke-linecap="round" />
                                                    </g>
                                                    </svg>
                                                {{ $userDetails['latitude']; }}, {{ $userDetails['longitude'] }}
                                            </a>
                                            <br>
                                            <strong>Vendor Name:</strong> {{ $vendor->name }}<br>
                                            <strong>Vendor Location:</strong>
                                            <a class="btn bg-light shadow-sm" href="https://www.google.com/maps?q={{ $vendor->latitude }},{{ $vendor->longitude }}" target="_blank">
                                                <svg id='Shop_Location_16' width='16' height='16' viewBox='0 0 16 16' xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink'><rect width='16' height='16' stroke='none' fill='#000000' opacity='0'/>
                                                    <g transform="matrix(0.1 0 0 0.1 8 8)" >
                                                    <path style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-dashoffset: 0; stroke-linejoin: miter; stroke-miterlimit: 4; fill: rgb(0,0,0); fill-rule: nonzero; opacity: 1;" transform=" translate(-64.05, -64)" d="M 14 1 C 6.8 1 1 6.8 1 14 L 1 43.599609 C 1 50.399609 6.1007812 56.300391 12.800781 56.900391 C 17.300781 57.300391 21.4 55.399219 24 52.199219 C 24.6 52.899219 25.3 53.599609 26 54.099609 L 26 89 C 26 90.7 27.3 92 29 92 L 52.800781 92 C 54.700781 92 56.100781 90.3 55.800781 88.5 C 53.400781 76.2 57 63.000391 66.5 53.400391 C 67 52.900391 67.5 52.5 68 52 C 69.2 51 69.300391 49.2 68.400391 48 C 67.600391 46.9 67.099609 45.5 67.099609 44 L 67.099609 19.199219 C 67.099609 17.599219 65.900781 16.1 64.300781 16 C 62.600781 15.9 61.099609 17.3 61.099609 19 L 61.099609 43.800781 C 61.099609 47.400781 58.5 50.5 55 51 C 50.7 51.5 47 48.2 47 44 L 47 19.199219 C 47 17.599219 45.799219 16.1 44.199219 16 C 42.499219 15.9 41 17.3 41 19 L 41 43.800781 C 41 47.400781 38.400391 50.5 34.900391 51 C 30.700391 51.5 27 48.2 27 44 L 27 34.199219 C 27 32.599219 25.799219 31.1 24.199219 31 C 22.499219 30.9 21 32.3 21 34 L 21 43.800781 C 21 47.400781 18.400391 50.5 14.900391 51 C 10.700391 51.5 7 48.2 7 44 L 7 14 C 7 10.1 10.1 7 14 7 L 114 7 C 117.9 7 121 10.1 121 14 L 121 44 C 121 45.5 120.49922 46.899609 119.69922 48.099609 C 118.79922 49.399609 118.89961 51.099609 120.09961 52.099609 C 121.39961 53.299609 123.4 53.099219 124.5 51.699219 C 126.1 49.499219 127.09961 46.800391 127.09961 43.900391 L 127.09961 14 C 126.99961 6.8 121.2 1 114 1 L 14 1 z M 24 16 C 22.34314575050762 16 21 17.34314575050762 21 19 C 21 20.65685424949238 22.34314575050762 22 24 22 C 25.65685424949238 22 27 20.65685424949238 27 19 C 27 17.34314575050762 25.65685424949238 16 24 16 z M 83.800781 16 C 82.200781 16.1 81 17.499219 81 19.199219 L 81 40.300781 C 81 42.200781 82.799609 43.599609 84.599609 43.099609 C 85.999609 42.799609 87 41.599219 87 40.199219 L 87 19 C 87 17.3 85.600781 15.9 83.800781 16 z M 104.19922 16 C 102.49922 15.9 101 17.3 101 19 L 101 24 L 101 40.199219 C 101 41.599219 102.00039 42.799609 103.40039 43.099609 C 105.30039 43.499609 107 42.099219 107 40.199219 L 107 24 L 107 19.199219 C 107 17.599219 105.79922 16.1 104.19922 16 z M 93.949219 48.025391 C 85.499219 48.025391 77.049609 51.249219 70.599609 57.699219 C 57.799609 70.499219 57.799219 91.500781 70.699219 104.30078 L 92 125.69922 C 92.6 126.29922 93.299609 126.59961 94.099609 126.59961 C 94.899609 126.59961 95.699219 126.29922 96.199219 125.69922 L 117.30078 104.40039 C 130.20078 91.500391 130.20078 70.599219 117.30078 57.699219 C 110.85078 51.249219 102.39922 48.025391 93.949219 48.025391 z M 14.199219 61 C 12.499219 60.9 11 62.3 11 64 L 11 106 L 4.1992188 106 C 2.5992187 106 1.1 107.20078 1 108.80078 C 0.9 110.50078 2.3 112 4 112 L 62.800781 112 C 65.400781 112 66.7 108.9 65 107 L 64.900391 106.90039 C 64.300391 106.30039 63.599219 106 62.699219 106 L 17 106 L 17 64.199219 C 17 62.499219 15.799219 61.1 14.199219 61 z M 94 70.5 C 99.5 70.5 104 75 104 80.5 C 104 86 99.5 90.5 94 90.5 C 88.5 90.5 84 86 84 80.5 C 84 75 88.5 70.5 94 70.5 z M 124 106 C 122.34314575050762 106 121 107.34314575050762 121 109 C 121 110.65685424949238 122.34314575050762 112 124 112 C 125.65685424949238 112 127 110.65685424949238 127 109 C 127 107.34314575050762 125.65685424949238 106 124 106 z M 24 121 C 22.3 121 21 122.3 21 124 C 21 125.7 22.3 127 24 127 L 74 127 C 75.7 127 77 125.7 77 124 C 77 122.3 75.7 121 74 121 L 24 121 z M 114 121 C 112.3 121 111 122.3 111 124 C 111 125.7 112.3 127 114 127 L 124 127 C 125.7 127 127 125.7 127 124 C 127 122.3 125.7 121 124 121 L 114 121 z" stroke-linecap="round" />
                                                    </g>
                                                    </svg>
                                                {{ $vendor->latitude }}, {{ $vendor->longitude }}
                                            </a>
                                             <br>
                                             <br>
                                             <a class="btn btn-success" href="https://www.google.com/maps/dir/?api=1&origin={{ $vendor->latitude }},{{ $vendor->longitude }}&destination={{ $lat1 }},{{ $lon1 }}" target="_blank">
                                                <svg id='Direction_16' width='16' height='16' viewBox='0 0 16 16' xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink'><rect width='16' height='16' stroke='none' fill='#000000' opacity='0'/>
                                                    <g transform="matrix(0.6 0 0 0.6 8 8)" >
                                                    <path style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-dashoffset: 0; stroke-linejoin: miter; stroke-miterlimit: 4; fill: rgb(255, 255, 255); fill-rule: nonzero; opacity: 1;" transform=" translate(-12, -12)" d="M 17 2 L 17 6 L 11 6 L 11 8 L 17 8 L 17 12 L 22 7 L 17 2 z M 3 6 L 3 8 L 5 8 L 5 6 L 3 6 z M 7 6 L 7 8 L 9 8 L 9 6 L 7 6 z M 7 12 L 2 17 L 7 22 L 7 18 L 13 18 L 13 16 L 7 16 L 7 12 z M 15 16 L 15 18 L 17 18 L 17 16 L 15 16 z M 19 16 L 19 18 L 21 18 L 21 16 L 19 16 z" stroke-linecap="round" />
                                                    </g>
                                                    </svg>
                                                Directions from Vendor to Customer
                                             </a>
                                            <div class="btn btn-primary"><strong><svg id='Location_16' width='16' height='16' viewBox='0 0 16 16' xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink'><rect width='16' height='16' stroke='none' fill='#000000' opacity='0'/>
                                                <g transform="matrix(0.57 0 0 0.57 8 8)" >
                                                <path style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-dashoffset: 0; stroke-linejoin: miter; stroke-miterlimit: 4; fill: rgb(255, 255, 255); fill-rule: nonzero; opacity: 1;" transform=" translate(-12, -11.5)" d="M 12 1 C 8.686 1 6 3.686 6 7 C 6 11.286 12 18 12 18 C 12 18 18 11.286 18 7 C 18 3.686 15.314 1 12 1 z M 12 4.8574219 C 13.184 4.8574219 14.142578 5.816 14.142578 7 C 14.142578 8.183 13.183 9.1425781 12 9.1425781 C 10.817 9.1425781 9.8574219 8.184 9.8574219 7 C 9.8574219 5.816 10.816 4.8574219 12 4.8574219 z M 4.8007812 15 L 2 22 L 22 22 L 19.199219 15 L 16.8125 15 C 16.3275 15.731 15.840578 16.408 15.392578 17 L 17.847656 17 L 19.046875 20 L 4.953125 20 L 6.1523438 17 L 8.6074219 17 C 8.1594219 16.408 7.6725 15.731 7.1875 15 L 4.8007812 15 z" stroke-linecap="round" />
                                                </g>
                                            </svg>
                                             Distance:</strong> {{ number_format($distance, 2) }} km</div>

                                        </p>
                                    </div>
                                </div>
                            </div> --}}
                                <div class="col-md-4">
                                    @php $getProductImage=Product::getProductImage($product['product_id']) @endphp
                                    <a target="_blank" href="{{ url('product/'.$product['product_id']) }}">
                                    <img src="{{ Product::getProductImage($product['product_id']) }}" style="width:100%;" alt="product image">
                                    </a>
                                    @if(Auth::guard('admin')->user()->type=="vendor")
                                    <p class="text-center"> <b>Order Product Code # {{ $product['order_product_code'] }}</b> </p>
                                    @endif
                                </div>
                                <div class="col-md-8">
                                 <h5 class="card-title">{{ $product['product_name'] }}</h5>
                                <p class="card-text">Code: {{ $product['product_code'] }}</p>
                                <p class="card-text">Size: {{ $product['product_size'] }}</p>
                                <p class="card-text">Color: {{ $product['product_color'] }}</p>
                                @if($product['specail_discount'] && $product['discounted_price'] && $product['discount_type'])
                                <p class="card-text">
                                    Original Price:
                                     <strong>{{ $product['product_price'] }}</strong>
                                     @if($product['specail_discount'])
                                       <div class="btn btn-outline-primary shadow-none text-left justify-start">
                                           Now Price <strong>{{ $product['discounted_price'] }}</strong> with  Specail Discount <br><span class="py-1 px-2 btn-success" style="border-radius: 2px;">  @if($product['discount_type']==="Percentage") <strong>{{ $product['specail_discount'] }}</strong> % @endif @if($product['discount_type']==="Discounted Price") $ <strong>{{ $product['specail_discount'] }}</strong>   @endif</span>
                                       </div>
                                    @endif
                                </p>
                                @else
                                <p class="card-text">
                                    Original Price:
                                     {{ $product['product_price'] }}
                                </p>
                                @endif
                                <p class="card-text">Quantity: {{ $product['product_qty'] }}</p>
                                <p class="card-text">Total Price:
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
                                </p>
                                <!-- Add other fields as needed -->
                                @if(Auth::guard('admin')->user()->type!="vendor")
                                @if($product['vendor_id']>0)
                                    <p class="card-text">Product by: <a target="_blank" href="/admin/vendors/details/{{$product['vendor_id']}}">Vendor</a></p>
                                @else
                                    <p class="card-text">Product by: Admin</p>
                                @endif
                            @endif

                            @if($product['vendor_id']>1)
                                @php $getVendorCommission=Vendor::getVendorCommission($product['vendor_id']); @endphp
                                <p class="card-text">Commission: {{$commission= round($total_price * $getVendorCommission/100,2)}} Birr</p>
                                <p class="card-text">Final Amount: {{$total_price-$commission }} Birr</p>
                            @else
                                <p class="card-text">Commission: 0</p>
                                <p class="card-text">Final Amount: {{$total_price}}</p>
                            @endif
                            @if($product['item_status']==="Completed")
                            <p class="text-lg p-2 btn-success shadow-none text-white text-center rounded w-100">Order item completed successfully!</p>
                            @else
                            @if ($user && $user->hasPermissionByRole('update_order_item_status'))
                                <form action="{{ url('admin/update-order-item-status') }}" method="post">
                                @csrf
                                    <input type="hidden" name="order_item_id" value="{{ $product['id'] }}">
                                    <select name="order_item_status" id="order_item_status" class="form-control mb-2" required="">
                                        <option value="">Select</option>
                                        @foreach ($orderItemStatus as $status)
                                        <option value="{{ $status['name'] }}" @if(!empty($product['item_status']) && $product['item_status']==$status['name']) selected="" @endif>{{ $status['name'] }}</option>
                                        @endforeach
                                    </select>
                                    <input type="number" name="vendor_code" style="display: none;" class="form-control item_courier_names mb-2" placeholder="Enter Vendor Code">
                                    <input type="text" name="item_courier_name" style="display: none;"  class="form-control item_courier_name mb-2" placeholder="Item Courier Name" @if(!empty($product['item_courier_name'])) value="{{ $product['courier_name'] }}" @endif>
                                    <input type="text" name="item_tracking_number" style="display: none;"  class="form-control item_tracking_number mb-2" placeholder="Item Tracking Number">
                                    <input class="ml-2 btn btn-primary text-white " type="submit" value="Update Order Status">
                                </form>
                            @endif
                            @endif
                            </div>
                        </div>
                    </div>
                    </div>
                </div>
                @endforeach
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

        $(".item_courier_name").hide();
        $(".item_tracking_number").hide();
        $("#order_item_status").on("change", function() {
            if (this.value=="Picked") {
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

