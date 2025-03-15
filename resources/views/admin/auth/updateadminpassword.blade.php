@extends('admindashboard.maindashboard')
@section('dashboard')
<div class="pagetitle bg-light">
    <nav>
       <ol class="breadcrumb p-3 ">
          <li class="breadcrumb-item font-weight-bold"><a href="">Setting</a></li>
          <li class="breadcrumb-item">Update Password</li>
       </ol>
    </nav>
 </div>
 <h1 class=" card-title">Welcome  <span style="font-size: 20px; color:rgb(44, 10, 144)"> {{ Auth::guard('admin')->user()->name }}</span></h1>
 <section class="section col-md-12" >
   <div class="card" >
      <div class="card-body pt-3">
                    <h5 class="card-title">Update Password</h5>
                     <form class="" id="loginForm" action="{{ url('admin/updateadminpassword') }}" method="POST" enctype="multipart/form-data" >
                        @csrf
                        <div class="col-md-12 pt-3">
                           <label for="email" class="form-label">Admin User Name / Email</label>
                            <input type="text" class="form-control" readonly value={{ $adminDetails['email'] }} name="email">
                            @error('email')
                            <small class=" text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-md-12 pt-3">
                            <label for="type" class="form-label">Admin Type</label>
                             <input type="text" class="form-control" readonly value={{ $adminDetails['type'] }} name="type">
                             @error('type')
                             <small class=" text-danger">{{ $message }}</small>
                             @enderror
                         </div>
                         <div class="col-md-12 pt-3">
                            <label for="oldpassword" class="form-label">Old Password</label>
                             <input type="password" class="form-control" placeholder="Old Password" required id="oldpassword" pattern=".{8,}" title="Only eight or more characters" name="oldpassword">
                             @error('oldpassword')
                             <small class=" text-danger">{{ $message }}</small>
                             @enderror
                         </div>
                         <div class="col-md-12 pt-3">
                            <label for="new_password" class="form-label">New Password</label>
                             <input type="password" class="form-control" placeholder="New password" required id="new_password" pattern=".{8,}" title="Only eight or more characters" name="new_password">
                             @error('new_password')
                             <small class=" text-danger">{{ $message }}</small>
                             @enderror
                         </div>
                         <div class="col-md-12 pt-3">
                            <label for="new_password_confirmation" class="form-label">Confirm Password</label>
                             <input type="password" class="form-control" placeholder="Confirm New Password" id="confirm_password" pattern=".{8,}" title="Only eight or more characters" required name="new_password_confirmation">
                             @error('new_password_confirmation')
                             <small class=" text-danger">{{ $message }}</small>
                             @enderror
                         </div>
                    <div class="form-group pt-3">
                    <input type="submit" class=" btn btn-primary pt-2 pb-2 shadow" value="Update Your Password">
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
        const oldpassword = document.getElementById("oldpassword");
        const newpassword = document.getElementById("new_password");
        const confirmpassword=document.getElementById("confirm_password");

        const validateold=oldpassword.value;
        const vold=validateold.length;
        const validatenew=newpassword.value;
        const validateconfirm=confirmpassword.value;

        if(vold < 8){
            alert("The old password input must be greater than 8");
            oldpassword.focus();
            event.preventDefault();
            return false;
        }
        if(validatenew.length<8){
            alert("The new password input must be greater than 8");
            newpassword.focus();
            event.preventDefault();
            return false;
        }
        if(validateconfirm.length<8){
            alert("The confirmation password input must be greater than 8");
            confirmpassword.focus();
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
