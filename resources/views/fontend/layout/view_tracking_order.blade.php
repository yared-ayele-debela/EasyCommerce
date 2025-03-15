@extends('fontend.layout.layout')
@section('content')
@if($order)
<style>
    .card {
        position: relative;
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        -webkit-box-orient: vertical;
        -webkit-box-direction: normal;
        -ms-flex-direction: column;
        flex-direction: column;
        min-width: 0;
        word-wrap: break-word;
        background-color: #fff;
        background-clip: border-box;
        border-radius: 0.10rem
    }

    .card-header:first-child {
        border-radius: calc(0.37rem - 1px) calc(0.37rem - 1px) 0 0
    }

    .card-header {
        padding: 0.75rem 1.25rem;
        margin-bottom: 0;
        background-color: #fff;
        border-bottom: 1px solid rgba(0, 0, 0, 0.1)
    }

    .track {
        position: relative;
        background-color: #ddd;
        height: 7px;
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        margin-bottom: 60px;
        margin-top: 50px
    }

    .track .step {
        -webkit-box-flex: 1;
        -ms-flex-positive: 1;
        flex-grow: 1;
        width: 25%;
        margin-top: -18px;
        text-align: center;
        position: relative
    }

    .track .step.active:before {
        background: #1E665E;
    }

    .track .step::before {
        height: 7px;
        position: absolute;
        content: "";
        width: 100%;
        left: 0;
        top: 18px
    }

    .track .step.active .icon {
        background: #1E665E;
        color: #fff
    }

    .track .icon {
        display: inline-block;
        width: 40px;
        height: 40px;
        line-height: 40px;
        position: relative;
        border-radius: 100%;
        background: #ddd
    }

    .track .step.active .text {
        font-weight: 400;
        color: #000
    }

    .track .text {
        display: block;
        margin-top: 7px
    }

    .itemside {
        position: relative;
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        width: 100%
    }

    .itemside .aside {
        position: relative;
        -ms-flex-negative: 0;
        flex-shrink: 0
    }

    .img-sm {
        width: 80px;
        height: 80px;
        padding: 7px
    }

    ul.row,
    ul.row-sm {
        list-style: none;
        padding: 0
    }

    .itemside .info {
        padding-left: 15px;
        padding-right: 7px
    }

    .itemside .title {
        display: block;
        margin-bottom: 5px;
        color: #212529
    }

    p {
        margin-top: 0;
        margin-bottom: 1rem
    }

    .btn-warning {
        color: #ffffff;
        background-color: #1E665E;
        border-color: #1E665E;
        border-radius: 1px
    }

    .btn-warning:hover {
        color: #ffffff;
        background-color: #1E665E;
        border-color: #1E665E;
        border-radius: 1px
    }

</style>


<div class="page-track-order u-s-p-t-80">
    <div class="container shadow-sm  mb-3 pb-3">
        <article class="card border-0 " style="background-color:#E7F2F1";>
            <header class="card-header bg-white border-0"> My Orders </header>
            <div class="card-body">
                <h6>Order ID: # {{ $order->id }} </h6>
                <article class="card border-0">
                    @if($order->deliveryBoy)
                    <div class="card-body row">
                        <div class="col"> <strong>Order Code :</strong> <br>{{ $order->order_code }} </div>
                        <div class="col"> <strong>Payment Method :</strong> <br>{{ $order->payment_method }} </div>

                        <div class="col"> <strong>Shipping BY:</strong> <br> {{ $order->deliveryBoy->first_name }} {{ $order->deliveryBoy->last_name }} | <i class="fa fa-phone"></i> {{ $order->deliveryBoy->phone }} </div>
                        <div class="col"> <strong>Status:</strong> <br> {{ $order->order_status }}</div>
                    </div>
                    @endif
                </article>
                <div class="track">
                    <div class="step @if($order->order_status == "New" || $order->order_status == "Delivered" || $order->order_status == "In Process" ||  $order->order_status == "Pending" || $order->order_status == "Shipped" || $order->order_status == "Partially Shipped" ) active @endif"> <span class="icon"> <i class="fa fa-check"></i> </span> <span class="text">Order confirmed</span> </div>
                    <div class="step @if($order->order_status == "In Process" || $order->order_status == "Pending" || $order->order_status == "Delivered" || $order->order_status == "Shipped" || $order->order_status == "Partially Shipped") active @endif"> <span class="icon"> <i class="fa fa-user"></i> </span> <span class="text"> </span> In process </div>
                    <div class="step @if($order->order_status == "Shipped" || $order->order_status == "Partially Shipped" || $order->order_status == "Delivered" ) active @endif"> <span class="icon"> <i class="fa fa-truck"></i> </span> <span class="text">Shipped by delivery man</span> </div>
                    <div class="step @if($order->order_status == "Delivered") active @endif" > <span class="icon"> <i class="fa fa-box"></i> </span> <span class="text">Delivered</span> </div>

                </div>
                <br>
                <ul class="row  ">
                    @foreach ($order->orders_products as $orderProduct)
                        @if($orderProduct->product)
                    <li class="col-md-4">
                        <figure class="itemside mb-3">
                            <div class="aside"><img src="{{ asset('/storage/products/'.$orderProduct->product->product_image) }}" class="img-sm border"></div>
                            <figcaption class="info align-self-center">
                                <p class="title">{{ $orderProduct->product->product_name }}<br> {{ $orderProduct->product->product_code }}</p> <span class="text-muted">{{ $orderProduct->product->product_price }} Birr </span>
                            </figcaption>
                        </figure>
                    </li>
                    @endif
                    @endforeach
                </ul>
                <br>
                <a href="{{ route('orders') }}" class="btn btn-warning" data-abc="true"> <i class="fa fa-chevron-left"></i> Back to orders</a>
            </div>
        </article>
    </div>
</div>
@endif
@endsection
