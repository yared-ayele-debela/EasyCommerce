
@extends('admindashboard.maindashboard')
@php
$user = Auth::guard('admin')->user();
@endphp
@section('dashboard')
<div class="pagetitle bg-light mb-3">
    <h1 class="breadcrumb-item font-weight-bold"><a href="javascript:void(0);">Transaction #{{ $transaction['id'] }} Details</a></h1>
    <a href="{{ url('admin/transactions/all-transactions') }}" class=" link-primary ">Back to Transactions</a>
</div>
<section class="section ">
    <div class="row">
        <div class="col-lg-5">
            <div class="card shadow-sm border-0">
                <div class="card-body bg-light m-3 pt-1">
                    <h1 class=" card-title"> <b>Transaction Details</b> </h1>
                    <div class="col-md-8 pt-1">
                        <label for="" class="form-label"><b>ID:</b></label>
                        <label for="">{{ $transaction['id'] }} </label>
                    </div>
                    <div class="col-md-8 pt-1">
                        <label for="" class="form-label"><b>Order ID:</b></label>
                        <label for="">{{ $transaction['order_id'] }}</label>
                    </div>
                    <div class="col-md-8 pt-1">
                        <label for="" class="form-label"><b>Payment Status:</b></label>
                        <label for="">
                            @if($transaction['payment_status'])
                            <div class="btn-primary text-white px-2 rounded">
                                {{ $transaction['payment_status'] }}
                             </div>
                            @endif
                        </label>
                    </div>
                    <div class="col-md-8 pt-1">
                        <label for="" class="form-label"><b>Payment Amount:</b></label>
                        <label for="">{{ $transaction['amount'] }} Birr</label>
                    </div>

                    <div class="col-md-8 pt-1">
                        <label for="" class="form-label"><b>Payment Date:</b></label>
                        <label for="">{{ $transaction['created_at'] }}</label>
                    </div>

                    <div class="col-md-8 pt-1">
                        <label for="" class="form-label"><b>Payment Method:</b></label>
                        <label for="">{{ $transaction['order']['payment_method'] }}</label>
                    </div>
                    <div class="col-md-8 pt-1">
                        <label for="" class="form-label"><b>Payment Gateway:</b></label>
                        <label for="">{{ $transaction['order']['payment_gateway'] }}</label>
                    </div>
                    <hr>


                @if ($user && $user->hasPermissionByRole('edit transaction'))
                    <h1 class="card-title mb-2">Update Payment Amount</h1>
                        <form action="{{ url('admin/update-transaction-amount') }}" class="d-flex flex-column" method="post">
                            @csrf
                            <input type="hidden" name="id" value="{{ $transaction['id'] }}">
                            <div class="form-group mb-2">
                                <input type="text" name="amount" class="form-control" value="{{ $transaction['amount'] }}" id="amount" placeholder="payment amount">
                            </div>

                            <input class="btn btn-primary  mb-2" type="submit" value="Update Payment Amount">
                        </form>
                    <br>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-lg-7">
            <div class="card shadow-sm border-0">
                <div class="card-body bg-light m-3 pt-1">
                    <h1 class=" card-title">Customer Details</h1>
                    <div class="col-md- pt-1">
                        <label for="" class="form-label"><b>Name:</b></label>
                        <label for="">{{ $transaction['order']['name'] }}</label>
                    </div>
                    @if(!empty($transaction['order']['address']))
                    <div class="col-md- pt-1">
                        <label for="" class="form-label"><b>Address:</b></label>
                        <label for="">{{ $transaction['order']['address'] }}</label>
                    </div>
                    @endif
                    @if(!empty($transaction['order']['city']))
                    <div class="col-md- pt-1">
                        <label for="" class="form-label"><b>City:</b></label>
                        <label for="">{{ $transaction['order']['city'] }}</label>
                    </div>
                    @endif
                    @if(!empty($transaction['order']['state']))
                    <div class="col-md- pt-1">
                        <label for="" class="form-label"><b>State:</b></label>
                        <label for="">{{ $transaction['order']['state'] }}</label>
                    </div>
                    @endif
                    @if(!empty($transaction['order']['country']))
                    <div class="col-md- pt-1">
                        <label for="" class="form-label"><b>Country:</b></label>
                        <label for="">{{ $transaction['order']['country'] }}</label>
                    </div>
                    @endif

                    @if(!empty($transaction['order']['mobile']))
                    <div class="col-md- pt-1">
                        <label for="" class="form-label"><b>Mobile:</b></label>
                        <label for="">{{ $transaction['order']['mobile'] }}</label>
                    </div>
                    @endif
                    @if(!empty($transaction['order']['email']))
                    <div class="col-md- pt-1">
                        <label for="" class="form-label"><b>Email:</b></label>
                        <label for="">{{ $transaction['order']['email'] }}</label>
                    </div>
                    @endif

                    <hr class=" hr pt-0 mt-4">
                    <h1 class="card-title pt-4 ">Order Details</h1>
                    <div class="col-md-8 pt-3">
                        <div class="col-md- pt-1">
                            <label for="" class="form-label"><b>ID:</b></label>
                            <label for="">{{ $transaction['order']['id'] }}</label>
                        </div>
                        @if(!empty($transaction['order']['order_code']))
                        <div class="col-md- pt-1">
                            <label for="" class="form-label"><b>Order Code:</b></label>
                            <label for="">{{ $transaction['order']['order_code'] }}</label>
                        </div>
                        @endif
                        @if(!empty($transaction['order']['order_status']))
                        <div class="col-md- pt-1">
                            <label for="" class="form-label"><b>Order status:</b></label>
                            <label for="">{{ $transaction['order']['order_status'] }}</label>
                        </div>
                        @endif
                        @if(!empty($transaction['order']['payment_method']))
                        <div class="col-md- pt-1">
                            <label for="" class="form-label"><b>Payment Method:</b></label>
                            <label for="">{{ $transaction['order']['payment_method'] }}</label>
                        </div>
                        @endif
                        @if(!empty($transaction['order']['payment_gateway']))
                        <div class="col-md- pt-1">
                            <label for="" class="form-label"><b>Payment Gateway:</b></label>
                            <label for="">{{ $transaction['order']['payment_gateway'] }}</label>
                        </div>
                        @endif
                        @if(!empty($transaction['order']['created_at']))
                        <div class="col-md- pt-1">
                            <label for="" class="form-label"><b>Order Date:</b></label>
                            <label for="">{{ $transaction['order']['created_at'] }}</label>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

