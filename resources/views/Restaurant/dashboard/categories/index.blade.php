@extends('Restaurant.dashboard.layouts')
@section('restaurant-dashboard')
@php
$user = Auth::guard('admin')->user();
@endphp
 <nav class="breadcrumb">
    <a class="breadcrumb-item" href="#">Home</a>
    <a class="breadcrumb-item active" href="#">Banners</a>
 </nav>
<div class="container">
    <div class="card">
        <div class="card-header">
            <h4>Categories</h4>
            <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addCategoryModal">Add Category</button>
        </div>
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Image</th>
                        <th>Discount</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($categories as $category)
                    <tr>
                        <td>{{ $category->name }}</td>
                        <td>{{ $category->description }}</td>
                        <td><img src="{{ asset('storage/' . $category->image) }}" width="50"></td>
                        <td>{{ $category->discount }} {{ $category->discount_type == 'percentage' ? '%' : 'ETB' }}</td>
                        <td>
                            <div class="btn btn-sm {{ $category->is_active ? 'btn-success' : 'btn-danger' }}">
                                {{ $category->is_active ? 'Active' : 'Inactive' }}
                            </div>
                        </td>
                        <td>
                            <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editCategoryModal-{{ $category->id }}"><i class="bi bi-pencil-fill"></i></button>
                            <form action="{{ route('categories.destroy', $category->id) }}" method="POST" class="delete-form" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-danger btn-sm delete-category">
                                    <i class="bi bi-trash-fill"></i>
                                </button>
                            </form>

                        </td>
                    </tr>

                    <!-- Edit Modal -->
                    <div class="modal fade" id="editCategoryModal-{{ $category->id }}">
                        <div class="modal-dialog">
                            <form action="{{ route('categories.update', $category->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf @method('PUT')
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5>Edit Category</h5>
                                    </div>
                                    <div class="modal-body">
                                        <!-- Category Name -->
                                        <div class="mb-3">
                                            <label class="form-label">Category Name</label>
                                            <input type="text" name="name" class="form-control" value="{{ $category->name }}" required>
                                        </div>



                                        <!-- Image Upload -->
                                        <div class="mb-3">
                                            <label class="form-label">Upload Image</label>
                                            <input type="file" name="image" class="form-control">
                                            @if($category->image)
                                            <img src="{{ asset('storage/' . $category->image) }}" width="50">
                                            @endif
                                        </div>

                                        <!-- Discount -->
                                        <div class="mb-3">
                                            <label class="form-label">Discount</label>
                                            <input type="number" name="discount" class="form-control" value="{{ $category->discount }}" required>
                                        </div>

                                        <!-- Discount Type -->
                                        <div class="mb-3">
                                            <label class="form-label">Discount Type</label>
                                            <select name="discount_type" class="form-control">
                                                <option value="fixed" {{ $category->discount_type == 'fixed' ? 'selected' : '' }}>Fixed</option>
                                                <option value="percentage" {{ $category->discount_type == 'percentage' ? 'selected' : '' }}>Percentage</option>
                                            </select>
                                        </div>

                                        <div class="mb-3">
                                            <label>Description:</label>
                                            <textarea name="description" class="form-control">
                                                {{ $category->description }}
                                            </textarea>
                                        </div>
                                        <!-- Status -->
                                        <div class="mb-3">
                                            <label class="form-label">Status</label>
                                            <select name="is_active" class="form-control">
                                                <option value="1" {{ $category->is_active ? 'selected' : '' }}>Active</option>
                                                <option value="0" {{ !$category->is_active ? 'selected' : '' }}>Inactive</option>
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

    <div class="modal fade" id="addCategoryModal">
        <div class="modal-dialog">
            <form action="{{ route('categories.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add New Category</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                        <label>Category Name:</label>
                        <input type="text" name="name" class="form-control" required>
                        </div>
                    
                        <div class="mb-3">
                        <label>Description:</label>
                        <textarea name="description" class="form-control"></textarea>
                        </div>
                        <div class="mb-3">
                        <label>Upload Image:</label>
                        <input type="file" name="image" class="form-control">
                        </div>
                        <div class="mb-3">
                        <label>Discount:</label>
                        <input type="number" name="discount" class="form-control" required>
                        </div>
                        <div class="mb-3">
                        <label>Discount Type:</label>
                        <select name="discount_type" class="form-control">
                            <option value="fixed">Fixed</option>
                            <option value="percentage">Percentage</option>
                        </select>

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
                        <button type="submit" class="btn btn-success">Save Category</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $(document).on('click', '.delete-category', function (e) {
            e.preventDefault();
            let form = $(this).closest("form");

            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
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
</script>
@endsection
