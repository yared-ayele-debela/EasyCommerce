
@extends('Hotel.dashboard.layouts')
@section('hotel-dashboard')
<div class="pagetitle bg-light p-3 mb-4 rounded shadow-sm">
    <nav>
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item fw-bold"><a href="#">Setting</a></li>
            <li class="breadcrumb-item active">Update Admin Details</li>
        </ol>
    </nav>
</div>

<h4 class="mb-4 text-dark">Welcome,
    <span class="text-primary" style="font-size: 20px;">{{ Auth::guard('admin')->user()->name }}</span>
</h4>

<section class="section">
    <div class="card shadow-sm border-0">
        <div class="card-header">
            Update Admin Details
        </div>
        <div class="card-body mb-2">
            <!-- Tab Header -->
            <form id="adminUpdateForm" action="{{ url('admin/update_admin_details') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row g-4 mt-2">
                    <!-- Email -->
                    <div class="col-md-6">
                        <label for="email" class="form-label">Admin Email</label>
                        <input type="email" class="form-control" id="email" value="{{ $adminDetails['email'] }}" readonly>
                    </div>

                    <!-- Name -->
                    <div class="col-md-6">
                        <label for="name" class="form-label">Full Name</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ Auth::guard('admin')->user()->name }}" required>
                        @error('name')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- Mobile -->
                    <div class="col-md-6">
                        <label for="mobile" class="form-label">Mobile Number</label>
                        <input type="text" class="form-control" id="mobile" name="mobile" value="{{ Auth::guard('admin')->user()->mobile }}" required>
                        @error('mobile')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- Image -->
                    <div class="col-md-6">
                        <label for="image" class="form-label">Profile Image</label>
                        <input type="file" class="form-control" id="image" name="image">
                        @error('image')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                        @if(!empty(Auth::guard('admin')->user()->image))
                            <div class="mt-2">
                                <img src="{{ asset('storage/' . Auth::guard('admin')->user()->image) }}" class="rounded border" width="60" height="60" alt="Admin Image">
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Submit -->
                <div class="mt-4">
                    <button type="submit" class="btn btn-primary shadow-sm px-4 py-2">
                        Update Details
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>

<!-- JavaScript Validation -->
<script>
    document.getElementById("adminUpdateForm").addEventListener("submit", function(event) {
        const name = document.getElementById("name").value.trim();
        const mobile = document.getElementById("mobile").value.trim();

        if (!/^[A-Za-z\s]+$/.test(name)) {
            alert("Invalid name! Only letters and spaces are allowed.");
            event.preventDefault();
            return false;
        }

        if (!/^\d{10}$/.test(mobile)) {
            alert("Invalid mobile number! Please enter exactly 10 digits.");
            event.preventDefault();
            return false;
        }

        return true;
    });
</script>

@endsection
