@extends('admindashboard.maindashboard')
@section('dashboard')
@php
$user = Auth::guard('admin')->user();
@endphp
<div class="pagetitle bg-light">
    <nav>
        <ol class="breadcrumb p-3 ">
            <li class="breadcrumb-item font-weight-bold"><a href="{{ url('admin/dashboard') }}">Home</a></li>
            <li class="breadcrumb-item">Add color</li>
        </ol>
    </nav>
</div>
<section class="section col-md-12">
    <div class="card border-0">
        <div class="card-body pt-3">
            <h5 class="card-title">Add color</h5>
            <ul class="nav nav-tabs pb-4 align-items-end card-header-tabs w-100">
                <li class="nav-item border-none">
                    <a class="nav-link active bg-light" href="javascript:void(0);"><i class=" fas fa-plus"></i>Add color</a>
                </li>
                @if ($user && $user->hasPermissionByRole('view_color'))
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('colors') }}"><i class="fa fa-list mr-2"></i>All colors</a>
                </li>
                @endif
            </ul>
            <form class=" g-3" action="{{ route('store-color') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" name="name">
                        @error('name')
                        <small class=" text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="color" class="form-label">Color</label>
                        <input type="color" class="form-control " name="color">
                        @error('color')
                        <small class=" text-danger">{{ $message }}</small>
                        @enderror
                    </div>
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

