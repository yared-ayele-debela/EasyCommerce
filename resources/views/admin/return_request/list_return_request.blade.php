@extends('admindashboard.maindashboard')
@section('dashboard')
@php
$user = Auth::guard('admin')->user();
@endphp
    <div class="pagetitle bg-light shadow-sm">
        <nav>
            <ol class="breadcrumb p-3">
                <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">All return requests</li>
            </ol>
        </nav>
    </div>
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                     <div class="card-header mb-2">
                        <a class="btn btn-primary" href=""></i>All Return Requests</a>
                     </div>
                    <div class="card-body">
                        <table id="example"  class="table mt-2">
                            <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col"> Size</th>
                                <th scope="col"> Code</th>
                                <th scope="col">Return Reason</th>
                                <th scope="col">Comment</th>
                                <th scope="col">Status</th>
                                <th scope="col">Date</th>
                                <th scope="col">Approve/Reject</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if($return_request > 0)
                            @foreach ($return_request as $k => $return)

                                <tr>
                                    <td><a target="_blank" href="{{url('admin/orders/'.$return['order_id'])}}">{{ $return['id']}}</a> </td>
                                    <td>{{ $return['product_size'] }}</td>
                                    <td>{{ $return['product_code']}}</td>

                                    <td>{{ $return['return_reason'] }}</td>
                                    <td>{{ $return['comment'] }}</td>
                                    <td>
                                       {{$return['return_status']}}
                                    </td>
                                    <td>
                                        {{date('d-m-Y h:i:s',strtotime($return['created_at']))}}
                                    </td>

                                    <td>
                                        @if ($user && $user->hasPermissionByRole('edit_return_request'))
                                        <form method="Post" action="{{url('admin/return_request/update')}}">
                                            @csrf
                                            <input type="hidden" name="return_id" value="{{$return['id']}}">
                                            <select class="form-control" name="return_status">
                                                <option @if($return['return_status']=="Approved") selected="" @endif value="Approved">Approved</option>
                                                <option @if($return['return_status']=="Rejected") selected="" @endif value="Rejected">Rejected</option>
                                                <option @if($return['return_status']=="Pending") selected="" @endif value="Pending">Pending</option>
                                            </select>
                                           <br>
                                            <input type="submit" class=" btn btn-primary btn-sm" value="Update">
                                        </form>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            @else
                            <tr>
                                <td>you don't have return request order!</td>
                            </tr>
                            @endif
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
