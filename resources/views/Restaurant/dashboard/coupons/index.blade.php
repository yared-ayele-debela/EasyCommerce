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
            <li class="breadcrumb-item active" aria-current="page">Coupons</li>
        </ol>
    </nav>
    <div class="card">
        <div class="card-header">
            <h4>Coupons</h4>
            @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            <!-- Add Coupon Button -->
            <button class="btn btn-primary" data-toggle="modal" data-target="#couponModal">Add Coupon</button>

        </div>
        <div class="card-body">
            <!-- Coupon Table -->
            <table class="table mt-3">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Code</th>
                        <th>Type</th>
                        <th>Value</th>
                        <th>Validated Date</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($coupons as $coupon)
                    <tr>
                        <td>{{ $coupon->name }}</td>
                        <td>{{ $coupon->code }}</td>
                        <td>{{ ucfirst($coupon->type) }}</td>
                        <td>{{ $coupon->value }}</td>
                        <td>{{ $coupon->validated_date }}</td>
                        <td>
                            <div class="btn btn-sm btn-{{ $coupon->is_active ? 'success' : 'danger' }}">
                                {{ $coupon->is_active ? 'Active' : 'Inactive' }}
                            </div>
                        </td>
                        <td>
                            <button class="btn btn-warning btn-sm edit-btn" data-toggle="modal" data-target="#editModal" data-id="{{ $coupon->id }}" data-name="{{ $coupon->name }}" data-description="{{ $coupon->description }}" data-code="{{ $coupon->code }}" data-type="{{ $coupon->type }}" data-value="{{ $coupon->value }}" data-validated_date="{{ $coupon->validated_date }}" data-is_active="{{ $coupon->is_active }}"><i class="bi bi-pencil-fill"></i></button>

                            <form action="{{ route('coupons.destroy', $coupon->id) }}" method="POST" class="delete-form d-inline">
                                @csrf
                                <button type="button" class="btn btn-danger btn-sm delete-coupon">
                                    <i class="bi bi-trash-fill"></i>
                                </button>
                            </form>

                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Add/Edit Coupon Modal -->
            <div class="modal fade" id="couponModal" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Add Coupon</h5>
                            <button type="button" class="close btn" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('coupons.store') }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label>Name</label>
                                    <input type="text" name="name" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label>Code</label>
                                    <input type="text" name="code" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label>Type</label>
                                    <select name="type" class="form-control">
                                        <option value="fixed">Fixed</option>
                                        <option value="percentage">Percentage</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Value</label>
                                    <input type="number" step="0.01" name="value" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label>Validated Date</label>
                                    <input type="date" name="validated_date" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label>Status</label>
                                    <select name="is_active" class="form-control">
                                        <option value="1">Active</option>
                                        <option value="0">Inactive</option>
                                    </select>
                                </div>
                                <br>
                                <button type="submit" class="btn btn-success">Save</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Edit Coupon Modal -->
            <div class="modal fade" id="editModal" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Edit Coupon</h5>
                            <button type="button" class="close btn" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body">
                            <form id="editCouponForm" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label>Name</label>
                                    <input type="text" name="name" id="edit-name" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label>Code</label>
                                    <input type="text" name="code" id="edit-code" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label>Type</label>
                                    <select name="type" id="edit-type" class="form-control">
                                        <option value="fixed">Fixed</option>
                                        <option value="percentage">Percentage</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Value</label>
                                    <input type="number" step="0.01" name="value" id="edit-value" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label>Validated Date</label>
                                    <input type="date" name="validated_date" id="edit-validated_date" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label>Status</label>
                                    <select name="is_active" id="edit-is_active" class="form-control">
                                        <option value="1">Active</option>
                                        <option value="0">Inactive</option>
                                    </select>
                                </div>
                                <br>
                                <button type="submit" class="btn btn-success">Update</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $(document).ready(function () {
        $(document).on('click', '.delete-coupon', function (e) {
            e.preventDefault();
            let form = $(this).closest("form");

            Swal.fire({
                title: "Are you sure?",
                text: "This action cannot be undone!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit(); // Submit the form after confirmation
                }
            });
        });
    });
        $('.edit-btn').click(function() {
            let id = $(this).data('id');
            let name = $(this).data('name');
            let description = $(this).data('description');
            let code = $(this).data('code');
            let type = $(this).data('type');
            let value = $(this).data('value');
            let validated_date = $(this).data('validated_date');
            let is_active = $(this).data('is_active');

            // Populate modal fields
            $('#edit-name').val(name);
            $('#edit-code').val(code);
            $('#edit-type').val(type);
            $('#edit-value').val(value);
            $('#edit-validated_date').val(validated_date);
            $('#edit-is_active').val(is_active);

            // Set form action dynamically
            $('#editCouponForm').attr('action', '/admin/restaurant/coupons/update/' + id);
        });
    });

</script>

@endsection

