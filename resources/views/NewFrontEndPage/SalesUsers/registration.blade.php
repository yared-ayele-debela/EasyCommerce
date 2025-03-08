@extends('fontend.layout.layout')
@section('content')


<form method="POST" action="{{ route('sales.register') }}">
    @csrf
    <div>
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" value="{{ old('name') }}" required autofocus>
    </div>
    <div>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="{{ old('email') }}" required>
    </div>
    <div>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
    </div>
    <div>
        <label for="password-confirm">Confirm Password:</label>
        <input type="password" id="password-confirm" name="password_confirmation" required>
    </div>
    <div>
        <button type="submit">Register</button>
    </div>
</form>
@endsection
