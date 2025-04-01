@extends('Restaurant.dashboard.layouts')
@section('restaurant-dashboard')
@php
$user = Auth::guard('admin')->user();
@endphp

<div class="container">
    <nav class="breadcrumb">
        <a class="breadcrumb-item" href="#">Home</a>
        <a class="breadcrumb-item active" href="#">Orders</a>
    </nav>
   <div class="card">
     <div class="card-header">
        <h5>All Orders</h5>
     </div>
     <div class="card-body">
       <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>User Info</th>
                    <th>SubTotal</th>
                    <th>Discount</th>
                    <th>Delivery Fee</th>
                    <th>Total</th>
                    <th>Payment Method</th>
                    <th>Order Status</th>
                    <th>Delivery Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($orders as $order)
                    <tr>
                        <td>{{ $order->id }}</td>
                        <td>{{ $order->user->name }}</td>
                        <td>{{ $order->subtotal }} ETB</td>
                        <td>{{ $order->discount }} ETB</td>
                        <td>{{ $order->delivery_fee }} ETB</td>
                        <td>{{ $order->total }} ETB</td>
                        <td>{{ $order->payment_method }}</td>
                        <td>
                            <span class="btn btn-sm text-white @if($order->status == 'completed') bg-success @endif  @if($order->status==='processing') bg-info @endif  @if($order->status == 'canceled') bg-danger @endif
                                @if($order->status == 'pending') bg-warning @endif      ">
                                 {{ ucfirst($order->status) }}
                             </span>
                        </td>
                        <td>
                                <span class="btn btn-sm text-white @if($order->delivery_status === 'shipped') bg-info @endif  @if($order->delivery_status==='delivered') bg-success @endif
                                @if($order->delivery_status === 'pending') bg-warning @endif">
                                 {{ ucfirst($order->delivery_status) }}
                             </span>
                        </td>
                        <td>
                            <a href="{{ route('restaurant.orders.show', $order->id) }}" class="btn btn-info btn-sm text-white"><i class="bi bi-eye"></i> Details</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
       </div>
     </div>
   </div>
</div>
@endsection
