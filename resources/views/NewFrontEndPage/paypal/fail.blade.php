@extends('fontend.layout.layout')

@section('content')

<div class="page-track-order u-s-p-t-80">
    <div class="container">
        <div class="track-order-wrapper">
                <div class="row">
                   <div class="col-md-12">
                     <h2 class="text-center pt-4 text-uppercase ">YOUR PAYMENT HAS BEEN <span style="color:rgb(255, 8, 0)">FAIED</span>  </h2><br>
                      <span class="animate-border mx-auto"></span>
                      <p class=" text-center">Please try again after some time and contact us if there is any enquiry.</p>
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
