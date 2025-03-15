@extends('admindashboard.maindashboard')
@section('dashboard')
@php
$user = Auth::guard('admin')->user();
@endphp
<div class="pagetitle bg-light">
    <nav>
        <ol class="breadcrumb p-3 ">
            <li class="breadcrumb-item font-weight-bold"><a href="{{ url('admin/dashboard') }}">Home</a></li>
            <li class="breadcrumb-item">edit permissions</li>
        </ol>
    </nav>
</div>
<section class="section col-md-8">
    <div class="card">
        <div class="card-header">
            @if($user && $user->hasPermissionByRole('view permission'))
                    <a class="btn btn-primary" href="{{ route('permissions.index') }}">All Permissionss</a>
            @endif
        </div>
        <div class="card-body pt-3">
            <form class="row g-3" action="{{ route('permissions.update', $permission->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="col-md-6">
                    <label for="name" class="form-label">Permissions Name</label>
                    <input type="hidden" name="id" value="{{ $permission->id }}">
                    <input type="text" value="{{ $permission->name }}" class="form-control" name="name" required>
                    @error('name')
                    <small class=" text-danger">{{ $message }}</small>
                    @enderror
                    <div class="form-group">
                        <label for="category">Category</label>
                        <select class="form-control" name="category_id" >
                         @foreach($category as $key => $cate)
                         <option @if($permission->category_id==$cate->id) selected @endif value="{{ $cate->id }}">{{ $cate->name }}</option>
                         @endforeach
                        </select>
                        @error('category_id')
                        <small class=" text-danger">{{ $message }}</small>
                        @enderror
                    </div>
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

