@extends('admindashboard.maindashboard')
@section('dashboard')

<section class="section col-md-6">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title"></h5> <h4>Assign Role to User: <b>{{ $user->name }}</b>
            </h4>
            <form class="g-3" action="{{ route('users.update_role', $user->id) }}" method="POST">
                @csrf
                <div class="form-group mb-2">
                    <label for="role_id" class="mb-2">Role</label>
                    <input type="hidden" name="user_id" value="{{ $user->id }}">
                    <select name="role_id" id="role_id" class="form-control">
                        <option value="">Select</option>
                        @foreach ($roles as $role)
                            <option value="{{ $role->id }}">{{ $role->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Assign Role</button>
                </div>
            </form>
        </div>
    </div>
    </section>
@endsection

