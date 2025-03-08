@extends('admindashboard.maindashboard')
@section('dashboard')
@php
$user = Auth::guard('admin')->user();
@endphp
    <div class="pagetitle bg-light">
        <nav>
            <ol class="breadcrumb p-3">
                <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Home</a></li>
                <li class="breadcrumb-item">Ratings</li>
                <li class="breadcrumb-item active">All Ratings</li>
            </ol>
        </nav>
    </div>
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">

                    <div class="card-body">

                        <ul class="nav nav-tabs pb-4 align-items-end card-header-tabs w-100">
                            <li class="nav-item">
                                <a class="nav-link active" href=""><i class="fa fa-list mr-2"></i>All Ratings</a>
                            </li>

                        </ul>

                        <table id="example"  class="table datatable">
                            <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Product Name</th>
                                <th scope="col">User Email</th>
                                <th scope="col">Review</th>
                                <th scope="col">Ratings</th>
                                <th scope="col">Status</th>
                                <th scope="col">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($ratings as $k => $rating)

                                <tr>
                                    <td>{{ $rating['id']}}</td>
                                    <td>{{ $rating['product']['product_name'] }}</td>
                                    <td>{{ $rating['user']['email'] }}</td>

                                    <td>{{ $rating['review'] }}</td>
                                    <td>{{ $rating['rating'] }}</td>
                                    <td>
                                    @if ($user && $user->hasPermissionByRole('edit product rating'))
                                        @if($rating['status']==1)
                                            <a href="{{ url('admin/ratings/inactive/'.$rating['id']) }}"><span style="border-radius: 0.2rem;padding-left:3px;padding-right:3px"  class="btn btn-outline-success btn-sm">Active</span></a>
                                        @elseif ($rating['status']==0)
                                            <a href="{{ url('admin/ratings/active/'.$rating['id']) }}"><span style="border-radius: 0.2rem;padding-left:3px;padding-right:3px"  class="btn btn-outline-danger btn-sm">Inactive</span></a>
                                        @endif
                                    @endif

                                    </td>
                                    <td>
                                        @if ($user && $user->hasPermissionByRole('delete_product_rating'))
                                        <a href="{{ url('admin/ratings/delete/'.$rating['id']) }}" style="background-color:rgb(239, 239, 239) " onclick="return confirm('Are you sure,you want to delete this rating ?? ') " class="btn  btn-sm" ><i class=" ri-delete-bin-6-fill"></i></a>
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
