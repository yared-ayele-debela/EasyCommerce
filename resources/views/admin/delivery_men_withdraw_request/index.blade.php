@extends('admindashboard.maindashboard')
@section('dashboard')
@php
$user = Auth::guard('admin')->user();
@endphp
<div class="container">
    <div class="pagetitle bg-light">
        <nav>
            <ol class="breadcrumb p-3 ">
                <li class="breadcrumb-item font-weight-bold"><a href="{{ url('admin/dashboard') }}">Home</a></li>
                <li class="breadcrumb-item">Withdraw Requests</li>
            </ol>
        </nav>
    </div>
    <div class="card">
        <div class="card-header">
            <h4>Withdrawal Requests</h4>
            @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
            @elseif(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
        </div>
        <div class="card-body">
            <table class="table table-bordered mt-3">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Delivery Man</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Requested At</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($withdrawals as $withdrawal)
                    <tr>
                        <td>{{ $withdrawal->id }}</td>
                        <td>{{ $withdrawal->deliveryMan->first_name }} {{ $withdrawal->deliveryMan->last_name}} | Phone {{ $withdrawal->deliveryMan->phone }} Address {{ $withdrawal->deliveryMan->address }}</td>
                        <td>{{ $withdrawal->amount }} ETB</td>
                        <td>
                            <span class="badge bg-{{
                            $withdrawal->status === 'pending' ? 'warning' :
                            ($withdrawal->status === 'approved' ? 'success' : 'danger')
                        }}">
                                {{ ucfirst($withdrawal->status) }}
                            </span>
                        </td>
                        <td>{{ $withdrawal->created_at->format('Y-m-d H:i') }}</td>
                        <td>
                            @if($withdrawal->status === 'pending')
                            <form method="POST" action="{{ route('admin.withdrawals.approve', $withdrawal->id) }}" style="display:inline-block;">
                                @csrf
                                <button class="btn btn-success btn-sm">Approve</button>
                            </form>
                            <form method="POST" action="{{ route('admin.withdrawals.reject', $withdrawal->id) }}" style="display:inline-block;">
                                @csrf
                                <button class="btn btn-danger btn-sm">Reject</button>
                            </form>
                            @else
                            <em>No actions</em>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6">No withdrawal requests found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    {{ $withdrawals->links() }}
</div>
@endsection

