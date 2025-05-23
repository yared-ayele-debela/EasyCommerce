@extends('fontend.layout.layout')
@section('content')

<div class="page-about u-s-p-t-80">
    <div class="container">
        <div class="container mt-5">
            <h2 class="mb-4 text-center text-uppercase">MY <span style="color:black;">Orders </span></h2>

            <div class="table-responsive">
                <table class="table table-striped table-borderless">
                    <thead class="thead text-dark" style="background-color:#E7F2F1;">
                        <tr>
                            <th>Order ID</th>
                            <th>Ordered Products</th>
                            <th>Payment Method</th>
                            <th>Grand Total</th>
                            <th>Created on</th>
                            <td>Detail</td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $order)
                            @if($order['orders_products'])
                                <tr>
                                    <td>
                                        <a href="{{ url('user/orders/'.$order['id']) }}">{{ $order['id'] }} </a>
                                    </td>
                                    <td>
                                        @foreach ($order['orders_products'] as $product)
                                            {{ $product['product_code'] }} <br>
                                        @endforeach
                                    </td>
                                    <td>
                                        {{ $order['payment_method'] }}
                                    </td>
                                    <td>
                                        {{  App\Helper\Helper::currency_converter(App\Helper\Helper::currency_converter($order['grand_total'])) }}
                                    </td>
                                    <td>
                                        {{ date('Y-m-d j:i:s', strtotime($order['created_at'])) }}
                                    </td>
                                    <td>
                                        <a href="{{ url('user/orders/'.$order['id']) }}" class=" btn btn-sm bg-light  text-dark" >
                                            <li class=" fas fa-eye "></li>
                                        </a>
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>
@endsection

