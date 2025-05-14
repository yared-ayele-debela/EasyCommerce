@extends('admindashboard.maindashboard')
@section('dashboard')
<section class="section col-md-12">
    <nav class="breadcrumb bg-white shadow-sm py-3 px-4 rounded d-flex justify-content-between align-items-center">
        <button class="btn btn-outline-primary btn-sm d-flex align-items-center" onclick="history.back()">
            <i class="bi bi-arrow-left mr-2"></i> &nbsp;
            <span>Back</span>
        </button>
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item">
                <a href="{{ url('admin/dashboard') }}">Home</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">Update Business detail information</li>
        </ol>
    </nav>
    <h1 class="card-title">Welcome <span style="font-size: 20px; color:rgb(44, 10, 144)"> {{ Auth::guard('admin')->user()->name }}</span></h1>

    <div class="card border-0 shadow-sm">
          <div class="card-header">
           <h5 class="text-dark"> Update Vendor Details</h5>
        </div>
        <div class="card-body">

            <form id="loginForm" class="row g-3" action="{{ url('admin/update_vendor_businessdetails') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-4 pt-3">
                    <label for="vendor_email" class="form-label">Email</label>
                    <input type="text" class="form-control " readonly value="{{Auth::guard('admin')->user()->email}}" name="vendor_email" required>
                    @error('vendor_email')
                    <small class=" text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="col-md-4 pt-3">
                    <label for="shop_name" class="form-label">Shop Name</label>
                    <input type="text" class="form-control" @if(isset($vendorbusiness['shop_name'])) value="{{ $vendorbusiness['shop_name']}}" @endif name="shop_name" pattern="[A-Za-z\s]+" title="Only letters and spaces are allowed" required>
                    @error('shop_name')
                    <small class=" text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="col-md-4 pt-3">
                    <label for="shop_address" class="form-label">Shop Address</label>
                    <input type="text" class="form-control" @if(isset($vendorbusiness['shop_address'])) value="{{ $vendorbusiness['shop_address']}}" @endif name="shop_address" required>
                    @error('shop_address')
                    <small class=" text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="col-md-4 pt-3">
                    <label for="shop_city" class="form-label">Shop City</label>
                    <input type="text" class="form-control" @if(isset($vendorbusiness['shop_city'])) id="city" value="{{ $vendorbusiness['shop_city']}}" @endif name="shop_city" required>
                    @error('shop_city')
                    <small class=" text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="col-md-4 pt-3">
                    <label for="shop_state" class="form-label">Shop State</label>
                    <input type="text" class="form-control" @if(isset($vendorbusiness['shop_state'])) id="state" value="{{ $vendorbusiness['shop_state']}}" @endif name="shop_state" required>
                    @error('shop_state')
                    <small class=" text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="col-md-4 pt-3">
                    <label for="shop_image" class="form-label">Shoping Image</label><br>
                    recommend image size for your shop (4800 x 1200)
                    <input type="file" class="form-control" placeholder="" name="shop_image">
                    @error('shop_image')
                    <small class=" text-danger">{{ $message }}</small>
                    @enderror
                    @if(!empty($vendorbusiness['shop_image']))
                    <img src="{{$vendorbusiness['shop_image']}}" style="width: 40px; height:40px;" class="" alt="">
                    <input type="hidden" name="current_shop_image" value="{{ $vendorbusiness['shop_image'] }}">
                    @endif
                </div>

                <div class="col-md-4 pt-3">
                    <label for="shop_country" class="form-label">Country</label>
                    <select class="form-select" id="shop_country" name="shop_country">
                        <option value="">Select country</option>
                        @foreach ($country as $country)
                        <option value="{{ $country['country_name'] }}" @if(isset($vendorbusiness['shop_country']) && $country['country_name']==$vendorbusiness['shop_country']) selected @endif>{{ $country['country_name'] }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4 pt-3">
                    <label for="shop_pincode" class="form-label">Shop pincode</label>
                    <input type="number" class="form-control" id="pincode" @if(isset($vendorbusiness['shop_pincode'])) value="{{ $vendorbusiness['shop_pincode']}}" @endif name="shop_pincode" required>
                    @error('shop_pincode')
                    <small class=" text-danger">{{ $message }}</small>
                    @enderror
                </div>


                <div class="col-md-4 pt-3">
                    <label for="shop_mobile" class="form-label">Shop Mobile </label>
                    <input type="number" class="form-control" id="mobile" pattern=".{10,}" title="Enter vaid phone number" name="shop_mobile" @if(isset($vendorbusiness['shop_mobile'])) value="{{ $vendorbusiness['shop_mobile']}}" @endif>
                    @error('shop_mobile')
                    <small class=" text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="col-md-4 pt-3">
                    <label for="shop_website" class="form-label">Shop Website</label>
                    <input type="text" class="form-control" @if(isset($vendorbusiness['shop_website'])) value="{{ $vendorbusiness['shop_website']}}" @endif name="shop_website">
                    @error('shop_website')
                    <small class=" text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="col-md-4 pt-3">
                    <label for="shop_email" class="form-label">Shop Email </label>
                    <input type="email" class="form-control" @if(isset($vendorbusiness['shop_email'])) value="{{ $vendorbusiness['shop_email']}}" @endif required name="shop_email" required>
                    @error('shop_email')
                    <small class=" text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="col-md-4 pt-3">
                    <label for="address_proof" class="form-label">Address Proof</label>
                    <select class="form-select" id="address_proof" name="address_proof">
                        <option value="Passport" @if(isset($vendorbusiness['address_proof']) && $vendorbusiness['address_proof']=="Passport" )selected @endif>Passport</option>
                        <option value="Voting Card" @if(isset($vendorbusiness['address_proof']) && $vendorbusiness['address_proof']=="Voting Card" )selected @endif>Voting Card</option>
                        <option value="PAN" @if(isset($vendorbusiness['address_proof']) && $vendorbusiness['address_proof']=="PAN" )selected @endif>PAN</option>
                        <option value="PAN" @if(isset($vendorbusiness['address_proof']) && $vendorbusiness['address_proof']=="Driving License" )selected @endif>Driving License</option>
                    </select>
                </div>
                <div class="col-md-4 pt-3">
                    <label for="address_proof_image" class="form-label">Address Proof Image</label>
                    <input type="file" class="form-control" placeholder="" name="address_proof_image">
                    @error('address_proof_image')
                    <small class=" text-danger">{{ $message }}</small>
                    @enderror
                    @if(!empty($vendorbusiness['address_proof_image']))
                    <img src="{{ $vendorbusiness['address_proof_image'] }}" style="width: 40px; height:40px;" class="" alt="">
                    <input type="hidden" name="current_address_proof" value="{{ $vendorbusiness['address_proof_image'] }}">
                    @endif
                </div>
                <div class="col-md-4 pt-3">
                    <label for="business_license_number" class="form-label">Business License Number</label>
                    <input type="number" class="form-control" @if(isset($vendorbusiness['business_license_number'])) value="{{ $vendorbusiness['business_license_number']}}" @endif name="business_license_number" required>
                    @error('business_license_number')
                    <small class=" text-danger">{{ $message }}</small>
                    @enderror
                </div>
                </div>
                <div class="form-group pt-3   ">
                    <input type="submit" class="btn lightblue btn-primary pt-2 pb-2 shadow" value="Update Vendor Business Details">
                </div>
            </form>
        </div>
    </div>
</section>

@endsection

