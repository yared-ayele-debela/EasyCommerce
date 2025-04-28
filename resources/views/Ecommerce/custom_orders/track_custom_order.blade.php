@extends('all_frontend_layouts.layouts')
@section('content')
<div class="container-fluid">
    <div class="header">
        <button class="btn btn-link text-dark" onclick="history.back()">
            <i class="bi bi-arrow-left"></i>
        </button>
        <h5 class="my-4 text-dark text-center">My Custom Orders</h5>
    </div>
    <div class="row d-flex justify-content-center align-items-center"> 
       
        <div class="col-lg-6 mb-4">
            <div class="offer-card p-4">
                <div class="col-12 text-center">
                    <h3 class="text-dark"><b>Track your custom order</b></h3>
                    <p  class="text-dark">To track your custom order please enter your phone number in the box below and press the "Track" button.</p>
                </div>
                <form name="fast_orders" action="{{ route('check_custom_order') }}" method="POST">
                    @csrf
                    <div class="form-group mb-3">
                        <label for="name"> Name (Optional)</label>
                        <input type="text" class="form-control" name="name" placeholder="Enter your Name">
                        @error('name')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group mb-3">
                        <label for="phone_number">Phone Number </label>
                        <input type="number" class="form-control w-100 text-left" name="phone_number" placeholder="Enter your phone number">
                        @error('phone_number')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group pt-3">
                        <button type="submit" class="btn btn-primary text-white w-100">TRACK</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

