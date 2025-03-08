@extends('admindashboard.maindashboard')
@section('dashboard')
@php
$user = Auth::guard('admin')->user();
@endphp
<div class="pagetitle bg-light">
    <nav>
        <ol class="breadcrumb p-3 ">
            <li class="breadcrumb-item font-weight-bold"><a href="{{ url('admin/dashboard') }}">Home</a></li>
            <li class="breadcrumb-item">update city</li>
        </ol>
    </nav>
</div>
<section class="section col-md-12">
    <div class="card border-0">
        <div class="card-body pt-3">
            <ul class="nav nav-tabs pb-4 align-items-end card-header-tabs w-100">
                @if ($user && $user->hasPermissionByRole('view city'))
                    <a class="btn btn-primary" href="{{ route('cities') }}"><i class="fa fa-list mr-2"></i>All citys</a>
                @endif
            </ul>
            <form class=" g-3" action="{{ route('update-city') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="col-md-12">
                    <input type="hidden" name="id" value="{{ $city->id }}">
                    <label for="name" class="form-label">City Name</label>
                    <input type="text" class="form-control" value="{{ $city->name }}" name="name">
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
