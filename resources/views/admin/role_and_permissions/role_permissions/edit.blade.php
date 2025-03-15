@extends('admindashboard.maindashboard')
@section('dashboard')
<div class="pagetitle bg-light">
   <nav>
      <ol class="breadcrumb p-3">
         <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Home</a></li>
         <li class="breadcrumb-item active">All permissions</li>
      </ol>
   </nav>
 </div>
 <section class="section">
    <div class="container mt-5">
        <div class="card border-0">
            <div class="card-header">
                <h5 class="card-title mb-0">Assign Permissions to Role: <b>{{ $roles->name }}</b></h5>
            </div>
            <div class="card-body">
                <form action="{{ route('role_permissions.update', $roles->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="permissions">Permissions</label>
                        <div class="row">
                            {{-- @foreach($permissions as $category)
                                <h2><b>for {{ $category->name }} permissions </b></h2>
                                <ul>
                                    @foreach($category->permissions as $permission)
                                        <li>{{ $permission->name }}</li>
                                    @endforeach
                                </ul>
                            @endforeach --}}
                            @foreach ($permissions as $category)
                                <div class="col-lg-4 col-md-6 col-sm-12 mb-3">
                                    <h2><b>for {{ $category->name }} permissions </b></h2>
                                    @foreach($category->permissions as $permission)
                                    <div class="custom-control custom-checkbox">
                                        <input class="custom-control-input" type="checkbox" id="permission_{{ $permission->id }}" name="permissions[]" value="{{ $permission->id }}" {{ $roles->permissions->contains($permission->id) ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="permission_{{ $permission->id }}">
                                            {{ $permission->name }}
                                        </label>
                                    </div>
                                    @endforeach
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="mt-3">
                        <button type="submit" class="btn btn-primary">Save Permissions</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

  </section>
@endsection
