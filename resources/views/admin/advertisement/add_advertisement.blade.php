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
                            <label for="type" class="form-label">Advertisement Type</label>
                            <select class="form-control" name="type" id="type" onchange="filterPositionOptions()">
                                <option value="">Select Type</option>
                                <option value="restaurant">Restaurant</option>
                                <option value="hotel">Hotel</option>
                                <option value="ecommerce">Ecommerce</option>
                            </select>
                            @error('type')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                       <div class="col-md-6">
                            <label for="position" class="form-label">Select Position To Display</label>
                            <select class="form-control" name="position" id="position">
                                <option value="">Select Position</option>

                                <option value="after_special_offer_product_list" data-type="restaurant">After Special Offer Products List</option>
                                <option value="after_best_seller_product_list" data-type="restaurant">After Best Seller Product Lists</option>
                                <option value="after_all_restaurants" data-type="restaurant">After All Restaurant Lists</option>

                                {{-- Hotel Positions --}}
                                <option value="after_discount_hotels" data-type="hotel">After Discount Hotels</option>
                                <option value="after_latest_rooms" data-type="hotel">After Latest Rooms</option>
                                <option value="after_latest_hotels" data-type="hotel">Under Latest Hotels</option>

                                {{-- Ecommerce Positions --}}
                                <option value="after_featured_products" data-type="ecommerce">After Featured Products</option>
                                <option value="after_discounted_products" data-type="ecommerce">After Discounted Products</option>
                                <option value="after_vendors" data-type="ecommerce">After Vendor Lists</option>
                            </select>
                            @error('position')
                            <small class="text-danger">{{ $message }}</small>
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
    function filterPositionOptions() {
        const type = document.getElementById('type').value;
        const positionSelect = document.getElementById('position');
        const allOptions = positionSelect.querySelectorAll('option');

        allOptions.forEach(option => {
            const optionType = option.getAttribute('data-type');
            if (!optionType || optionType === type) {
                option.style.display = 'block';
            } else {
                option.style.display = 'none';
            }
        });

        // Reset selected position
        positionSelect.value = "";
    }

    // Run once on page load to apply initial filtering
    document.addEventListener('DOMContentLoaded', filterPositionOptions);
</script>

@endsection
