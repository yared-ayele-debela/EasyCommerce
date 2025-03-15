@extends('delivery_man.admin_dashboard.maindashboard')
@section('delivery_man_dashboard')

<div class="pagetitle bg-light">
    <nav>
       <ol class="breadcrumb p-3 ">
          <li class="breadcrumb-item font-weight-bold"><a href="{{ url('admin/dashboard') }}">Home</a></li>
          <li class="breadcrumb-item">Update my password</li>
       </ol>
    </nav>
 </div>
 <div class="card border-0 shadow-sm" >
    <div class="card-body pt-3">
                   <h5 class="card-title">Update my profile</h5>
<div class="row">
    <div class="col">
        <form id="loginForm" class="row g-3" action="{{ url('deilvery-boy/update_delivery_boy_password') }}" method="POST" enctype="multipart/form-data" >
        @csrf
        <div class="form-group">
            <label for="old_password" class="form-label">Old password</label>
                <input type="password" class="form-control" id="old_password" name="old_password">
                @error('old_password')
                <small class=" text-danger">{{ $message }}</small>
                @enderror
            <div class="form-group">
            <label for="new_password" class="form-label">New password</label>
                <input type="password" class="form-control" id="new_password" name="new_password">
                @error('new_password')
                <small class=" text-danger">{{ $message }}</small>
                @enderror
            </div>
        <div class="form-group">
            <label for="new_password_confirmation" class="form-label">New Password Confirmation</label>
            <input type="password" class="form-control" id="links" name="new_password_confirmation">
            @error('new_password_confirmation')
            <small class=" text-danger">{{ $message }}</small>
            @enderror
        </div>
        <div class="form-group pt-3 ">
        <input type="submit" class=" btn btn-primary pt-2 pb-2 shadow" value="Update Password">
        </div>
</form>
    </div>
    <div class="col"></div>
</div>
    </div>
@endsection
