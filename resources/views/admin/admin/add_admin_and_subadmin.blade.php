@extends('admindashboard.maindashboard')
@section('dashboard')
@php
$user = Auth::guard('admin')->user();
@endphp
<div class="pagetitle bg-light shadow-sm">
    <nav>
        <ol class="breadcrumb p-3 ">
            <li class="breadcrumb-item font-weight-bold"><a href="javascript:void(0);">home</a></li>
            <li class="breadcrumb-item">add admin</li>
        </ol>
    </nav>
</div>
<section class="section col-md-12">
    <div class="card">
        <div class="card-header">
            @if ($user && $user->hasPermissionByRole('view_admin'))
                <a class="btn btn-primary" href="{{ route('alladmins') }}">Lists of admins</a>
            @endif
        </div>
        <div class="card-body pt-3">

            <form id="loginForm" action="{{ route('store_admin_or_subadmin') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                <div class="col-md-6 pt-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control" id="name" name="name">
                    @error('name')
                    <small class=" text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="col-md-6 pt-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" required name="email">
                    @error('email')
                    <small class=" text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>

               <div class="row">
                <div class="col-md-6 pt-3">
                    <label for="type" class="form-label">Admin Type</label>
                    <select class="form-select" required name="type">
                        <option value="">Select Admin Type</option>
                        @foreach ($role as $ro)
                        <option value="{{$ro->name}}">{{ $ro->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6 pt-3">
                    <label for="mobile" class="form-label">Mobile</label>
                    <input type="number" class="form-control" id="mobile" name="mobile">
                    @error('mobile')
                    <small class=" text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>
                <div class="row">
                <div class="col-md-6 pt-3">
                    <label for="image" class="form-label">Image</label>
                    <input type="file" class="form-control" name="image">
                    @error('image')
                    <small class=" text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="col-md-6 pt-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password">
                    @error('password')
                    <small class=" text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>
                <div class="form-group pt-3">
                    <input type="submit" class=" btn lightblue btn-primary pt-2 pb-2 shadow" value="Submit">
                </div>
            </form>
        </div>
    </div>
    </div>
    </div>
</section>

@endsection

