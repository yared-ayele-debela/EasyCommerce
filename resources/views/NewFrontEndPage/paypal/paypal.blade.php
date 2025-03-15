@extends('fontend.layout.layout')

@section('content')
@php
$grand_total=App\Helper\Helper::currency_converter(Session::get('grand_total'));
@endphp
<div class="page-track-order u-s-p-t-80">
    <div class="container">
        <div class="track-order-wrapper">
            <div class="row">
                <div class="col-md-12">
                    <div class="about-me-info ">
                        <h1 class="text-center pt-4 text-uppercase" style="color:#1E665E;">PLEASE MAKE PAYMENT FOR YOUR ORDER</h1>
                    </div>
                    <form action="{{ route('pay') }}" method="post">
                    @csrf
                    <input type="hidden"  name="amount" value="{{ $grand_total }}" id="">
                        <div class="text-center pb-4">
                        <input  type="image" src="https://www.paypalobjects.com/webstatic/mktg/logo/AM_mc_vs_dc_ae.jpg" alt="">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

