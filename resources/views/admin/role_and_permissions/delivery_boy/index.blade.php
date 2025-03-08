@extends('admindashboard.maindashboard')
@section('dashboard')
@php
$user_ = Auth::guard('admin')->user();
@endphp
<div class="pagetitle bg-light">
    <nav>
        <ol class="breadcrumb p-3">
            <li class="breadcrumb-item"><a href="{{ url('Delivery Boy/dashboard') }}">Home</a></li>
            <li class="breadcrumb-item active">all delivery boys</li>
        </ol>
    </nav>
</div>
<section class="section">
    <div class="container mt-5">
        <div class="card">
            <div class="card-header">
                <a class="btn btn-primary" href="javascript:void();">All Delivery Boys</a>
            </div>
            <div class="card-body mt-2">

                <div class="table-responsive">
                    <table class="table mt-2" id="example">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                            <tr>
                                <td>{{ $user->first_name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    @if ($user->roles->count() > 0)
                                        @foreach ($user->roles as $role)
                                            <span class="btn btn-sm btn-success">{{ $role->name }}</span>
                                        @endforeach
                                    @else
                                        <span class="badge badge-dark text-dark">No Role</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($user_ && $user_->hasPermissionByRole('assign role'))
                                    <a href="{{ route('delivery_boy.assign_role', $user->id) }}" class="btn btn-primary btn-sm">Assign Role</a>
                                    @endif
                                 </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</section>

@endsection

