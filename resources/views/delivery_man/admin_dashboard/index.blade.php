@extends('delivery_man.admin_dashboard.maindashboard')
@section('delivery_man_dashboard')
@php
$user = Auth::guard('deliverymen')->user();
@endphp
    <div class="container ">
        <nav class="breadcrumb bg-white shadow-sm py-3 px-4 rounded d-flex justify-content-between align-items-center">
    <button class="btn btn-outline-primary btn-sm d-flex align-items-center" onclick="history.back()">
        <i class="bi bi-arrow-left mr-2"></i> &nbsp;
        <span>Back</span>
    </button>
    <ol class="breadcrumb mb-0">
        <li class="breadcrumb-item">
            <a href="">Home</a>
        </li>
    </ol>
    </nav>
    {{-- <h2 class="mb-4">Delivery Dashboard</h2> --}}
    <div class="row mb-4">
         <div class="col-md-3">
            <div class="card bg-success text-white">
                <div class="card-body pt-4">
                    <h5>Total Earned</h5>
                    <h3>{{ number_format($totalEarned, 2) }} ETB</h3>
                </div>
            </div>
        </div>
        <!-- Total Earned -->
        <div class="col-md-3">
            <div class="card bg-secondary text-white">
                <div class="card-body pt-4">
                    <h5>Withdrawn</h5>
                    <h3>{{ number_format($withdrawn, 2) }} ETB</h3>
                </div>
            </div>
        </div>

        <!-- Available Balance -->
        <div class="col-md-3">
            <div class="card bg-info text-white">
                <div class="card-body pt-4">
                    <h5>Available to Withdraw</h5>
                    <h3>{{ number_format($available_to_withdraw , 2) }} ETB</h3>
                </div>
            </div>
        </div>
        <!-- Pending Withdrawal -->
        <div class="col-md-3">
            <div class="card bg-warning text-white">
                <div class="card-body pt-4">
                    <h5>Pending Withdrawal</h5>
                    <h3>{{ number_format($pendingWithdraw, 2) }} ETB</h3>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
