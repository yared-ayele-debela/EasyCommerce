@extends('all_frontend_layouts.layouts')
@section('content')
<div class="container my-4">
    <div class="row d-flex justify-content-center align-items-center">
        <div class="col-md-4">
            <div class="card text-center">
                <img class="card-img-top img-fluid mb-3" src="{{ asset('restaurant_frontend/assets/img/on th way.png') }}" alt="Order on the way" />
                <div class="card-body text-center">
                    <h4 class="card-title text-primary">Congrats, Your Food is on The Way</h4>
                    <p class="card-text text-dark">You successfully placed an order. Enjoy our service!</p>
                    <div class="d-flex justify-content-around align-items-center my-3 text-dark">
                        <span>Delivery Time</span>
                        <span>{{ $order->estimated_delivery_time ?? '20 Min' }}</span>
                    </div>
                    <a href="{{ url('restaurant/order/'.$order->id.'/track') }}" class="btn bg-primary text-white w-100">Track Order</a>
                    <div class="mt-2">
                        <a href="{{url('/')}}" class="btn btn-outline-primary w-100 ">Continue Shopping</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
