@extends('admindashboard.maindashboard')
@section('dashboard')

<section class="section col-md-8">
    <div class="card">
        <div class="card-header">
            <a class="btn btn-primary" href=""><i class=" fas fa-plus"></i>Edit Roles</a>
        </div>
        <div class="card-body pt-3">
            <h1>Assign Roles to User: <b>{{ $user->name }}</b></h1>
            <form class="row g-3" action="{{ route('user_roles.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="col-md-6">
                    @foreach ($roles as $role)
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="roles[]" value="{{ $role->id }}" {{ $user->roles->contains($role->id) ? 'checked' : '' }}>
                        <label class="form-check-label" for="role_{{ $role->id }}">
                            {{ $role->role_name }}
                        </label>
                     </div>
                    @endforeach
                    @error('roles[]')
                    <small class=" text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-group pt-3 ">
                    <input type="submit" class=" btn btn-primary pt-2 pb-2 shadow" value="Assign Roles">
                </div>
            </form>
        </div>
    </div>
    </div>
    </div>
</section>
@endsection

