<?php  use App\Models\ProductFilter; ?>
@extends('admindashboard.maindashboard')
@section('dashboard')
@php
$user = Auth::guard('admin')->user();
@endphp
<div class="pagetitle bg-light">
   <nav>
      <ol class="breadcrumb p-3">
         <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Home</a></li>
         <li class="breadcrumb-item">filters_values_Value</li>
         <li class="breadcrumb-item active">All filters_values_Values</li>
      </ol>
   </nav>
 </div>
 <section class="section">
   <div class="row">
      <div class="col-lg-12">
         <div class="card">
            <div class="card-body">
               <h5 class="card-title">filters_values_values Data</h5>
               <ul class="nav nav-tabs pb-4 align-items-end card-header-tabs w-100">
                <li class="nav-item">
                  <a class="nav-link active" href="javascript:void(0);"><i class="fa fa-list mr-2"></i>All filters_values_values</a>
                </li>
                @if ($user && $user->hasPermissionByRole('create_filters_value'))
                  <li class="nav-item border-none">
                  <a class="nav-link bg-light" href="{{ url('admin/filters/create_filter_values') }}"><i class=" fas fa-plus"></i>Add filters_values_values</a>
                </li>
                @endif
               </ul>
               <table id="example"  class="table datatable">
                  <thead>
                     <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Filter ID</th>
                        <th scope="col">Filter Name</th>
                        <th scope="col">Filter Value</th>
                        <th scope="col">Status</th>
                        <th scope="col">Actions</th>
                     </tr>
                  </thead>
                  <tbody>
                    @foreach ($filters_values as $k => $filters_values)

                     <tr>
                        <td>{{ $filters_values['id'] }}</td>
                        <td>{{ $filters_values['filter_id'] }}</td>
                        <td>
                          <?php
                          echo $getFilterName=ProductFilter::getFilterName($filters_values['filter_id']);
                          ?>
                        </td>
                        <td>{{ $filters_values['filter_value'] }}</td>
                        <td>
                            @if ($user && $user->hasPermissionByRole('edit_filter_value'))

                           @if($filters_values['status']==1)
                                 <a href="{{ url('admin/inactive/filters_values/'.$filters_values['id']) }}"><span style="border-radius: 0.2rem;padding-left:3px;padding-right:3px"  class="btn btn-outline-success btn-sm">Active</span></a>
                           @elseif($filters_values['status']==0)
                                 <a href="{{ url('admin/active/filters_values/'.$filters_values['id']) }}"><span style="border-radius: 0.2rem;padding-left:3px;padding-right:3px"  class="btn btn-outline-danger btn-sm">InActive</span></a>
                            @endif
                            @endif
                           </td>
                        <td>


                         @if ($user && $user->hasPermissionByRole('delete_filter_value'))
                         <a href="{{ url('admin/filters_value/delete/'.$filters_values['id']) }}" style="background-color: rgb(0, 0, 0); border:none" onclick="return confirm('Are you sure,you want to delete this filters_values ?? ') " class="btn btn-danger btn-sm" ><i class="ri-delete-bin-6-fill"></i></a>
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
