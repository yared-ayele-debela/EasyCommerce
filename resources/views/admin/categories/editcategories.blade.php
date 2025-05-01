@extends('admindashboard.maindashboard')
@section('dashboard')
@php
$user = Auth::guard('admin')->user();
@endphp
<div class="pagetitle bg-light">
    <nav>
       <ol class="breadcrumb p-3 ">
          <li class="breadcrumb-item font-weight-bold"><a href="{{ url('admin/dashboard') }}">Home</a></li>
          <li class="breadcrumb-item">edit category</li>
       </ol>
    </nav>
 </div>
 <section class="section col-md-12" >
   <div class="card" >
      <div class="card-body pt-3">
                     <ul class="nav nav-tabs pb-4 align-items-end card-header-tabs w-100">
                         @if ($user && $user->hasPermissionByRole('view_category'))
                           <a class="btn btn-primary" href="{{ route('categories') }}"><i class="fa fa-list mr-2"></i>All Categories</a>
                         @endif
                       </ul>
                     <form class="row g-3" id="loginForm" action="{{ url('admin/categories/update/') }}" method="POST" enctype="multipart/form-data" >
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="id" value="{{ $categories->id }}">
                        <div class="col-md-6">
                           <label for="group_id" class="form-label"> Select Group</label>
                           <select name="group_id"  id="group_id" class="form-select">
                              <option  value="">Select Groups</option>
                             @foreach ($groups as $group)
                             <option value="{{ $group->id }}" @if(!empty($categories['group_id'])&&$categories['group_id']==$group['id'])
                              selected="" @endif>{{$group->name }}</option>
                             @endforeach
                           </select>
                        </div>
                        <div class="col-md-6 " id="appendCategoriesLevel">
                           @include('admin.categories.append_categories')
                        </div>
                        <div class="col-md-6">
                           <label for="name" class="form-label">Category Name</label>
                            <input type="text" class="form-control" value="{{ $categories->name }}" id="name" name="name">
                            @error('name')
                            <small class=" text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-md-6">
                           <label for="image" class="form-label">Category Image</label>
                            <input type="file" class="form-control" value="{{ $categories->image }}" name="image">
                            @error('image')
                            <small class=" text-danger">{{ $message }}</small>
                            @enderror
                            <div class="pt-3">
                              <div class="row">
                                <img src="{{$categories->image }}" style="width:80px; height:50px" class=" rounded" alt="">
                              </div>
                           </div>
                        </div>
                        <div class="col-md-6">
                            <label for="banner_image" class="form-label">Category banner image</label>
                             <input type="file" class="form-control" name="banner_image">
                             @error('banner_image')
                             <small class=" text-danger">{{ $message }}</small>
                             @enderror
                             <div class="pt-3">
                                <div class="row">
                                  <img src="{{$categories->banner_image }}" style="width:80px; height:50px" class=" rounded" alt="">
                                </div>
                             </div>
                         </div>

                        <div class="col-md-6">
                           <label for="discount" class="form-label">Category Discount</label>
                            <input type="number" class="form-control" value="{{$categories->discount }}" name="discount">
                            @error('discount')
                            <small class=" text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-md-6 ">
                           <label for="description" class="form-label">Category Description</label>
                           <textarea name="description" class="form-control" cols="30" rows="3">{{$categories->description }}</textarea>
                           @error('description')
                           <small class=" text-danger">{{ $message }}</small>
                           @enderror
                         </div>
                        <div class="col-md-6">
                            <label for="url" class="form-label">Category URL</label>
                             <input type="text" class="form-control" value="{{ $categories->url }}" name="url">
                             @error('url')
                             <small class=" text-danger">{{ $message }}</small>
                             @enderror
                        </div>
                         <div class="col-md-6 ">
                           <label for="meta_title" class="form-label">Meta Title</label>
                           <textarea name="meta_title"  class="form-control" cols="20" rows="2">{{$categories->meta_title }}</textarea>
                           @error('meta_title')
                           <small class=" text-danger">{{ $message }}</small>
                           @enderror
                         </div>
                         <div class="col-md-6 ">
                           <label for="meta_description" class="form-label">Meta Description</label>
                           <textarea name="meta_description"  class="form-control" cols="20" rows="2">{{$categories->meta_description }}</textarea>
                           @error('meta_description')
                           <small class=" text-danger">{{ $message }}</small>
                           @enderror
                         </div>
                         <div class="col-md-6 ">
                           <label for="meta_keywords" class="form-label">Meta Keywords</label>
                           <textarea name="meta_keywords"  class="form-control" cols="20" rows="2">{{$categories->meta_keywords }}</textarea>
                           @error('meta_keywords')
                           <small class=" text-danger">{{ $message }}</small>
                           @enderror
                         </div>
                     <div class="form-group pt-3 ">
                     <input type="submit" class=" btn btn-primary pt-2 pb-2 shadow" value="Update">
                     </div>
          </form>
         </div>
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
@section('script')
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
         url:"/admin/append-categories-level",
         data:{group_id:group_id},

         success:function(resp){
            // alert(resp);
            $("#appendCategoriesLevel").html(resp);
         },error:function(){
            alert("An error ocurred");
         }
      })
  });
});
</script>
@endsection
