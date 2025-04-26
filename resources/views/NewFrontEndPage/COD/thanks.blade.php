@extends('all_frontend_layouts.layouts')
@section('content')
@php
$grand_total = App\Helper\Helper::currency_converter(Session::get('grand_total'));
$order_id = Session::get('order_id');
@endphp
<div class="py-3">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-10">
                <div class="offer-card shadow rounded-3 border">
                    <div class="card-body py-5 text-center">
                        <h3 class="text-uppercase fw-bold text-primary mb-4">
                            Your Order Has Been Placed Successfully
                        </h3>
                        <p class="fs-5 fw-semibold text-dark">
                            Your Order ID is
                            <span class="text-primary">{{ Session::get('order_id') }}</span>
                            and the Grand Total is
                            <span class="text-primary"><strong>{{ $grand_total }}</strong></span>.
                        </p>
                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ url('/ecommerce') }}" class="btn btn-outline-primary px-3">
                                <i class="bi bi-arrow-left"></i> Back to Shop
                            </a>
                            <a href="{{ url('ecommerce/orders/'.encrypt($order_id)) }}" class="btn btn-primary px-3">
                                <i class="bi bi-eye-fill"></i> View Your Order
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
