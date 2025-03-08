@extends('admindashboard.maindashboard')
@section('dashboard')
@php
$user = Auth::guard('admin')->user();
@endphp
<div class="pagetitle bg-light">
    <nav>
        <ol class="breadcrumb p-3">
            <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Home</a></li>
            <li class="breadcrumb-item active">All city</li>
        </ol>
    </nav>
</div>
<section class="section">
    <div class="container mt-5">
        <div class="card border-0">
            <div class="card-body pt-2">
                <ul class="nav nav-tabs pb-4 align-items-end card-header-tabs w-100">
                    @if ($user && $user->hasPermissionByRole('add city'))
                        <a class="btn btn-primary" href="{{ route('add-city') }}"><i class="fas fa-plus"></i>Add city</a>
                    @endif
                </ul>
                <div class="table-responsive">
                    <table class="table datatable">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Name</th>
                                <th scope="col">Status</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($cities as $k => $city)
                            <tr>
                                <td>{{ $city->id }}</td>
                                <td>{{ $city->name }}</td>
                                <td>
                                    @if ($user && $user->hasPermissionByRole('edit city'))
                                    @if($city->status==1)
                                          <a href="{{ url('admin/city/inactive/'.$city->id) }}"><span style="border-radius: 0.2rem;padding-left:3px;padding-right:3px"  class="btn btn-outline-success btn-sm">Active</span></a>
                                    @elseif ($city->status==0)
                                          <a href="{{ url('admin/city/active/'.$city->id) }}"><span style="border-radius: 0.2rem;padding-left:3px;padding-right:3px"  class="btn btn-outline-danger btn-sm">Inactive</span></a>
                                     @endif
                                     @endif
                                    </td>
                                 <td>
                                 @if ($user && $user->hasPermissionByRole('edit city'))
                                  <a href="{{ url('admin/city/edit/'.$city->id) }}"  style="background-color:rgb(239, 239, 239) " class=" btn  btn-sm"><i class="ri-ball-pen-fill"></i></a>
                                 @endif
                                 @if ($user && $user->hasPermissionByRole('delete city'))
                                  <a href="{{ url('admin/city/delete/'.$city->id) }}" style="background-color:hsl(0, 0%, 94%) " onclick="return confirm('Are you sure,you want to delete this City ?? ') " class="btn  btn-sm" ><i class=" ri-delete-bin-6-fill"></i></a>
                                 @endif
                                 </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{-- Pagination --}}
                 <div class="pagination-sm">
                    {!! $cities->links() !!}
                </div>
            </div>
        </div>
    </div>

</section>
@endsection

