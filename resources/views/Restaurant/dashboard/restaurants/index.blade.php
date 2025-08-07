@extends('Restaurant.dashboard.layouts')
@section('restaurant-dashboard')
@php
$user = Auth::guard('admin')->user();
@endphp
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

 <div class="container">
    <nav class="breadcrumb bg-white shadow-sm py-3 px-4 rounded d-flex justify-content-between align-items-center">
        <button class="btn btn-outline-primary btn-sm d-flex align-items-center" onclick="history.back()">
            <i class="bi bi-arrow-left mr-2"></i> &nbsp;
            <span>Back</span>
        </button>

        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item">
                <a href="{{ route('restaurant.dashboard') }}">Home</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">Restaurants</li>
        </ol>
    </nav>
    <div class="card">
        <div class="card-header">
            <h2>Restaurants</h2>
            @adminCan('add_restaurant_restaurant')
            <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addRestaurantModal">Add Restaurant</a>
             @endadminCan
             @session('success')
            <div class="alert alert-success mt-2">
                {{ session('success') }}
            </div>
             @endsession
        </div>
        <div class="card-body">

            <!-- Table -->
            <div class="table-responsive">
                 <table class="table mt-3">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Owner</th>
                        <th>Phone</th>
                        <th>Address</th>
                        <th>Delivery Radius in KM</th>
                        <th>Logo</th>
                        <th>Cover Image</th>
                        <th>Images</th>
                        <th>Opening Time</th>
                        <th>Closing Time</th>
                        <th>Address</th>
                        <th>Is Open</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($restaurants as $restaurant)
                    <tr>
                        <td>{{ $restaurant->name }}</td>
                        <td>{{ $restaurant->email }}</td>
                        <td>{{ $restaurant->admin? $restaurant->admin->name:'' }}</td>
                        <td>{{ $restaurant->phone }}</td>
                        <td>{{ $restaurant->address }}</td>
                        <td><div class="btn btn-sm btn-info">
                            {{ $restaurant->delivery_radius }} KM
                            </div></td>
                        <td><img src="{{ asset('storage/' . $restaurant->logo) }}" width="50" /></td>
                        <td><img src="{{ asset('storage/' . $restaurant->cover) }}" width="50" /></td>
                        <td>
                           <!-- Button trigger modal -->
                           <button type="button" class="btn btn-secondary btn-sm" data-toggle="modal" data-target="#restaurant{{ $restaurant->id }}">
                             View Images
                           </button>

                           <!-- Modal -->
                           <div class="modal fade" id="restaurant{{ $restaurant->id }}" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Images</h5>
                                            <button type="button" class="close btn" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                    </div>
                                    <div class="modal-body">
                                        @foreach($restaurant->images as $image)
                                        <div style="display: inline-block; position: relative;">
                                            <img src="{{$image->image_path}}" width="50">
                                            <form action="{{ route('restaurants.deleteImage', $image->id) }}" method="POST" style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">X</button>
                                            </form>
                                        </div>
                                        @endforeach
                                      </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                           </div>
                        </td>
                        <td>
                            {{ $restaurant->opening_time }}
                        </td>
                        <td>
                            {{ $restaurant->closing_time }}
                        </td>
                        <td>
                         <small> {{ $restaurant->state }}, {{ $restaurant->city }}, | <b>Delivery Zone {{ $restaurant->zone }}</b></small>
                        </td>
                        <td>
                            <div class="btn btn-sm {{ $restaurant->is_open ? 'btn-success' : 'btn-warning' }}">
                                {{ $restaurant->is_open ? 'Open' : 'Close' }}
                            </div>
                        </td>
                        <td>
                            @adminCan('edit_restaurant_restaurant')
                            <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editRestaurantModal-{{ $restaurant->id }}"><i class="bi bi-pencil-fill"></i></button>
                            @endadminCan
                            @adminCan('delete_restaurant_restaurant')
                            <form action="{{ route('restaurants.destroy', $restaurant->id) }}" method="POST" class="delete-form" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-danger btn-sm delete-restaurant">
                                    <i class="bi bi-trash-fill"></i>
                                </button>
                            </form>
                            @endadminCan
                            @adminCan('view_restaurant_restaurant')
                            <a href="{{ url('admin/restaurant/my-restaurant/'.encrypt($restaurant->id)) }}" class="btn btn-info btn-sm text-white"><i class="bi bi-eye-fill"></i></a>
                         @endadminCan
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            </div>
            <div>
                {{ $restaurants->links() }}
            </div>
        </div>
    </div>
