@extends('admindashboard.maindashboard')
@section('dashboard')
@livewire('offer-list',['productId' => $id])
@endsection

