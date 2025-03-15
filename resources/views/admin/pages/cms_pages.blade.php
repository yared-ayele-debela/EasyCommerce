@extends('admindashboard.maindashboard')
@section('dashboard')
@php
$user = Auth::guard('admin')->user();
@endphp
    <div class="pagetitle bg-light">
        <nav>
            <ol class="breadcrumb p-3">
                <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                <li class="breadcrumb-item">Cms</li>
                <li class="breadcrumb-item active">All Cms Pages</li>
            </ol>
        </nav>
    </div>
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Cms Pages Data</h5>
                        <ul class="nav nav-tabs pb-4 align-items-end card-header-tabs w-100">
                            <li class="nav-item">
                                <a class="nav-link active" href=""><i class="fa fa-list mr-2"></i>All Cms Pages</a>
                            </li>
                            @if ($user && $user->hasPermissionByRole('create_cmspage'))
                            <li class="nav-item border-none">
                                <a class="nav-link bg-light" href="{{ url('admin/add_cms_page') }}"><i class=" fas fa-plus"></i>Add Cms Page</a>
                            </li>
                            @endif
                        </ul>

                        <table id="example"  class="table datatable">
                            <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <td scope="col">Title</td>
                                <td>Url</td>
                                <td>Created on</td>
                                <th scope="col">Status</th>
                                <th scope="col">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($cms_pages as $k => $cms)
                                <tr>
                                    <td>{{ $cms['id'] }}</td>
                                    <td>{{ $cms['title'] }}</td>
                                    <td>{{$cms['url']}}</td>
                                    <td>{{$cms['created_at']}}</td>
                                    <td>
                                        @if ($user && $user->hasPermissionByRole('edit_cmspage'))
                                        @if($cms['status']==1)
                                            <a href="{{ url('admin/cms/inactive/'.$cms['id']) }}"><span style="border-radius: 0.2rem;padding-left:3px;padding-right:3px"  class="btn btn-outline-success btn-sm">Active</span></a>
                                        @elseif($cms['status']==0)
                                            <a href="{{ url('admin/cms/active/'.$cms['id']) }}"><span style="border-radius: 0.2rem;padding-left:3px;padding-right:3px"  class="btn btn-outline-danger btn-sm">InActive</span></a>
                                        @endif
                                        @endif
                                    </td>
                                    <td>
                                        @if ($user && $user->hasPermissionByRole('edit_cmspage'))
                                        <a href="{{ url('admin/edit_cms_page/'.$cms['id']) }}" style="background-color: rgb(239, 239, 239) " class=" btn  btn-sm"><i class="ri-ball-pen-fill"></i></a>
                                        @endif
                                        @if ($user && $user->hasPermissionByRole('delete_cmspage'))
                                        <a href="{{ url('admin/cms/delete/'.$cms['id']) }}" style="background-color: rgb(239, 239, 239) ; border:none" onclick="return confirm('Are you sure,you want to delete this Cms Pages ?? ') " class="btn btn-sm" ><i class="ri-delete-bin-6-fill "></i></a>
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
