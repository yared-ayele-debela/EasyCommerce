@extends('admindashboard.maindashboard')
@section('dashboard')
@php
$user = Auth::guard('admin')->user();
@endphp
    <div class="pagetitle bg-light shadow-sm">
        <nav>
            <ol class="breadcrumb p-3 ">
                <li class="breadcrumb-item font-weight-bold"><a href="javascript:void(0);">Admin</a></li>
                <li class="breadcrumb-item">Update Admin</li>
            </ol>
        </nav>
    </div>
    <section class="section col-md-12" >
        <div class="card border-0 shadow-sm" >
            <div class="card-header">
                @if ($user && $user->hasPermissionByRole('view_admin'))
                    <a class="btn btn-primary" href="{{ route('alladmins') }}">Lists of admins</a>
                @endif
            </div>
            <div class="card-body pt-3">
                <form  id="loginForm" action="{{ route('update_admin_or_subadmin') }}" method="POST"  enctype="multipart/form-data" >
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="id" value="{{$admin->id}}">

                    <div class="row">
                        <div class="col-md-6">
                            <div class="pt-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" class="form-control" value="{{$admin->name}}" id="name"  name="name">
                                @error('name')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="pt-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="text" class="form-control" value="{{$admin->email}}" id="email" required name="email">
                                @error('email')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="pt-3">
                                <label for="type" class="form-label">Admin Type</label>
                                <select class="form-select"  name="type">
                                    <option value="">select</option>
                                    @foreach ($role as $role)
                                        <option @if($admin->type==$role->name) selected @endif value="{{$role->name}}">{{ $role->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="pt-3">
                                <label for="mobile" class="form-label">Mobile</label>
                                <input type="number" class="form-control" value="{{$admin->mobile}}" id="mobile"  name="mobile">
                                @error('mobile')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="pt-3">
                                <label for="image" class="form-label">Image</label>
                                <input type="file" class="form-control" name="image">
                                @error('image')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                                @if(!empty($admin['image']))
                                    <img src="{{ asset('storage/admin/image/'.$admin['image']) }}" style="width: 40px; height:40px;" class="" alt="">
                                @endif
                            </div>
                        </div>
                    </div>


                    <div class="form-group pt-3">
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

            if (!/^[A-Za-z\s]+$/.test(nameInput.value)) {
                alert("Invalid name! Only characters are allowed.");
                nameInput.focus();
                event.preventDefault();
                return false;
            }
                      // Validation for mobile (accept only 10 digits)
            if (!/^[0-9]{10}$/.test(mobileInput.value)) {
                alert("Invalid mobile number! Please enter a 10-digit mobile number.");
                mobileInput.focus();
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
