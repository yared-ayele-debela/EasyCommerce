@extends('admindashboard.maindashboard')
@section('dashboard')
<div class="pagetitle bg-light">
    <nav>
       <ol class="breadcrumb p-3 ">
          <li class="breadcrumb-item font-weight-bold"><a href="">Setting</a></li>
          <li class="breadcrumb-item">Update Admin Details</li>
       </ol>
    </nav>
 </div>
 <h1 class=" card-title">Welcome  <span style="font-size: 20px; color:rgb(44, 10, 144)"> {{ Auth::guard('admin')->user()->name }}</span></h1>
 <section class="section col-md-12" >
   <div class="card" >
      <div class="card-body pt-3">
                      <ul class="nav nav-tabs pb-4 align-items-end card-header-tabs w-100 pt-3">
                        <li class="nav-item border-none">
                           <a class="nav-link active bg-light" href=""><i class=" fas fa-plus"></i>Update Admin Details</a>
                         </li>
                       </ul>
                     <form  id="loginForm" action="{{ url('admin/update_admin_details') }}" method="POST" enctype="multipart/form-data" >
                        @csrf
                        @method('PUT')
                        <div class="col-md-12 pt-3">
                           <label for="name" class="form-label">Admin Email</label>
                            <input type="email" class="form-control"  value={{ $adminDetails['email'] }}  required name="name">
                            @error('name')
                            <small class=" text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                         <div class="col-md-12 pt-3">
                            <label for="name" class="form-label">Name </label>
                             <input type="text" class="form-control" id="name" value="{{ Auth::guard('admin')->user()->name }}" name="name">
                             @error('name')
                             <small class=" text-danger">{{ $message }}</small>
                             @enderror
                         </div>
                         <div class="col-md-12 pt-3">
                            <label for="mobile" class="form-label">Mobile</label>
                             <input type="text" class="form-control" id="mobile" value="{{ Auth::guard('admin')->user()->mobile }}" name="mobile">
                             @error('mobile')
                             <small class=" text-danger">{{ $message }}</small>
                             @enderror
                         </div>

                         <div class="col-md-12 pt-3">
                           <label for="image" class="form-label">Image</label>
                            <input type="file" class="form-control" placeholder="" name="image">
                            @error('image')
                            <small class=" text-danger">{{ $message }}</small>
                            @enderror
                            <br>
                            @if(!empty(Auth::guard('admin')->user()->image))
                            <img src="{{ asset('storage/admin/image/'.Auth::guard('admin')->user()->image) }}" style="width: 40px; height:40px;" class="" alt="">
                            @endif
                        </div>

                     <div class="form-group pt-3   ">
                     <input type="submit" class=" btn  lightblue btn-warning pt-2 pb-2 shadow" value="Update">
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
