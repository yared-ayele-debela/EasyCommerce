@extends('admindashboard.maindashboard')
@section('dashboard')
@php
$user = Auth::guard('admin')->user();
@endphp
<div class="pagetitle bg-light">
    <nav>
       <ol class="breadcrumb p-3 ">
          <li class="breadcrumb-item font-weight-bold"><a href="{{ url('admin/dashboard') }}">Home</a></li>
          <li class="breadcrumb-item">Add shipping charges</li>
       </ol>
    </nav>
 </div>
 <section class="section col-md-12" >
   <div class="card" >
      <div class="card-body pt-3">
                     <h5 class="card-title">Add shipping charges</h5>
                     <ul class="nav nav-tabs pb-4 align-items-end card-header-tabs w-100">
                        <li class="nav-item border-none">
                           <a class="nav-link active bg-light" href=""><i class=" fas fa-plus"></i>Add shipping charges</a>
                         </li>
                         @if ($user && $user->hasPermissionByRole('view_shipping_charge'))
                        <li class="nav-item">
                          <a class="nav-link " href="{{ url('admin/shipping-charges') }}"><i class="fa fa-list mr-2"></i>All shipping charges</a>
                        </li>
                        @endif
                       </ul>
                     <form class="g-3" action="{{ url('admin/shipping-charges/store') }}" method="POST" enctype="multipart/form-data" >
                        @csrf
                        <div class="col-md-12">
                           <div class="form-group">
                             <label for="city">City</label>
                             <select class="form-control"  name="city" id="">
                               <option value="" selected disabled>select city</option>
                               @foreach ($city as $city)
                               <option value="{{ $city->name }}">{{ $city->name }}</option>
                               @endforeach
                             </select>
                             @error('city')
                             <small class=" text-danger">{{ $message }}</small>
                             @enderror
                           </div>
                        </div>
                        <div class="col-md-12">
                            <label for="0_500g" class="form-label">0_500g</label>
                             <input type="number"  class="form-control" name="0_500g">
                             @error('0_500g')
                             <small class=" text-danger">{{ $message }}</small>
                             @enderror
                         </div>
                         <div class="col-md-12">
                            <label for="501_1000g" class="form-label">501_1000g</label>
                             <input type="number"  class="form-control" name="501_1000g">
                             @error('501_1000g')
                             <small class=" text-danger">{{ $message }}</small>
                             @enderror
                         </div>
                         <div class="col-md-12">
                            <label for="1001_2000g" class="form-label">1001_2000g</label>
                             <input type="number"  class="form-control" name="1001_2000g">
                             @error('1001_2000g')
                             <small class=" text-danger">{{ $message }}</small>
                             @enderror
                         </div>
                         <div class="col-md-12">
                            <label for="2001_5000g" class="form-label">2001_5000g</label>
                             <input type="number"   class="form-control" name="2001_5000g">
                             @error('2001_5000g')
                             <small class=" text-danger">{{ $message }}</small>
                             @enderror
                         </div>
                          <div class="col-md-12">
                            <label for="above_5000g" class="form-label">above_5000g</label>
                             <input type="number"  class="form-control" name="above_5000g">
                             @error('above_5000g')
                             <small class=" text-danger">{{ $message }}</small>
                             @enderror
                         </div>
                     <div class="form-group pt-3 ">
                     <input type="submit" class=" btn btn-primary pt-2 pb-2 shadow" value="Update Shipping Charges">
                     </div>
          </form>
         </div>
        </div>
      </div>
      </div>
 </section>
@endsection
