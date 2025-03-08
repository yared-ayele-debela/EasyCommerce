@extends('admindashboard.maindashboard')
@section('dashboard')
@php
$user = Auth::guard('admin')->user();
@endphp
<div class="pagetitle bg-light">
    <nav>
       <ol class="breadcrumb p-3 ">
          <li class="breadcrumb-item font-weight-bold"><a href="{{ url('admin/dashboard') }}">Home</a></li>
          <li class="breadcrumb-item">Add Filter Value</li>
       </ol>
    </nav>
 </div>
 <section class="section col-md-12" >
   <div class="card" >
      <div class="card-body pt-3">
                     <h5 class="card-title">Add Filter Value</h5>
                     <ul class="nav nav-tabs pb-4 align-items-end card-header-tabs w-100">
                        <li class="nav-item border-none">
                           <a class="nav-link active bg-light" href=""><i class=" fas fa-plus"></i>Add Filter Value</a>
                         </li>
                         @if ($user && $user->hasPermissionByRole('view_filter_value'))
                        <li class="nav-item">
                          <a class="nav-link " href="{{ route('filters') }}"><i class="fa fa-list mr-2"></i>All Filter Values</a>
                        </li>
                        @endif

                       </ul>
                     <form class="row g-3" action="{{ url('admin/filters/store_filter_value') }}" method="POST" enctype="multipart/form-data" >
                        @csrf
                        <div class="col-md-12  ">
                            <label>Select Filter</label>
                            <select name="filter_id" id="filter_id" class="form-control" >
                                <option value="">Select</option>
                                 @foreach ($filters as $filter)
                                       <option value="{{ $filter['id'] }}">{{ $filter['filter_name'] }}</option>
                                 @endforeach
                            </select>
                           </div>
                        <div class="col-md-12">
                           <label for="filter_value" class="form-label">Filter Value</label>
                            <input type="text" class="form-control" name="filter_value">
                            @error('filter_value')
                            <small class=" text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group pt-3 ">
                        <input type="submit" class=" btn btn-primary pt-2 pb-2 shadow" value="Save Filter Value">
                        </div>
          </form>
         </div>
        </div>
      </div>
      </div>
 </section>
@endsection
