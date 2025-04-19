<?php  use App\Models\Product;
       use App\Models\Order;
       $getOrderStatus=Order::getOrderStatus($orderDetails['id']);
       $checkorderproductavailable=Order::checkOrderProductAvalible($orderDetails['id']);
     ?>
@extends('all_frontend_layouts.layouts')
@section('content')

<div class="container-fluid my-2">
    <div class="header">
        <button class="btn btn-link text-dark" onclick="history.back()">
            <i class="bi bi-arrow-left"></i>
        </button>
        <h5 class="my-4 text-dark text-center">Order detail</h5>
    </div>
    {{-- Order Actions --}}
    

    {{-- Return Status Modal --}}
    @if($check_return_order)
        <button type="button" class="btn btn-outline-primary mb-4" data-bs-toggle="modal" data-bs-target="#returnStatusModal">
            View Return Status
        </button>

        <div class="modal fade" id="returnStatusModal" tabindex="-1">
            <div class="modal-dialog modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-body">
                        @foreach($return_order as $order)
                            <div class="mb-3 border-bottom pb-2">
                                <strong>Order ID:</strong> {{ $order->order_id }} <br>
                                <strong>Product:</strong> {{ $order->product_code }} <br>
                                <strong>Size:</strong> {{ $order->product_size }} <br>
                                <strong>Status:</strong>
                                <span class="badge bg-success">{{ $order->return_status }}</span>
                            </div>
                        @endforeach
                    </div>
                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- Order Overview --}}
    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white p-3">
                    <strong>Order Details</strong>
                    <span class="float-end">#{{ $orderDetails['order_code'] }}</span>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"><strong>Date:</strong> {{ $orderDetails['created_at'] }}</li>
                        <li class="list-group-item"><strong>Status:</strong> {{ $orderDetails['order_status'] }}</li>
                        <li class="list-group-item"><strong>Total:</strong> {{ App\Helper\Helper::currency_converter($orderDetails['grand_total']) }}</li>
                        <li class="list-group-item"><strong>Shipping:</strong> {{ App\Helper\Helper::currency_converter($orderDetails['shipping_charges']) }}</li>
                        <li class="list-group-item"><strong>Tax:</strong> {{ App\Helper\Helper::currency_converter($orderDetails['tax_charge']) }}</li>
                        @if($orderDetails['coupon_code'])
                            <li class="list-group-item"><strong>Coupon:</strong> {{ $orderDetails['coupon_code'] }}</li>
                            <li class="list-group-item"><strong>Discount:</strong> {{ App\Helper\Helper::currency_converter($orderDetails['coupon_amount']) }}</li>
                        @endif
                        @if($orderDetails['courier_name'])
                            <li class="list-group-item"><strong>Courier:</strong> {{ $orderDetails['courier_name'] }}</li>
                            <li class="list-group-item"><strong>Tracking #:</strong> {{ $orderDetails['tracking_number'] }}</li>
                        @endif
                        <li class="list-group-item"><strong>Payment:</strong> {{ $orderDetails['payment_method'] }}</li>
                    </ul>
                </div>
            </div>
        </div>

        {{-- Delivery Address --}}
        <div class="col-md-6 mb-4">
            <div class="offer-card">
                <div class="card-header bg-primary text-white p-3">
                    <strong>Delivery Address</strong>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"><strong>Name:</strong> {{ $orderDetails['name'] }}</li>
                        <li class="list-group-item"><strong>Email:</strong> {{ $orderDetails['email'] }}</li>
                        <li class="list-group-item"><strong>Address:</strong> {{ $orderDetails['address'] }}</li>
                        <li class="list-group-item"><strong>City:</strong> {{ $orderDetails['city'] }}</li>
                        <li class="list-group-item"><strong>State:</strong> {{ $orderDetails['state'] }}</li>
                        <li class="list-group-item"><strong>Country:</strong> {{ $orderDetails['country'] }}</li>
                        <li class="list-group-item"><strong>Mobile:</strong> {{ $orderDetails['mobile'] }}</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            @if($checkorderproductavailable)
            @if($getOrderStatus == "Delivered")
            <div class="mb-4">
                <button class="btn btn-success" id="toggleReturnForm">Open Product Return Form</button>
                <div id="returnForm" class="mt-3 card shadow-sm d-none">
                    <div class="card-body">
                        <form method="POST" action="{{ url('admin/orders/'.$orderDetails['id'].'/return') }}">
                            @csrf
                            <div class="form-group mb-3">
                                <label for="returnProduct">Select Product</label>
                                <select class="form-control select2" name="product_info[]" multiple required>
                                    @foreach($orderDetails['orders_products'] as $product)
                                        @php
                                            $productModel = \App\Models\Product::find($product['product_id']);
                                            $isReturnable = $productModel?->is_returnable;
                                            $returnableDate = $productModel?->returnable_time;
                                            $productStatus = $product['item_status'];
                                            $deliveryDate = $product['created_at'];
                                            $daysSinceDelivery = now()->diffInDays($deliveryDate);
                                        @endphp

                                        @if($isReturnable && $daysSinceDelivery <= $returnableDate && $productStatus != "Return Initiated")
                                            <option value="{{ $product['product_code'] }}--{{ $product['product_size'] }}">
                                                {{ $product['product_code'] }} -- {{ $product['product_size'] }}
                                            </option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group mb-3">
                                <label for="returnReason">Return Reason</label>
                                <select name="return_reason" class="form-control" required>
                                    <option value="">Select Reason</option>
                                    <option value="Performance or quality not adequate">Performance or quality not adequate</option>
                                    <option value="Product damaged, but shipping box OK">Product damaged, but shipping box OK</option>
                                    <option value="Item arrived too late">Item arrived too late</option>
                                    <option value="Wrong Item was sent">Wrong Item was sent</option>
                                    <option value="Item defective or doesn't work">Item defective or doesn't work</option>
                                </select>
                            </div>

                            <div class="form-group mb-3">
                                <label for="comment">Comment</label>
                                <textarea name="comment" class="form-control" rows="3"></textarea>
                            </div>

                            <button type="submit" class="btn btn-success">Submit Return Request</button>
                        </form>
                    </div>
                </div>
            </div>
        @endif

        @if($getOrderStatus == "New")
            <div class="mb-4">
                <div class="offer-card">
                    <div class="card-body">
                        <form method="POST" action="{{ url('admin/orders/'.$orderDetails['id'].'/cancel') }}">
                            @csrf
                            <div class="form-group mb-3">
                                <label for="cancelReason" class=" form-label"> Cancellation Reason</label>
                                <select name="reason" class="form-control" required>
                                    <option value="">Select Reason</option>
                                    <option value="Order Created by Mistake">Order Created by Mistake</option>
                                    <option value="Item Not Arrive on Time">Item Not Arrive on Time</option>
                                    <option value="Shipping Cost too High">Shipping Cost too High</option>
                                    <option value="Found Cheaper Somewhere Else">Found Cheaper Somewhere Else</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-danger rounded rounded-1">Cancel Order</button>
                        </form>
                    </div>
                </div>
            </div>
        @endif
        @endif
        </div>
    </div>
    <hr>
    <h4 class="text-muted">Order Products</h4>
    <div class="row">

        @foreach ($orderDetails['orders_products'] as $product)
        <div class="col-md-2 col-6 mb-2">
            <div class="offer-card h-100 text-center">
                <div class="card-body p-2">
                    <img src="{{ asset('/storage/products/' . \App\Models\Product::getProductImage($product['product_id'])) }}" class="img-fluid mb-2" style="max-height: 80px;">
                    <h6>{{ $product['product_name'] }}</h6>
                    <p class="mb-1">
                        Code: {{ $product['product_code'] }}<br>
                        Size: {{ $product['product_size'] }}, Color: {{ $product['product_color'] }}
                    </p>
                    <span class="badge bg-light text-dark">Qty: {{ $product['product_qty'] }}</span>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

@endsection

@section('script')
    <script>
        $(document).ready(function(){
            $(document).on('click','.btnCancelOrder',function (){
                var reason=$("#cancelReason").val();
                if(reason==""){
                    alert("Please select Reason for canceling the Order");
                    return false;
                }
               var result=confirm("Want to cancel this Order?");
               if(!result){
                   return false;
               }
            });

            $(document).on('click','.btnReturnOrder',function (){
                var reason=$("#returnReason").val();
                var product=$("#returnProduct").val();
                if(product==""){
                    alert("Please select Product you want to return");
                    return false;
                }
                if(reason==""){
                    alert("Please select Reason for return the Order");
                    return false;
                }
                var result=confirm("Want to return this Order?");
                if(!result){
                    return false;
                }
            });
        });


    var toggleButton = document.getElementById('toggleButton');
    var content = document.getElementById('content');

    toggleButton.addEventListener('click', function() {
        if (content.style.display === 'none') {
        content.style.display = 'block';
        } else {
        content.style.display = 'none';
        }
    });
    </script>
@endsection
