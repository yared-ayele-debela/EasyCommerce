@extends('admindashboard.maindashboard')
@section('dashboard')
@php
$user = Auth::guard('admin')->user();
@endphp
<div class="pagetitle bg-light">
   <nav>
      <ol class="breadcrumb p-3">
         <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Home</a></li>
         <li class="breadcrumb-item active">admin Admin and Subadmin</li>
      </ol>
   </nav>
 </div>
 <section class="section">
   <div class="row">
      <div class="col-lg-12">
         <div class="card">
            <div class="card-body">
               <ul class="nav nav-tabs pb-4 align-items-end card-header-tabs w-100">
                <li class="nav-item">
                  <a class="nav-link active" href=""><i class="fa fa-list mr-2"></i>All Admins</a>
                </li>
                @if ($user && $user->hasPermissionByRole('create_admin'))
                  <li class="nav-item border-none right-0">
                  <a class="nav-link bg-light" href="{{ url('admin/add_admin_or_subadmin') }}"><i class=" fas fa-plus"></i>Add Admins/Subadmins</a>
                </li>
                @endif
               </ul>

               <table id="example"  class="table datatable">
                  <thead>
                     <tr>
                        <th scope="col">Admin ID</th>
                        <th scope="col">Name</th>
                         <th scope="col">Mobile</th>
                        <th scope="col">Email</th>
                        <th scope="col">Type</th>
                        <th scope="col">Status</th>
                        <th scope="col">Actions</th>
                     </tr>
                  </thead>
                  <tbody>
                    @foreach ($admin_subadmins as $admin)
                     <tr>
                        <td>{{ $admin['id'] }}</td>
                        <td>{{ $admin['name']}}</td>
                         <td>{{ $admin['mobile']}}</td>
                         <td>{{ $admin['email']}}</td>
                        <td>
                            @if($admin['type'])
                            <span style="border-radius: 0.2rem; padding-left:4px; padding-top:4px; padding-bottom:4px; padding-right:4px; background-color:rgb(239, 239, 239); color:black"  class="  text-dark ">{{ $admin['type'] }}</span></a>
                            @endif
                        </td>

                        {{-- <td>
                           @if(!empty($admin['image']))
                           <img src="{{ asset('storage/admin/image/'.$admin['image']) }}" style=" box-shadow:1px 1px 3px gray; border-radius:2rem;width: 40px; height:40px;" class="" alt="">
                           @else
                           <img  src="{{ asset('/storage/products/noimagefile.png') }}" style="box-shadow:1px 1px 3px gray;  border-radius:2rem; width: 40px; height:40px;" class="" alt="">
                           @endif
                        </td> --}}
                        <td>
                            @if ($user && $user->hasPermissionByRole('edit_admin'))
                           @if($admin->type!="superadmin")
                            @if($admin['status']==1)
                                 <a href="{{ url('admin/admin_subadmin_inactive/'.$admin['id']) }}"><span style="border-radius: 0.2rem;padding-left:3px;padding-right:3px"  class="btn btn-outline-success btn-sm">Active</span></a>
                            @elseif ($admin['status']==0)
                                 <a href="{{ url('admin/admin_subadmin_active/'.$admin['id']) }}"><span style="border-radius: 0.2rem;padding-left:3px;padding-right:3px"  class="btn btn-outline-success btn-sm">InActive</span></a>
                            @endif
                          @endif
                          @endif
                        </td>

                        <td>
                            @if($admin->type!="superadmin")
                             <a href="{{ url('admin/update-role/'.$admin['id']) }}" style="background-color:rgb(239, 239, 239)" class=" btn  btn-sm"><i class="ri-lock-password-fill"></i></a>
                             <a href="{{ url('admin/edit_admin_or_subadmin/'.$admin['id']) }}" style="background-color:rgb(239, 239, 239) " class=" btn  btn-sm"><i class="ri-ball-pen-fill"></i></a>
                             <a href="{{ url('admin/admin-subadmin/'.$admin['id']) }}" style="background-color:rgb(239, 239, 239) " onclick="return confirm('Are you sure,you want to delete this Admin or SubAdmin ?? ') " class="btn  btn-sm" ><i class=" ri-delete-bin-6-fill"></i></a>
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
