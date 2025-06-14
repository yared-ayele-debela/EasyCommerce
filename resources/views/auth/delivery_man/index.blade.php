@extends('all_frontend_layouts.layouts')

@section('content')
<div class="container d-flex align-items-center justify-content-center">
    <div class="row py-4">
        <div class="card mb-2">
            <div class="card-body pt-4">
            <h4 class="text-center mb-2 text-primary">Easy eCommerce, Hotel Booking, and Food Delivery</h4>
            <h6 class="text-center mb-2 text-dark">Create Delivery Man Account</h6>
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            @if(session('info'))
            <div class="alert alert-warning">{{ session('info') }}</div>
            @endif
                <form action="{{ route('delivery_man.register') }}" method="POST" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-4">
                            @csrf
                            <div class="form-group m-3">
                                <label for="first_name">First Name</label>
                                <input type="text" name="first_name" id="first_name" class="form-control" required>
                                @error('first_name')
                                <small class=" text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group m-3">
                                <label for="last_name">Last Name</label>
                                <input type="text" name="last_name" id="last_name" class="form-control" required>
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
                            </div>
                            <div class="form-group m-3">
                                <label for="address">Address</label>
                                <input type="text" name="address" id="address" class="form-control" required>
                                @error('address')
                                <small class=" text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group m-3">
                                <label for="country">Country</label>
                                <select class="form-control" name="country" id="country">
                                    <option value="" disabled selected>Select one</option>
                                    @foreach ($country as $coun)
                                    <option value="{{ $coun->country_name }}">{{ $coun->country_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group m-3">
                                <label for="state">State</label>
                                <select class="form-control" name="state" id="">
                                    <option selected value="" disabled>Select one</option>
                                    @foreach ($state as $state)
                                    <option value="{{ $state->name }}">{{ $state->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group m-3">
                                <label for="city">City</label>
                                <select class="form-control" name="city" id="">
                                    <option selected value="" disabled>Select one</option>
                                    @foreach ($city as $city)
                                    <option value="{{ $city->name }}">{{ $city->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group m-3">
                                <label for="identity_type">Identity Type</label>
                                <input type="text" name="identity_type" id="identity_type" class="form-control" required>
                                @error('identity_type')
                                <small class=" text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group m-3">
                                <label for="identity_number">Identity Number</label>
                                <input type="text" name="identity_number" id="identity_number" class="form-control" required>
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
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group m-3">
                                <label for="phone">Phone</label>
                                <input type="text" name="phone" id="phone" class="form-control" required>
                                @error('phone')
                                <small class=" text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group m-3">
                                <label for="email">Email</label>
                                <input type="email" name="email" id="email" class="form-control" required>
                                @error('email')
                                <small class=" text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group m-3">
                                <label for="password">Password</label>
                                <input type="password" name="password" id="password" class="form-control" required>
                                @error('password')
                                <small class=" text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group m-3">
                                <label for="confirm_password">Confirm Password</label>
                                <input type="password" name="confirm_password" id="confirm_password" class="form-control" required>
                                @error('confirm_password')
                                <small class=" text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                                                        <div class="form-group m-3">
                                <label for="delivery_zone">Delivery Zone</label>
                                <select class="form-control" name="delivery_zone" id="delivery_zone">
                                    <option selected disabled value="">select one</option>
                                    @foreach ($delivery_zone as $delivery_zone)
                                    <option value="{{ $delivery_zone->name }}">{{ $delivery_zone->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @error('delivery_zone')
                            <small class=" text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <div class="form-group m-3">
                                <label for="vehicle_type">Vehicle Type</label>
                                <select class="form-control" name="vehicle_type" id="vehicle_type">
                                    <option selected disabled value="">select one</option>
                                    @foreach ($vehicle_type as $vehicle_type)
                                    <option value="{{ $vehicle_type->name }}">{{ $vehicle_type->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @error('vehicle_type')
                            <small class=" text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-md-4">

                            <div class="form-group m-3">
                                <label for="driving_license_number">Driving License Number</label>
                                <input type="text" name="driving_license_number" id="driving_license_number" class="form-control" required>
                                @error('identity_number')
                                <small class=" text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">

                            <div class="form-group m-3">
                                <label for="driving_license_image" class="form-lable">Driving License Image</label>
                                <input type="file" name="driving_license_image" id="driving_license_image" class="form-control" accept="image/*">
                                @error('driving_license')
                                <small class=" text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <button type="submit" class="btn btn-primary m-3">Register</button>

                            </div>
                        </div>
                    </div>
            </div>
            </form>
        </div>
    </div>
</div>
</div>
@endsection

