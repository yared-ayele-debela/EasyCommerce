@extends('admindashboard.maindashboard')
@section('dashboard')
@php
$user = Auth::guard('admin')->user();
@endphp
<div class="pagetitle bg-light">
    <nav>
        <ol class="breadcrumb p-3 ">
            <li class="breadcrumb-item font-weight-bold"><a href="{{ url('admin/dashboard') }}">Home</a></li>
            <li class="breadcrumb-item">Edit Delivery Boy</li>
        </ol>
    </nav>
</div>
<section class="section col-md-12">
    <div class="card border-0">
        <div class="card-body pt-3">
            <ul class="nav nav-tabs pb-4 align-items-end card-header-tabs w-100">
                @if ($user && $user->hasPermissionByRole('view_delivery_boy'))
                    <a class="btn btn-primary" href="{{ url('admin/delivery_boy') }}"><i class="fa fa-list mr-2"></i>All Delivery Boy</a>
                @endif
            </ul>
            <div class="row">
                <div class="col-md-6">
                    <form action="{{ url('admin/delivery_boy/'.$deliveryman->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form-group m-3">
                            <label for="first_name">First Name</label>
                            <input type="text" name="first_name" value="{{ $deliveryman->first_name }}" id="first_name" class="form-control" required>
                            @error('first_name')
                            <small class=" text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group m-3">
                            <label for="last_name">Last Name</label>
                            <input type="text" name="last_name" id="last_name" value="{{ $deliveryman->last_name }}" class="form-control" required>
                            @error('last_name')
                            <small class=" text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group m-3">
                            <label for="delivery_man_image" class="form-lable">Profile Image</label>
                            <input type="file" name="delivery_man_image" id="delivery_man_image" class="form-control" accept="image/*">
                            @error('delivery_man_image')
                            <small class=" text-danger">{{ $message }}</small>
                            @enderror
                            <img src="{{ asset('/storage/delivery_man/'.$deliveryman->delivery_man_image) }}" style="width: 50px; height:50px" alt="">
                        </div>
                        <div class="form-group m-3">
                            <label for="address">Address</label>
                            <input type="text" name="address" value="{{ $deliveryman->address }}" id="address" class="form-control" required>
                            @error('address')
                            <small class=" text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group m-3">
                            <label for="country">Country</label>
                            <select class="form-control" name="country" id="country">
                                <option value="" disabled selected>Select one</option>
                                @foreach ($country as $coun)
                                  <option @if($deliveryman->country == $coun->country_name) selected @endif value="{{ $coun->country_name }}">{{ $coun->country_name }}</option>
                                @endforeach
                            </select>
                        </div>
                </div>

                <div class="col-md-6">

                    <div class="form-group m-3">
                        <label for="state">State</label>
                        <select class="form-control" name="state" id="">
                            <option selected value="" disabled>Select one</option>
                            @foreach ($state as $state)
                            <option @if($deliveryman->state == $state->name) selected  @endif value="{{ $state->name }}" >{{ $state->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group m-3">
                        <label for="city">City</label>
                        <select class="form-control" name="city" id="">
                            <option selected value="" disabled>Select one</option>
                            @foreach ($city as $city)
                            <option @if($city->name == $deliveryman->city) selected  @endif  value="{{ $city->name }}">{{ $city->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group m-3">
                        <label for="identity_type">Identity Type</label>
                        <input type="text" name="identity_type" value="{{ $deliveryman->identity_type }}" id="identity_type" class="form-control" required>
                        @error('identity_type')
                        <small class=" text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group m-3">
                        <label for="identity_number">Identity Number</label>
                        <input type="text" name="identity_number" id="identity_number" value="{{ $deliveryman->identity_number }}"  class="form-control" required>
                        @error('identity_number')
                        <small class=" text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group m-3">
                        <label for="identity_image" class="form-lable">Identity Image</label>
                        <input type="file" name="identity_image" id="identity_image" class="form-control" accept="image/*">
                        @error('identity_image')
                        <small class=" text-danger">{{ $message }}</small>
                        @enderror
                        @if($deliveryman->identity_image)
                        <img src="{{ asset('/storage/delivery_man/'.$deliveryman->identity_image) }}" style="width: 50px; height:50px" alt="">
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card shadow-sm border-0">
            <div class="card-header bg-white border-0 pt-4 pl-4">
               <h1 style="font-size: 24px; font-weight:bold; ">Account Information</h1>
            </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-5">
                    <div class="form-group m-3">
                        <label for="phone">Phone</label>
                        <input type="text" name="phone" id="phone" value="{{ $deliveryman->phone }}" class="form-control" required>
                        @error('phone')
                        <small class=" text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                </div>
                <div class="col-md-5">
                    <div class="form-group m-3">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" value="{{ $deliveryman->email }}" class="form-control" required>
                        @error('email')
                        <small class=" text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group m-3">
                      <label for="status">Status</label>
                      <select class="form-control" name="status" id="">
                        <option value="" selected disabled>select one</option>
                        <option @if($deliveryman->status =="available") selected @endif value="available">Available</option>
                        <option  @if($deliveryman->status =="delivering") selected @endif value="delivering">delivering</option>
                      </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white border-0 pt-4 pl-4">
           <h1 style="font-size: 24px; font-weight:bold; ">Delivery Information</h1>
        </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-5">
                <div class="form-group m-3">
                    <div class="form-group m-3">
                      <label for="delivery_man_type">Delivery Man Type</label>
                      <select class="form-control" name="delivery_man_type" id="delivery_man_type">
                        <option selected disabled value="">select one</option>
                        @foreach ($delivery_man_type as $delivery_man_type)
                        <option @if($deliveryman->delivery_man_type== $delivery_man_type->name ) selected @endif value="{{ $delivery_man_type->name }}">{{ $delivery_man_type->name }}</option>
                        @endforeach
                      </select>
                    </div>
                    @error('delivery_man_type')
                    <small class=" text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-group m-3">
                    <div class="form-group m-3">
                      <label for="delivery_zone">Delivery Zone</label>
                      <select class="form-control" name="delivery_zone" id="delivery_zone">
                        <option selected disabled value="">select one</option>
                        @foreach ($delivery_zone as $delivery_zone)
                        <option @if($deliveryman->delivery_zone == $delivery_zone->name ) selected @endif  value="{{ $delivery_zone->name }}">{{ $delivery_zone->name }}</option>
                        @endforeach
                      </select>
                    </div>
                    @error('delivery_zone')
                    <small class=" text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-group m-3">
                    <div class="form-group m-3">
                      <label for="vehicle_type">Vehicle Type</label>
                      <select class="form-control" name="vehicle_type" id="vehicle_type">
                        <option selected disabled value="">select one</option>
                        @foreach ($vehicle_type as $vehicle_type)
                        <option  @if($deliveryman->vehicle_type == $vehicle_type->name ) selected @endif  value="{{ $vehicle_type->name }}">{{ $vehicle_type->name }}</option>
                        @endforeach
                      </select>
                    </div>
                    @error('vehicle_type')
                    <small class=" text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>
            <div class="col-md-5">
                <div class="form-group m-3">
                    <label for="vehicle_capacity">Vehicle Capactiy</label>
                    <input type="text" name="vehicle_capacity" value="{{ $deliveryman->vehicle_capacity }}" id="vehicle_capacity" class="form-control" required>
                    @error('vehicle_capacity')
                    <small class=" text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-group m-3">
                    <label for="driving_license_number">Driving License Number</label>
                    <input type="text" name="driving_license_number" value="{{ $deliveryman->driving_license_number }}" id="driving_license_number" class="form-control" required>
                    @error('identity_number')
                    <small class=" text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-group m-3">
                    <label for="driving_license_image" class="form-lable">Driving License Image</label>
                    <input type="file" name="driving_license_image" id="driving_license_image" class="form-control" accept="image/*">
                    @error('driving_license')
                    <small class=" text-danger">{{ $message }}</small>
                    @enderror
                    @if($deliveryman->driving_license_image)
                    <img src="{{ asset('/storage/delivery_man/'.$deliveryman->driving_license_image) }}" style="width: 50px; height:50px" alt="">
                    @endif
                </div>

                <div class="form-group m-3">
                    <br>
                    <button type="submit" class="btn btn-primary">Update Delivery Boy</button>
                </form>
                </div>
            </div>
        </div>
    </div>
</div>
</section>
@endsection

