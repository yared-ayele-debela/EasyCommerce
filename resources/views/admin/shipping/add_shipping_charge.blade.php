@extends('admindashboard.maindashboard')
@section('dashboard')
@php
$user = Auth::guard('admin')->user();
@endphp
<!-- In the <head> -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<section class="section col-md-12">
    <nav class="breadcrumb bg-white shadow-sm py-3 px-4 rounded d-flex justify-content-between align-items-center">
        <button class="btn btn-outline-primary btn-sm d-flex align-items-center" onclick="history.back()">
            <i class="bi bi-arrow-left mr-2"></i> &nbsp;
            <span>Back</span>
        </button>
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item">
                <a href="{{ url('admin/dashboard') }}">Home</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">Create Shipping Charge</li>
        </ol>
    </nav>
    <div class="card">
        <div class="card-header">
            <h4 class="mb-3">Create Shipping Charge</h4>
        </div>
        <div class="card-body">
            <form class="g-3" action="{{ url('admin/shipping-charges/store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row pt-3">

                <div class="col-md-3 mb-2">
                    <div class="form-group">
                        <label for="delivery_zoon">Delivery Zoon</label>
                        <select class="form-control select-delivery-zone" name="zone">
                            <option required selected disabled>select delivery_zoon</option>
                            @foreach ($delivery_zoons as $zoon)
                                <option value="{{ $zoon->name }}">{{ $zoon->name }}</option>
                            @endforeach
                        </select>

                        @error('delivery_zoon')
                        <small class=" text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="col-md-3 mb-2">
                    <label for="0_500g" class="form-label">0_500g</label>
                    <input type="number" min="1" class="form-control" name="0_500g">
                    @error('0_500g')
                    <small class=" text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="col-md-3 mb-2">
                    <label for="501_1000g" class="form-label">501_1000g</label>
                    <input type="number" min="1" class="form-control" name="501_1000g">
                    @error('501_1000g')
                    <small class=" text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="col-md-3 mb-2">
                    <label for="1001_2000g" class="form-label">1001_2000g</label>
                    <input type="number" min="1" class="form-control" name="1001_2000g">
                    @error('1001_2000g')
                    <small class=" text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="col-md-3 mb-2">
                    <label for="2001_5000g" class="form-label">2001_5000g</label>
                    <input type="number" min="1" class="form-control" name="2001_5000g">
                    @error('2001_5000g')
                    <small class=" text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="col-md-3 mb-2">
                    <label for="above_5000g" class="form-label">above_5000g</label>
                    <input type="number" min="1" class="form-control" name="above_5000g">
                    @error('above_5000g')
                    <small class=" text-danger">{{ $message }}</small>
                    @enderror
                </div>
                </div>
                <div class="form-group pt-3 ">
                    <input type="submit" class=" btn btn-primary pt-2 pb-2 shadow" value="Create Shipping Charges">
                </div>
            </form>
        </div>
    </div>
    </div>
    </div>
</section>
<!-- Before </body> -->

@endsection

