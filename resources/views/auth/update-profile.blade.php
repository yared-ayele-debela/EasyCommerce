@extends('all_frontend_layouts.layouts')

@section('content')
<style>
     .profile-image {
      width: 150px;
      height: 150px;
      object-fit: cover;
      border-radius: 50%;
    }
</style>
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-8 col-12">
            <h3 class="text-left text-dark mb-3">Update Your Personal Details</h3>
            <div class="offer-card shadow-sm rounded">
                <div class="card-body">
                    <form method="POST" action="{{ route('user.account.update') }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                        <div class="row">
                            @if(session('success'))
                                <div class="alert alert-success">{{ session('success') }}</div>
                            @endif

                            @if(session('error'))
                                <div class="alert alert-danger">{{ session('error') }}</div>
                            @endif

                            @if(session('info'))
                                <div class="alert alert-info">{{ session('info') }}</div>
                            @endif

                            <div class="col-12 mb-3">
                                @if(Auth::user()->profile_photo_path)
                                    <img src="{{ auth()->user()->profile_photo_path }}" alt="Profile Image" class="profile-image border border-2 offer-card">
                                  @endif
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="profileImage" class="form-label">Profile Image</label>
                                    <input type="file" class="form-control" id="profileImage" name="profile_image" accept="image/*">
                                  </div>

                                  <div class="mb-3">
                                    <img id="previewImage" src="" alt="Profile Image" class="profile-image d-none">
                                  </div>

                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Full Name</label>
                                    <input type="text" name="name" class="form-control" value="{{ Auth::user()->name }}" required placeholder="Full Name">
                                    @error('name')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" name="email" id="email" class="form-control" value="{{ Auth::user()->email }}" disabled placeholder="Email">
                                    @error('email')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="country" class="form-label">Country</label>
                                    <select name="country" class="form-select" required>
                                        <option selected disabled>Select Country</option>
                                        @foreach ($countries as $country)
                                            <option value="{{ $country['country_name'] }}" @if($country['country_name'] == Auth::user()->country) selected @endif>{{ $country['country_name'] }}</option>
                                        @endforeach
                                    </select>
                                    @error('country')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="mobile" class="form-label">Phone</label>
                                    <input type="text" name="mobile" class="form-control" value="{{ Auth::user()->mobile }}" required placeholder="Phone">
                                    @error('mobile')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="address" class="form-label">Address</label>
                                    <input type="text" name="address" class="form-control" value="{{ Auth::user()->address }}" required placeholder="Address">
                                    @error('address')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="state" class="form-label">State</label>
                                    <select name="state" class="form-select" required>
                                        <option disabled selected>Select State</option>
                                        @foreach ($states as $state)
                                            <option value="{{ $state->name }}" @if($state->name == Auth::user()->state) selected @endif>{{ $state->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('state')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="city" class="form-label">City</label>
                                    <select name="city" class="form-select" required>
                                        <option disabled selected>Select City</option>
                                        @foreach ($cities as $city)
                                            <option value="{{ $city->name }}" @if($city->name == Auth::user()->city) selected @endif>{{ $city->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('city')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="pincode" class="form-label">Pincode</label>
                                    <input type="text" name="pincode" class="form-control" value="{{ Auth::user()->pincode }}" required placeholder="Pincode">
                                    @error('pincode')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                            </div>

                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Update Details</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-8 col-12">
            <h3 class="text-left mb-3 text-dark">Update Your Password</h3>

            <div class="offer-card shadow-sm rounded">
                <div class="card-body">
                    <form id="passwordUpdateForm" action="{{ route('user.password.update') }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="my-3">
                            @if(session('successs'))
                            <div class="alert alert-success">{{ session('successs') }}</div>
                            @endif

                            @if(session('errorr'))
                                <div class="alert alert-danger">{{ session('error') }}</div>
                            @endif
                        </div>
                        <div class="mb-3">
                            <label for="oldpassword" class="form-label">Current Password</label>
                            <input type="password" name="oldpassword" id="oldpassword" class="form-control" required placeholder="Old password">
                            @error('oldpassword')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="new_password" class="form-label">New Password</label>
                            <input type="password" name="new_password" id="new_password" class="form-control" required placeholder="New password">
                            @error('new_password')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="new_confirm_password" class="form-label">Confirm New Password</label>
                            <input type="password" name="new_password_confirmation" id="new_password_confirmation" class="form-control" required placeholder="Confirm new password">
                            @error('new_confirm_password')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Update Password</button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- Delete Account Button -->
            <button class="btn btn-danger shadow mt-3" data-bs-toggle="modal" data-bs-target="#deleteAccountModal">
                <i class="bi bi-trash"></i> Delete My Account
            </button>

            <!-- Delete Account Modal -->
            <div class="modal fade" id="deleteAccountModal" tabindex="-1" aria-labelledby="deleteAccountModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content border-0 shadow-lg">
                        <div class="modal-header bg-danger text-white">
                            <h5 class="modal-title" id="deleteAccountModalLabel">Confirm Account Deletion</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p class="mb-3">
                                Are you sure you want to permanently delete your account? This action <strong>cannot be undone</strong>.
                            </p>
                            <p class="text-danger small">All your data will be erased and you will no longer be able to access your account.</p>
                        </div>
                        <div class="modal-footer">
                            <form action="{{ route('user.destroy') }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-danger">Yes, Delete My Account</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<script>

    // Preview image before upload
    const profileImageInput = document.getElementById('profileImage');
    const previewImage = document.getElementById('previewImage');

    profileImageInput.addEventListener('change', function (e) {
      const file = e.target.files[0];
      if (file) {
        const reader = new FileReader();
        reader.onload = function (event) {
          previewImage.src = event.target.result;
          previewImage.classList.remove('d-none');
        };
        reader.readAsDataURL(file);
      }
    });
  </script>
@endsection
