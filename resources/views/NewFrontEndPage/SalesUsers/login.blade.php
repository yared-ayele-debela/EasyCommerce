@extends('fontend.layout.layout')
@section('content')
<form method="POST" action="{{ route('sales.login') }}">
    @csrf
    <div>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus>
    </div>
    <div>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
    </div>
    <div>
        <label for="remember">
            <input type="checkbox" id="remember" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
        </label>
    </div>
    <div>
        <button type="submit">Login</button>
    </div>
</form>
@endsection
