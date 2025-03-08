@extends('admindashboard.maindashboard')
@section('dashboard')
@php
$user = Auth::guard('admin')->user();
@endphp
    <div class="pagetitle bg-light">
        <nav>
            <ol class="breadcrumb p-3 ">
                <li class="breadcrumb-item font-weight-bold"><a href="javascript:void(0);">Home</a></li>
                <li class="breadcrumb-item">Add Users</li>
            </ol>
        </nav>
    </div>
    <section class="section col-md-12" >
        <div class="card" >
            <div class="card-body pt-3">
                 <ul class="nav nav-tabs pb-4 align-items-end card-header-tabs w-100">
                <li class="nav-item">
                    <a class="nav-link active" href=""><i class="fa fa-list mr-2"></i>Add User</a>
                </li>
                @if ($user && $user->hasPermissionByRole('view_users'))
                <li class="nav-item">
                    <a class="nav-link active" href="{{ url('admin/users') }}"><i class="fa fa-list mr-2"></i>All users</a>
                </li>
                @endif
            </ul>
                <form id="loginForm" action="{{ route('store_user') }}" method="POST"  enctype="multipart/form-data" >
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="pt-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" class="form-control" id="name"  name="name">
                                @error('name')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="pt-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="text" class="form-control"  name="email" required>
                                @error('email')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="pt-3">
                                <label for="mobile" class="form-label">Mobile</label>
                                <input type="text" class="form-control" id="mobile"  name="mobile">
                                @error('mobile')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="pt-3">
                                <label for="address" class="form-label">Address</label>
                                <input type="text" class="form-control" id="address"  name="address">
                                @error('address')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="pt-3">
                                <div class="form-group">
                                    <label for="city">City</label>
                                    <select class="form-control" name="city" id="city">
                                        @foreach ($city as $city)
                                            <option>{{ $city->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('city')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="pt-3">
                                <div class="form-group">
                                    <label for="state">State</label>
                                    <select class="form-control" name="state" id="state">
                                        @foreach ($state as $state)
                                            <option>{{ $state->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('state')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="pt-3">
                                <div class="form-group">
                                    <label for="country">Country</label>
                                    <select class="form-control" name="country" id="country">
                                        @foreach ($country as $country)
                                            <option>{{ $country->country_name }}</option>
                                        @endforeach
                                    </select>
                                    @error('country')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="pt-3">
                                <label for="pincode" class="form-label">Pincode</label>
                                <input type="text" class="form-control" id="pincode"  name="pincode">
                                @error('pincode')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>


                    <div class="form-group pt-3   ">
                        <input type="submit" class=" btn lightblue btn-primary pt-2 pb-2 shadow" value="Submit">
                    </div>
                </form>
             </div>
           </div>
        </div>
    </div>
    </section>

    <script>
        // Form validation function
        function validateForm() {
            const mobileInput = document.getElementById("mobile");
            const nameInput = document.getElementById("name");
            const country = document.getElementById("country");
            const state = document.getElementById("state");
            const pincode = document.getElementById("pincode");
            const city = document.getElementById("city");
            // const address = document.getElementById("address");


            if (!/^[A-Za-z\s]+$/.test(nameInput.value)) {
                alert("Invalid name! Only characters are allowed.");
                nameInput.focus();
                event.preventDefault();
                return false;
            }
            if (!/^[A-Za-z\s]+$/.test(country.value)) {
                alert("Invalid Country name! Only characters are allowed.");
                country.focus();
                event.preventDefault();
                return false;
            }
            if (!/^[A-Za-z\s]+$/.test(state.value)) {
                alert("Invalid State! Only characters are allowed.");
                state.focus();
                event.preventDefault();
                return false;
            }
            if (!/^[A-Za-z\s]+$/.test(city.value)) {
                alert("Invalid City! Only characters are allowed.");
                city.focus();
                event.preventDefault();
                return false;
            }
            // if (!/^[A-Za-z\s]+$/.test(address.value)) {
            //     alert("Invalid Address! Only characters are allowed.");
            //     address.focus();
            //     event.preventDefault();
            //     return false;
            // }


            // Validation for mobile (accept only 10 digits)
            if (!/^[0-9]{10}$/.test(mobileInput.value)) {
                alert("Invalid mobile number! Please enter a 10-digit mobile number.");
                mobileInput.focus();
                event.preventDefault();
                return false;
            }
            if (!/^[0-9]/.test(pincode.value)) {
                alert("Invalid Pincode number! Please enter only a digit number.");
                pincode.focus();
                event.preventDefault();
                return false;
            }
            return true; // Form will be submitted if everything is valid
        }

        // Event listener for form submission
        document.getElementById("loginForm").addEventListener("submit", function (event) {
            if (!validateForm()) {
                event.preventDefault(); // Prevent form submission if validation fails
            }
        });
    </script>
@endsection
