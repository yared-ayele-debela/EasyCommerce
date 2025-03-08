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
                <ul class="nav nav-tabs pb-4 align-items-end card-header-tabs mt-3 w-100">
                        <a class="btn btn-primary" href="javascript:void();"><i class="fa fa-list mr-2"></i>All blog comments</a>
                </ul>
                <div class="table-responsive">
                    <table class="table datatable">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Blog</th>
                                <th scope="col">Full Name</th>
                                <th scope="col">Email</th>
                                <th scope="col">Comment</th>
                                <th scope="col">Status</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($all_blog_comments as $k => $blog)
                            <tr>
                                <td>{{ $blog->id }}</td>
                                <td>{{ $blog->blog_id }}</td>
                                <td>{{ $blog->fullname }}</td>
                                <td>{{ $blog->email }}</td>
                                <td>{{ $blog->comment }}</td>
                                <td>
                                    @if ($user && $user->hasPermissionByRole('edit blog comment'))
                                    @if($blog->status==1)
                                          <a href="{{ url('admin/blog-comment/inactive/'.$blog->id) }}"><span style="border-radius: 0.2rem;padding-left:3px;padding-right:3px"  class="btn btn-outline-success btn-sm">Active</span></a>
                                    @elseif ($blog->status==0)
                                          <a href="{{ url('admin/blog-comment/active/'.$blog->id) }}"><span style="border-radius: 0.2rem;padding-left:3px;padding-right:3px"  class="btn btn-outline-danger btn-sm">Inactive</span></a>
                                    @endif
                                    @endif
                                    </td>
                                 <td>

                                 @if ($user && $user->hasPermissionByRole('delete blog comment'))
                                  <a href="{{ url('admin/blog-comment/delete/'.$blog->id) }}" style="background-color:hsl(0, 0%, 94%) " onclick="return confirm('Are you sure,you want to delete this blog? ') " class="btn  btn-sm" ><i class=" ri-delete-bin-6-fill"></i></a>
                                 @endif
                                 </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{-- Pagination --}}
                 <div class="pagination-sm">
                    {!! $all_blog_comments->links() !!}
                </div>
            </div>
        </div>
    </div>

</section>
@endsection

