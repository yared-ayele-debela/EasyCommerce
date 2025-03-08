@extends('admindashboard.maindashboard')
@section('dashboard')
@php
$user = Auth::guard('admin')->user();
@endphp
<div class="pagetitle bg-light">
    <nav>
        <ol class="breadcrumb p-3">
            <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Home</a></li>
            <li class="breadcrumb-item active">All Country</li>
        </ol>
    </nav>
</div>
<section class="section">
    <div class="container mt-5">
        <div class="card border-0">
            <div class="card-body">
                <h5 class="card-title">Country Data</h5>
                <ul class="nav nav-tabs pb-4 align-items-end card-header-tabs w-100">
                    <li class="nav-item">
                        <a class="nav-link active" href=""><i class="fa fa-list mr-2"></i>All Country</a>
                    </li>
                    @if ($user && $user->hasPermissionByRole('add country'))
                    <li class="nav-item border-none">
                        <a class="nav-link bg-light" href="{{ route('add-country') }}"><i class="fas fa-plus"></i>Add Country</a>
                    </li>
                    @endif
                </ul>

                <div class="table-responsive">
                    <table class="table table-bordered datatable">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Country Code</th>
                                <td scope="col">Country Name</td>
                                <th scope="col">Status</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($countries as $country)
                            <tr>
                                <td>{{ $country->id }}</td>
                                <td>{{ $country->country_code }}</td>
                                <td>{{ $country->country_name }}</td>
                                <td>
                                    @if ($user && $user->hasPermissionByRole('edit country'))
                                    @if($country->status==1)
                                          <a href="{{ url('admin/country/inactive/'.$country->id) }}"><span style="border-radius: 0.2rem;padding-left:3px;padding-right:3px"  class="btn btn-outline-success btn-sm">Active</span></a>
                                    @elseif ($country->status==0)
                                          <a href="{{ url('admin/country/active/'.$country->id) }}"><span style="border-radius: 0.2rem;padding-left:3px;padding-right:3px"  class="btn btn-outline-danger btn-sm">Inactive</span></a>
                                     @endif
                                     @endif
                                    </td>
                                 <td>
                                 @if ($user && $user->hasPermissionByRole('edit country'))
                                  <a href="{{ url('admin/country/edit/'.$country->id) }}"  style="background-color:rgb(239, 239, 239) " class=" btn  btn-sm"><i class="ri-ball-pen-fill"></i></a>
                                 @endif
                                 @if ($user && $user->hasPermissionByRole('delete country'))
                                  <a href="{{ url('admin/country/delete/'.$country->id) }}" style="background-color:hsl(0, 0%, 94%) " onclick="return confirm('Are you sure,you want to delete this country ?? ') " class="btn  btn-sm" ><i class=" ri-delete-bin-6-fill"></i></a>
                                 @endif
                                 </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{-- Pagination --}}
                 <div class="pagination-sm">
                    {!! $countries->links() !!}
                </div>
            </div>
        </div>
    </div>

</section>
@endsection