</div>

<!-- Add Restaurant Modal -->
<div class="modal fade" id="addRestaurantModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <form action="{{ route('restaurants.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Restaurant</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="name" class="form-label">Restaurant Name</label>
                                <input type="text" id="name" name="name" class="form-control" placeholder="Enter Name" required>
                                @error('name')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email Address</label>
                                <input type="email" id="email" name="email" class="form-control" placeholder="Enter Email" required>
                                @error('email')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-3">

                            <div class="mb-3">
                                <label for="phone" class="form-label">Phone Number</label>
                                <input type="phone" id="phone" name="phone" class="form-control" placeholder="Enter Phone" required>
                                @error('phone')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="is_active" class="form-label">Is Open?</label>
                                <select id="is_active" name="is_active" class="form-control">
                                    <option value="1" selected>Yes</option>
                                    <option value="0">No</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                               <textarea name="description" id="description" class=" form-control" cols="20" rows="5">
                                Enter Restaurant description
                               </textarea>
                               @error('description')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="address" class="form-label">Address</label>
                               <textarea name="address" id="address" class=" form-control location" cols="20" rows="5">
                                Enter Restaurant Address
                               </textarea>
                               @error('address')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        @include('Restaurant.dashboard.restaurants.add_partail')
                        <div class="col-md-3 mb-2">
                            <div class="form-group">
                                <label for="country">Country</label>
                                <select class="form-control" name="country_id">
                                    <option required selected disabled>Select country</option>
                                    @foreach ($countries as $country)
                                        <option value="{{ $country->id }}">{{ $country->country_name }}</option>
                                    @endforeach
                                </select>
                                @error('country')
                                <small class=" text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-3 mb-2">
                            <div class="form-group">
                                <label for="state">State</label>
                                <select class="form-control" name="state">
                                    <option required selected disabled>Select State</option>
                                    @foreach ($states as $state)
                                        <option value="{{ $state->name }}">{{ $state->name }}</option>
                                    @endforeach
                                </select>
                                @error('state')
                                <small class=" text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-3 mb-2">
                            <div class="form-group">
                                <label for="city">City</label>
                                <select class="form-control" name="city">
                                    <option required selected disabled>Select City</option>
                                    @foreach ($cities as $city)
                                        <option value="{{ $city->name }}">{{ $city->name }}</option>
                                    @endforeach
                                </select>
                                @error('city')
                                <small class=" text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                         <div class="col-md-4">
                            <div class="mb-3">
                                <label for="start_from" class="form-label">Delivery fee start from</label>
                                <input type="text" id="start_from" name="start_from" class="form-control">
                                @error('start_from')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                         <div class="col-md-4">
                            <div class="mb-3">
                                <label for="opening_time" class="form-label">Opening time</label>
                                <input type="time" id="opening_time" name="opening_time" class="form-control">
                                @error('opening_time')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                         <div class="col-md-4">
                            <div class="mb-3">
                                <label for="closing_time" class="form-label">Closing time</label>
                                <input type="time" id="closing_time" name="closing_time" class="form-control">
                                @error('closing_time')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                         <div class="col-md-4">
                            <div class="mb-3">
                                <label for="delivery_radius" class="form-label">Maximum delivery radius (in km)</label>
                                <input type="number" id="delivery_radius" name="delivery_radius" class="form-control">
                                @error('delivery_radius')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="logo" class="form-label">Restaurant Logo</label>
                                <input type="file" id="logo" name="logo" class="form-control">
                                @error('logo')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="cover_image" class="form-label">Restaurant Cover Image</label>
                                <input type="file" id="cover_image" name="cover_image" class="form-control">
                                @error('cover_image')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="images" class="form-label">Restaurant Image Gallery</label>
                                <input type="file" id="images" name="images[]" class="form-control" multiple>
                                @error('images')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <input type="hidden" name="admin_id" value="{{ $user->id }}">
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="latitude" class="form-label">Latitude</label>
                                <input type="text" id="latitude" name="latitude" class="form-control latitude" placeholder="Enter Latitude" required>
                                @error('latitude')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="longitude" class="form-label">Longitude</label>
                                <input type="text" id="longitude" name="longitude" class="form-control longitude" placeholder="Enter Longitude" required>
                                @error('longitude')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="mb-3">
                               @include('Restaurant.dashboard.restaurants.partials.map')
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div id="locationMessage" class="text-success"></div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </div>
        </form>
    </div>
</div>

@foreach($restaurants as $restaurant)
<div class="modal fade" id="editRestaurantModal-{{ $restaurant->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <form action="{{ route('restaurants.update', $restaurant->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Restaurant</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="name" class="form-label">Restaurant Name</label>
                                <input type="text" id="name" name="name" class="form-control" value="{{ $restaurant->name }}" placeholder="Enter Name" required>
                                @error('name')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email Address</label>
                                <input type="email" id="email" name="email" class="form-control" value="{{ $restaurant->email }}" placeholder="Enter Email" required>
                                @error('email')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-3">

                            <div class="mb-3">
                                <label for="phone" class="form-label">Phone Number</label>
                                <input type="phone" id="phone" name="phone" class="form-control" value="{{ $restaurant->phone }}" placeholder="Enter Phone" required>
                                @error('phone')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="is_active" class="form-label">Is Open?</label>
                                <select id="is_active" name="is_active" class="form-control">
                                    <option value="1" {{ $restaurant->is_open ? 'selected' : '' }}>Yes</option>
                                    <option value="0" {{ $restaurant->is_open ? '' : 'selected' }}>No</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                               <textarea name="description" id="description" class=" form-control"  cols="20" rows="5">
                                {{ $restaurant->description }}
                               </textarea>
                               @error('description')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="address" class="form-label">Address</label>
                               <textarea name="address" id="address" class=" form-control location"  cols="20" rows="5">
                                {{ $restaurant->address }}
                               </textarea>
                               @error('address')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        @include('Restaurant.dashboard.restaurants.edit_partail')
                        <div class="col-md-3 mb-2">
                            <div class="form-group">
                                <label for="country">Country</label>
                                <select class="form-control" name="country_id">
                                    <option required selected disabled>Select country</option>
                                    @foreach ($countries as $country)
                                        <option @if($restaurant->country_id===$country->id) selected @endif value="{{ $country->id }}">{{ $country->country_name }}</option>
                                    @endforeach
                                </select>
                                @error('country')
                                <small class=" text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-3 mb-2">
                            <div class="form-group">
                                <label for="state">State</label>
                                <select class="form-control" name="state">
                                    <option required selected disabled>Select State</option>
                                    @foreach ($states as $state)
                                        <option @if($restaurant->state===$state->name) selected @endif  value="{{ $state->name }}">{{ $state->name }}</option>
                                    @endforeach
                                </select>
                                @error('state')
                                <small class=" text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-3 mb-2">
                            <div class="form-group">
                                <label for="city">City</label>
                                <select class="form-control" name="city">
                                    <option required selected disabled>Select City</option>
                                    @foreach ($cities as $city)
                                        <option @if($restaurant->city===$city->name) selected @endif value="{{ $city->name }}">{{ $city->name }}</option>
                                    @endforeach
                                </select>
                                @error('city')
                                <small class=" text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                         <div class="col-md-4">
                            <div class="mb-3">
                                <label for="start_from" class="form-label">Delivery fee start from</label>
                                <input type="text" id="start_from" value=" {{ $restaurant->start_from }}" name="start_from" class="form-control">
                                @error('start_from')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                         <div class="col-md-4">
                            <div class="mb-3">
                                <label for="opening_time" class="form-label">Opening time</label>
                                <input type="time" id="opening_time" value="{{ \Carbon\Carbon::parse($restaurant->opening_time)->format('H:i') }}" name="opening_time" class="form-control">
                                @error('opening_time')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                         <div class="col-md-4">
                            <div class="mb-3">
                                <label for="closing_time" class="form-label">Closing time</label>
                                <input type="time" id="closing_time"  value="{{ \Carbon\Carbon::parse($restaurant->closing_time)->format('H:i') }}" name="closing_time" class="form-control">
                                @error('closing_time')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                         <div class="col-md-4">
                            <div class="mb-3">
                                <label for="delivery_radius" class="form-label">Maximum delivery radius (in km)</label>
                                <input type="number" id="delivery_radius" name="delivery_radius" value="{{ $restaurant->delivery_radius }}" class="form-control">
                                @error('delivery_radius')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="logo" class="form-label">Restaurant Logo</label>
                                <input type="file" id="logo" name="logo" class="form-control">
                                @if($restaurant->logo)
                                <img src="{{ asset('storage/' . $restaurant->logo) }}" width="50" />
                                @endif
                                @error('logo')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="cover_image" class="form-label">Restaurant Cover Image</label>
                                <input type="file" id="cover_image" name="cover_image" class="form-control">
                                @if($restaurant->cover_image)
                                <img src="{{ asset('storage/' . $restaurant->logo) }}" width="50" />
                                @endif
                                @error('cover_image')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="images" class="form-label">Restaurant Images</label>
                                <input type="file" id="images" name="images[]" class="form-control" multiple>
                                @error('images')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <input type="hidden" name="admin_id" value="{{ $user->id }}">
                            <br>
                            @foreach($restaurant->images as $image)
                            <img src="{{ $image->image_path }}" width="50">
                           @endforeach
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="latitude" class="form-label">Latitude</label>
                                <input type="text" id="latitudes" name="latitude" value="{{ $restaurant->latitude }}" class="form-control latitude" placeholder="Enter Latitude" required>
                                @error('latitude')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="longitudes" class="form-label">Longitude</label>
                                <input type="text" id="longitudes" name="longitude" value="{{ $restaurant->longitude }}" class="form-control longitude" placeholder="Enter Longitude" required>
                                @error('longitude')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-12">
                       @include('Restaurant.dashboard.restaurants.partials.map')
                        </div>
                        <div class="col-md-12">
                            <div id="locationMessage" class="text-success"></div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endforeach

<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        let initializedMaps = new Set();

        document.querySelectorAll('.modal').forEach(modal => {
            modal.addEventListener('shown.bs.modal', function () {
                const modalId = this.getAttribute('id');
                if (initializedMaps.has(modalId)) return;

                const container = this;
                const mapDiv = container.querySelector('.map');
                const searchInput = container.querySelector('.search-address');
                const resultsContainer = container.querySelector('.map-search-results');
                const spinner = container.querySelector('.loading-spinner');
                const latField = container.querySelector('.delivery-lat');
                const lngField = container.querySelector('.delivery-lng');
                const latitude = container.querySelector('.latitude');
                const longtidue = container.querySelector('.longitude');
                const location = container.querySelector('.location');
                const addressField = container.querySelector('.delivery-address');
                const selectedText = container.querySelector('.selected-address-text');


                const map = L.map(mapDiv).setView([9.6040976, 41.8207994], 13);

                L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);

                const icon = L.icon({
                    iconUrl: 'https://unpkg.com/leaflet@1.9.3/dist/images/marker-icon.png',
                    iconSize: [25, 41],
                    iconAnchor: [12, 41],
                    shadowUrl: 'https://unpkg.com/leaflet@1.9.3/dist/images/marker-shadow.png',
                    shadowSize: [41, 41]
                });

                let marker;

                map.on('click', async function (e) {
                    const lat = e.latlng.lat;
                    const lng = e.latlng.lng;
                    try {
                        const res = await fetch(`/api/reverse-geocode?lat=${lat}&lon=${lng}`);
                        const data = await res.json();
                        if (data.data?.length) {
                            const address = data.data[0].name + ", " + data.data[0].City;
                            setLocation(lat, lng, address);
                        }
                    } catch (err) {
                        console.error('Reverse geocoding error:', err);
                    }
                });

                if (searchInput) {
                searchInput.addEventListener('keyup', async function () {
                    const q = this.value.trim();
                    if (q.length < 3) return;

                    spinner.style.display = 'inline-block';
                    resultsContainer.innerHTML = '';

                    try {
                        const bounds = '41.766,9.550,41.920,9.640'; // minLng,minLat,maxLng,maxLat
                        const apiKey = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJjb21wYW55bmFtZSI6IkVhc3kgZS1jb21tZXJjZSBob3RlbCBib29raW5nIGFuZCBkZWxpdmVyeSIsImRlc2NyaXB0aW9uIjoiMGU4ZDhhZDMtZmJhYy00OTJkLWE4OWYtZGFiZjQxNTFlNDc2IiwiaWQiOiI3OWY1ODRlYy0yZDA3LTRjNWQtYTI2Ny00MjBhNzVlMDY2NzMiLCJ1c2VybmFtZSI6ImJlZmk3NzU2In0.JgSoBiAoa4Te6ccg-jSJSifq26PZV4FnGbkhQKiTnuo'; // insert your API key if required
                        const url = `https://mapapi.gebeta.app/api/v1/route/geocoding?name=${encodeURIComponent(q)}&apiKey=${apiKey}&bounds=${bounds}`;

                        const res = await fetch(url);
                        const data = await res.json();
                        spinner.style.display = 'none';

                        if (data.data?.length) {
                            data.data.forEach(loc => {
                                const item = document.createElement('a');
                                item.href = "#";
                                item.className = 'list-group-item list-group-item-action';
                                item.textContent = `${loc.name}${loc.City ? ', ' + loc.City : ''}`;

                                item.onclick = () => {
                                    setLocation(loc.latitude, loc.longitude, `${loc.name}${loc.City ? ', ' + loc.City : ''}`);
                                    resultsContainer.innerHTML = '';
                                };

                                resultsContainer.appendChild(item);
                            });
                        } else {
                            resultsContainer.innerHTML = '<div class="list-group-item">No results found</div>';
                        }

                    } catch (err) {
                        spinner.style.display = 'none';
                        resultsContainer.innerHTML = '<div class="list-group-item text-danger">Error fetching results</div>';
                        console.error('Geocoding fetch error:', err);
                    }
                });
            }


                function setLocation(lat, lng, address) {
                    if (marker) map.removeLayer(marker);
                    marker = L.marker([lat, lng], { icon }).addTo(map).bindPopup(address).openPopup();
                    map.setView([lat, lng], 15);

                    selectedText.textContent = address;
                    latField.value = lat;
                    lngField.value = lng;
                    latitude.value=lat;
                    longtidue.value=lng;
                    location.value=address;
                    addressField.value = address;
                }

                initializedMaps.add(modalId);

                // Fix map size rendering after modal animation
                setTimeout(() => {
                    map.invalidateSize();
                }, 300);
            });
        });
    });
</script>
<script>
    $(document).ready(function () {
        // Listen for any modal being shown
        $('.modal').on('shown.bs.modal', function () {
            // Inside this modal, find any .select-street and initialize Select2
            const $modal = $(this);
            $modal.find('.select-delivery-zon').select2({
                dropdownParent: $modal, // make sure dropdown stays inside modal
                placeholder: 'Select a street',
                allowClear: true,
                width: '100%' // optional but helps in modals
            });
        });
    });
</script>

<script>
    $(document).ready(function() {
    $('#addRestaurantModal').on('shown.bs.modal', function () {
        $('.select-delivery-zone').select2({
            dropdownParent: $('#addRestaurantModal'),
            placeholder: 'Select a street',
            allowClear: true,
            width: '100%' // Ensures full width inside modal
        });
    });

});
    function getLocation() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(
            function(position) {
                document.getElementById('latitude').value = position.coords.latitude;
                document.getElementById('longitude').value = position.coords.longitude;
                document.getElementById('latitudes').value = position.coords.latitude;
                document.getElementById('longitudes').value = position.coords.longitude;
                document.getElementById('locationMessage').innerText = "Location captured!";
            },
            function(error) {
                document.getElementById('locationMessage').innerText = "Error: Unable to retrieve location.";
            }
        );
    } else {
        document.getElementById('locationMessage').innerText = "Geolocation is not supported by this browser.";
    }
}

    </script>
    <script>
        $(document).ready(function () {
            $(document).on("click", ".delete-restaurant", function (e) {
                e.preventDefault();
                let form = $(this).closest("form");

                Swal.fire({
                    title: "Are you sure?",
                    text: "You won't be able to revert this!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#d33",
                    cancelButtonColor: "#3085d6",
                    confirmButtonText: "Yes, delete it!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit(); // Submit the form after confirmation
                    }
                });
            });
        });
    </script>
@endsection
