@extends('admindashboard.maindashboard')
@section('dashboard')
@php
$user = Auth::guard('admin')->user();
@endphp
<div class="pagetitle bg-light">
    <nav>
        <ol class="breadcrumb p-3 ">
            <li class="breadcrumb-item font-weight-bold"><a href="{{ url('admin/dashboard') }}">Home</a></li>
            <li class="breadcrumb-item">sub cities</li>
        </ol>
    </nav>
</div>
<div class="container">
    <div class="card">
        <div class="card-header">
            <h4>Sub Cities</h4>
            <!-- Button to trigger modal -->
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addSubCityModal">Add Sub City</button>
        
            <!-- Success Message -->
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
                <th>City</th>
                <th>Name</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($subCities as $subCity)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $subCity->city->name }}</td>
                    <td>{{ $subCity->name }}</td>
                    <td>
                        <!-- Edit Button -->
                        <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editSubCityModal{{ $subCity->id }}">Edit</button>
                        
                        <!-- Delete Form -->
                        <form action="{{ route('sub-cities.destroy', $subCity->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </td>
                </tr>

                <!-- Edit Modal -->
                <div class="modal fade" id="editSubCityModal{{ $subCity->id }}" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Edit Sub City</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <form action="{{ route('sub-cities.update', $subCity->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="modal-body">
                                    <label>City</label>
                                    <select name="city_id" class="form-control">
                                        @foreach($cities as $city)
                                            <option value="{{ $city->id }}" {{ $subCity->city_id == $city->id ? 'selected' : '' }}>{{ $city->name }}</option>
                                        @endforeach
                                    </select>
                                    <label>Name</label>
                                    <input type="text" name="name" class="form-control" value="{{ $subCity->name }}" required>
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
<div class="modal fade" id="addSubCityModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Sub City</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('sub-cities.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <label>City</label>
                    <select name="city_id" class="form-control">
                        @foreach($cities as $city)
                            <option value="{{ $city->id }}">{{ $city->name }}</option>
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
