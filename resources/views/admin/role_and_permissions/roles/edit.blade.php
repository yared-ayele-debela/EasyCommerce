@extends('admindashboard.maindashboard')
@section('dashboard')
@php
$user = Auth::guard('admin')->user();
@endphp
<div class="pagetitle bg-light">
    <nav>
        <ol class="breadcrumb p-3 ">
            <li class="breadcrumb-item font-weight-bold"><a href="{{ url('admin/dashboard') }}">Home</a></li>
            <li class="breadcrumb-item">Edit Role</li>
        </ol>
    </nav>
</div>
<section class="section col-md-8">
    <div class="card">
        <div class="card-header">
            @if ($user && $user->hasPermissionByRole('view role'))
            <a class="btn btn-primary" href="{{ route('roles.index') }}">All Roles</a>
           @endif
        </div>
        <div class="card-body pt-3">
            <form class="row g-3" action="{{ route('roles.update', $role->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="col-md-6">
                    <label for="name" class="form-label">Role Name</label>
                    <input type="text" value="{{ $role->name }}" class="form-control" name="name">
                    @error('name')
                    <small class=" text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-group pt-3 ">
                    <input type="submit" class=" btn btn-primary pt-2 pb-2 shadow" value="Update">
                </div>
            </form>
        </div>
    </div>
    </div>
    </div>
</section>
@endsection

