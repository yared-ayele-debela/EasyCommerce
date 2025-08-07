@extends('admindashboard.maindashboard')
@section('dashboard')
@php
$user = Auth::guard('admin')->user();
@endphp
<div class="pagetitle bg-light">
   <nav>
      <ol class="breadcrumb p-3">
         <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Home</a></li>
         <li class="breadcrumb-item active">all advertisements</li>
      </ol>
   </nav>
 </div>
 <section class="section">
   <div class="row">
      <div class="col-lg-12">
         <div class="card">
            <div class="card-body">
                @if ($user && $user->hasPermissionByRole('view_advertisment'))
                <a class="btn btn-primary mt-3" href="{{ url('admin/adverstisements/add') }}"><i class="fa fa-list mr-2"></i>Add Advertisements</a>
                @endif
               <table id="example"  class="table datatable">
                  <thead>
                     <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Tye</th>
                        <th scope="col">Position</th>
                        <td scope="col">title</td>
                        <th scope="col">Image</th>
                        <th scope="col">description</th>
                        <th scope="col">Link</th>
                        <th scope="col">is Approved</th>
                        <th scope="col">Actions</th>
                     </tr>
                  </thead>
                  <tbody>
                    @foreach ($adver as $k => $ad)

                     <tr>
                        <td>{{ $ad['id'] }}</td>
                        <td><div class="btn btn-sm btn-outline-secondary">{{ $ad['type'] }}</div></td>
                        <td>{{ $ad['position'] }}</td>
                        <td>{{ $ad['title'] }}</td>
                        <td><img src="{{ asset('storage/' . $ad['image']) }}" style="width: 80px; height:40px; box-shadow:1px 1px 2px 1px gray" alt=""></td>
                        <td>{{ $ad['description'] }}</td>
                        <td>{{ \Illuminate\Support\Str::limit($ad['adv_links'], 20) }}</td>
                        <td>
                        @if ($user && $user->hasPermissionByRole('edit_advertisment'))
                           @if($ad['is_approved']==1)
                                 <a href="{{ url('admin/adverstisements/inactive/'.$ad['id']) }}"><span style="border-radius: 0.2rem;padding-left:3px;padding-right:3px"  class="btn btn-outline-success btn-sm">Active</span></a>
                           @elseif($ad['is_approved']==0)
                                 <a href="{{ url('admin/adverstisements/active/'.$ad['id']) }}"><span style="border-radius: 0.2rem;padding-left:3px;padding-right:3px"  class="btn btn-outline-danger btn-sm">Inactive</span></a>
                            @endif
                        @endif
                        </td>
                        <td>
                        @if ($user && $user->hasPermissionByRole('edit_advertisment'))
                         <a href="{{ url('admin/adverstisements/edit/'.$ad['id']) }}" style="background-color: rgb(242, 248, 248)" class=" btn btn-sm"><i class="ri-ball-pen-fill"></i></a>
                        @endif
                        @if ($user && $user->hasPermissionByRole('delete_advertisment'))
                         <a href="{{ route('delete_adverstisements',['id'=>$ad['id']]) }}" style="background-color: rgb(204, 199, 199); border:none" data-confirm-delete="true"  class="btn btn-sm" ><i class="ri-delete-bin-6-fill"></i></a>
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

