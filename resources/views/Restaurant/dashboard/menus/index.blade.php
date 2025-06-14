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
            <li class="breadcrumb-item active" aria-current="page">Menus</li>
        </ol>
    </nav>
    <div class="card">
        <div class="card-header">
            <h4>Restaurant Menu</h4>
            @adminCan('add_restaurant_restaurant_menu')
            <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addMenuModal">Add Restaurant Menu</button>
            @endadminCan
        </div>
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Image</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($restaurant_menus as $Menu)
                    <tr>
                        <td>{{ $Menu->name }}</td>
                        <td><img src="{{ $Menu->image }}" width="50"></td>
                        <td>
                            <div class="btn btn-sm {{ $Menu->is_active ? 'btn-success' : 'btn-danger' }}">
                                {{ $Menu->is_active ? 'Active' : 'Inactive' }}
                            </div>
                        </td>
                        <td>
                            @adminCan('edit_restaurant_restaurant_menu')
                            <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editMenuModal-{{ $Menu->id }}"><i class="bi bi-pencil-fill"></i></button>
                            @endadminCan
                            @adminCan('delete_restaurant_restaurant_menu')
                            <form action="{{ route('menus.destroy', $Menu->id) }}" method="POST" class="delete-form" style="display:inline;">
                                @csrf @method('DELETE')
                                <button type="button" data-id="{{ $Menu->id }}" class="btn btn-danger btn-sm delete-menu">
                                    <i class="bi bi-trash-fill"></i>
                                </button>
                            </form>
                            @endadminCan
                        </td>
                    </tr>

                    <!-- Edit Modal -->
                    <div class="modal fade" id="editMenuModal-{{ $Menu->id }}">
                        <div class="modal-dialog">
                            <form action="{{ route('menus.update', $Menu->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5>Edit Menu </h5>
                                    </div>
                                    <div class="modal-body">
                                        <!-- Menu Name -->
                                        <div class="mb-3">
                                            <label class="form-label">Menu Name</label>
                                            <input type="text" name="name" class="form-control" value="{{ $Menu->name }}" required>
                                        </div>
                                        <!-- Image Upload -->
                                        <div class="mb-3">
                                            <label class="form-label">Upload Image</label>
                                            <input type="file" name="image" class="form-control">
                                            @if($Menu->image)
                                            <img src="{{ $Menu->image }}" width="50">
                                            @endif
                                        </div>
                                        <!-- Status -->
                                        <div class="mb-3">
                                            <label class="form-label">Status</label>
                                            <select name="is_active" class="form-control">
                                                <option value="1" {{ $Menu->is_active ? 'selected' : '' }}>Active</option>
                                                <option value="0" {{ !$Menu->is_active ? 'selected' : '' }}>Inactive</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary">Update</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="modal fade" id="addMenuModal">
        <div class="modal-dialog">
            <form action="{{ route('menus.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add New Menu</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label>Menu Name:</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label>Upload Image:</label>
                            <input type="file" name="image" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label>Status:</label>
                            <select name="is_active" class="form-control">
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Save Menu</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $(document).on('click', '.delete-menu', function(e) {
        e.preventDefault();
        let form = $(this).closest("form");

        Swal.fire({
            title: "Are you sure?"
            , text: "This action cannot be undone!"
            , icon: "warning"
            , showCancelButton: true
            , confirmButtonColor: "#d33"
            , cancelButtonColor: "#3085d6"
            , confirmButtonText: "Yes, delete it!"
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit(); // Submit the form after confirmation
            }
        });
    });

</script>

@endsection

