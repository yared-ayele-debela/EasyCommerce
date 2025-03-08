<?php use App\Models\Category; ?>
@extends('admindashboard.maindashboard')
@section('dashboard')
@php
$user = Auth::guard('admin')->user();
@endphp
<div class="pagetitle bg-light">
   <nav>
      <ol class="breadcrumb p-3">
         <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Home</a></li>
         <li class="breadcrumb-item">Filters</li>
         <li class="breadcrumb-item active">All Filters</li>
      </ol>
   </nav>
 </div>
 <section class="section">
   <div class="row">
      <div class="col-lg-12">
         <div class="card">
            <div class="card-body">
               <h5 class="card-title">filters Data</h5>
               <ul class="nav nav-tabs pb-4 align-items-end card-header-tabs w-100">
                <li class="nav-item">
                  <a class="nav-link active" href=""><i class="fa fa-list mr-2"></i>All filters</a>
                </li>
                @if ($user && $user->hasPermissionByRole('create_filters'))
                  <li class="nav-item broder">
                  <a class="nav-link bg-light" href="{{ url('admin/filters/create') }}"><i class=" fas fa-plus"></i>Add Filters Columns</a>
                </li>
                @endif
                @if ($user && $user->hasPermissionByRole('view_filters_value'))
                <li class="nav-item broder ml-1">
                <a class="nav-link bg-light" href="{{ url('admin/filters_values') }}"><i class=" fas fa-plus"></i>View Filters Values</a>
                </li>
                @endif
               </ul>
               <table id="example"  class="table datatable">
                  <thead>
                     <tr>
                        <th scope="col">ID</th>
                        <td scope="col">Filter Name</td>
                        <th scope="col">Filter Column</th>
                        <th scope="col">Categories</th>
                        <th scope="col">Status</th>
                        <th scope="col">Actions</th>
                     </tr>
                  </thead>
                  <tbody>
                    @foreach ($filters as $k => $filters)

                     <tr>
                        <td>{{ $filters['id'] }}</td>
                        <td>{{ $filters['filter_name'] }}</td>

                        <td>{{ $filters['filter_column'] }}</td>
                        <td>
                        <?php
                            $catIds=explode(",",$filters['cat_ids']);
                            foreach ($catIds as $key => $catId) {
                               $Category_name=Category::getCategoryName($catId);
                               echo $Category_name." , ";
                            }
                            ?>

                        </td>
                        <td>
                            @if ($user && $user->hasPermissionByRole('edit_filter'))
                            @if($filters['status']==1)
                                    <a href="{{ url('admin/inactive/filters/'.$filters['id']) }}"><span style="border-radius: 0.2rem;padding-left:3px;padding-right:3px"  class="btn btn-outline-success btn-sm">Active</span></a>
                            @elseif($filters['status']==0)
                                    <a href="{{ url('admin/active/filters/'.$filters['id']) }}"><span style="border-radius: 0.2rem;padding-left:3px;padding-right:3px"  class="btn btn-outline-danger btn-sm">InActive</span></a>
                            @endif
                            @endif
                           </td>
                        <td>

                         @if ($user && $user->hasPermissionByRole('delete_filter'))
                         <a href="{{ url('admin/filters/delete/'.$filters['id']) }}" style="background-color: rgb(0, 0, 0); border:none" onclick="return confirm('Are you sure,you want to delete this filters ?? ') " class="btn btn-danger btn-sm" ><i class="ri-delete-bin-6-fill"></i></a>
                         @endif
                        </td>
                        <td>

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
