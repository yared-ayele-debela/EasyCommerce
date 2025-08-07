@extends('admindashboard.maindashboard')
@section('dashboard')
@php
$user = Auth::guard('admin')->user();
@endphp
<div class="pagetitle bg-light">
    <nav>
        <ol class="breadcrumb p-3 ">
            <li class="breadcrumb-item font-weight-bold"><a href="{{ url('admin/dashboard') }}">Home</a></li>
            <li class="breadcrumb-item"> Delivery Settings</li>
        </ol>
    </nav>
</div>
<div class="container">
   <div class="card">
    <div class="card-header">
    <h4>Delivery Fee Settings</h4>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    </div>
    <div class="card-body">
    <form method="POST" action="{{ route('delivery-settings.update') }}">
        @csrf
        @method('PUT')
        <div class="my-3">
            <label for="fee_per_km" class="form-label">Fee Per KM (ETB)</label>
            <input type="number" step="0.01" class="form-control @error('fee_per_km') is-invalid @enderror"
                   id="fee_per_km" name="fee_per_km" value="{{ old('fee_per_km', $setting->fee_per_km) }}" required>
            @error('fee_per_km')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Update Fee</button>
    </form>
    </div>
   </div>
</div>
@endsection
