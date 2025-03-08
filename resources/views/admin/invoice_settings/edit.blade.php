@extends('admindashboard.maindashboard')
@section('dashboard')
@php
$user = Auth::guard('admin')->user();
@endphp
<div class="pagetitle bg-light">
    <nav>
        <ol class="breadcrumb p-3 ">
            <li class="breadcrumb-item font-weight-bold"><a href="{{ url('admin/dashboard') }}">Home</a></li>
            <li class="breadcrumb-item">Invoice settings</li>
        </ol>
    </nav>
</div>
<section class="section col-md-12">
    <div class="card border-0">
        <div class="card-body pt-3">
            <h5 class="card-title">Update Invoice settings</h5>
            <ul class="nav nav-tabs pb-4 align-items-end card-header-tabs w-100">
                <li class="nav-item border-none">
                    <a class="nav-link active bg-light" href="javascript:void(0);"><i class=" fas fa-plus"></i>Update Invoice settings</a>
                </li>
                @if ($user && $user->hasPermissionByRole('view invoice'))
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('invoice-settings') }}"><i class="fa fa-list mr-2"></i> Invoice settingss</a>
                </li>
                @endif
            </ul>
            <form class="g-3" action="{{ route('update-invoice-setting') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="col-md-12">
                    <input type="hidden" name="id" value="{{ $invoicesettings->id }}">
                    <label for="name" class="form-label">Company Name</label>
                    <input type="text" class="form-control" value="{{ $invoicesettings->name }}" name="name">
                    @error('name')
                    <small class=" text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="col-md-12">
                    <label for="email" class="form-label">Company Email</label>
                    <input type="email" class="form-control" value="{{ $invoicesettings->email }}" name="email">
                    @error('email')
                    <small class=" text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="col-md-12">
                    <label for="phone" class="form-label">Company Phone Number</label>
                    <input type="text" class="form-control" value="{{ $invoicesettings->phone }}" name="phone">
                    @error('phone')
                    <small class=" text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="col-md-12">
                    <label for="address" class="form-label">Company Address</label>
                    <input type="text" class="form-control" value="{{ $invoicesettings->address }}" name="address">
                    @error('address')
                    <small class=" text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="col-md-12">
                    <label for="background_color" class="form-label">Invoice background_color</label>
                    <input type="color" class="form-control" value="{{ $invoicesettings->background_color }}" name="background_color">
                    @error('background_color')
                    <small class=" text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="col-md-12">
                    <label for="footer_text" class="form-label">Footer Text</label>
                    <input type="text" class="form-control" value="{{ $invoicesettings->footer_text }}" name="footer_text">
                    @error('footer_text')
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

