@extends('admindashboard.maindashboard')
@section('dashboard')
@php
$user = Auth::guard('admin')->user();
@endphp
<div class="pagetitle bg-light">
   <nav>
      <ol class="breadcrumb p-3">
         <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Home</a></li>
         <li class="breadcrumb-item active">all categories</li>
      </ol>
   </nav>
 </div>
 <section class="section">
   <div class="row">
      <div class="col-lg-12">
         <div class="card">
            <div class="card-body pt-3">
               <ul class="nav nav-tabs pb-4 align-items-end card-header-tabs w-100">
                @if ($user && $user->hasPermissionByRole('create_category'))
                  <a class="btn btn-primary" href="{{ route('add_categories') }}"><i class=" fas fa-plus"></i>Add Category</a>
                @endif
               </ul>
               <table id="example" class="table datatable">
                  <thead>
                     <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Category </th>
                        <th scope="col">Group</th>
                        <th scope="col">Parent Category</th>
                        <th scope="col">URL</th>
                        <th scope="col">Image</th>
                        <th scope="col">Status</th>
                        <th scope="col">Actions</th>
                     </tr>
                  </thead>
                  <tbody>
                     @foreach($categories as $category)
                     @if (isset($category['parentcategory']['name'])&&!empty($category['parentcategory']))
                      <?php   $parentcategory=$category['parentcategory']['name']; ?>
                     @else
                      <?php   $parentcategory="Root"; ?>
                     @endif
                    <tr>
                        <td>{{ $category['id'] }}</td>
                        <td>{{ $category['name'] }}</td>
                        <td>{{ $category['group']['name'] }}</td>
                        <td>{{ $parentcategory }}</td>
                        <td>{{ $category['url'] }}</td>

                        <td><img src="{{ asset('/storage/category/'.$category['image']) }}" style="width: 25px; height:25px;" alt=""></td>
                        <td>
                            @if ($user && $user->hasPermissionByRole('edit_category'))
                            @if($category['status']==1)
                                  <a href="{{ url('admin/inactive/category/'.$category['id']) }}"><span style="border-radius: 0.2rem;padding-left:3px;padding-right:3px"  class="btn btn-outline-success btn-sm">Active</span></a>
                            @elseif ($category['status']==0)
                                  <a href="{{ url('admin/active/category/'.$category['id']) }}"><span style="border-radius: 0.2rem;padding-left:3px;padding-right:3px"  class="btn btn-outline-danger btn-sm">InActive</span></a>
                            @endif
                            @endif
                        </td>
                        <td>
                            @if ($user && $user->hasPermissionByRole('edit_category'))
                           <a href="{{ url('admin/categories/'.$category['id'].'/edit') }}" style="background-color:rgb(239, 239, 239) " class=" btn  btn-sm"><i class="ri-ball-pen-fill"></i></a>
                           @endif
                           @if ($user && $user->hasPermissionByRole('delete_category'))
                           <a href="{{ url('admin/categories/'.$category['id'].'/delete') }}" style="background-color:rgb(239, 239, 239) "  onclick="return confirm('Are you sure,you want to delete this Category ?? ') " class="btn  btn-sm" ><i class=" ri-delete-bin-6-fill"></i></a>
                           @endif
                        </td>
                     </tr>
                     @endforeach
                  </tbody>
               </table>
               <div class=" pagination-sm">
                  {{-- {{ $categories->links() }} --}}
               </div>

            </div>
         </div>
      </div>
   </div>
 </section>

@endsection
