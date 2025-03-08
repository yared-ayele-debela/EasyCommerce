@extends('admindashboard.maindashboard')
@section('dashboard')
@php
$user = Auth::guard('admin')->user();
@endphp
<div class="pagetitle bg-light">
    <nav>
       <ol class="breadcrumb p-3 ">
          <li class="breadcrumb-item font-weight-bold"><a href="{{ url('admin/dashboard') }}">Home</a></li>
          <li class="breadcrumb-item">Add Filter</li>
       </ol>
    </nav>
 </div>
 <section class="section col-md-12" >
   <div class="card" >
      <div class="card-body pt-3">
                     <h5 class="card-title">Add Filter</h5>
                     <ul class="nav nav-tabs pb-4 align-items-end card-header-tabs w-100">
                        <li class="nav-item border-none">
                           <a class="nav-link active bg-light" href=""><i class=" fas fa-plus"></i>Add Filter</a>
                         </li>
                         @if ($user && $user->hasPermissionByRole('view_filters'))
                            <li class="nav-item">
                            <a class="nav-link " href="{{ route('filters') }}"><i class="fa fa-list mr-2"></i>All Filter</a>
                            </li>
                         @endif
                       </ul>
                     <form class="row g-3" action="{{ url('admin/filters/store') }}" method="POST" enctype="multipart/form-data" >
                        @csrf
                        <div class="col-md-12">
                            <label>Category:</label>
                            <select name="cat_ids[]" id="cat_ids" style="color:#000; height:200px;" class="form-control" multiple="" >
                               @foreach ($categories as $section)
                                     <optgroup label="{{ $section['name'] }}"></optgroup>
                                 @foreach ($section['categories'] as $category )
                                       <option value="{{ $category['id'] }}">&nbsp;&nbsp;->&nbsp;{{ $category['name'] }}</option>
                                     @foreach ($category['subcategories'] as $subcategory )
                                       <option value="{{ $subcategory['id'] }}">&nbsp;&nbsp;--->&nbsp;{{ $subcategory['name'] }}</option>
                                     @endforeach
                                 @endforeach
                                @endforeach
                            </select>
                           </div>

                        <div class="col-md-12">
                           <label for="filter_name" class="form-label">Filter Name</label>
                            <input type="text" class="form-control" name="filter_name">
                            @error('filter_name')
                            <small class=" text-danger">{{ $message }}</small>
                            @enderror
                             <br>
                            <label for="fiter_column" class="form-label">Filter Column</label>
                            <input type="text" class="form-control" name="fiter_column">
                            @error('fiter_column')
                            <small class=" text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group pt-3 ">
                        <input type="submit" class=" btn btn-primary pt-2 pb-2 shadow" value="Save Filter">
                        </div>
          </form>
         </div>
        </div>
      </div>
      </div>
 </section>
@endsection
{{-- @section('script')
<script>

$(document).ready(function(){

 $("#group_id").change(function()
 {
   var group_id=$(this).val();
      $.ajax({
         header:{
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
         },

         type:"get",
         url:"/admin/append-Filter-level",
         data:{group_id:group_id},

         success:function(resp){
            // alert(resp);
            $("#appendFilterLevel").html(resp);
         },error:function(){
            alert("An error ocurred");
         }
      })
  });
});
</script>
@endsection --}}
