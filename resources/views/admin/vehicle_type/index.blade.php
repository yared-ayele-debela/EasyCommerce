@extends('admindashboard.maindashboard')
@section('dashboard')
@php
$user = Auth::guard('admin')->user();
@endphp
<div class="pagetitle bg-light">
    <nav>
        <ol class="breadcrumb p-3">
            <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Home</a></li>
            <li class="breadcrumb-item active">All Vehicle_Type</li>
        </ol>
    </nav>
</div>
<section class="section">
    <div class="container mt-5">
        <div class="card border-0">
            <div class="card-body">
                <h5 class="card-title">Vehicle_Type Data</h5>
                <ul class="nav nav-tabs pb-4 align-items-end card-header-tabs w-100">
                    <li class="nav-item">
                        <a class="nav-link active" href="javascripit:void();"><i class="fa fa-list mr-2"></i>All Vehicle_Type</a>
                    </li>
                    @if ($user && $user->hasPermissionByRole('add vehicle type'))
                    <li class="nav-item border-none">
                        <a class="nav-link bg-light" href="{{ route('add-vehicle_type') }}"><i class="fas fa-plus"></i>Add Vehicle_Type</a>
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
                            @foreach ($vehicle_type as $k => $vehicle_type)
                            <tr>
                                <td>{{ $vehicle_type->id }}</td>
                                <td>{{ $vehicle_type->name }}</td>
                                <td>
                                    @if ($user && $user->hasPermissionByRole('edit vehicle type'))
                                    @if($vehicle_type->status==1)
                                          <a href="{{ url('admin/vehicle_type/inactive/'.$vehicle_type->id) }}"><span style="border-radius: 0.2rem;padding-left:3px;padding-right:3px"  class="btn btn-outline-success btn-sm">Active</span></a>
                                    @elseif ($vehicle_type->status==0)
                                          <a href="{{ url('admin/vehicle_type/active/'.$vehicle_type->id) }}"><span style="border-radius: 0.2rem;padding-left:3px;padding-right:3px"  class="btn btn-outline-danger btn-sm">Inactive</span></a>
                                    @endif
                                    @endif
                                    </td>
                                 <td>
                                 @if ($user && $user->hasPermissionByRole('edit vehicle type'))
                                  <a href="{{ url('admin/vehicle_type/edit/'.$vehicle_type->id) }}"  style="background-color:rgb(239, 239, 239) " class=" btn  btn-sm"><i class="ri-ball-pen-fill"></i></a>
                                 @endif
                                 @if ($user && $user->hasPermissionByRole('delete vehicle type'))
                                  <a href="{{ url('admin/vehicle_type/delete/'.$vehicle_type->id) }}" style="background-color:hsl(0, 0%, 94%) " onclick="return confirm('Are you sure,you want to delete this Vehicle_Type ?? ') " class="btn  btn-sm" ><i class=" ri-delete-bin-6-fill"></i></a>
                                 @endif
                                 </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{-- Pagination --}}
                 <div class="pagination-sm">
                    {{-- {!! $vehicle_type->links() !!} --}}
                </div>
            </div>
        </div>
    </div>

</section>
@endsection

