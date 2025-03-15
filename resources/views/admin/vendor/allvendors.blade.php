@extends('admindashboard.maindashboard')
@section('dashboard')
@php
$user = Auth::guard('admin')->user();
@endphp
<div class="pagetitle bg-light shadow-sm">
   <nav>
      <ol class="breadcrumb p-3">
         <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Home</a></li>
         <li class="breadcrumb-item active">All vendors</li>
      </ol>
   </nav>
 </div>
 <section class="section">
   <div class="row">
      <div class="col-lg-12">
         <div class="card border-0 shadow-sm">
            <div class="card-header mb-2">
                <a class="btn btn-primary" href="javascript:void();"><i class="fa fa-list mr-2"></i>All vendors</a>
            </div>
            <div class="card-body">
               <table id="example"  class="table mt-2">
                  <thead>
                     <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Name</th>
                        <th scope="col">Mobile</th>
                        <th scope="col">Email</th>
                        <th scope="col">Status</th>
                        <th scope="col">Actions</th>
                     </tr>
                  </thead>
                  <tbody>
                    @foreach ($vendor as $k => $all)
                     <tr>
                        <td>{{ $all['id'] }}</td>
                        <td>{{ $all['name']}}</td>
                        <td>{{ $all['mobile']}}</td>
                        <td>{{ $all['email']}}</td>
                        <td>
                           @if($all['status']==1)
                                 <a href="{{ url('admin/vendors/inactive/'.$all['id']) }}"><span style="border-radius: 0.2rem;padding-left:3px;padding-right:3px"  class="btn btn-outline-success btn-sm">Active</span></a>
                           @elseif ($all['status']==0)
                                 <a href="{{ url('admin/vendors/active/'.$all['id']) }}"><span style="border-radius: 0.2rem;padding-left:3px;padding-right:3px"  class="btn btn-outline-danger btn-sm">InActive</span></a>
                            @endif
                        </td>
                        <td class="d-flex">
                           @if ($user && $user->hasPermissionByRole('view_vendor_detail'))
                            <a href="{{ url('admin/vendors/details/'.$all['id']) }}" class=" btn btn-light btn-sm"> <i class=" bi bi-eye-fill"></i> </a>
                           @endif                           @if ($user && $user->hasPermissionByRole('delete_vendor'))
                           <a href="{{ url('admin/vendor/delete/'.$all['id']) }}" style="background-color:rgb(239, 239, 239)" class="btn  btn-sm" ><i class="ri-login-box-line"></i></a>
                           @endif
                           &nbsp;
                           @if ($user && $user->hasPermissionByRole('login with vendor'))
                           <form action="{{ route('admin.login-as-vendor', $all['id']) }}" method="POST">
                              @csrf
                              <button type="submit" class="btn btn-primary btn-sm">Login as {{ $all['name'] }}</button>
                           </form>
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
