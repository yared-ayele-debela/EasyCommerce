@extends('Restaurant.dashboard.layouts')
@section('restaurant-dashboard')
@php
$user = Auth::guard('admin')->user();
@endphp
 <nav class="breadcrumb">
    <a class="breadcrumb-item" href="#">Home</a>
    <a class="breadcrumb-item active" href="#">Restaurants</a>
 </nav>
 <div class="container">
    <div class="card">
        <div class="card-header">
            <h2>Restaurants</h2>
            <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addRestaurantModal">Add Restaurant</a>

        </div>
        <div class="card-body">

            <!-- Table -->
            <table class="table mt-3">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Owner</th>
                        <th>Phone</th>
                        <th>Address</th>
                        <th>Logo</th>
                        <th>Cover Image</th>
                        <th>Images</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($restaurants as $restaurant)
                    <tr>
                        <td>{{ $restaurant->name }}</td>
                        <td>{{ $restaurant->email }}</td>
                        <td>{{ $restaurant->admin->name }}</td>
                        <td>{{ $restaurant->phone }}</td>
                        <td>{{ $restaurant->address }}</td>
                        <td><img src="{{ $restaurant->logo }}" width="50" /></td>
                        <td><img src="{{ $restaurant->cover }}" width="50" /></td>
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
                            <div class="btn btn-sm {{ $restaurant->is_active ? 'btn-success' : 'btn-warning' }}">
                                {{ $restaurant->is_active ? 'Active' : 'Inactive' }}
                            </div>
                        </td>
                        <td>
                            <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editRestaurantModal-{{ $restaurant->id }}"><i class="bi bi-pencil-fill"></i></button>
                            <form action="{{ route('restaurants.destroy', $restaurant->id) }}" method="POST" class="delete-form" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-danger btn-sm delete-restaurant">
                                    <i class="bi bi-trash-fill"></i>
                                </button>
                            </form>
                            <a href="{{ url('admin/restaurant/my-restaurant/'.encrypt($restaurant->id)) }}" class="btn btn-info btn-sm text-white"><i class="bi bi-eye-fill"></i></a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Add Restaurant Modal -->
