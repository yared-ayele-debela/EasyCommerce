@extends('delivery_man.admin_dashboard.maindashboard')
@section('delivery_man_dashboard')
@php
$user = Auth::guard('deliverymen')->user();
@endphp
<div class="container">
     <nav class="breadcrumb bg-white shadow-sm py-3 px-4 rounded d-flex justify-content-between align-items-center">
        <button class="btn btn-outline-primary btn-sm d-flex align-items-center" onclick="history.back()">
            <i class="bi bi-arrow-left mr-2"></i> &nbsp;
            <span>Back</span>
        </button>
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item">
                <a href="{{ url('delivery-boy/dashboard') }}">Home</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">Orders</li>
        </ol>
    </nav>
<div class="card  shadow-sm border-0 p-2">
    <table id="" class="table datatable">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col"> Date</th>
                <th scope="col">Customer Info</th>
                <th scope="col"> Products</th>
                <th scope="col">Payment Method</th>
                <th scope="col"> Status</th>
                <th scope="col">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($orders as $k => $order)
            @if($order['orders_products'])
            <tr>
                <td>{{ $order['id']}}</td>
                <td>
                    {{ date('Y-m-d h:i:s',strtotime($order['created_at'])) }}
                </td>
                <td>Name: {{ $order['name'] }} Phone: {{ $order['mobile'] }}</td>
                </td>
                <td>
                    @foreach ($order['orders_products'] as $product)
                    {{ $product['product_name'] }} ({{ $product['product_qty'] }})
                    @endforeach
                </td>

                <td>
                    {{ $order['payment_method'] }}
                </td>
                <td>
                    <a href=""><span style="border-radius: 0.2rem;padding-left:3px;padding-right:3px" class="btn btn-outline-success btn-sm disabled">{{$order['order_status']}}</span></a>
                </td>
                <td>
                    <div class="flex">
                        @if ($user && $user->hasPermissionByRole('view_orders_details'))
                        <a href="{{ url('delivery-boy/order-detail/'.$order['id']) }}" style="background-color:rgb(239, 239, 239) " class=" btn  btn-sm"><i class="ri-eye-fill "></i></a>
                        @endif
                        @if ($user && $user->hasPermissionByRole('view_order_invoice'))
                        <a target="_blank" href="{{ url('delivery-boy/order/invoice/'.$order['id']) }}" style="background-color:rgb(239, 239, 239) " class=" btn btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="view delivery note"><i class="ri-printer-cloud-fill"></i></a>
                        <a target="_blank" href="{{ url('delivery-boy/order/invoice/pdf/'.$order['id']) }}" style="background-color:rgb(239, 239, 239) " class=" btn btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="view delivery note"><i class="ri-file-2-fill"></i></a>
                        @endif
                    </div>
                </td>
            </tr>
            @endif
            @endforeach
        </tbody>
    </table>
    <div>
        {{ $orders->links() }}
    </div>
</div>
@endsection

