@extends('admindashboard.maindashboard')
@section('dashboard')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
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
            <li class="breadcrumb-item active" aria-current="page">Update detail information</li>
        </ol>
    </nav>
    <h1 class="card-title">Welcome <span style="font-size: 20px; color:rgb(44, 10, 144)"> {{ Auth::guard('admin')->user()->name }}</span></h1>

    <div class="card">
        <div class="card-header">
           <h5 class="text-dark"> Update Vendor Details</h5>
        </div>
        <div class="card-body ">
            <form id="loginForm" action="{{ url('admin/update_vendor_details') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-4 pt-3">
                    <label for="vendor_email" class="form-label">Email</label>
                    <input type="text" class="form-control " readonly value="{{  $vendorDetails['email'] }}" name="vendor_email" required>
                    @error('vendor_email')
                    <small class=" text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="col-md-4 pt-3">
                    <label for="vendor_name" class="form-label">Name</label>
                    <input type="text" class="form-control" value="{{  $vendorDetails['name'] }}" id="name" name="vendor_name" pattern="[A-Za-z\s]+" title="Only letters and spaces are allowed" required>
                    @error('vendor_name')
                    <small class=" text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="col-md-4 pt-3">
                    <label for="vendor_address" class="form-label">Address</label>
                    <input type="text" class="form-control" value="{{  $vendorDetails['address'] }}" id="address" name="vendor_address" required>
                    @error('vendor_address')
                    <small class=" text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="col-md-4 pt-3">
                    <div class="form-group">
                      <label for="zone">Delivery zone</label>
                      <select class="form-control select-delivery-zone" name="zone"  id="zone" required>
                        <option value="" selected disabled>Select delivery zone</option>
                        @foreach ($zones as $zoon)
                        <option value="{{ $zoon->name }}" @if($zoon->name==$vendorDetails['zone']) selected @endif>{{ $zoon->name }}</option>
                        @endforeach
                      </select>
                    </div>
                </div>
                <div class="col-md-4 pt-3">
                    <label for="vendor_city" class="form-label">City</label>
                    <input type="text" class="form-control" value="{{  $vendorDetails['city'] }}" id="city" name="vendor_city" required>
                    @error('vendor_city')
                    <small class=" text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="col-md-4 pt-3">
                    <label for="vendor_state" class="form-label">State</label>
                    <input type="text" class="form-control" value="{{  $vendorDetails['state'] }}" id="state" name="vendor_state" required>
                    @error('vendor_state')
                    <small class=" text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="col-md-4 pt-3">
                    <label for="vendor_country" class="form-label">Country</label>
                    <select class="form-select" id="vendor_country" id="country" name="vendor_country">
                        <option value="">Select country</option>
                        @foreach ($country as $country)
                        <option value="{{ $country['country_name'] }}" @if($country['country_name']==$vendorDetails['country']) selected @endif>{{ $country['country_name'] }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4 pt-3">
                    <label for="vendor_pincode" class="form-label">Pincode</label>
                    <input type="text" class="form-control" id="pincode" value="{{  $vendorDetails['pincode'] }}" name="vendor_pincode" required>
                    @error('vendor_pincode')
                    <small class=" text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="col-md-4 pt-3">
                    <label for="vendor_mobile" class="form-label">Mobile</label>
                    <input type="text" class="form-control" id="mobile" value="{{  $vendorDetails['mobile'] }}" name="vendor_mobile" pattern=".{10,}" title="Enter vaid phone number">
                    @error('vendor_mobile')
                    <small class=" text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="col-md-4 pt-3">
                    <label for="vendor_image" class="form-label">Image</label>
                    <input type="file" class="form-control" placeholder="" name="vendor_image">
                    @error('vendor_image')
                    <small class=" text-danger">{{ $message }}</small>
                    @enderror
                    @if(!empty(Auth::guard('admin')->user()->image))
                    <img src="{{ asset('storage/' . Auth::guard('admin')->user()->image) }}" style="width: 40px; height:40px;" class="" alt="">
                    @endif
                </div>
                </div>
                <div class="form-group pt-3">
                    <input type="submit" class=" btn lightblue btn-primary pt-2 pb-2 shadow" value="Update Vendor Details">
                </div>
            </form>
        </div>
    </div>
</section>
<script>
    // Form validation function
    function validateForm() {
        const name = document.getElementById("name");
        const adddress = document.getElementById("address");
        const city = document.getElementById("city");
        const state = document.getElementById("state");
        const pincode = document.getElementById("pincode");
        const mobile = document.getElementById("mobile");

        if (!/^[A-Za-z\s]+$/.test(name.value)) {
            alert("Invalid name! Only characters are allowed.");
            name.focus();
            event.preventDefault();
            return false;
        }
        if (!/^[A-Za-z\s]+$/.test(city.value)) {
            alert("Invalid city! Only characters are allowed.");
            city.focus();
            event.preventDefault();
            return false;
        }
        if (!/^[A-Za-z\s]+$/.test(state.value)) {
            alert("Invalid state! Only characters are allowed.");
            state.focus();
            event.preventDefault();
            return false;
        }
        // Validation for mobile (accept only 10 digits)
        if (!/^[0-9]{10}$/.test(mobile.value)) {
            alert("Invalid mobile number! Please enter a 10-digit mobile number.");
            mobile.focus();
            event.preventDefault();
            return false;
        }
        if (!/^[0-9]/.test(pincode.value)) {
            alert("Invalid pincode number! Please enter a digit number.");
            pincode.focus();
            event.preventDefault();
            return false;
        }



        return true; // Form will be submitted if everything is valid
    }

    // Event listener for form submission
    document.getElementById("loginForm").addEventListener("submit", function(event) {
        if (!validateForm()) {
            event.preventDefault(); // Prevent form submission if validation fails
        }
    });

</script>
@endsection

