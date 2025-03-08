@extends('admindashboard.maindashboard')
@section('dashboard')
@php
$user = Auth::guard('admin')->user();
@endphp
@livewire('withdraw-request.withdraw-request')
@endsection

