<!-- resources/views/amenities/index.blade.php -->
@extends('Hotel.dashboard.layouts')
@section('hotel-dashboard')
<div class="pagetitle shadow-sm">
    <nav class=" p-2 text-center">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.html">Home</a></li>
            <li class="breadcrumb-item active">Amenites</li>
        </ol>
    </nav>
</div>
<div class="container">
    <div class="card">
        <div class="card-header">
            <h4 class="mb-4">Hotel Categories</h4>
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            <button class="btn btn-primary mb-1" data-bs-toggle="modal" data-bs-target="#addModal">Add Category</button>
        </div>
        <div class="card-body">
            <!-- Amenities Table -->
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($categories as $category)
                        <tr>
                            <td>
                                <img src="{{ asset('storage/' . $category->image) }}" width="40" height="40">
                            </td>
                            <td>{{ $category->name }}</td>
                            <td>
                                <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#editModal{{ $category->id }}"><i class="bi bi-pencil-square"></i></button>
                                <form action="{{ route('hotel-categories.destroy', $category->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger"><i class="bi bi-trash-fill"></i></button>
                                </form>
                            </td>
                        </tr>
    
                        <!-- Edit Modal -->
                        <div class="modal fade" id="editModal{{ $category->id }}" tabindex="-1">
                          <div class="modal-dialog">
                            <form action="{{ route('hotel-categories.update', $category->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h5 class="modal-title">Edit Hotel Category</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                  </div>
                                  <div class="modal-body">
                                      <div class="mb-3">
                                          <label>Name</label>
                                          <input type="text" class="form-control" name="name" value="{{ $category->name }}" required>
                                      </div>
                                      <div class="mb-3">
                                          <label>Image</label>
                                          <input type="file" class="form-control" name="image">
                                          <img src="{{ asset('storage/' . $category->image) }}" width="60" height="60" class="mt-2">
                                      </div>
                                  </div>
                                  <div class="modal-footer">
                                      <button type="submit" class="btn btn-success">Update</button>
                                  </div>
                                </div>
                            </form>
                          </div>
                        </div>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{ $categories->links() }}
        </div>


<!-- Add Modal -->
<div class="modal fade" id="addModal" tabindex="-1">
    <div class="modal-dialog">
      <form action="{{ route('hotel-categories.store') }}" method="POST" enctype="multipart/form-data">
          @csrf
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Add Hotel Category</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label>Name</label>
                    <input type="text" class="form-control" name="name" required>
                </div>
                <div class="mb-3">
                    <label>Image</label>
                    <input type="file" class="form-control" name="image" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
          </div>
      </form>
    </div>
  </div>

        </div>
    </div>
</div>
@endsection

