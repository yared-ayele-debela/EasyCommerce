@extends('Restaurant.dashboard.layouts')
@section('restaurant-dashboard')
@php
$user = Auth::guard('admin')->user();
@endphp
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<div class="container mt-4">
      <div class="row">
    <!-- Available Balance -->
    <div class="col-md-4 mb-3">
        <div class="card text-white bg-success shadow-sm">
            <div class="card-body">
                <h5 class="card-title text-white">Available Balance</h5>
                <p class="card-text fs-4">
                    {{ number_format($wallet->available_balance??'0', 2) }} ETB
                </p>
            </div>
        </div>
    </div>

    <!-- Pending Balance -->
    <div class="col-md-4 mb-3">
        <div class="card text-white bg-warning shadow-sm">
            <div class="card-body">
                <h5 class="card-title text-white">Pending Balance</h5>
                <p class="card-text fs-4">
                    {{ number_format($wallet->pending_balance??'0', 2) }} ETB
                </p>
            </div>
        </div>
    </div>

    <!-- Total Withdrawn -->
    <div class="col-md-4 mb-3">
        <div class="card text-white bg-info shadow-sm">
            <div class="card-body">
                <h5 class="card-title text-white">Total Withdrawn</h5>
                <p class="card-text fs-4">
                    {{ number_format($wallet->total_withdrawn??'0', 2) }} ETB
                </p>
            </div>
        </div>
    </div>
</div>

    <div class="row">
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-body py-4">
                    <p><strong>Full Name: </strong> &nbsp; {{ $vendor->name }} </p>
                    <p><strong>Email: </strong> &nbsp; {{ $vendor->email }} </p>
                    <p><strong>Phone: </strong> &nbsp; {{ $vendor->mobile }} </p>
                    <p><strong>Address: </strong> &nbsp;{{ $vendor->address }}, {{$vendor->city}}, {{ $vendor->state }}, {{ $vendor->country }}  </p>
                    @if($vendor->vendorBank)
                    <p><strong>Account Number: </strong> &nbsp; {{ $vendor->vendorBank->account_number }} </p>
                    <p><strong>Bank Name: </strong> &nbsp; {{ $vendor->vendorBank->bank_name }} </p>
                    @endif

                </div>
            </div>

        </div>
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-body py-4">
                     @session('error')
                    <div class="alert alert-danger mb-1 pb-1" role="alert">
                        <p>{{ session('error') }}</p>
                    </div>
                    @endsession
                     @session('success')
                    <div class="alert alert-success mb-1 pb-1" role="alert">
                        <p>{{ session('success') }}</p>
                    </div>
                    @endsession
                    <h5 class="card-title">Withdraw Request</h5>
                    <p class="card-text">Minimum withdraw request amount is <strong>{{ number_format($withdrawSetting->amount,2) }} ETB</strong></p>
                    <form method="POST" action="{{ route('vendor-withdraw-request') }}">
                        @csrf
                        <div class="form-group">
                            <label for="amount" class="form-lable4">Amount</label>
                            <input type="text" class="form-control" name="amount" min="0" maxlength="{{ $withdrawSetting->amount }}" id="amount" placeholder="Enter amount">
                            @error('amount')
                            <small class="text-danger text-muted">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group mt-3">
                            @if(isset($wallet->available_balance) && $wallet->available_balance >= $withdrawSetting->amount)
                            <button type="submit" class="btn btn-primary">Request Withdraw</button>
                            @else
                            <button type="button" class="btn btn-secondary" disabled>Insufficient Balance</button>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="card p-2">
        <div class="card-header">
            <h6>Withdraw History</h6>
        </div>
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Type</th>
                        <th>Amount</th>
                        <th>Description</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($transactions as $txn)
                    <tr>
                        <td>{{ $txn->created_at->format('Y-m-d') }}</td>
                        <td>
                            @if($txn->type == 'credit')
                            <span class="badge bg-success">Credit</span>
                            @else
                            <span class="badge bg-danger">Debit</span>
                            @endif
                        </td>
                        <td>{{ number_format($txn->amount, 2) }} ETB</td>
                        <td>{{ $txn->description ?? '—' }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4">No transactions found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{ $transactions->links() }} <!-- Laravel pagination -->
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script>
    $(document).ready(function() {
        let isVisible = true;
        $('#toggleBalance').click(function() {
            if (isVisible) {
                $('#balanceAmount').text('•••••••••');
                $(this).removeClass('fa-eye').addClass('fa-eye-slash');
            } else {
                $('#balanceAmount').text('ETB 12,345.67');
                $(this).removeClass('fa-eye-slash').addClass('fa-eye');
            }
            isVisible = !isVisible;
        });
    });

</script>
@endsection
