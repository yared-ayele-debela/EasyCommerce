@extends('all_frontend_layouts.layouts')

@section('content')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<style>
    #map { height: 400px; width: 100%; margin-bottom: 20px; }
</style>
<div class="container py-4">
    <div class="header">
        <button class="btn btn-link text-dark" onclick="history.back()">
            <i class="bi bi-arrow-left"></i>
        </button>
        <h5 class="my-4 text-dark text-center">My Delivery Addresses</h5>
    </div>
    <div class="offer-card p-2">
        <div class="card-head p-2">
            <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addressModal">Add Delivery Addresses</a>
            @if(session('success'))
            <div class="alert alert-success mt-2">{{ session('success') }}</div>
            @endif
        </div>
        <div class="card-body p-1">
            @if($addresses->isNotEmpty())
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead class="">
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Address</th>
                            <th>City / Sub-City</th>
                            <th>Street</th>
                            <th>State / Country</th>
                            <th>Pincode</th>
                            <th>Mobile</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($addresses as $index => $address)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $address->name }}</td>
                            <td>{{ $address->address }}</td>
                            <td>{{ $address->city }} / {{ $address->sub_city }}</td>
                            <td>{{ $address->street }}</td>
                            <td>{{ $address->state }} / {{ $address->country }}</td>
                            <td>{{ $address->pincode }}</td>
                            <td>{{ $address->mobile }}</td>
                            <td>
                                @if($address->status)
                                <span class="badge bg-success">Active</span>
                                @else
                                <span class="badge bg-secondary">Inactive</span>
                                @endif
                            </td>

                            <td>
                                <form action="{{ route('user.addresses.destroy', $address->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this address?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm"><i class="bi bi-trash-fill"></i></button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <p>No addresses found. <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addressModal">Add One</a> </p>
            @endif
        </div>
    </div>
</div>
@include('all_frontend_layouts.partials.delivery_address_modal')
@endsection
