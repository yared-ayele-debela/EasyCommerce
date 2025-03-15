@extends('admindashboard.maindashboard')
@section('dashboard')
@php
$user = Auth::guard('admin')->user();
@endphp
<div class="pagetitle bg-light">
   <nav>
      <ol class="breadcrumb p-3">
         <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Home</a></li>
         <li class="breadcrumb-item">Group</li>
         <li class="breadcrumb-item active">All Groups</li>
      </ol>
   </nav>
 </div>
 <section class="section">
   <div class="row">
      <div class="col-lg-12">
         <div class="card">
            <div class="card-body">
               <h5 class="card-title">Groups Data</h5>
               <ul class="nav nav-tabs pb-4 align-items-end card-header-tabs w-100">
                <li class="nav-item">
                  <a class="nav-link active" href=""><i class="fa fa-list mr-2"></i>All Groups</a>
                </li>
                @if ($user && $user->hasPermissionByRole('create_group'))
                  <li class="nav-item border-none">
                  <a class="nav-link bg-light" href="{{ route('add_group') }}"><i class=" fas fa-plus"></i>Add Group</a>
                  </li>
                @endif

               </ul>

               <table id="example"  class="table datatable">
                  <thead>

                     <tr>
                        <th scope="col">Group ID</th>
                        <th scope="col">Group Name</th>
                        <th scope="col">Group Descriptioin</th>
                        <th scope="col">Status</th>
                        <th scope="col">Action</th>
                     </tr>
                  </thead>
                  <tbody>
                   @foreach ($group as $groups)


                     <tr>
                        <td>{{ $groups->id }}</td>
                        <td>{{ $groups->name }}</td>
                        <td>{{ $groups->description }}</td>
                        <td>
                            @if ($groups->status==0)
                            <a href="{{ url('admin/active/group/'.$groups->id) }}"><span style="border-radius: 0.2rem;padding-left:3px;padding-right:3px"  class="btn btn-outline-danger btn-sm">Inctive</span></a>
                            @elseif ($groups->status==1)
                            <a href="{{url('admin/inactive/group/'.$groups->id ) }}"><span style="border-radius: 0.2rem;padding-left:3px;padding-right:3px"  class="btn btn-outline-success btn-sm">Active</span></a>
                            @endif
                       </td>
                        <td>
                        @if ($user && $user->hasPermissionByRole('edit_group'))
                         <a href="{{ url('admin/groups/'.$groups->id.'/edit') }}"  style="background-color:rgb(239, 239, 239) " class=" btn  btn-sm"><i class="ri-ball-pen-fill"></i></a>
                        @endif
                        @if ($user && $user->hasPermissionByRole('delete_group'))
                         <a href="{{ url('admin/groups/delete/'.$groups->id) }}"  style="background-color:rgb(239, 239, 239) " onclick="return confirm('Are you sure,you want to delete this Group ?? ') " class="btn  btn-sm" ><i class=" ri-delete-bin-6-fill"></i></a>
                        @endif
                        </td>
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
