@extends('admindashboard.maindashboard')
@section('dashboard')
@php
$user = Auth::guard('admin')->user();
@endphp
 <section class="section">
   <div class="container">
     <nav class="breadcrumb bg-white shadow-sm py-3 px-4 rounded d-flex justify-content-between align-items-center">
        <button class="btn btn-outline-primary btn-sm d-flex align-items-center" onclick="history.back()">
            <i class="bi bi-arrow-left mr-2"></i> &nbsp;
            <span>Back</span>
        </button>
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item">
                <a href="">Home</a> / 
                <a href="" class=" breadcrumb-item active">Delivery Men Withdraw Detail</a>
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
        <div class="col-md-12">
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
                            <tr>
                                <td colspan="4" class="text-center">No withdrawals yet</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
   </div>
 </section>
@endsection

