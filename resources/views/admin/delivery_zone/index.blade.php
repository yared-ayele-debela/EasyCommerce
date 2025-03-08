@extends('admindashboard.maindashboard')
@section('dashboard')
@php
$user = Auth::guard('admin')->user();
@endphp
<div class="pagetitle bg-light">
    <nav>
        <ol class="breadcrumb p-3">
            <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Home</a></li>
            <li class="breadcrumb-item active">All Delivery_Zone</li>
        </ol>
    </nav>
</div>
<section class="section">
    <div class="container mt-5">
        <div class="card border-0">
            <div class="card-body">
                <h5 class="card-title">Delivery_Zone Data</h5>
                <ul class="nav nav-tabs pb-4 align-items-end card-header-tabs w-100">
                    <li class="nav-item">
                        <a class="nav-link active" href=""><i class="fa fa-list mr-2"></i>All Delivery_Zone</a>
                    </li>
                    @if ($user && $user->hasPermissionByRole('add delivery zone'))
                    <li class="nav-item border-none">
                        <a class="nav-link bg-light" href="{{ route('add-delivery_zone') }}"><i class="fas fa-plus"></i>Add Delivery_Zone</a>
                    </li>
                    @endif
                </ul>

                <div class="table-responsive">
                    <table class="table  datatable">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Name</th>
                                <th scope="col">Status</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($delivery_zone as $k => $delivery_zone)
                            <tr>
                                <td>{{ $delivery_zone->id }}</td>
                                <td>{{ $delivery_zone->name }}</td>
                                <td>
                                    @if ($user && $user->hasPermissionByRole('edit delivery zone'))
                                    @if($delivery_zone->status==1)
                                          <a href="{{ url('admin/delivery_zone/inactive/'.$delivery_zone->id) }}"><span style="border-radius: 0.2rem;padding-left:3px;padding-right:3px"  class="btn btn-outline-success btn-sm">Active</span></a>
                                    @elseif ($delivery_zone->status==0)
                                          <a href="{{ url('admin/delivery_zone/active/'.$delivery_zone->id) }}"><span style="border-radius: 0.2rem;padding-left:3px;padding-right:3px"  class="btn btn-outline-danger btn-sm">Inactive</span></a>
                                     @endif
                                     @endif
                                    </td>
                                 <td>
                                 @if ($user && $user->hasPermissionByRole('edit delivery zone'))
                                  <a href="{{ url('admin/delivery_zone/edit/'.$delivery_zone->id) }}"  style="background-color:rgb(239, 239, 239) " class=" btn  btn-sm"><i class="ri-ball-pen-fill"></i></a>
                                 @endif
                                 @if ($user && $user->hasPermissionByRole('delete delivery zone'))
                                  <a href="{{ url('admin/delivery_zone/delete/'.$delivery_zone->id) }}" style="background-color:hsl(0, 0%, 94%) " onclick="return confirm('Are you sure,you want to delete this delivery_man_type ?? ') " class="btn  btn-sm" ><i class=" ri-delete-bin-6-fill"></i></a>
                                 @endif
                                 </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{-- Pagination --}}
                 <div class="pagination-sm">
                    {{-- {!! $delivery_man_type->links() !!} --}}
                </div>
            </div>
        </div>
    </div>

</section>
@endsection

