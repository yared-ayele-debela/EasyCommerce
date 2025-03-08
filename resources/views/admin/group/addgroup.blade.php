@extends('admindashboard.maindashboard')
@section('dashboard')
@php
$user = Auth::guard('admin')->user();
@endphp
  <div class="pagetitle  bg-light">
     <nav>
        <ol class="breadcrumb p-3 ">
           <li class="breadcrumb-item font-weight-bold"><a href="{{ url('admin/dashboard') }}">Home</a></li>
           <li class="breadcrumb-item">Add Group</li>
        </ol>
     </nav>
  </div>
  <section class="section">
     <div class="row">
        <div class="col-lg-12">
           <div class="card">
              <div class="card-body">
                 <h5 class="card-title" style="font-weight: bold; font-size:27px;"> Add Group</h5>
                 <ul class="nav pb-5 nav-tabs align-items-end card-header-tabs w-100">
                  <li class="nav-item">
                    <a class="nav-link active" href=""><i class="fa fa-list mr-2"></i>Add Group</a>
                  </li>
                  @if ($user && $user->hasPermissionByRole('view_group'))
                    <li class="nav-item border-none">
                    <a class="nav-link bg-light " href="{{ route('groups') }}"><i class=" fas fa-plus"></i>All Groups</a>
                    </li>
                  @endif
                 </ul>
                 <form method="POST" id="loginForm" action="{{ url('admin/groups/store')}}" class="row g-3" enctype="multipart/form-data">
                    @csrf
                    <div class="col-md-12">
                       <label for="name" class="form-label">Group Name</label>
                        <input type="text" name="name" id="name" class="form-control" >
                        @error('name')
                            <small class=" text-danger">{{ $message }}</small><br>
                        @enderror
                        <label for="description" class="form-label">Description</label>
                        <textarea name="description"  class="form-control" cols="30" rows="4"></textarea>
                        @error('description')
                        <small class=" text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="col-md-6">
                    <button type="submit" class=" col-md-4 btn btn-primary  pl-5 pr-5 pt-2 shadow pb-2">Save</button>
                    </div>
                    </div>
                   </form>
              </div>
           </div>
        </div>
  </section>
  <script>
    // Form validation function


    // Event listener for form submission
    document.getElementById("loginForm").addEventListener("submit", function (event) {
        if (!validateForm()) {
            event.preventDefault(); // Prevent form submission if validation fails
        }
    });
</script>
@endsection
