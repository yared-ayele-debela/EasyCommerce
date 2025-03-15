<?php  use App\Models\Product;
       use App\Models\Order;
       $getOrderStatus=Order::getOrderStatus($orderDetails['id']);
       $checkorderproductavailable=Order::checkOrderProductAvalible($orderDetails['id']);
     ?>
@extends('fontend.layout.layout')
@section('content')

<div class="page-about u-s-p-t-80">
    <div class="container">
        <div class="row">
            <div class="container mt-5">
                <div class="col-md-12 pb-3">
                    @if($checkorderproductavailable)
                    @if($getOrderStatus=="Delivered")

                    <button id="toggleButton" class="btn text-white mb-2  mr-4" style="background-color:#1E665E;"> Open Product Return Form</button>
                    <div class="row justify-content-start pr-3">
                        <div class="col-md-4 col-lg-4">
                            <div id="content" class="card border-0 shadow-sm" style="display: none;">
                              <div class="card-body">
                                <form method="POST" action="{{url('admin/orders/'.$orderDetails['id'].'/return')}}">
                                  @csrf
                                  <div class="form-group">
                                    <label for="returnProduct">Select Product</label>
                                    <select class="form-control select2" name="product_info[]" id="returnProduct" multiple>
                                        @foreach($orderDetails['orders_products'] as $product)
                                        @php
                                            $productModel = Product::findOrFail($product['product_id']);
                                            $isReturnable = $productModel->is_returnable;
                                            $returnableDate = $productModel['returnable_time'];
                                            $productStatus = $product['item_status'];

                                            $deliveryDate = $product['created_at'];
                                            $currentDate = now();
                                            $daysSinceDelivery = $currentDate->diffInDays($deliveryDate);
                                        @endphp

                                        @if($isReturnable && $daysSinceDelivery <= $returnableDate && $productStatus != "Return Initiated")
                                            <option value="{{ $product['product_code'] }}--{{ $product['product_size'] }}">
                                                {{ $product['product_code'] }}--{{ $product['product_size'] }}
                                            </option>
                                        @endif
                                    @endforeach

                                    </select>
                                  </div>

                                  <div class="form-group">
                                    <label for="comment">Comment:</label>
                                    <textarea name="comment" class="form-control" rows="3" id="comment"></textarea>
                                  </div>

                                  <div class="form-group">
                                    <label for="returnReason">Return Reason</label>
                                    <select name="return_reason" class="form-control select2" id="returnReason" required>
                                      <option value="">Select Reason</option>
                                      <option value="Performance or quality not adequate">Performance or quality not adequate</option>
                                      <option value="Product damaged, but shipping box OK">Product damaged, but shipping box OK</option>
                                      <option value="Item arrived too late">Item arrived too late</option>
                                      <option value="Wrong Item was sent">Wrong Item was sent</option>
                                      <option value="Item defective or doesn't work">Item defective or doesn't work</option>
                                    </select>
                                  </div>

                                  <div class="text-left">
                                    <button type="submit" class="btn text-white mb-2" style="background-color:#1E665E;">Return Order</button>
                                  </div>
                                </form>
                              </div>
                            </div>
                          </div>
                    </div>
                    @endif
                    @endif

                    @if($getOrderStatus=="New")
                    <div class="row justify-content-end pr-3">
                        <div class="col-md-6 col-lg-4 shadow-sm p-3">
                            <form method="POST" action="{{url('admin/orders/'.$orderDetails['id'].'/cancel')}}">
                                @csrf
                                <div class="form-group">
                                    <label for="cancelReason">Cancellation Reason</label>
                                    <select name="reason" class="form-control" id="cancelReason" required>
                                        <option value="">Select Reason</option>
                                        <option value="Order Created by Mistake">Order Created by Mistake</option>
                                        <option value="Item Not Arrive on Time">Item Not Arrive on Time</option>
                                        <option value="Shipping Cost too High">Shipping Cost too High</option>
                                        <option value="Found Cheaper Somewhere Else">Found Cheaper Somewhere Else</option>
                                        <option value="Other">Other</option>
                                    </select>
                                </div>
                                <div class="mt-3">
                                    <button type="submit" class="btn text-white btnReturnOrder" style="background-color:#1E665E;">Return Order</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>



    <div class="container shadow-sm mb-2">
        @if($check_return_order)
        <button type="button" class="btn mt-2   mb-1" style="background-color:#1E665E;color:white;" data-toggle="modal" data-target="#status">
            View Your Return Status
        </button>

        <!-- Modal -->
        <div class="modal fade" id="status" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
            <div class="modal-content">

                <div class="modal-body border-0">
                 <p>
                 @foreach ($return_order as $order )

                <b>Order ID &nbsp;{{ $order->order_id }} &nbsp;</b>
                 </p>
                    <p>
                        Product code : {{ $order->product_code }}
                    </p>
                    <p>
                        Product Size : {{ $order->product_size }}
                    </p>
                 <div class="d-flex">
                    <p>Status :</p> &nbsp;
                    <div class="btn btn-sm" style="background-color:#1E665E;color:white;">
                    {{ $order->return_status }}
                     </div>
                 </div>
                 @endforeach


                </div>
                <div class="modal-footer border-0" style="margin-top: -20px;">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
            </div>
        </div>
        @endif
        <div class="row">
            <div class="col-md-6 mt-5">
                <div class="card border-0">
                    <div class="card-header border-0 " style="background-color:#E7F2F1;color:white;">
                        <h5 class="card-title mb-0">Order Details  &nbsp; <span class=" float-end"><b>Delivery Code  # {{ $orderDetails['order_code'] }}</b></span> </h5>
                    </div>
                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                        <li class="list-group-item"><strong>Order Date :</strong> {{ date('Y-m-d h:i:s', strtotime($orderDetails['created_at'])) }}</li>
                        <li class="list-group-item"><strong>Order Status :</strong> {{ $orderDetails['order_status'] }}</li>
                        <li class="list-group-item"><strong>Order Total :</strong> {{  App\Helper\Helper::currency_converter($orderDetails['grand_total']) }}</li>
                        <li class="list-group-item"><strong>Shipping Charges :</strong>{{  App\Helper\Helper::currency_converter($orderDetails['shipping_charges']) }}</li>
                        <li class="list-group-item"><strong>Tax Charges :</strong> {{  App\Helper\Helper::currency_converter($orderDetails['tax_charge']) }}</li>
                        @if($orderDetails['coupon_code']!="")
                        <li class="list-group-item"><strong>Coupon Code:</strong> {{ $orderDetails['coupon_code'] }}</li>
                        <li class="list-group-item"><strong>Coupon Amount: </strong>{{  App\Helper\Helper::currency_converter($orderDetails['coupon_amount']) }}</li>
                        @endif
                        @if($orderDetails['courier_name']!="")
                        <li class="list-group-item"><strong>Courier Name : </strong> {{ $orderDetails['courier_name'] }}</li>
                        <li class="list-group-item"><strong>Tracking Number : </strong> {{ $orderDetails['tracking_number'] }}</li>
                        @endif
                        <li class="list-group-item"><strong>Payment Method : </strong> {{ $orderDetails['payment_method'] }}</li>
                            <!-- Add other order details here -->
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mt-5">
                <div class="card border-0">
                    <div class="card-header border-0 " style="background-color:#E7F2F1;color:white;">
                        <h5 class="card-title mb-0">Delivery Address</h5>
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
        </div>

        <div class="row pb-3">
            @foreach ($orderDetails['orders_products'] as $product)
            <div class="col-md-2">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <img src="{{ asset('/storage/products/' . Product::getProductImage($product['product_id'])) }}" class="card-img-top" alt="Product 1" style="max-width: 60px;">

                        <h5 class="card-title"><strong>{{ $product['product_name'] }}</strong></h5>
                        <p class="card-text">
                            <small>Code: {{ $product['product_code'] }}</small><br>
                            <small>Size: {{ $product['product_size'] }}, Color: {{ $product['product_color'] }}</small>
                        </p>
                        <span class="badge badge-pill border" style="background-color:rgb(245,249,255);color:black;">{{ $product['product_qty'] }}</span>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
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
