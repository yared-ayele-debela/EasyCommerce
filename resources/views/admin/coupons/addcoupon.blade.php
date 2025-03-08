@extends('admindashboard.maindashboard')
@section('dashboard')
@php
$user = Auth::guard('admin')->user();
@endphp
<div class="pagetitle bg-light">
    <nav>
       <ol class="breadcrumb p-3 ">
          <li class="breadcrumb-item font-weight-bold"><a href="{{ url('admin/dashboard') }}">Home</a></li>
          <li class="breadcrumb-item">Updated Coupon</li>
       </ol>
    </nav>
 </div>
 <section class="section">
    <div class="col-lg-12 border-0 ">
        <div class="card shadow-sm border-0" >
           <div class="card-body pt-1">
             <h5 class="card-title">{{  $title }}</h5>
             <ul class="nav nav-tabs pb-4 align-items-end card-header-tabs w-100">
               <li class="nav-item border-none">
                  <a class="nav-link bg-light disabled" href=""><i class=" fas fa-plus"></i>{{ $title }}</a>
                </li>
                @if ($user && $user->hasPermissionByRole('view_coupon'))
               <li class="nav-item">
                 <a class="nav-link active" href="{{ route('coupons') }}"><i class="fa fa-list mr-2"></i>All Coupons</a>
               </li>
               @endif

              </ul>
                <form class="row g-3" @if(empty($coupon['id']))  action="{{ url('admin/coupons/add-edit') }}" @else action="{{ url('admin/coupons/add-edit/'.$coupon['id']) }}" @endif method="POST" enctype="multipart/form-data" >
                @csrf
                @if(empty($coupon['coupon_code']))
                {{-- <div class="col-md-4 pt-3">
                    <label class="custom-control-label" for="coupon_option">Coupon Option</label><br>
                    <input class="form-check-input" type="radio" name="coupon_option" id="AutomaticCoupon" value="Automatic" checked="">&nbsp;Automatic&nbsp;&nbsp;
                    <input class="form-check-input" type="radio" name="coupon_option" id="ManualCoupon" value="Manual" checked="">&nbsp;Manual&nbsp;&nbsp;
                </div> --}}
                <div class="col-md-4 pt-3   custom-control" id="couponField">
                    <label class="custom-control-label" for="coupon_code">Coupon Code :</label><br>
                    <input type="text" class="custom-control-input form-control"  name="coupon_code" placeholder="Enter Coupon Code" >
                </div>
                @else
                      {{-- <input type="hidden" name="coupon_option" value="{{ $coupon['coupon_option'] }}"> --}}
                      <input type="hidden" name="coupon_code" value="{{ $coupon['coupon_code'] }}">
                      <div class="form-group">
                        <label for="coupon_code">Coupon Code</label>
                        <span>{{ $coupon['coupon_code'] }}</span>
                      </div>
                @endif
                <div class="col-md-4 pt-3">
                    <label class="custom-control-label" for="coupon_type">Coupon Type</label><br>
                    <input class="form-check-input"  type="radio" name="coupon_type"  value="Multiple Times" @if(isset($coupon['coupon_type'])&& $coupon['coupon_type']=="Multiple Times") checked="" @endif>&nbsp;Multiple Times&nbsp;&nbsp;
                    <input class="form-check-input" type="radio" name="coupon_type"  value="Single Times"  @if(isset($coupon['coupon_type'])&& $coupon['coupon_type']=="Single Times") checked="" @endif>&nbsp;Single Times&nbsp;&nbsp;
                </div>
                <div class="col-md-4 pt-3">
                    <label class="custom-control-label" for="amount_type">Amount Type</label><br>
                    <input class="form-check-input" type="radio" name="amount_type"  value="Percentage" @if(isset($coupon['amount_type'])&& $coupon['amount_type']=="Percentage") checked="" @endif>&nbsp;Percentage&nbsp;(in %)&nbsp;
                    <input class="form-check-input" type="radio" name="amount_type"  value="Fixed" @if(isset($coupon['amount_type'])&& $coupon['amount_type']=="Fixed") checked="" @endif>&nbsp;Fixed&nbsp;&nbsp;(in Birr)
                </div>
                <div class="col-md-4 pt-3">
                    <label for="amount" class="form-label">Amount</label>
                        <input type="number" class="form-control" id="amount" name="amount" @if(isset($coupon['amount'])) value="{{ $coupon['amount'] }}" @else value="{{ old('amount') }}" @endif >
                        @error('amount')
                        <small class=" text-danger">{{ $message }}</small>
                        @enderror
                </div>
                <div class="col-md-4  pt-2">
                <label>Category:</label>
                <select name="categories[]" id="categories" style="color:#000;" class="form-control" multiple="">
                        @foreach ($categories as $section)
                        <optgroup label="{{ $section['name'] }}"></optgroup>
                        @foreach ($section['categories'] as $category )
                        <option value="{{ $category['id'] }}" @if(in_array($category['id'],$selCats)) selected="" @endif>&nbsp;&nbsp;->&nbsp;{{ $category['name'] }}</option>
                        @foreach ($category['subcategories'] as $subcategory )
                        <option value="{{ $subcategory['id'] }}" @if(in_array($subcategory['id'],$selCats)) selected="" @endif>&nbsp;&nbsp;--->&nbsp;{{ $subcategory['name'] }}</option>
                        @endforeach
                        @endforeach
                        @endforeach

                </select>
                @error('categories')
                <small class=" text-danger">{{ $message }}</small>
                @enderror
                </div>

                <div class="col-md-4">
                <label for="brands" class="form-label"> Select Brand</label>
                <select name="brands[]"  multiple="" class="form-select">
                    @foreach ($brands as $brand)
                    <option value="{{ $brand['id'] }}"  @if(in_array($brand['id'],$selBrands)) selected="" @endif>{{ $brand['name'] }}</option>
                    @endforeach
                </select>
                @error('brands')
                <small class=" text-danger">{{ $message }}</small>
                @enderror
                </div>
                <div class="col-md-4">
                    <label for="users" class="form-label"> Select Users</label>
                    <select name="users[]"   multiple="" class="form-select">
                        @foreach ($users as $users)
                        <option value="{{ $users['email'] }}" @if(in_array($users['email'],$selUsers)) selected="" @endif>{{ $users['email'] }}</option>
                        @endforeach
                        @error('users')
                        <small class=" text-danger">{{ $message }}</small>
                        @enderror
                    </select>
                </div>
                <div class="col-md-4 pt-3">
                    <label for="expiry_date" class="form-label">Expire Date</label>
                        <input type="date" @if(isset($coupon['expiry_date'])) value="{{ $coupon['expiry_date'] }}" @else value="{{ old('expiry_date') }}" @endif class="form-control" id="expiry_date" name="expiry_date">
                        @error('expiry_date')
                        <small class=" text-danger">{{ $message }}</small>
                        @enderror

                </div>
                <div class="form-group pt-3 ">
                <input type="submit" class=" btn btn-primary  pt-2 pb-2 shadow" value="{{ $title }}">
                </div>
                 </form>
                </div>
            </div>
          </div>
 </section>
@endsection
@section('script')
<script>
 $(document).ready(function () {

  /*------------------------------------------
  --------------------------------------------
  Country Dropdown Change Event
  --------------------------------------------
  --------------------------------------------*/
          $('#category').on('change', function () {
              var idCountry = this.value;
              $("#sub_category").html('');
              $.ajax({
                  url: "{{url('admin/fetchsubcategory')}}",
                  type: "POST",
                  data: {
                    category_id: idCountry,
                      _token: '{{csrf_token()}}'
                  },
                  dataType: 'json',
                  success: function (result) {
                      $('#sub_category').html('<option value="">-- Select SuCategory --</option>');
                      $.each(result.states, function (key, value) {
                          $("#sub_category").append('<option  value="' + value
                              .id + '">' + value.name + '</option>');
                      });

                  }
              });
          });

        $("#category").on('change',function(){
          var category_id=$(this).val();
          // alert(category_id);
          $.ajax({

            type:'post',
            url:'<?php echo url('/admin/category-filters') ?>',
            data:{category_id:category_id ,_token: '{{csrf_token()}}'},
            success:function(resp){
              $(".displayfilters").html(resp.view);
            }
          })
        });

        //show hiden coupon code



        });
</script>
@endsection
