<!-- resources/views/amenities/index.blade.php -->
@extends('Hotel.dashboard.layouts')
@section('hotel-dashboard')
<div class="pagetitle shadow-sm">
    <nav class=" p-2 text-center">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.html">Home</a></li>
            <li class="breadcrumb-item active">Coupon</li>
        </ol>
    </nav>
</div>
<div class="container py-4">
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between mb-3">
                <h4>Coupons</h4>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createCouponModal">Add Coupon</button>
            </div>
            @session('success')
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label
                "Close"></button>
            </div>
            @endsession
        </div>
        <div class="card-body">

            {{-- Coupon Table --}}
            <table class="table ">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Code</th>
                        <th>Type</th>
                        <th>Value</th>
                        <th>Usage Limit</th>
                        <th>Used</th>
                        <th>Expires At</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($coupons as $coupon)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $coupon->code }}</td>
                        <td>{{ ucfirst($coupon->type) }}</td>
                        <td>{{ $coupon->value }}</td>
                        <td>{{ $coupon->usage_limit ?? '∞' }}</td>
                        <td>{{ $coupon->used }}</td>
                        <td>{{ $coupon->expires_at }}</td>
                        <td>
                            <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editCouponModal{{ $coupon->id }}"><i class="bi bi-pencil-square"></i></button>

                            <form action="{{ route('hotel.coupon.destroy', $coupon->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this coupon?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger"><i class="bi bi-trash-fill"></i></button>
                            </form>

                            {{-- Edit Modal --}}
                            <div class="modal fade" id="editCouponModal{{ $coupon->id }}" tabindex="-1">
                                <div class="modal-dialog">
                                    <form action="{{ route('hotel.coupon.update', $coupon->id) }}" method="POST" class="modal-content">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-header">
                                            <h5 class="modal-title">Edit Coupon</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            @include('Hotel.dashboard.coupon._form', ['coupon' => $coupon])
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-success">Update</button>
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                        </div>
                                    </form>
                                </div>
                            </div>

                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- Create Modal --}}
<div class="modal fade" id="createCouponModal" tabindex="-1">
    <div class="modal-dialog">
        <form action="{{ route('hotel.coupon.store') }}" method="POST" class="modal-content">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title">Create Coupon</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                @include('Hotel.dashboard.coupon._form', ['coupon' => null])
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Save</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            </div>
        </form>
    </div>
</div>
@endsection
