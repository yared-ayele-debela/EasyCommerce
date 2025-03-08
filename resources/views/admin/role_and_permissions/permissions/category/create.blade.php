@extends('admindashboard.maindashboard')
@section('dashboard')
@php
$user = Auth::guard('admin')->user();
@endphp
<div class="pagetitle bg-light">
    <nav>
        <ol class="breadcrumb p-3 ">
            <li class="breadcrumb-item font-weight-bold"><a href="{{ url('admin/dashboard') }}">Home</a></li>
            <li class="breadcrumb-item">Add Permission Category</li>
        </ol>
    </nav>
</div>
<section class="section col-md-6">
    <div class="card border-0">
        <div class="card-header">
            @if ($user && $user->hasPermissionByRole('view permission category'))
            <a class="btn btn-primary" href="{{ route('permissions-categories') }}">All Permission Categories</a>
            @endif
        </div>
        <div class="card-body pt-3">
            <form class=" g-3" action="{{ route('store-permission-category') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="col-md-6">
                    <label for="name" class="form-label">Category Name</label>
                    <input type="text" class="form-control" name="name">
                    @error('name')
                    <small class=" text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-group pt-3 ">
                    <input type="submit" class=" btn btn-primary pt-2 pb-2 shadow" value="Save">
                </div>
            </form>
        </div>
    </div>
    </div>
    </div>
</section>
@endsection

