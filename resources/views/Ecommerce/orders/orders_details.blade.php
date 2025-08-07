<?php  use App\Models\Product;
       use App\Models\Order;
       $getOrderStatus=Order::getOrderStatus($orderDetails['id']);
       $checkorderproductavailable=Order::checkOrderProductAvalible($orderDetails['id']);
     ?>
@extends('all_frontend_layouts.layouts')
@section('content')

<div class="container my-2">
    <div class="header">
        <button class="btn btn-link text-dark" onclick="history.back()">
            <i class="bi bi-arrow-left"></i>
        </button>
        <h5 class="my-4 text-dark text-center">Order detail</h5>
    </div>
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

    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm rounded-3">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center p-3">
                    <strong>Order Details</strong>
                    <span class="badge bg-light text-dark">#{{ $orderDetails['order_code'] }}</span>
                </div>

                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-md-6">
                            @if($orderDetails['order_code'])
                            <p><strong>Delivery Code:</strong> {{ $orderDetails['order_code'] }}</p>
                            <div class="mb-2">
                                {!! QrCode::size(100)->generate($orderDetails['order_code']) !!}
                            </div>
                            @endif

                        </div>
                        <div class="col-md-6">
                            <div class="d-flex justify-content-between py-2 border-bottom">
                                <span class="text-muted">Date:</span>
                                <span>{{ \Carbon\Carbon::parse($orderDetails['created_at'])->format('d M Y, h:i A') }}</span>
                            </div>

                            <div class="d-flex justify-content-between py-2 border-bottom">
                                <span class="text-muted">Status:</span>
                                <span class="badge bg-secondary text-white">{{ $orderDetails['order_status'] }}</span>
                            </div>

                            <div class="d-flex justify-content-between py-2 border-bottom">
                                <span class="text-muted">Total:</span>
                                <span>{{ App\Helper\Helper::currency_converter($orderDetails['grand_total']) }}</span>
                            </div>

                            <div class="d-flex justify-content-between py-2 border-bottom">
                                <span class="text-muted">Shipping:</span>
                                <span>{{ App\Helper\Helper::currency_converter($orderDetails['shipping_charges']) }}</span>
                            </div>

                            <div class="d-flex justify-content-between py-2 border-bottom">
                                <span class="text-muted">Tax:</span>
                                <span>{{ App\Helper\Helper::currency_converter($orderDetails['tax_charge']) }}</span>
                            </div>

                            @if($orderDetails['coupon_code'])
                            <div class="d-flex justify-content-between py-2 border-bottom">
                                <span class="text-muted">Coupon:</span>
                                <span>{{ $orderDetails['coupon_code'] }}</span>
                            </div>
                            <div class="d-flex justify-content-between py-2 border-bottom">
                                <span class="text-muted">Discount:</span>
                                <span>{{ App\Helper\Helper::currency_converter($orderDetails['coupon_amount']) }}</span>
                            </div>
                            @endif

                            @if($orderDetails['courier_name'])
                            <div class="d-flex justify-content-between py-2 border-bottom">
                                <span class="text-muted">Courier:</span>
                                <span>{{ $orderDetails['courier_name'] }}</span>
                            </div>
                            <div class="d-flex justify-content-between py-2 border-bottom">
                                <span class="text-muted">Tracking #:</span>
                                <span>{{ $orderDetails['tracking_number'] }}</span>
                            </div>
                            @endif

                            <div class="d-flex justify-content-between py-2">
                                <span class="text-muted">Payment:</span>
                                <span>{{ $orderDetails['payment_method'] }}</span>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>

        {{-- Delivery Address --}}
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm rounded-3">
                <div class="card-header bg-primary text-white p-3">
                    <strong>Delivery Address</strong>
                </div>

                <div class="card-body p-3">
                    <div class="d-flex justify-content-between py-2 border-bottom">
                        <span class="text-muted">Name:</span>
                        <span>{{ $orderDetails['name'] }}</span>
                    </div>

                    <div class="d-flex justify-content-between py-2 border-bottom">
                        <span class="text-muted">Email:</span>
                        <span>{{ $orderDetails['email'] }}</span>
                    </div>

                    <div class="d-flex justify-content-between py-2 border-bottom">
                        <span class="text-muted">Address:</span>
                        <span>{{ $orderDetails['address'] }}</span>
                    </div>

                    <div class="d-flex justify-content-between py-2 border-bottom">
                        <span class="text-muted">City:</span>
                        <span>{{ $orderDetails['city'] }}</span>
                    </div>

                    <div class="d-flex justify-content-between py-2 border-bottom">
                        <span class="text-muted">State:</span>
                        <span>{{ $orderDetails['state'] }}</span>
                    </div>

                    <div class="d-flex justify-content-between py-2 border-bottom">
                        <span class="text-muted">Country:</span>
                        <span>{{ $orderDetails['country'] }}</span>
                    </div>

                    <div class="d-flex justify-content-between py-2">
                        <span class="text-muted">Mobile:</span>
                        <span>{{ $orderDetails['mobile'] }}</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            @session('success')
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
            </div>
            @endsession
              @session('error')
            <div class="alert alert-error alert-dismissible fade show" role="alert">
                {{ session('error') }}
            </div>
            @endsession
            @if($checkorderproductavailable)
            @if($getOrderStatus === "delivered")
            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#return_request">
                Return Request
            </button>
            <div class="modal fade" id="return_request" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
                <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalTitleId">
                                Return Request
                            </h5>
                            <button type="button" class="btn-close btn" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form method="POST" action="{{ url('ecommerce/orders/'.$orderDetails['id'].'/return') }}">
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

                                        @if($isReturnable && $daysSinceDelivery <= $returnableDate && $productStatus !="Return Initiated" ) <option value="{{ $product['product_code'] }}--{{ $product['product_size'] }}">
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

                                <button type="submit" class="btn btn-primary">Submit Return Request</button>
                            </form>
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


            @endif
            @if($getOrderStatus == "new")
            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#reason">
                Cancellation Reason
            </button>
            <div class="modal fade" id="reason" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
                <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalTitleId">
                                Cancellation Reason
                            </h5>
                            <button type="button" class="btn-close btn" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form method="POST" action="{{ url('ecommerce/orders/'.$orderDetails['id'].'/cancel') }}">
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
                    <img src="{{ asset('storage/'.\App\Models\Product::getProductImage($product['product_id']))??asset('restaurant_frontend/default-image.png') }}" class="img-fluid mb-2" style="max-height: 80px;">
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
    $(document).ready(function() {
        $(document).on('click', '.btnCancelOrder', function() {
            var reason = $("#cancelReason").val();
            if (reason == "") {
                alert("Please select Reason for canceling the Order");
                return false;
            }
            var result = confirm("Want to cancel this Order?");
            if (!result) {
                return false;
            }
        });

        $(document).on('click', '.btnReturnOrder', function() {
            var reason = $("#returnReason").val();
            var product = $("#returnProduct").val();
            if (product == "") {
                alert("Please select Product you want to return");
                return false;
            }
            if (reason == "") {
                alert("Please select Reason for return the Order");
                return false;
            }
            var result = confirm("Want to return this Order?");
            if (!result) {
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

