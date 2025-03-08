@extends('admindashboard.maindashboard')
@section('dashboard')
@livewire('offer-detail', ['offerId' => $offerId])
@endsection
