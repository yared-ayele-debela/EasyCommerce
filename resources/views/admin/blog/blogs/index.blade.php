@extends('admindashboard.maindashboard')
@section('dashboard')
@php
$user = Auth::guard('admin')->user();
@endphp
<div class="pagetitle bg-light">
    <nav>
        <ol class="breadcrumb p-3">
            <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Home</a></li>
            <li class="breadcrumb-item active">All Blog</li>
        </ol>
    </nav>
</div>
<section class="section">
    <div class="container mt-5">
        <div class="card border-0">
            <div class="card-body">
                <ul class="nav nav-tabs pb-4 align-items-end card-header-tabs w-100 mt-3">
                    @if ($user && $user->hasPermissionByRole('add blog'))
                        <a class="btn btn-primary" href="{{ route('add-blog') }}"><i class="fas fa-plus"></i>Add Blog</a>
                    @endif
                </ul>
                <div class="table-responsive">
                    <table class="table datatable">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Image</th>
                                <th scope="col">Title</th>
                                <th scope="col">Status</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($blogs as $k => $blog)
                            <tr>
                                <td>{{ $blog->id }}</td>
                                <td>
                                    <img src="{{ asset('/storage/blog/'.$blog['image']) }}" style="width: 80px; height:40px; padding-top:3px;" alt="">
                                </td>
                                <td>{{ $blog->title }}</td>
                                <td>
                                    @if ($user && $user->hasPermissionByRole('edit blog'))
                                     @if($blog->status==1)
                                          <a href="{{ url('admin/blogs/inactive/'.$blog->id) }}"><span style="border-radius: 0.2rem;padding-left:3px;padding-right:3px"  class="btn btn-outline-success btn-sm">Active</span></a>
                                     @elseif ($blog->status==0)
                                          <a href="{{ url('admin/blogs/active/'.$blog->id) }}"><span style="border-radius: 0.2rem;padding-left:3px;padding-right:3px"  class="btn btn-outline-danger btn-sm">Inactive</span></a>
                                     @endif
                                    @endif
                                    </td>
                                 <td>
                                 @if ($user && $user->hasPermissionByRole('edit blog'))
                                  <a href="{{ url('admin/blogs/edit/'.$blog->id) }}"  style="background-color:rgb(239, 239, 239) " class=" btn  btn-sm"><i class="ri-ball-pen-fill"></i></a>
                                 @endif

                                 @if ($user && $user->hasPermissionByRole('delete blog'))
                                  <a href="{{ url('admin/blogs/delete/'.$blog->id) }}" style="background-color:hsl(0, 0%, 94%) " onclick="return confirm('Are you sure,you want to delete this blog? ') " class="btn  btn-sm" ><i class=" ri-delete-bin-6-fill"></i></a>
                                 @endif
                                 </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{-- Pagination --}}
                 <div class="pagination-sm">
                    {!! $blogs->links() !!}
                </div>
            </div>
        </div>
    </div>

</section>
@endsection