<div class="modal fade" id="addRestaurantModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <form action="{{ route('restaurants.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Restaurant</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="name" class="form-label">Restaurant Name</label>
                                <input type="text" id="name" name="name" class="form-control" placeholder="Enter Name" required>
                                @error('name')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email Address</label>
                                <input type="email" id="email" name="email" class="form-control" placeholder="Enter Email" required>
                                @error('email')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">

                            <div class="mb-3">
                                <label for="phone" class="form-label">Phone Number</label>
                                <input type="phone" id="phone" name="phone" class="form-control" placeholder="Enter Phone" required>
                                @error('phone')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="is_active" class="form-label">Is Active?</label>
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
                               <textarea name="address" id="address" class=" form-control" cols="20" rows="5">
                                Enter Restaurant Address
                               </textarea>
                               @error('address')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="logo" class="form-label">Restaurant Logo</label>
                                <input type="file" id="logo" name="logo" class="form-control">
                                @error('logo')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="cover_image" class="form-label">Restaurant Cover Image</label>
                                <input type="file" id="cover_image" name="cover_image" class="form-control">
                                @error('cover_image')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                        </div>
                        <div class="col-md-6">
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
                                <input type="text" id="latitude" name="latitude" class="form-control" placeholder="Enter Latitude" required>
                                @error('latitude')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="longitude" class="form-label">Longitude</label>
                                <input type="text" id="longitude" name="longitude" class="form-control" placeholder="Enter Longitude" required>
                                @error('longitude')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <button type="button" onclick="getLocation()" class="btn btn-secondary">Use My Location</button>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="map">Select Location on Map</label>
                                <div id="map" style="height: 300px;"></div>
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
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
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
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="name" class="form-label">Restaurant Name</label>
                                <input type="text" id="name" name="name" class="form-control" value="{{ $restaurant->name }}" placeholder="Enter Name" required>
                                @error('name')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email Address</label>
                                <input type="email" id="email" name="email" class="form-control" value="{{ $restaurant->email }}" placeholder="Enter Email" required>
                                @error('email')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">

                            <div class="mb-3">
                                <label for="phone" class="form-label">Phone Number</label>
                                <input type="phone" id="phone" name="phone" class="form-control" value="{{ $restaurant->phone }}" placeholder="Enter Phone" required>
                                @error('phone')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="is_active" class="form-label">Is Active?</label>
                                <select id="is_active" name="is_active" class="form-control">
                                    <option value="1" {{ $restaurant->is_active ? 'selected' : '' }}>Yes</option>
                                    <option value="0" {{ $restaurant->is_active ? '' : 'selected' }}>No</option>
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
                               <textarea name="address" id="address" class=" form-control"  cols="20" rows="5">
                                {{ $restaurant->address }}
                               </textarea>
                               @error('address')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
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
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="cover_image" class="form-label">Restaurant Cover Image</label>
                                <input type="file" id="cover_image" name="cover_image" class="form-control">
                                @if($restaurant->cover_image)
                                <img src="{{ asset('storage/' . $restaurant->cover_image) }}" width="50" />
                                @endif
                                @error('cover_image')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                        </div>
                        <div class="col-md-6">
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
                            <img src="{{ asset('storage/' . $image->image_path) }}" width="50">
                           @endforeach
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="latitude" class="form-label">Latitude</label>
                                <input type="text" id="latitudes" name="latitude" value="{{ $restaurant->latitude }}" class="form-control" placeholder="Enter Latitude" required>
                                @error('latitude')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="longitudes" class="form-label">Longitude</label>
                                <input type="text" id="longitudes" name="longitude" value="{{ $restaurant->longitude }}" class="form-control" placeholder="Enter Longitude" required>
                                @error('longitude')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-12">
                            <button type="button" onclick="getLocations()" class="btn btn-secondary">Use My Location</button>
                            <div class="mb-3">
                                <label for="map">Select Location on Map</label>
                                <div id="map" style="height: 300px;"></div>
                            </div>
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

<!-- Leaflet CSS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<!-- Leaflet JS -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    function getLocation() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(
            function(position) {
                document.getElementById('latitude').value = position.coords.latitude;
                document.getElementById('longitude').value = position.coords.longitude;
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
    function getLocations() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(
            function(position) {
                document.getElementById('latitudes').value = position.coords.latitude;
                document.getElementById('longitudes').value = position.coords.longitude;
                document.getElementById('locationMessages').innerText = "Location captured!";
            },
            function(error) {
                document.getElementById('locationMessages').innerText = "Error: Unable to retrieve location.";
            }
        );
    } else {
        document.getElementById('locationMessage').innerText = "Geolocation is not supported by this browser.";
    }
}
    document.addEventListener("DOMContentLoaded", function () {
        // Default location: Addis Ababa, Ethiopia
        var defaultLat = 9.03;
        var defaultLng = 38.74;

        var map = L.map('map').setView([defaultLat, defaultLng], 13);

        // Add OpenStreetMap (OSM) tile layer
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

        // Add marker at default location (Addis Ababa)
        var marker = L.marker([defaultLat, defaultLng], { draggable: true }).addTo(map);

        // Function to update coordinates in input fields
        function updateCoordinates(lat, lng) {
            document.getElementById('latitude').value = lat;
            document.getElementById('longitude').value = lng;
            document.getElementById('locationMessage').innerText = `Selected: ${lat}, ${lng}`;
        }

        // Set default coordinates
        updateCoordinates(defaultLat, defaultLng);

        // Update coordinates when clicking on the map
        map.on('click', function (e) {
            var lat = e.latlng.lat;
            var lng = e.latlng.lng;
            marker.setLatLng([lat, lng]); // Move marker
            updateCoordinates(lat, lng);
        });

        var mapModal = document.getElementById('addRestaurantModal');
        mapModal.addEventListener('shown.bs.modal', function () {
            if (!map) {
                initMap(); // Initialize map only once
            } else {
                setTimeout(() => {
                    map.invalidateSize();
                }, 200);
            }
        });

        marker.on('dragend', function (e) {
            var position = marker.getLatLng();
            updateCoordinates(position.lat, position.lng);
        });
    });
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
