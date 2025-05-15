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
     <div class="row g-4">
    @php
        $stats = [
            ['title' => 'Custom Orders', 'count' => $custom_order, 'bg' => 'primary'],
            ['title' => 'Stock Transfer', 'count' => $stock_transfer_product, 'bg' => 'warning'],
            ['title' => 'All Orders', 'count' => $allorders, 'bg' => 'danger'],
            ['title' => 'New Orders', 'count' => $new_orders, 'bg' => 'success'],
            ['title' => 'Pending Orders', 'count' => $pending_orders, 'bg' => 'primary'],
            ['title' => 'Shipped Orders', 'count' => $picked_orders, 'bg' => 'warning'],
            ['title' => 'Delivered Orders', 'count' => $deliverd_orders, 'bg' => 'danger'],
            ['title' => 'Delivering Orders', 'count' => $delivering_orders, 'bg' => 'success']
        ];
    @endphp

    @foreach ($stats as $stat)
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border-0 pt-3 shadow-sm bg-{{ $stat['bg'] }}">
                <div class="card-body d-flex align-items-center text-white">
                    <div class="flex-shrink-0">
                        <div class="bg-white bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                            <i class="bi bi-cart fs-4"></i>
                        </div>
                    </div>
                    <div class="ms-3">
                        <p class="mb-0 fw-semibold small">{{ $stat['title'] }}</p>
                        <h5 class="mb-0">{{ $stat['count'] }}</h5>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>

</div>
</section>
@endsection

