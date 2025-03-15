@extends('admindashboard.maindashboard')
@section('dashboard')
@php
$userrole = Auth::guard('admin')->user();
@endphp
<div class="pagetitle bg-light">
   <nav>
      <ol class="breadcrumb p-3">
         <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Home</a></li>
         <li class="breadcrumb-item">User</li>
         <li class="breadcrumb-item active">All Users</li>
      </ol>
   </nav>
 </div>
 <section class="section">
   <div class="row">
      <div class="col-lg-12">
         <div class="card">

            <div class="card-body">
               @if(Session::has('success_message'))
            <div class=" col-lg-6 alert alert-success alert-dismissible fade show" role="alert">
                 <i class="bi bi-check-circle me-1">
                 </i>{{ Session::get('success_message') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                </button>
             </div>
             @endif
               <h5 class="card-title">Users Data</h5>
               <ul class="nav nav-tabs pb-4 align-items-end card-header-tabs w-100">
                <li class="nav-item">
                  <a class="nav-link active" href=""><i class="fa fa-list mr-2"></i>All users</a>
                </li>
                @if ($userrole && $userrole->hasPermissionByRole('create_user'))
                <li class="nav-item">
                    <a class="nav-link active" href="{{ url('admin/add_user') }}">Add User</a>
                </li>
                @endif

                <li class="nav-itme">
                    <a class="nav-link " href="{{url('admin/view-users-city')}}">Users Reports</a>
                </li>
               </ul>

               <table id="example"  class="table datatable">
                  <thead>
                     <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Name</th>
                        <th scope="col">Address</th>
                        <th scope="col">Pincode</th>
                        <th scope="col">Email</th>
                        <th scope="col">Status</th>
                        <th scope="col">Action</th>
                     </tr>
                  </thead>
                  <tbody>
                    @foreach ($users as $k => $user)

                     <tr>
                        <td>{{ $user['id']}}</td>
                        <td>{{ $user['name'] }}</td>
                        <td>{{ $user['address'] }}</td>
                        <td>{{ $user['pincode'] }}
                         </td>
                        <td>{{ $user['email'] }}</td>
                        <td>
                            @if ($userrole && $userrole->hasPermissionByRole('edit_user'))

                           @if($user['status']==1)
                                 <a href="{{ url('admin/users/inactive/'.$user['id']) }}"><span style="border-radius: 0.2rem;padding-left:3px;padding-right:3px"  class="btn btn-outline-success btn-sm">Active</span></a>
                           @elseif ($user['status']==0)
                                 <a href="{{ url('admin/users/active/'.$user['id']) }}"><span style="border-radius: 0.2rem;padding-left:3px;padding-right:3px"  class="btn btn-outline-danger btn-sm">Inactive</span></a>
                            @endif
                            @endif
                           </td>
                        <td>
                         @if ($userrole && $userrole->hasPermissionByRole('edit_user'))
                         <a href="{{ url('admin/edit_user/'.$user['id']) }}" style="background-color:rgb(239, 239, 239) " class=" btn  btn-sm"><i class="ri-ball-pen-fill"></i></a>
                         @endif
                         @if ($userrole && $userrole->hasPermissionByRole('delete_user'))
                         <a href="{{ url('admin/users/'.$user['id'].'/delete') }}" style="background-color:rgb(239, 239, 239) " onclick="return confirm('Are you sure,you want to delete this users ?? ') " class="btn  btn-sm" ><i class=" ri-delete-bin-6-fill"></i></a>
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
