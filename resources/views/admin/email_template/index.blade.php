@extends('admindashboard.maindashboard')
@section('dashboard')
@php
$user = Auth::guard('admin')->user();
@endphp
<div class="pagetitle bg-light shadow-sm">
    <nav>
        <ol class="breadcrumb p-3">
            <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Home</a></li>
            <li class="breadcrumb-item active">All Email Template</li>
        </ol>
    </nav>
</div>
<section class="section">
    <div class="container mt-5">
        <div class="card border-0">
            <div class="card-header">
                @if ($user && $user->hasPermissionByRole('add email template'))
                        @if($emailtemplates =="0")
                            <a class="btn btn-primary" href="{{ route('add-email-template') }}">Add Email Template</a>
                        @endif
                 @endif
            </div>
            <div class="card-body mt-2">
                <div class="table-responsive">
                    <table class="table mt-2" id="example">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Company Name</th>
                                <td scope="col">Company Email</td>
                                <td scope="col">Company Phone Number</td>
                                <td scope="col">Company Address</td>
                                <th scope="col">Status</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($emailtemplate as $k => $email )
                            <tr>
                                <td>{{ $email->id }}</td>
                                <td>{{ $email->name }}</td>
                                <td>{{ $email->email }}</td>
                                <td>{{ $email->phone }}</td>
                                <td>{{ $email->address }}</td>
                                <td>
                                    @if ($user && $user->hasPermissionByRole('edit email template'))
                                    @if($email->status==1)
                                          <a href="{{ url('admin/email-template/inactive/'.$email->id) }}"><span style="border-radius: 0.2rem;padding-left:3px;padding-right:3px"  class="btn btn-outline-success btn-sm">Active</span></a>
                                    @elseif ($email->status==0)
                                          <a href="{{ url('admin/email-template/active/'.$email->id) }}"><span style="border-radius: 0.2rem;padding-left:3px;padding-right:3px"  class="btn btn-outline-danger btn-sm">Inactive</span></a>
                                    @endif
                                    @endif
                                    </td>
                                 <td>
                                 @if ($user && $user->hasPermissionByRole('edit email template'))
                                  <a href="{{ url('admin/email-template/edit/'.$email->id) }}"  style="background-color:rgb(239, 239, 239) " class=" btn  btn-sm"><i class="ri-ball-pen-fill"></i></a>
                                 @endif
                                 @if ($user && $user->hasPermissionByRole('delete email template'))
                                  <a href="{{ url('admin/email-template/delete/'.$email->id) }}" style="background-color:hsl(0, 0%, 94%) " onclick="return confirm('Are you sure,you want to delete this Email Template ?? ') " class="btn  btn-sm" ><i class=" ri-delete-bin-6-fill"></i></a>
                                 @endif
                                 </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{-- Pagination --}}
                 <div class="pagination-sm">
                    {!! $emailtemplate->links() !!}
                </div>
            </div>
        </div>
    </div>

</section>
@endsection

