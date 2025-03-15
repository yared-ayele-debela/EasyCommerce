@extends('admindashboard.maindashboard')
@section('dashboard')
@php
$user = Auth::guard('admin')->user();
@endphp
<div class="pagetitle bg-light">
    <nav>
        <ol class="breadcrumb p-3 ">
            <li class="breadcrumb-item font-weight-bold"><a href="{{ url('admin/dashboard') }}">Home</a></li>
            <li class="breadcrumb-item">add permissions</li>
        </ol>
    </nav>
</div>
<section class="section col-md-8">
    <div class="card">
        <div class="card-header">
            @if ($user && $user->hasPermissionByRole('view permission'))
                    <a class="btn btn-primary" href="{{ route('permissions.index') }}">All Permissionss</a>
            @endif
        </div>
        <div class="card-body pt-3">
            <form class="row g-3" action="{{ route('permissions.store') }}" method="POST" >
                @csrf
                <div class="col-md-6">
                    <label for="name" class="form-label">Permissions Name</label>
                    <input type="text" class="form-control" name="name">
                    @error('name')
                    <small class=" text-danger">{{ $message }}</small>
                    @enderror
                    <div class="form-group">
                        <label for="category">Category</label>
                        <select class="form-control" name="category_id" >
                            <option value="" disabled selected>select one</option>
                         @foreach($category as $key => $cate)
                         <option value="{{ $cate->id }}">{{ $cate->name }}</option>
                         @endforeach
                        </select>
                        @error('category_id')
                        <small class=" text-danger">{{ $message }}</small>
                        @enderror
                      </div>
                </div>
                <div class="form-group pt-3 ">
                    <input type="submit" class=" btn btn-primary  pt-2 pb-2 shadow" value="Create">
                </div>
            </form>
        </div>
    </div>
    </div>
    </div>
</section>
@endsection

