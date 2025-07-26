@extends('admindashboard.maindashboard')
@section('dashboard')
<div class="pagetitle bg-light mb-3">
          <h1 class="breadcrumb-item font-weight-bold"><a href="javascript:void(0);">Vendor Details</a></h1>
         {{-- <a href="{{ route('display_vendor') }}" class=" link-primary ">Back to Vendors</a> --}}
 </div>
 <section class="section " >
    <div class="row">
        <div class="col-lg-4">
   <div class="card" >
      <div class="card-body pt-1">
        <h1 class=" card-title">Personal Details</h1>
                     <form  action="{{ url('admin/update_vendor_details') }}" method="POST"  enctype="multipart/form-data" >
                        @csrf
                        @method('PUT')
                        <div class="col-md-8 pt-1">
                           <label for="vendor_email" class="form-label">Email</label>
                            <input type="text" class="form-control " value="{{ $vendorDetails['email'] }}" readonly  name="vendor_email">
                            @error('vendor_email')
                            <small class=" text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-md-8 pt-1">
                           <label for="vendor_name" class="form-label">Name</label>
                            <input type="text" class="form-control" value="{{ $vendorDetails['name'] }}" readonly name="vendor_name">
                            @error('vendor_name')
                            <small class=" text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-md-8 pt-1">
                            <label for="vendor_address" class="form-label">Address</label>
                             <input type="text" class="form-control" value="{{ $vendorDetails['address']??'' }}" readonly name="vendor_address">
                             @error('vendor_address')
                             <small class=" text-danger">{{ $message }}</small>
                             @enderror
                         </div>
                         <div class="col-md-8 pt-1">
                            <label for="vendor_city" class="form-label">City</label>
                             <input type="text" class="form-control" value="{{ $vendorDetails['city']??'' }}" readonly name="vendor_city">
                             @error('vendor_city')
                             <small class=" text-danger">{{ $message }}</small>
                             @enderror
                         </div>
                         <div class="col-md-8 pt-1">
                            <label for="vendor_state" class="form-label">State</label>
                             <input type="text" class="form-control" value="{{ $vendorDetails['state']??'' }}" readonly  name="vendor_state">
                             @error('vendor_state')
                             <small class=" text-danger">{{ $message }}</small>
                             @enderror
                         </div>
                         <div class="col-md-8 pt-1">
                           <label for="vendor_country" class="form-label">Country</label>
                            <input type="text" class="form-control" value="{{ $vendorDetails['country']??'' }}" readonly  name="vendor_country">
                            @error('vendor_country')
                            <small class=" text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-md-8 pt-1">
                           <label for="vendor_pincode" class="form-label">Pincode</label>
                            <input type="text" class="form-control" value="{{ $vendorDetails['pincode']??'' }}" readonly  name="vendor_pincode">
                            @error('vendor_pincode')
                            <small class=" text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-md-8 pt-1">
                           <label for="vendor_mobile" class="form-label">Mobile</label>
                            <input type="text" class="form-control" value="{{ $vendorDetails['mobile']??'' }}" readonly   name="vendor_mobile">
                            @error('vendor_mobile')
                            <small class=" text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-md-8 pt-1">
                           <label for="vendor_image" class="form-label">Image</label>
                            @if(!empty($vendorDetails['image']))
                            <img src="{{ asset('storage/admin/image/'.$vendorDetails['image']) }}" style="width: 140px; height:100px;" class="" alt="">
                            @endif
                        </div>
                 </form>
           </div>
        </div>
    </div>
    <div class="col-lg-8">
        <div class="card" >
           <div class="card-body pt-1">
             <h1 class=" card-title">Vendor Business Information</h1>
                <form class="row g-3" action="{{ url('admin/update_vendorbusinessdetailsdetails') }}" method="POST" enctype="multipart/form-data" >
                @csrf
                @method('PUT')
                <div class="col-md-4 pt-3">
                   <label for="shop_name" class="form-label">Shop Name</label>
                    <input type="text" class="form-control" @if(isset($vendorDetails['vendorbusinessdetails']['shop_name'])) value="{{ $vendorDetails['vendorbusinessdetails']['shop_name'] }}"   @endif readonly  name="shop_name">
                    @error('shop_name')
                    <small class=" text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="col-md-4 pt-3">
                    <label for="shop_address" class="form-label">Shop Address</label>
                     <input type="text" class="form-control" @if(isset($vendorDetails['vendorbusinessdetails']['shop_address'])) value="{{ $vendorDetails['vendorbusinessdetails']['shop_address'] }}"   @endif  readonly name="shop_address">
                     @error('shop_address')
                     <small class=" text-danger">{{ $message }}</small>
                     @enderror
                 </div>
                 <div class="col-md-4 pt-3">
                    <label for="shop_city" class="form-label">Shop City</label>
                     <input type="text" class="form-control" @if(isset($vendorDetails['vendorbusinessdetails']['shop_city'])) value="{{ $vendorDetails['vendorbusinessdetails']['shop_city'] }}"   @endif  readonly name="shop_city">
                     @error('shop_city')
                     <small class=" text-danger">{{ $message }}</small>
                     @enderror
                 </div>
                 <div class="col-md-4 pt-3">
                    <label for="shop_state" class="form-label">Shop State</label>
                     <input type="text" class="form-control" @if(isset($vendorDetails['vendorbusinessdetails']['shop_state'])) value="{{ $vendorDetails['vendorbusinessdetails']['shop_state'] }}"   @endif   readonly  name="shop_state">
                     @error('shop_state')
                     <small class=" text-danger">{{ $message }}</small>
                     @enderror
                 </div>

                <div class="col-md-4 pt-3">
                   <label for="shop_country" class="form-label">shop Country </label>
                    <input type="text" class="form-control" @if(isset($vendorDetails['vendorbusinessdetails']['shop_country'])) value="{{ $vendorDetails['vendorbusinessdetails']['shop_country'] }}"   @endif  readonly  name="shop_country">
                    @error('shop_country')
                    <small class=" text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="col-md-4 pt-3">
                   <label for="shop_pincode" class="form-label">Shop pincode</label>
                    <input type="text" class="form-control " @if(isset($vendorDetails['vendorbusinessdetails']['shop_pincode'])) value="{{ $vendorDetails['vendorbusinessdetails']['shop_pincode'] }}"   @endif readonly name="shop_pincode">
                    @error('shop_pincode')
                    <small class=" text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="col-md-4 pt-3">
                   <label for="shop_mobile" class="form-label">Shop Mobile </label>
                    <input type="text" class="form-control" @if(isset($vendorDetails['vendorbusinessdetails']['shop_mobile'])) value="{{ $vendorDetails['vendorbusinessdetails']['shop_mobile'] }}"   @endif readonly  name="shop_mobile">
                    @error('shop_mobile')
                    <small class=" text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="col-md-4 pt-3">
                   <label for="shop_website" class="form-label">Shop Website</label>
                    <input type="text" class="form-control"@if(isset($vendorDetails['vendorbusinessdetails']['shop_website'])) value="{{ $vendorDetails['vendorbusinessdetails']['shop_website'] }}"   @endif  readonly name="shop_website">
                    @error('shop_website')
                    <small class=" text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="col-md-4 pt-3">
                  <label for="shop_email" class="form-label">Shop Email </label>
                   <input type="email" class="form-control" @if(isset($vendorDetails['vendorbusinessdetails']['shop_email'])) value="{{ $vendorDetails['vendorbusinessdetails']['shop_email'] }}"   @endif  readonly    name="shop_email">
                   @error('shop_email')
                   <small class=" text-danger">{{ $message }}</small>
                   @enderror
                </div>
                <div class="col-md-4 pt-3">
                <label for="shop_email" class="form-label">Address Proof </label>
                 <input type="email" class="form-control"@if(isset($vendorDetails['vendorbusinessdetails']['address_proof'])) value="{{ $vendorDetails['vendorbusinessdetails']['address_proof'] }}"   @endif  readonly name="address_proof">
                 @error('shop_email')
                 <small class=" text-danger">{{ $message }}</small>
                 @enderror
                </div>

                 <div class="col-md-4 pt-3">
                    <label for="address_proof_image" class="form-label">Address Proof Image</label>
                     @if(!empty($vendorDetails['vendorbusinessdetails']['address_proof_image']))
                     <img src="{{ asset('storage/admin/image/'.$vendorDetails['vendorbusinessdetails']['address_proof_image']) }}" style=" width: 200px; height:140px;" class="" alt="">
                     @endif
                 </div>
                 <div class="col-md-4 pt-3">
                    <label for="address_proof_image" class="form-label">Shop Image</label>
                     @if(!empty($vendorDetails['vendorbusinessdetails']['shop_image']))
                     <img src="{{ asset('storage/admin/image/'.$vendorDetails['vendorbusinessdetails']['shop_image']) }}" style=" width: 200px; height:140px;" class="" alt="">
                     @endif
                 </div>

                 </form>
                 <form  action="{{ url('admin/update_vendor_bank_details') }}" method="POST" enctype="multipart/form-data" >
                    @csrf
                    @method('PUT')
                    <hr class=" hr pt-0 mt-4">
                  <h1 class="card-title pt-4 ">Vendor Bank Account Details</h1>
                    <div class="col-md-8 pt-3">
                       <label for="account_holder_name" class="form-label">Account_holder_name</label>
                        <input type="text" class="form-control"  @if(isset($vendorDetails['vendor_bank']['account_holder_name'])) value="{{ $vendorDetails['vendor_bank']['account_holder_name'] }}"   @endif readonly  name="account_holder_name">
                        @error('account_holder_name')
                        <small class=" text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="col-md-8 pt-3">
                        <label for="bank_name" class="form-label">Bank Name</label>
                         <input type="text" class="form-control"  @if(isset($vendorDetails['vendor_bank']['bank_name'])) value="{{ $vendorDetails['vendor_bank']['bank_name'] }}"   @endif readonly  name="bank_name">
                         @error('bank_name')
                         <small class=" text-danger">{{ $message }}</small>
                         @enderror
                     </div>
                     <div class="col-md-8 pt-3">
                        <label for="account_number" class="form-label">Account Number </label>
                         <input type="number" class="form-control"   @if(isset($vendorDetails['vendor_bank']['account_number'])) value="{{ $vendorDetails['vendor_bank']['account_number'] }}"   @endif   readonly  name="account_number">
                         @error('account_number')
                         <small class=" text-danger">{{ $message }}</small>
                         @enderror
                     </div>

      </form>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                  <div class="card-body">
                    <h5 class="card-title">Service Charge per order item (%)</h5>
                    <form action="{{ url('admin/update-vendor-commission') }}" method="post">
                    @csrf
                    <div class="d-flex">
                        <input type="hidden" name="vendor_id" value="{{$vendorDetails['id']}}">
                        <input required="" name="commission" class="form-control" @if(isset($vendorDetails['commission'])) value="{{ $vendorDetails['commission'] }}" @endif type="number" name="commission" id="">
                        <button class="btn btn-primary ml-3">Submit</button>
                    </div>
                    </form>
                  </div>
                </div>
            </div>
          </div>
    </div>
 </section>
@endsection
