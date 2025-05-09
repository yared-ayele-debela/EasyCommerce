@extends('admindashboard.maindashboard')
@section('dashboard')
@php
$user = Auth::guard('admin')->user();
@endphp
<div class="pagetitle bg-light shadow-sm">
    <nav>
        <ol class="breadcrumb p-3">
            <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Home</a></li>
            <li class="breadcrumb-item active">All notifications</li>
        </ol>
    </nav>
</div>
<div class="container">
    <h5 class="text-dark">New Requests ({{ $newNotifications->count() }})</h5>
    @foreach ($newNotifications as $notification)
    <div class="card shadow-sm my-2 pt-3 border-start border-4 border-info">
        <div class="card-body">
            <div class="row">
                {{-- Product Info --}}
                <div class="col-md-4 d-flex">
                    <img src="{{$notification->product->product_image }}" class="img-thumbnail me-3" style="width: 100px; height: 100px;" alt="Product">
                    <div>
                        <h5 class="mb-1">{{ $notification->product->product_name }}</h5>
                        <p class="mb-1 text-muted">Category: {{ $notification->product->category->name ?? 'N/A' }}</p>
                        <p class="mb-1 fw-bold text-success">Price: {{ number_format($notification->product->product_price, 2) }} ETB</p>
                    </div>
                </div>

                {{-- Customer Info --}}
                <div class="col-md-4 d-flex">
                    <img src="{{ $notification->customer->profile_photo_path }}" class="rounded-circle me-3" style="width: 60px; height: 60px;" alt="">
                    <div>
                        <h6 class="mb-1">{{ $notification->customer->name }}</h6>
                        <p class="mb-0">📧 {{ $notification->customer->email }}</p>
                        <p class="mb-0">📞 {{ $notification->customer->mobile ?? 'N/A' }}</p>
                    </div>
                </div>

                {{-- Message + Mark Read --}}
                <div class="col-md-4">
                    <p class="mb-2"><strong>Message:</strong> {{ $notification->message ?? '—' }}</p>
                    <small class="text-muted">Requested on {{ $notification->created_at->format('M d, Y H:i') }}</small>

                    @if($notification->is_new == 0)
                    <form method="POST" action="{{ route('vendor.notifications.markAsRead', $notification->id) }}" class="mt-2">
                        @csrf
                        @method('PATCH')
                        <button class="btn btn-success btn-sm">Mark as Read</button>
                    </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @endforeach
    <h5 class="text-muted mt-4">Read Requests </h5>

    <table class="table table-hover bg-white align-middle shadow-sm">
        <thead class="">
            <tr>
                <th scope="col">Product</th>
                <th scope="col">Customer</th>
                <th scope="col">Message</th>
                <th scope="col">Requested At</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($readNotifications as $notification)
            <tr>
                {{-- Product Info --}}
                <td class="d-flex align-items-center">
                    <img src="{{ $notification->product->product_image }}"
                         alt="Product" class="me-2 img-thumbnail" style="width: 30px; height: 30px;">
                    <div>
                        <strong>{{ $notification->product->product_name }}</strong><br>
                        <small class="text-muted">{{ $notification->product->category->name ?? 'N/A' }}</small><br>
                        <span class="text-success fw-bold">{{ number_format($notification->product->product_price, 2) }} ETB</span>
                    </div>
                </td>

                {{-- Customer Info --}}
                <td>
                    <img src="{{ $notification->customer->profile_photo_path }}"
                    alt="Customer" class="rounded-circle me-2" style="width: 50px; height: 50px;">
                        <strong>{{ $notification->customer->name }}</strong><br>
                        <small>📞 {{ $notification->customer->mobile ?? 'N/A' }}</small>
                </td>
                <td>
                    {{ $notification->message ?? '—' }}
                </td>

                {{-- Timestamp --}}
                <td>
                    {{ $notification->created_at->format('M d, Y H:i') }}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $readNotifications->links() }}
</div>
@endsection

