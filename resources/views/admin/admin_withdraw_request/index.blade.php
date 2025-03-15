@extends('admindashboard.maindashboard')
@section('dashboard')
@php
$user = Auth::guard('admin')->user();
@endphp
@livewire('admin-withdraw-request.admin-withdraw-request')
@endsection

