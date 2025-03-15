@extends('admindashboard.maindashboard')
@section('dashboard')
@php
$user = Auth::guard('admin')->user();
@endphp
<div class="pagetitle bg-light">
    <nav>
       <ol class="breadcrumb p-3 ">
          <li class="breadcrumb-item font-weight-bold"><a href="{{ url('admin/dashboard') }}">Home</a></li>
          <li class="breadcrumb-item">add adverstisement</li>
       </ol>
    </nav>
 </div>
 <section class="section col-md-12" >
   <div class="card" >
      <div class="card-body pt-3">
                     <ul class="nav nav-tabs pb-4 align-items-end card-header-tabs w-100">
                        @if ($user && $user->hasPermissionByRole('view_advertisment'))
                          <a class="btn btn-primary" href="{{ url('admin/adverstisements')}}"><i class="fa fa-list mr-2"></i>All Advertisements</a>
                        @endif
                    </ul>
                     <form id="loginForm" class="row g-3" action="{{ route('store_adverstisements') }}" method="POST" enctype="multipart/form-data" >
                        @csrf
                        <div class="col-md-6">
                            <label for="title" class="form-label">advertisement title</label>
                             <input type="text" class="form-control" id="title" name="title">
                             @error('title')
                             <small class=" text-danger">{{ $message }}</small>
                             @enderror
                         </div>
                        <div class="col-md-6">
                            <label for="image" class="form-label">Image</label>
                             <input type="file" class="form-control" name="image">
                             @error('image')
                             <small class=" text-danger">{{ $message }}</small>
                             @enderror
                         </div>

                        <div class="col-md-6">
                           <label for="adver_links" class="form-label">links</label>
                            <input type="text" class="form-control" id="links" name="adver_links">
                            @error('adver_links')
                            <small class=" text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                         <div class="col-md-6">
                            <label for="description" class="form-label">Description</label><br>
                            <textarea name="description" class="form-control form-textarea" id="description" cols="60" rows="5"></textarea>
                            @error('description')
                             <small class=" text-danger">{{ $message }}</small>
                             @enderror
                         </div>

                     <div class="form-group pt-3 ">
                     <input type="submit" class=" btn btn-primary pt-2 pb-2 shadow" value="Save">
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
        const price = document.getElementById("price");
        const title = document.getElementById("title");
        const description=document.getElementById("description");
        const links=document.getElementById("links");

        if (!/^[A-Za-z\s]+$/.test(title.value)) {
            alert("Invalid Title! Only characters are allowed.");
            title.focus();
            event.preventDefault();
            return false;
        }
                  // Validation for mobile (accept only 10 digits)
        if (!/^[0-9]/.test(price.value)) {
            alert("Invalid Price number! Please enter only digit number.");
            price.focus();
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
