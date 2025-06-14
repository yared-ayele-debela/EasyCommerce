@extends('admindashboard.maindashboard')
@section('dashboard')
@php
$user = Auth::guard('admin')->user();
@endphp
<div class="pagetitle bg-light">
   <nav>
      <ol class="breadcrumb p-3">
         <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Home</a></li>
         <li class="breadcrumb-item">Permissions</li>
         <li class="breadcrumb-item active">All Permissionss</li>
      </ol>
   </nav>
 </div>
 <section class="section">
    <div class="container mt-5">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">All Permissions</h4>
               
                {{-- @if ($user && $user->hasPermissionByRole('view permission'))
                        <a class="btn btn-primary" href="{{ route('permissions.create') }}">Add Permissions</a>
                    @endif
                    @if ($user && $user->hasPermissionByRole('view permission category'))
                        <a class="btn btn-info text-white" href="{{ route('permissions-categories') }}">Permission Categories</a>
                    @endif --}}
            </div>
            <div class="card-body mt-2">

                <div class="table-responsive">
                    <table class="table mt-2" id="example">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Name</th>
                                <th scope="col">Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($permissions as $permission)
                            <tr>
                                <td>{{ $permission->id }}</td>
                                <td>{{ $permission->name }}</td>
                                <td>
                                    {{ $permission->created_at }}
                                    {{-- @if ($user && $user->hasPermissionByRole('view permission'))
                                    {{-- @if ($user && $user->hasPermissionByRole('edit permission'))
                                    <a href="{{ route('permissions.edit', $permission->id) }}" class="btn btn-sm btn-info text-white">Edit</a>
                                    @endif

                                    @if($user && $user->hasPermissionByRole('delete permission'))
                                    <form action="{{ route('permissions.destroy', $permission->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this permission?')">Delete</button>
                                    </form>
                                    @endif --}}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="pagination">
                    {!! $permissions->links() !!}
                </div>
            </div>
        </div>
    </div>

 </section>

@endsection
