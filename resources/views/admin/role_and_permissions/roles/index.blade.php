@extends('admindashboard.maindashboard')
@section('dashboard')
@php
$user = Auth::guard('admin')->user();
@endphp
<div class="pagetitle bg-light">
    <nav>
        <ol class="breadcrumb p-3">
            <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Home</a></li>
            <li class="breadcrumb-item active">All Roles</li>
        </ol>
    </nav>
</div>
<section class="section">
    <div class="container mt-5">
        <div class="card">
            <div class="card-header">
                @if($user && $user->hasPermissionByRole('add role'))
                    <a class="btn btn-primary" href="{{ route('roles.create') }}">Add Role</a>
                @endif
            </div>
            <div class="card-body mt-2">
                <div class="table-responsive">
                    <table class="table mt-2" id="example">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Role</th>
                                <th>Permissions</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($roles as $k => $role)
                            <tr>
                                <td>{{ $role->id }}</td>
                                <td>{{ $role->name }}</td>
                                <td>
                                    @if ($role->permissions->count() > 0)
                                    @foreach ($role->permissions as $permission)
                                    <span class="badge bg-light text-dark border-1 ">{{ $permission->name }}</span>
                                    @endforeach
                                    @else
                                    <span class="badge badge-dark">No permission</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($user && $user->hasPermissionByRole('assign role'))
                                    <a class="btn btn-primary  btn-sm" href="{{ url('admin/role/'.$role->id.'/permission') }}">Assign</a>
                                    @endif <br>
                                     @if($role->name == 'Super Admin' || $role->name == 'Admin' ||$role->name == 'admin' ||$role->name == 'Hotel Manager' || $role->name == 'Ecommerce Manager'|| $role->name == 'Restaurant Manager')
                                    @else
                                    @if($user && $user->hasPermissionByRole('edit role'))
                                    <a href="{{ route('roles.edit', $role->id) }}" class="btn btn-sm btn-secondary text-white">Edit</a>
                                    @endif
                                    @endif
                                    <br>
                                    @if ($user && $user->hasPermissionByRole('delete role'))
                                    @if($role->name == 'Super Admin' || $role->name == 'Admin' ||$role->name == 'admin' ||$role->name == 'Hotel Manager' || $role->name == 'Ecommerce Manager'|| $role->name == 'Restaurant Manager')
                                    @else
                                    <form action="{{ route('roles.destroy', $role->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm text-white" onclick="return confirm('Are you sure you want to delete this role?')">Delete</button>
                                    </form>
                                    @endif
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                 <div class="pagination-sm">
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

