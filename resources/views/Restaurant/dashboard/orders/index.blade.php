@extends('Restaurant.dashboard.layouts')
@section('restaurant-dashboard')
@php
$user = Auth::guard('admin')->user();
@endphp

<div class="container">
    <nav class="breadcrumb bg-white shadow-sm py-3 px-4 rounded d-flex justify-content-between align-items-center">
        <button class="btn btn-outline-primary btn-sm d-flex align-items-center" onclick="history.back()">
            <i class="bi bi-arrow-left mr-2"></i> &nbsp;
            <span>Back</span>
        </button>
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item">
                <a href="{{ route('restaurant.dashboard') }}">Home</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">Orders</li>
        </ol>
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
                    <th>Tax</th>
                    <th>Total</th>
                    <th>Payment Method</th>
                    <th>Order Status</th>
                    <th>Delivery Status</th>
                    <th>Payment Info</th>
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
                        <td>{{ $order->tax? $order->tax:0 }} ETB</td>
                        <td>{{ $order->total }} ETB</td>
                        <td>{{ $order->payment_method }}</td>
                        <td>
                            <span class="btn btn-sm text-white btn-info">
                                 {{ ucfirst($order->status) }}
                             </span>
                        </td>
                        <td>
                                <span class="btn btn-sm text-white btn-secondary">
                                 {{ ucfirst($order->delivery_status) }}
                             </span>
                        </td>
                        <td>
                              @if($order->paymentInfo)
                                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#order{{ $order->id }}">
                                    <i class="bi bi-eye-fill"></i> Payment information
                                </button>

                                <div class="modal fade" id="order{{ $order->id }}" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Payment Detail</h5>
                                                <button type="button" class="close btn" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <p>Receipt:</p>
                                                @if($order->paymentInfo->receipt)
                                                <img src="{{ $order->paymentInfo->receipt }}"  class="img-fluid" alt="{{ $order->paymentInfo->bank_name }}">
                                                @else
                                                <img src="{{ asset('restaurant_frontend/default-image.png') }}" class="img-fluid" alt="{{ $order->paymentInfo->bank_name }}">
                                                @endif
                                                <p class="card-text"><strong>Bank Name :</strong> {{ $order->paymentInfo->bank_name }}</p>
                                                <p class="card-text"><strong>Transaction Number :</strong> <strong>{{ $order->paymentInfo->transaction_number }}</strong></p>
                                                <p class="card-text"><strong>Amount Paid :</strong> {{ $order->paymentInfo->amount_paid }} ETB</p>
                                                <p class="card-text"><strong>Payment Status :</strong> {{ $order->paymentInfo->payment_status }}</p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @else

                                @endif
                        </td>
                        <td>
                                        @adminCan('view_restaurant_order')

                            <a href="{{ route('restaurant.orders.show', $order->id) }}" class="btn btn-info btn-sm text-white"><i class="bi bi-eye"></i> Details</a>
                      @endadminCan
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
