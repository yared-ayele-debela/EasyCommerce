@extends('fontend.layout.layout')
@section('content')
<h1>Dashboard</h1>
<form action="{{ route('sales.logout') }}" method="POST">
@csrf
<button type="submit" class="btn btn-success">Logout </button>
</form>
@endsection
