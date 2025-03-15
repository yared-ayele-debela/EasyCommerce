@extends('admindashboard.maindashboard')
@section('dashboard')
@php
$user = Auth::guard('admin')->user();
@endphp
<div class="pagetitle bg-light">
    <nav>
        <ol class="breadcrumb p-3 ">
            <li class="breadcrumb-item font-weight-bold"><a href="{{ url('admin/dashboard') }}">Home</a></li>
            <li class="breadcrumb-item">edit brand</li>
        </ol>
    </nav>
</div>
<section class="section col-md-12">
    <div class="card">
        <div class="card-body pt-3">
            <ul class="nav nav-tabs pb-4 align-items-end card-header-tabs w-100">
                @if ($user && $user->hasPermissionByRole('view_brand'))
                    <a class="btn btn-primary" href="{{ route('brands') }}"><i class="fa fa-list mr-2"></i>All Brands</a>
                @endif
            </ul>
            <form class="row g-3" action="{{ url('admin/brands/update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <input type="hidden" name="id" value="{{ $brand->id }}">
                <div class="col-md-12">
                    <label for="name" class="form-label">Brand Name</label>
                    <input type="text" class="form-control" value="{{ $brand->name }}" name="name">
                    @error('name')
                    <small class=" text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="col-md-12">
                    <label for="image" class="form-label">Brand Image</label>
                    <input type="file" class="form-control" value="{{ $brand->image }}" name="image">
                    <small>Recomended size for image (139 x 97)</small>
                    @error('image')
                    <small class=" text-danger">{{ $message }}</small>
                    @enderror
                    <div class="pt-3">
                        <div class="row">
                            <img src="{{ asset('/storage/brand/'.$brand->image) }}" style="width:80px; margin-left:15px;  border:1px solid black; height:50px" class=" rounded" alt="">
                        </div>
                    </div>
                </div>


                <div class="form-group pt-3 ">
                    <input type="submit" class=" btn btn-primary pt-2 pb-2 shadow" value="Update">
                </div>
            </form>
        </div>
    </div>

</section>
@endsection

