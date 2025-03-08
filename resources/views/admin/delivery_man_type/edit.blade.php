@extends('admindashboard.maindashboard')
@section('dashboard')
@php
$user = Auth::guard('admin')->user();
@endphp
<div class="pagetitle bg-light">
    <nav>
        <ol class="breadcrumb p-3 ">
            <li class="breadcrumb-item font-weight-bold"><a href="{{ url('admin/dashboard') }}">Home</a></li>
            <li class="breadcrumb-item">Edit delivery_man_type</li>
        </ol>
    </nav>
</div>
<section class="section col-md-12">
    <div class="card border-0">
        <div class="card-body pt-3">
            <h5 class="card-title">Edit delivery_man_type</h5>
            <ul class="nav nav-tabs pb-4 align-items-end card-header-tabs w-100">
                <li class="nav-item border-none">
                    <a class="nav-link active bg-light" href="javascript:void(0);"><i class=" fas fa-plus"></i>Edit delivery_man_type</a>
                </li>
                @if ($user && $user->hasPermissionByRole('view deliveryman type'))
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('delivery_man_type') }}"><i class="fa fa-list mr-2"></i>All delivery_man_types</a>
                </li>
                @endif
            </ul>
            <form class=" g-3" action="{{ route('update-delivery_man_type') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="col-md-12">
                    <input type="hidden" name="id" value="{{$delivery_man_type->id }}">
                    <label for="name" class="form-label">delivery_man_type</label>
                    <input type="text" class="form-control" value="{{ $delivery_man_type->name }}" name="name">
                    @error('name')
                    <small class=" text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-group pt-3 ">
                    <input type="submit" class=" btn btn-primary pt-2 pb-2 shadow" value="Submit">
                </div>
            </form>
        </div>
    </div>
    </div>
    </div>
</section>
@endsection