<div class="card shadow-sm mb-4">
        <div class="card-header">
             @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
            @elseif(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            <div class="card-header">
                Withdrawal
                <span class="badge bg-success float-end">
                    Max Available: {{ number_format($available_to_withdraw, 2) }} ETB
                </span>
            </div>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('delivery.withdraw.request') }}">
                @csrf
                <div class="form-group">
                    <label for="amount">Enter amount to withdraw</label>
                    <input type="number" name="amount" class="form-control" required step="0.01" max="{{ $available_to_withdraw }}">
                </div>
                <button type="submit" class="btn btn-primary mt-2">Request</button>
            </form>
        </div>
    </div>
        </div>
        <div class="col-md-8">
 <div class="card">
        <div class="card-header">Withdrawal History</div>
        <div class="card-body p-0">
            <table class="table mb-2">
                <thead>
                    <tr>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Created At</th>
                        <th>Approved or Declined At</th>

                    </tr>
                </thead>
                <tbody>
                    @foreach($withdrawals as $withdraw)
                        <tr>
                            <td>{{ number_format($withdraw->amount, 2) }} ETB</td>
                            <td>
                                @if($withdraw->status == 'pending')
                                    <span class="badge bg-warning">Pending</span>
                                @elseif($withdraw->status == 'approved')
                                    <span class="badge bg-success">Approved</span>
                                @else
                                    <span class="badge bg-danger">Rejected</span>
                                @endif
                            </td>
                            <td>{{$withdraw->created_at->format('Y-m-d')}}</td>
                            <td>{{$withdraw->approved_at}}</td>
                        </tr>
                    @endforeach
                    @if($withdrawals->isEmpty())
                        <tr><td colspan="4" class="text-center">No withdrawals yet</td></tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
        </div>
    </div>

    <!-- Withdraw Request Form -->



    <!-- Withdraw History -->

     <div class="row">
        <div class="col-xxl-3 col-md-3">
            <div class="card info-card bg-c-blue sales-card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                            <i class="bi bi-cart"></i></div>
                        <div class="ps-3">
                            <p class="text-white small pt-1 fw-bold">Custom orders</p>
                            <h6 class="text-white"> {{ $custom_order}}</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xxl-3 col-md-3">
            <div class="card info-card bg-c-yellow sales-card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center"> <i class="bi bi-cart"></i></div>
                        <div class="ps-3">
                            <p class="text-white small pt-1 fw-bold">Stock Transfer </p>
                            <h6 class="text-white"> {{ $stock_transfer_product}}</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xxl-3 col-md-3">
            <div class="card info-card bg-c-pink sales-card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center"> <i class="bi bi-cart"></i></div>
                        <div class="ps-3">
                            <p class="text-white small pt-1 fw-bold">All orders</p>
                            <h6 class="text-white"> {{ $allorders}}</h6>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xxl-3 col-md-3">
            <div class="card info-card bg-c-green sales-card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center"> <i class="bi bi-cart"></i></div>
                        <div class="ps-3">
                            <p class="text-white small pt-1 fw-bold">New orders</p>
                            <h6 class="text-white"> {{ $new_orders}}</h6>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xxl-3 col-md-3">
            <div class="card info-card bg-c-blue sales-card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center"> <i class="bi bi-cart"></i></div>
                        <div class="ps-3">
                            <p class="text-white small pt-1 fw-bold">Pending order</p>
                            <h6 class="text-white"> {{ $pending_orders }}</h6>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xxl-3 col-md-3">
            <div class="card info-card bg-c-yellow sales-card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center"> <i class="bi bi-cart"></i></div>
                        <div class="ps-3">
                            <p class="text-white  pt-1 fw-bold">Shipped order</p>
                            <h6 class="text-white"> {{ $shipped_orders }}</h6>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xxl-3 col-md-3">
            <div class="card info-card sales-card bg-c-pink border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center"> <i class="bi bi-cart"></i></div>
                        <div class="ps-3">
                            <p class="text-white small pt-1 fw-bold">Deliverd orders</p>
                            <h6 class="text-white"> {{ $deliverd_orders }}</h6>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xxl-3 col-md-3">
            <div class="card info-card bg-c-green sales-card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center"> <i class="bi bi-cart"></i></div>
                        <div class="ps-3">
                            <span class="text-white small pt-1 fw-bold">Paid orders</span>
                            <h6 class="text-white"> {{ $deliverd_orders }}</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
     </div>
</div>
</section>
<div class="container">
    <h5 class="card-title">Latest Orders </h5>
    @if ($user && $user->hasPermissionByRole('view_orders_details'))
    <div class="row">
        @foreach ($orders as $k => $order)
        <div class="col-md-6">
            @if($order['orders_products'])
            <div class="card mb-4 shadow-sm border-0">
                <div class="card-body">
                    <h5 class="card-title">Order ID: {{ $order['id'] }}</h5>
                    <p class="card-text">Order Date: {{ date('Y-m-d h:i:s', strtotime($order['created_at'])) }}</p>
                    <p class="card-text">Customer Name: {{ $order['name'] }}</p>
                    <p class="card-text">Customer Email: {{ $order['email'] }}</p>
                    <p class="card-text">Ordered Products:
                        @foreach ($order['orders_products'] as $product)
                        {{ $product['product_name'] }} ({{ $product['product_qty'] }}),
                        @endforeach
                    </p>
                    <p class="card-text">Ordered Price: {{ $order['grand_total'] }}</p>
                    <p class="card-text">Payment Method: {{ $order['payment_method'] }}</p>
                    <p class="card-text mb-2">Order Status:
                        <span class="px-2 text-white" style="border-radius: 0.2rem; background-color:rgb(30, 141, 231)">{{ $order['order_status'] }}</span>
                    </p>
                    <div class="">
                        <a href="{{ url('delivery-boy/order-detail/'.$order['id']) }}" class="btn btn-sm btn-outline-primary">View Details</a>
                        <a target="_blank" href="{{ url('delivery-boy/order/invoice/'.$order['id']) }}" class="btn btn-sm btn-outline-secondary ">Print Invoice</a>
                        <a target="_blank" href="{{ url('delivery-boy/order/invoice/pdf/'.$order['id']) }}" class="btn btn-sm btn-outline-secondary  ">Download PDF</a>
                    </div>
                </div>
            </div>
            @endif
        </div>
        @endforeach
    </div>
    @endif

</div>

@endsection

