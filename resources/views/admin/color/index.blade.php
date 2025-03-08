@extends('admindashboard.maindashboard')
@section('dashboard')
@php
$user = Auth::guard('admin')->user();
@endphp
<div class="pagetitle bg-light">
    <nav>
        <ol class="breadcrumb p-3">
            <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Home</a></li>
            <li class="breadcrumb-item active">All color</li>
        </ol>
    </nav>
</div>
<section class="section">
    <div class="container mt-5">
        <div class="card border-0">
            <div class="card-body">
                <ul class="nav nav-tabs pb-4 align-items-end card-header-tabs w-100">
                    <li class="nav-item">
                        <a class="nav-link active" href=""><i class="fa fa-list mr-2"></i>All color</a>
                    </li>
                    @if ($user && $user->hasPermissionByRole('add_color'))
                    <li class="nav-item border-none">
                        <a class="nav-link bg-light" href="{{ route('add-color') }}"><i class="fas fa-plus"></i>Add color</a>
                    </li>
                    @endif
                </ul>
                <div class="table-responsive">
                    <table class="table datatable">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Name</th>
                                <td scope="col">Color</td>
                                <th scope="col">Status</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($colors as $k => $color)
                            <tr>
                                <td>{{ $color->id }}</td>
                                <td>{{ $color->name }}</td>
                                <td class="d-flex">
                                    <div style="height: 30px; width:30px; background-color:{{ $color->color; }}">
                                    </div>{{ $color->color }}</td>
                                <td>
                                    @if ($user && $user->hasPermissionByRole('edit_color'))
                                     @if($color->status==1)
                                          <a href="{{ url('admin/color/inactive/'.$color->id) }}"><span style="border-radius: 0.2rem;padding-left:3px;padding-right:3px"  class="btn btn-outline-success btn-sm">Active</span></a>
                                     @elseif ($color->status==0)
                                           <a href="{{ url('admin/color/active/'.$color->id) }}"><span style="border-radius: 0.2rem;padding-left:3px;padding-right:3px"  class="btn btn-outline-danger btn-sm">Inactive</span></a>
                                     @endif
                                     @endif
                                    </td>
                                 <td>
                                 @if ($user && $user->hasPermissionByRole('delete_color'))
                                  <a href="{{ url('admin/color/edit/'.$color->id) }}"  style="background-color:rgb(239, 239, 239) " class=" btn  btn-sm"><i class="ri-ball-pen-fill"></i></a>
                                 @endif
                                 @if ($user && $user->hasPermissionByRole('delete_color'))
                                  <a href="{{ url('admin/color/delete/'.$color->id) }}" style="background-color:hsl(0, 0%, 94%) " onclick="return confirm('Are you sure,you want to delete this color ?? ') " class="btn  btn-sm" ><i class=" ri-delete-bin-6-fill"></i></a>
                                 @endif
                                 </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{-- Pagination --}}
                 {{-- <div class="pagination-sm">
                    {!! $color->links() !!}
                </div> --}}
            </div>
        </div>
    </div>

</section>
@endsection

