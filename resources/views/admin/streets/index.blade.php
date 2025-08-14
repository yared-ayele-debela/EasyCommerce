@extends('admindashboard.maindashboard')
@section('dashboard')
@php
$user = Auth::guard('admin')->user();
@endphp
<div class="pagetitle bg-light">
    <nav>
        <ol class="breadcrumb p-3 ">
            <li class="breadcrumb-item font-weight-bold"><a href="{{ url('admin/dashboard') }}">Home</a></li>
            <li class="breadcrumb-item">Streets</li>
        </ol>
    </nav>
</div>
<div class="container">
   <div class="card">
    <div class="card-header">
        <h4>Streets</h4>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addStreetModal">Add Street</button>
        @if(session('success'))
            <div class="alert alert-success mt-2">{{ session('success') }}</div>
        @endif
    </div>
     <div class="card-body">

        <!-- Table -->
        <table class="table mt-3">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Sub City</th>
                    <th>Name</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($streets as $street)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{  $street->subCity?$street->subCity->name:'' }}</td>
                        <td>{{ $street->name }}</td>
                        <td>
                            <!-- Edit Button -->
                            <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editStreetModal{{ $street->id }}">Edit</button>

                            <!-- Delete Form -->
                            <form action="{{ route('streets.destroy', $street->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </td>
                    </tr>

                    <!-- Edit Modal -->
                    <div class="modal fade" id="editStreetModal{{ $street->id }}" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Edit Street</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <form action="{{ route('streets.update', $street->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-body">
                                        <label>Sub City</label>
                                        <select name="sub_city_id" class="form-control">
                                            @foreach($subCities as $subCity)
                                                <option value="{{ $subCity->id }}" {{ $street->sub_city_id == $subCity->id ? 'selected' : '' }}>{{ $subCity->name }}</option>
                                            @endforeach
                                        </select>
                                        <label>Name</label>
                                        <input type="text" name="name" class="form-control" value="{{ $street->name }}" required>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary">Update</button>
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                @endforeach
            </tbody>
        </table>
     </div>
   </div>
</div>

<!-- Add Modal -->
<div class="modal fade" id="addStreetModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Street</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('streets.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <label>Sub City</label>
                    <select name="sub_city_id" class="form-control">
                        @foreach($subCities as $subCity)
                            <option value="{{ $subCity->id }}">{{ $subCity->name }}</option>
                        @endforeach
                    </select>
                    <label>Name</label>
                    <input type="text" name="name" class="form-control" required>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
