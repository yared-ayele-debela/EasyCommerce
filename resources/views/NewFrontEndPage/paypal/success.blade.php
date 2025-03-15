@extends('fontend.layout.layout')

@section('content')
@php
$grand_total=App\Helper\Helper::currency_converter(Session::get('grand_total'));
@endphp
<div class="page-about u-s-p-t-80">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="about-me-info u-s-m-b-30">
                    <h1 class="text-center pt-4 text-uppercase" style="color:#1E665E;">YOUR ORDER HAS BEEN PLACED <span style="color:rgb(12, 172, 95);">SUCCESSFULLY</span> </h1>
                    <p class="text-center text-dark font-weight-bold">Your order ID is {{ Session::get('order_id') }} and Grand total is {{ $grand_total }} BIRR </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
<?php
Session::forget('grand_total');
Session::forget('order_id');
Session::forget('couponCode');
Session::forget('couponAmount');
?>

