@extends('admindashboard.maindashboard')
@section('dashboard')
@php
$user = Auth::guard('admin')->user();
@endphp
<div class="pagetitle bg-light shadow-sm">
    <nav>
        <ol class="breadcrumb p-3">
            <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Home</a></li>
            <li class="breadcrumb-item active">All Invoice Settings Template</li>
        </ol>
    </nav>
</div>
<section class="section">
    <div class="container mt-5">
        <div class="card border-0">
            <div class="card-header">
                @if ($user && $user->hasPermissionByRole('view invoice'))
                @if($invoicesetting =="0")
                    <a class="btn btn-primary" href="{{ route('add-invoice-setting') }}">Add Invoice settings</a>
                @endif
                @endif
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table datatable">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Company Name</th>
                                <td scope="col">Company Email</td>
                                <td scope="col">Company Phone Number</td>
                                <td scope="col">Company Address</td>
                                <td scope="col">Footer Text</td>
                                <th scope="col">Status</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($invoicesetting as $k => $invoice )
                            <tr>
                                <td>{{ $invoice->id }}</td>
                                <td>{{ $invoice->name }}</td>

                                <td>
                                    {{ $invoice->email }}
                                </td>
                                <td>{{ $invoice->phone }}</td>
                                <td>{{ $invoice->address }}</td>
                                <td>{{ $invoice->footer_text }}</td>
                                <td>
                                     @if ($user && $user->hasPermissionByRole('edit invoice'))
                                        @if($invoice->status==1)
                                            <a href="{{ url('admin/invoice-setting/inactive/'.$invoice->id) }}"><span style="border-radius: 0.2rem;padding-left:3px;padding-right:3px"  class="btn btn-outline-success btn-sm">Active</span></a>
                                        @elseif ($invoice->status==0)
                                            <a href="{{ url('admin/invoice-setting/active/'.$invoice->id) }}"><span style="border-radius: 0.2rem;padding-left:3px;padding-right:3px"  class="btn btn-outline-danger btn-sm">Inactive</span></a>
                                        @endif
                                     @endif
                                    </td>
                                 <td>
                                 @if ($user && $user->hasPermissionByRole('edit invoice'))
                                  <a href="{{ url('admin/invoice-setting/edit/'.$invoice->id) }}"  style="background-color:rgb(239, 239, 239) " class=" btn  btn-sm"><i class="ri-ball-pen-fill"></i></a>
                                 @endif
                                 @if ($user && $user->hasPermissionByRole('delete invoice'))
                                  <a href="{{ url('admin/invoice-setting/delete/'.$invoice->id) }}" style="background-color:hsl(0, 0%, 94%) " onclick="return confirm('Are you sure,you want to delete this Invoice Settings ? ') " class="btn  btn-sm" ><i class=" ri-delete-bin-6-fill"></i></a>
                                 @endif
                                 </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{-- Pagination --}}
                 <div class="pagination-sm">
                    {!! $invoicesetting->links() !!}
                </div>
            </div>
        </div>
    </div>

</section>
@endsection

