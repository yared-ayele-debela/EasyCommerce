<link href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<!------ Include the above in your HEAD tag ---------->

<div class="container">
    <div class="row">
        <div class="col-xs-12">
    		<div class="invoice-title">
                <h1 style="text-align: center; padding:10px; 0px;" ><strong>Delivery Note</strong> </h1>

    			<h2>Invoice </h2><h3 class="pull-right">Order # {{ $orderDetails['id'] }}</h3>
				<?php echo DNS1D::getBarcodeHTML($orderDetails['id'], 'C39');
				?>
    		</div>
    		<hr>
    		<div class="row">
    			<div class="col-xs-6">
    				<address>
    				<strong>Billed To:</strong><br>
    					{{$userDetails['name']}} <br>
                        @if(!empty($userDetails['address']))
                          {{$userDetails['address']}} <br>
                        @endif
                        @if(!empty($userDetails['city']))
    					  {{$userDetails['city']}} <br>
                        @endif
                        @if(!empty($userDetails['state']))
    					{{$userDetails['state']}} <br>
                        @endif
                        @if(!empty($userDetails['country']))
    					{{$userDetails['country']}} <br>
                        @endif
                        @if(!empty($userDetails['pincode']))
    					{{$userDetails['pincode']}} <br>
                        @endif
                        @if(!empty($userDetails['mobile']))
    					{{$userDetails['mobile']}} <br>
                        @endif
    				</address>
    			</div>
    			<div class="col-xs-6 text-right">
    				<address>
        			<strong>Shipped To:</strong><br>
                    {{$orderDetails['name']}} <br>
                    {{$orderDetails['address']}} <br>
                    {{$orderDetails['city']}},
                    {{$orderDetails['state']}} <br>
                    {{$orderDetails['country']}}-{{$orderDetails['pincode']}} <br>
                    {{$orderDetails['mobile']}} <br>
    				</address>
    			</div>
    		</div>
    		<div class="row">
    			<div class="col-xs-6">
    				<address>
    					<strong>Payment Method:</strong><br>
    					{{ $orderDetails['payment_method'] }}
						<br>
    				</address>
    			</div>
    			<div class="col-xs-6 text-right">
    				<address>
    					<strong>Order Date:</strong><br>
    					{{ $orderDetails['created_at'] }}
    				</address>
    			</div>
    		</div>
    	</div>
    </div>

    <div class="row">
    	<div class="col-md-12">
    		<div class="">
    			<div class="">
    				<h3 class="panel-title"><strong>Order summary</strong></h3>
    			</div>
    			<div class="">
    				<div class="table-responsive">
    					<table class="table table-borderless">
    						<thead>
                                <tr>
        							<td><strong>Product Code</strong></td>
        							<td class="text-center"><strong>Size</strong></td>
        							<td class="text-center"><strong>Color</strong></td>
        							<td class="text-right"><strong>Price</strong></td>
									<td class="text-right"><strong>Quantity</strong></td>
									<td class="text-right"><strong>Totals</strong></td>
                                </tr>
    						</thead>
    						<tbody>
								@php $subTotal= 0 @endphp
    						   @foreach ($orderDetails['orders_products'] as $product )
    							<tr>
    								<td>{{ $product['product_code'] }}
										<?php echo DNS1D::getBarcodeHTML($product['product_code'], 'C39');?>
									</td>
    								<td class="text-center">{{ $product['product_size'] }}</td>
    								<td class="text-center">{{ $product['product_color'] }}</td>
    								<td class="text-right">
										{{ $product['product_price'] }} Birr
									</td>
									<td class=" text-right">
										{{ $product['product_qty'] }}
									</td>
									<td class=" text-right">
										{{ $product['product_price']*$product['product_qty'] }} Birr
									</td>
    							</tr>
								@php $subTotal=$subTotal+($product['product_price']*$product['product_qty']) @endphp

								@endforeach

    							<tr>
    								<td class="no-line"></td>
    								<td class="no-line"></td>
									<td class="no-line"></td>
    								<td class="no-line"></td>
    								<td class="no-line text-right"><strong>Subtotal</strong></td>
    								<td class="no-line text-right">{{ $subTotal }} Birr</td>
    							</tr>
    							<tr>
    								<td class="no-line"></td>
    								<td class="no-line"></td>
									<td class="no-line"></td>
    								<td class="no-line"></td>
    								<td class="no-line text-right"><strong>Shipping Charges</strong></td>
    								<td class="no-line text-right">{{ $orderDetails['shipping_charges'] }} Birr</td>
    							</tr>
                                <tr>
    								<td class="no-line"></td>
    								<td class="no-line"></td>
									<td class="no-line"></td>
    								<td class="no-line"></td>
    								<td class="no-line text-right"><strong>Tax Charges</strong></td>
    								<td class="no-line text-right">{{ $orderDetails['tax_charge'] }} Birr</td>
    							</tr>
    							<tr>
									<td class="no-line"></td>
    								<td class="no-line"></td>
									<td class="no-line"></td>
    								<td class="no-line"></td>
    								<td class="no-line text-right"><strong>Total</strong></td>
    								<td class="no-line text-right"><strong> {{ $orderDetails['grand_total'] }} Birr</strong>
									<br>
									@if($orderDetails['payment_method']=="COD")
									<font color=red>(Alread Paid)</font>
									@endif
									</td>
    							</tr>
                                <tr>
                                     <td>
                                         {{-- <p><b>#</b> : {{ $orderDetails['delivery_boy']['id'] }} <b>Delivered by</b> : {{ $orderDetails['delivery_boy']['first_name'] }} {{ $orderDetails['delivery_boy']['last_name'] }} <b> phone number : </b>{{ $orderDetails['delivery_boy']['phone'] }}</p> --}}
                                     </td>
                                </tr>
    						</tbody>

    					</table>
    				</div>
    			</div>
    		</div>
    	</div>
    </div>
</div>
