@extends('admindashboard.maindashboard')
@section('dashboard')
<nav class="breadcrumb bg-white shadow-sm py-3 px-4 rounded d-flex justify-content-between align-items-center">
    <button class="btn btn-outline-primary btn-sm d-flex align-items-center" onclick="history.back()">
        <i class="bi bi-arrow-left mr-2"></i> &nbsp;
        <span>Back</span>
    </button>
    <ol class="breadcrumb mb-0">
        <li class="breadcrumb-item">
            <a href="{{ url('admin/dashboard') }}">Home</a>
        </li>
        <li class="breadcrumb-item active" aria-current="page">Update Vendor Bank Details</li>
    </ol>
</nav>
<h1 class="card-title">Welcome <span style="font-size: 20px; color:rgb(44, 10, 144)"> {{ Auth::guard('admin')->user()->name }}</span></h1>

<section class="section col-md-12">
    <div class="card">
        <div class="card-header">
            <h5 class="text-dark"> Update Vendor Bank Details</h5>
        </div>
        <div class="card-body">
            <form id="loginForm" action="{{ url('admin/update_vendor_bank_details') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row">
                     <div class="col-md-4 pt-3">
                    <label for="vendor_email" class="form-label">Email</label>
                    <input type="text" class="form-control " readonly value="{{Auth::guard('admin')->user()->email}}" name="vendor_email">
                    @error('vendor_email')
                    <small class=" text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="col-md-4 pt-3">
                    <label for="account_holder_name" class="form-label">Account_holder_name</label>
                    <input type="text" class="form-control" @if(isset($VendorBankDetails['account_holder_name'])) value="{{ $VendorBankDetails['account_holder_name']}}" @endif id="account_holder_name" name="account_holder_name">
                    @error('account_holder_name')
                    <small class=" text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="col-md-4 pt-3">
                    <label for="bank_name" class="form-label">Bank Name</label>
                    <input type="text" class="form-control" @if(isset($VendorBankDetails['bank_name'])) value="{{ $VendorBankDetails['bank_name']}}" @endif id="bank_name" name="bank_name">
                    @error('bank_name')
                    <small class=" text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="col-md-4 pt-3">
                    <label for="account_number" class="form-label">Account Number </label>
                    <input type="number" class="form-control" @if(isset($VendorBankDetails['account_number'])) value="{{ $VendorBankDetails['account_number']}}" @endif id="account_number" name="account_number">
                    @error('account_number')
                    <small class=" text-danger">{{ $message }}</small>
                    @enderror
                </div>
                </div>
                <div class="form-group pt-3">
                    <input type="submit" class="btn lightblue btn-primary pt-2 pb-2 shadow" value="Update Vendor Bank Details">
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
    document.getElementById("loginForm").addEventListener("submit", function(event) {
        if (!validateForm()) {
            event.preventDefault(); // Prevent form submission if validation fails
        }
    });

</script>
@endsection

