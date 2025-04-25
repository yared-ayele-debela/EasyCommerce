@extends('all_frontend_layouts.layouts')
@section('content')
@php
$grand_total = App\Helper\Helper::currency_converter(Session::get('grand_total'));
@endphp
<div class="py-3">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-10 text-center">
                <div class="offer-card">
                    <div class="card-body py-5">
                        <h3 class="text-uppercase fw-bold mb-4 text-primary">
                            Your Order Has Been Placed Successfully
                        </h3>
                        <p class="fs-5 fw-semibold text-dark">
                            Your Order ID is 
                            <span class="text-primary">{{ Session::get('order_id') }}</span> 
                            and Grand Total is 
                            <span class="text-primary"><strong>{{ $grand_total }}</strong></span>.
                        </p>
                        <a href="{{ route('home') }}" class="btn btn-primary mt-2 px-2">
                           <i class="bi bi-arrow-left"></i> Back to Home
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
