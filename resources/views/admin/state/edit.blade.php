@extends('admindashboard.maindashboard')
@section('dashboard')
@php
$user = Auth::guard('admin')->user();
@endphp
<div class="pagetitle bg-light">
    <nav>
        <ol class="breadcrumb p-3 ">
            <li class="breadcrumb-item font-weight-bold"><a href="{{ url('admin/dashboard') }}">Home</a></li>
            <li class="breadcrumb-item">Update State</li>
        </ol>
    </nav>
</div>
<section class="section col-md-12">
    <div class="card border-0">
        <div class="card-body pt-3">
            <h5 class="card-title">Update State</h5>
            <ul class="nav nav-tabs pb-4 align-items-end card-header-tabs w-100">
                <li class="nav-item border-none">
                    <a class="nav-link active bg-light" href="javascript:void(0);"><i class=" fas fa-plus"></i>Update State</a>
                </li>
                @if ($user && $user->hasPermissionByRole('view state'))
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('states') }}"><i class="fa fa-list mr-2"></i>All States</a>
                </li>
                @endif
            </ul>
            <form class=" g-3" action="{{ route('update-state') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="col-md-12">
                    <input type="hidden" name="id" value="{{ $state->id }}">
                    <label for="name" class="form-label">state Name</label>
                    <input type="text" class="form-control" value="{{ $state->name }}" name="name">
                    @error('name')
                    <small class=" text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="country_id"></label>
                        <select class="form-control" name="country_id" id="country_id">
                            @foreach ($countries as $country)
                            <option value="{{ $country->id }}">{{ $country->country_name }}</option>    
                            @endforeach              
                        </select>
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
