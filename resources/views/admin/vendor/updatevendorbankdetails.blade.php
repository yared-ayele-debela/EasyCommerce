@extends('admindashboard.maindashboard')
@section('dashboard')
<div class="pagetitle bg-light">
    <nav>
       <ol class="breadcrumb p-3 ">
          <li class="breadcrumb-item font-weight-bold"><a href="javascript:void(0);">Vendor Details</a></li>
          <li class="breadcrumb-item">Update Vendor Bank Details</li>
       </ol>
    </nav>
 </div>
 <h1 class=" card-title">Welcome  <span style="font-size: 20px; color:rgb(44, 10, 144)"> {{ Auth::guard('admin')->user()->name }}</span></h1>

 <section class="section col-md-6" >
   <div class="card" >
      <div class="card-body pt-3">
                      <ul class="nav nav-tabs pb-4 align-items-end card-header-tabs w-100 pt-3">
                        <li class="nav-item border-none">
                           <a class="nav-link active bg-light" href=""><i class=" fas fa-plus"></i>Update Vendor Bank Details</a>
                         </li>
                       </ul>
                     <form id="loginForm" action="{{ url('admin/update_vendor_bank_details') }}" method="POST" enctype="multipart/form-data" >
                        @csrf
                        @method('PUT')
                        <div class="col-md-8 pt-3">
                           <label for="vendor_email" class="form-label">Email</label>
                            <input type="text" class="form-control " readonly value="{{Auth::guard('admin')->user()->email}}" name="vendor_email">
                            @error('vendor_email')
                            <small class=" text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-md-8 pt-3">
                           <label for="account_holder_name" class="form-label">Account_holder_name</label>
                            <input type="text" class="form-control" @if(isset($VendorBankDetails['account_holder_name'])) value="{{ $VendorBankDetails['account_holder_name']}}" @endif id="account_holder_name" name="account_holder_name">
                            @error('account_holder_name')
                            <small class=" text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-md-8 pt-3">
                            <label for="bank_name" class="form-label">Bank Name</label>
                             <input type="text" class="form-control" @if(isset($VendorBankDetails['bank_name'])) value="{{ $VendorBankDetails['bank_name']}}" @endif id="bank_name"   name="bank_name">
                             @error('bank_name')
                             <small class=" text-danger">{{ $message }}</small>
                             @enderror
                         </div>
                         <div class="col-md-8 pt-3">
                            <label for="account_number" class="form-label">Account Number </label>
                             <input type="number" class="form-control"  @if(isset($VendorBankDetails['account_number'])) value="{{ $VendorBankDetails['account_number']}}" @endif id="account_number"  name="account_number">
                             @error('account_number')
                             <small class=" text-danger">{{ $message }}</small>
                             @enderror
                         </div>


                     <div class="form-group pt-3   ">
                     <input type="submit" class=" btn  lightblue btn-warning pt-2 pb-2 shadow" value="Update Vendor Bank Details">
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
        const account_holder_name = document.getElementById("account_holder_name");
        const bank_name = document.getElementById("bank_name");
        const account_number = document.getElementById("account_number");


        if (!/^[A-Za-z\s]+$/.test(bank_name.value)) {
            alert("Invalid Bank name! Only characters are allowed.");
            bank_name.focus();
            event.preventDefault();
            return false;
        }
        if (!/^[A-Za-z\s]+$/.test(account_holder_name.value)) {
            alert("Invalid account_holder_name name! Only characters are allowed.");
            account_holder_name.focus();
            event.preventDefault();
            return false;
        }

        if (!/^[0-9]/.test(account_number.value)) {
            alert("Invalid account_number number! Please enter only a digit number.");
            account_number.focus();
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
