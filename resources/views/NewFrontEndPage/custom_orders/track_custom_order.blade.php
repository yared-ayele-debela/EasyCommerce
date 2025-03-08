@extends('fontend.layout.layout')
@section('content')
<div class="container p-3 mt-3 shadow-sm">
    <div class="rounded p-4" style="background-color:#E7F2F1">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h3 class="" style="color:#1E665E;"><b>Track your custom order</b></h3>
                <p  style="color:#1E665E;">To track your custom order please enter your phone number in the box below and press the "Track" button.</p>
            </div>

        </div>
    </div>
</div>
<div class="page-track-order u-s-p-t-30">
    <div class="container">
        <div class="track-order-wrapper">
            <form name="fast_orders" action="{{ route('check_custom_order') }}" method="POST">
                @csrf
                <div class="u-s-m-b-30">
                    <label for="name"> Name (Optional)</label>
                    <input type="text" class="form-control" name="name" placeholder="Enter your Name">
                    @error('name')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="u-s-m-b-30">
                    <label for="phone_number">Phone Number </label>
                    <input type="number" class="form-control" name="phone_number" placeholder="Enter your billing email">
                    @error('phone_number')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="u-s-m-b-30">
                    <button type="submit" class="button buttons button-primary  text-white  w-100">TRACK</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
