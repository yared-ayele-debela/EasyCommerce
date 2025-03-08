@extends('fontend.layout.layout')
@section('content')
<div class="container p-3 mt-3 shadow-sm">
    <div class="rounded p-4" style="background-color:#E7F2F1">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h3 class="" style="color:#1E665E;"><b>Track your order</b></h3>
                <p  style="color:#1E665E;">To track your order please enter your Order ID in the box below and press the "Track" button. This was given to you on your receipt and in the confirmation email you should have received.</p>
            </div>

        </div>
    </div>
</div>
<div class="page-track-order u-s-p-t-80">
    <div class="container">
        <div class="track-order-wrapper">
            <form name="fast_orders" action="{{ route('check-order') }}" method="POST">
                @csrf
                <div class="u-s-m-b-30">
                    <label for="order_code">Order Code</label>
                    <input type="text" class="form-control" name="order_code" placeholder="Enter your order code">
                    @error('order_code')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="u-s-m-b-30">
                    <label for="billing_email">Email (Optional) </label>
                    <input type="email" class="form-control" name="billing_email" placeholder="Enter your billing email">
                    @error('billing_email')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="u-s-m-b-30">
                    <button type="submit" class="button buttons  text-white  w-100">TRACK</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
