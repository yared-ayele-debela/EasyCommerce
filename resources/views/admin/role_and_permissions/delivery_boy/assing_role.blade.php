@extends('admindashboard.maindashboard')
@section('dashboard')

<section class="section col-md-6">
    <div class="card">
        <div class="card-body pt-3">
            <h5 class="card-title">Assign Role</h5> <h1>Assign Role to User: <b>{{ $user->name }}</b>
            </h1>
            <form class="g-3" action="{{ route('delivery_boy.update_role', $user->id) }}" method="POST">
                @csrf
                <div class="form-group mb-2">
                    <label for="role_id" class="mb-2">Role</label>
                    <select name="role_id" id="role_id" class="form-control">
                        <option value="">Select</option>
                        @foreach ($roles as $role)
                            <option value="{{ $role->id }}">{{ $role->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-outline-primary">Assign role to delviery boy</button>
                </div>
            </form>
        </div>
    </div>
    </section>
@endsection

