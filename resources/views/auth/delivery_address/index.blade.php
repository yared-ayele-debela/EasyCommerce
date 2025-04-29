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


    <div class="modal fade" id="addressModal" tabindex="-1" aria-labelledby="addressModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addressModalLabel">Add Delivery Address</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-7">
                            <div class="mb-3">
                                <button type="button" onclick="getLocation()" class="btn btn-secondary">Use My Location</button>
                            </div>
                            <div class="mb-3">
                                <div id="locationMessage" style="margin-top: 10px; font-weight: bold;"></div>
                                <div id="map"></div>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <form action="{{ url('/addresses') }}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label class="form-label">Full Name</label>
                                            <input type="text" class="form-control" name="name" required>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label class="form-label">Address</label>
                                            <input type="text" class="form-control" name="address" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="country" class="form-label">Country</label>
                                            <select id="country" class="form-select" name="country">
                                                <option value="">Select Country</option>
                                                @foreach ($countries as $country)
                                                <option value="{{ $country->id }}">{{ $country->country_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="state" class="form-label">State</label>
                                            <select id="state" class="form-select" name="state">
                                                <option value="">Select State</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="city" class="form-label">City</label>
                                            <select id="city" class="form-select" name="city">
                                                <option value="">Select City</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="sub_city" class="form-label">Sub City</label>
                                            <select id="sub_city" class="form-select" name="sub_city">
                                                <option value="">Select Sub City</option>
                                            </select>
                                        </div>

                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="street" class="form-label">Street</label>
                                            <select id="street" class="form-select" name="street">
                                                <option value="">Select Street</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label class="form-label">Pincode</label>
                                            <input type="text" class="form-control w-100" name="pincode">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="form-label">Mobile</label>
                                            <input type="number" class="form-control w-100" name="mobile" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-2">
                                    <label for="latitude" class="form-label">Latitude:</label>
                                    <input type="text" id="latitude" class="form-control" name="latitude" readonly>
                                    </div>

                                    <div class="col-md-6 mb-2">
                                        <label for="longitude" class="form-label">Longitude:</label>
                                       <input type="text" id="longitude" class="form-control" name="longitude" readonly>
                                    </div>
                                </div>
                                <button type="submit" class="btn bg-primary text-white">Save Address</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        var defaultLat = 9.03;
        var defaultLng = 38.74;

        var map = L.map('map').setView([defaultLat, defaultLng], 13);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

        var marker = L.marker([defaultLat, defaultLng], { draggable: true }).addTo(map);

        function updateCoordinates(lat, lng) {
            document.getElementById('latitude').value = lat.toFixed(6);
            document.getElementById('longitude').value = lng.toFixed(6);
            document.getElementById('locationMessage').innerText = `Selected: ${lat.toFixed(6)}, ${lng.toFixed(6)}`;
        }

        updateCoordinates(defaultLat, defaultLng);

        marker.on('dragend', function(e) {
            var position = marker.getLatLng();
            updateCoordinates(position.lat, position.lng);
        });

        map.on('click', function(e) {
            var lat = e.latlng.lat;
            var lng = e.latlng.lng;
            marker.setLatLng([lat, lng]);
            updateCoordinates(lat, lng);
        });

        document.addEventListener('shown.bs.modal', function (event) {
            if (event.target.id === 'addressModal') {
                setTimeout(function () {
                    map.invalidateSize();
                    map.setView(marker.getLatLng(), 13);
                }, 300);
            }
        });
    });
</script>
@endsection
