<!-- resources/views/amenities/index.blade.php -->
@extends('Hotel.dashboard.layouts')
@section('hotel-dashboard')

<div class="container">
    <nav class="breadcrumb bg-white shadow-sm py-3 px-4 rounded d-flex justify-content-between align-items-center">
        <button class="btn btn-outline-primary btn-sm d-flex align-items-center" onclick="history.back()">
            <i class="bi bi-arrow-left mr-2"></i> &nbsp;
            <span>Back</span>
        </button>

        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item">
                <a href="{{ route('hotel.dashboard') }}">Home</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">Hotels</li>
        </ol>
    </nav>
    <div class="card">
        <div class="card-header">
            <h4 class="mb-4">Hotel List</h4>
            <!-- Success Alert -->
            @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            <!-- Create Button -->
            <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#createHotelModal">Add Hotel</button>

        </div>
        <div class="card-body">

            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Category</th>
                            <th>Country</th>
                            <th>State</th>
                            <th>City</th>
                            <th>Location</th>
                            <th>Banner</th>
                            <th>Gallery</th>
                            <th>Is Advertised</th>
                            <th>Is Featured</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($hotels as $hotel)
                        <tr>
                            <td>{{ $hotel->id }}</td>
                            <td>{{ $hotel->name }}</td>
                            <td>{{ $hotel->category->name ?? '-' }}</td>

                            <td>{{ $hotel->country }}</td>
                            <td>{{ $hotel->state }}</td>
                            <td>{{ $hotel->city }}</td>
                            <td>{{ $hotel->location }}</td>
                            <td>
                                @if($hotel->banner_image)
                                <img src="{{ $hotel->banner_image }}" width="40">
                                @endif
                            </td>
                            <td>
                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-secondary btn-sm mb-1" data-toggle="modal" data-target="#viewImage{{ $hotel->id }}">
                                  View Images
                                </button>

                                <!-- Modal -->
                                <div class="modal fade" id="viewImage{{ $hotel->id }}" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Hotel Image Gallery</h5>
                                                    <button type="button" class="close btn" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row">
                                                    @foreach($hotel->photos as $photo)
                                                <div class="col-md-3">
                                                    <div class="card mb-3">
                                                        <img src="{{$photo->photo_url }}"  class=" img-fluid" alt="Photo">
                                                        <div class="card-body p-2">
                                                            <form action="{{ route('hotel_photos.destroy', $photo->id) }}" method="POST">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-sm btn-danger">
                                                                    x
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                                @endforeach
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <button class="btn btn-primary mb-3 btn-sm" data-bs-toggle="modal" data-bs-target="#addPhotoModal{{ $hotel->id }}">Add Photo</button>

                                <div class="modal fade" id="addPhotoModal{{ $hotel->id }}" tabindex="-1" aria-labelledby="addPhotoModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <form action="{{ route('hotel_photos.store') }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Add Hotel Photo</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <input type="hidden" name="hotel_id" value="{{ $hotel->id }}" class="form-control" required>
                                                    <div class="mb-3">
                                                        <label for="photo_url" class="form-label">Image </label>
                                                        <input type="file" name="photo_url" class="form-control" required>
                                                    </div>

                                                    @if ($errors->any())
                                                    <div class="alert alert-danger mt-2">
                                                        <ul class="mb-0">
                                                            @foreach ($errors->all() as $error)
                                                            <li class="small">{{ $error }}</li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                    @endif

                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-primary">Add Photo</button>
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </td>

                            <td>
                                <a href="{{ url('admin/hotel/'.$hotel->id.'/toggleAdvertise') }}" class="btn btn-sm {{ $hotel->is_adverted? 'btn-success':'btn-danger' }} ">
                                    {{ $hotel->is_adverted? "Yes":"No"}}
                                </a>
                            </td>
                            <td>
                                <a href="{{ url('admin/hotel/'.$hotel->id.'/toggleFeatured') }}" class="btn btn-sm {{ $hotel->is_featured? 'btn-success':'btn-danger' }} ">
                                    {{ $hotel->is_featured? "Yes":"No"}}
                                </a>
                            </td>
                            <td>
                                <a href="{{ url('admin/hotel/'.$hotel->id.'/reviews') }}" class="btn btn-sm btn-warning text-white"><i class="bi bi-star-fill"></i></a>
                                <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#editHotelModal{{ $hotel->id }}"><i class="bi bi-pencil-square"></i></button>
                                <form action="{{ route('hotels.destroy', $hotel->id) }}" method="POST" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-danger delete-restaurant"><i class=" bi bi-trash-fill"></i></button>
                                </form>
                                <form action="{{ route('my-hotel') }}" method="GET" class="d-inline">
                                    @csrf
                                    <input type="hidden" name="id" id="id" value="{{ $hotel->id }}">
                                    <button class="btn btn-sm btn-secondary text-white"><i class="bi bi-eye-fill"></i> Hotel</button>
                                </form>

                            </td>
                        </tr>
                        <!-- Edit Modal -->
                        <div class="modal fade " id="editHotelModal{{ $hotel->id }}" tabindex="-1">
                            <div class="modal-dialog bg-white modal-fullscreen modal-dialog-scrollable">
                                <div class="modal-content shadow-lg border-0 rounded-4">
                                <form method="POST" action="{{ route('hotels.update', $hotel->id) }}" enctype="multipart/form-data">
                                    @csrf @method('PUT')
                                    <div class="modal-header">
                                        <h5 class="modal-title">Edit Hotel</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-2">
                                                    <label class="form-label">Name</label>
                                                    <input type="text" name="name" class="form-control" value="{{  $hotel->name ? $hotel->name : old('name') }}" required>
                                                </div>

                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-2">
                                                    <label class="form-label">Category</label>
                                                    <select name="category_id" class="form-select">
                                                        <option value="">-- Select Category --</option>
                                                        @foreach($categories as $category)
                                                        <option value="{{ $category->id }}" {{ $hotel && $hotel->category_id == $category->id ? 'selected' : '' }}>
                                                            {{ $category->name }}
                                                        </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="mb-2">
                                                    <label class="form-label">Location</label>
                                                    <input type="text" name="location" class="form-control" value="{{ $hotel ? $hotel->location : old('location') }}" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-2">
                                                    <label class="form-label">Price Per Night</label>
                                                    <input type="number" step="0.01" name="price_per_night" class="form-control" value="{{ $hotel ? $hotel->price_per_night : old('price_per_night') }}" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-2">
                                                    <label class="form-label">Phone</label>
                                                    <input type="text" name="phone" class="form-control" value="{{ $hotel ? $hotel->phone : old('phone') }}">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-2">
                                                    <label class="form-label">Banner Image</label>
                                                    <input type="file" name="banner_image" class="form-control">
                                                    @if($hotel && $hotel->banner_image)
                                                    <img src="{{ $hotel->banner_image }}" class="mt-2" width="60">
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="mb-3">
                                                    <label for="latitudes" class="form-label">Latitude</label>
                                                    <input type="text" id="latitudes" name="latitude" class="form-control" value="{{ $hotel->latitude }}" placeholder="Enter Latitude" required>
                                                    @error('latitude')
                                                    <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="mb-3">
                                                    <label for="longitudes" class="form-label">Longitude</label>
                                                    <input type="text" id="longitudes" name="longitude" class="form-control" value="{{ $hotel->longitude }}" placeholder="Enter Longitude" required>
                                                    @error('longitude')
                                                    <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="mb-3">
                                                    <label for="location" class="form-label">Location</label>
                                                    <br>
                                                    <button type="button" onclick="getLocation()" class="btn btn-secondary">Use My Location</button>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="mb-3">
                                                    <label for="map{{ $hotel->id }}">Select Location on Map</label>
                                                    <div id="map{{ $hotel->id }}" style="height: 300px;"></div>
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div id="locationMessages" class="text-success"></div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="mb-2">
                                                    <label class="form-label">Description</label>
                                                    <textarea name="description" class="form-control">{{ $hotel ? $hotel->description : old('description') }}</textarea>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <button class="btn btn-success">Update</button>
                                    </div>
                                </form>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Create Modal -->
            <div class="modal fade" id="createHotelModal" tabindex="-1">
                <div class="modal-dialog modal-fullscreen modal-dialog-scrollable">
                    <form method="POST" action="{{ route('hotels.store') }}" enctype="multipart/form-data" class="modal-content">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title">Add New Hotel</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="map">Select Location on Map</label>
                                            <div id="map" style="height: 300px;"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="location" class="form-label">Location</label>
                                            <br>
                                            <button type="button" onclick="getLocation()" class="btn btn-secondary">Use My Location</button>
                                        </div>
                                    </div>

                                </div>

                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-2">
                                                <label class="form-label">Name</label>
                                                <input type="text" name="name" class="form-control" required>
                                            </div>

                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-2">
                                                <label class="form-label">Category</label>
                                                <select name="category_id" class="form-select">
                                                    <option value="">-- Select Category --</option>
                                                    @foreach($categories as $category)
                                                    <option value="{{ $category->id }}">
                                                        {{ $category->name }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="mb-2">
                                                <label class="form-label">Address</label>
                                                <input type="text" name="location" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-2">
                                                <label class="form-label">Price Per Night</label>
                                                <input type="number" step="0.01" name="price_per_night" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-2">
                                                <label class="form-label">Phone</label>
                                                <input type="text" name="phone" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-2">
                                                <label class="form-label">Banner Image</label>
                                                <input type="file" name="banner_image" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="latitude" class="form-label">Latitude</label>
                                                <input type="text" id="latitude" name="latitude" class="form-control" placeholder="Enter Latitude" required disabled>
                                                @error('latitude')
                                                <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="longitude" class="form-label">Longitude</label>
                                                <input type="text" id="longitude" name="longitude" class="form-control" placeholder="Enter Longitude" required disabled>
                                                @error('longitude')
                                                <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div id="locationMessage" class="text-success"></div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="mb-2">
                                                <label class="form-label">Description</label>
                                                <textarea name="description" class="form-control">{{ old('description') }}</textarea>
                                                @error('description')
                                                <span class="text-danger">{{ $messsage }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="discount">Discount</label>
                                                <input type="number" class="form-control" name="discount" min="1" id="discount" placeholder="Enter Discount">
                                                @error('discount')
                                                <span class="text-danger">{{ $messsage }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-check py-4">
                                                <label class="form-check-label">
                                                    Is Featured
                                                    <input type="checkbox" class="form-check-input" name="is_featured" id="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }}>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-check py-4">
                                                <label class="form-check-label">
                                                    Is Adverted
                                                    <input type="checkbox" class="form-check-input" name="is_adverted" id="is_adverted" value="1" {{ old('is_adverted') ? 'checked' : '' }}>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="country">Country</label>
                                                <select class="form-control" name="country" id="country">
                                                    <option value="">Select Country</option>
                                                    @foreach($countries as $country)
                                                    <option value="{{ $country->country_name }}">{{ $country->country_name }}</option>
                                                    @endforeach
                                                </select>
                                              </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="state">State</label>
                                                <select class="form-control" name="state" id="state">
                                                    <option value="">Select State</option>
                                                    @foreach($states as $state)
                                                    <option value="{{ $state->name }}">{{ $state->name }}</option>
                                                    @endforeach
                                                </select>
                                              </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="city">City</label>
                                                <select class="form-control" name="city" id="city">
                                                    <option value="">Select City</option>
                                                    @foreach($cities as $city)
                                                    <option value="{{ $city->name }}">{{ $city->name }}</option>
                                                    @endforeach
                                                </select>
                                              </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>

<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    function getLocation() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                function(position) {
                    document.getElementById('latitude').value = position.coords.latitude;
                    document.getElementById('longitude').value = position.coords.longitude;
                    document.getElementById('locationMessage').innerText = "Location captured!";
                    document.getElementById('latitudes').value = position.coords.latitude;
                    document.getElementById('longitudes').value = position.coords.longitude;
                    document.getElementById('locationMessages').innerText = "Location captured!";
                }
                , function(error) {
                    document.getElementById('locationMessage').innerText = "Error: Unable to retrieve location.";
                }
            );
        } else {
            document.getElementById('locationMessage').innerText = "Geolocation is not supported by this browser.";
        }
    }


    document.addEventListener("DOMContentLoaded", function() {
        // Default location: Addis Ababa, Ethiopia
        var defaultLat = 9.03;
        var defaultLng = 38.74;

        var map = L.map('map').setView([defaultLat, defaultLng], 13);

        // Add OpenStreetMap (OSM) tile layer
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

        // Add marker at default location (Addis Ababa)
        var marker = L.marker([defaultLat, defaultLng], {
            draggable: true
        }).addTo(map);

        // Function to update coordinates in input fields
        function updateCoordinates(lat, lng) {
            document.getElementById('latitude').value = lat;
            document.getElementById('longitude').value = lng;
            document.getElementById('latitudes').value = lat;
            document.getElementById('longitudes').value = lng;
            document.getElementById('locationMessage').innerText = `Selected: ${lat}, ${lng}`;
        }

        updateCoordinates(defaultLat, defaultLng);

        // Update coordinates when clicking on the map
        map.on('click', function(e) {
            var lat = e.latlng.lat;
            var lng = e.latlng.lng;
            marker.setLatLng([lat, lng]); // Move marker
            updateCoordinates(lat, lng);
        });

        var mapModal = document.getElementById('createHotelModal');
        mapModal.addEventListener('shown.bs.modal', function() {
            if (!map) {
                initMap(); // Initialize map only once
            } else {
                setTimeout(() => {
                    map.invalidateSize();
                }, 200);
            }
        });


        // Update coordinates when dragging marker
        marker.on('dragend', function(e) {
            var position = marker.getLatLng();
            updateCoordinates(position.lat, position.lng);
        });
    });

</script>
<script>
    $(document).ready(function() {
        $(document).on("click", ".delete-restaurant", function(e) {
            e.preventDefault();
            let form = $(this).closest("form");

            Swal.fire({
                title: "Are you sure?"
                , text: "You won't be able to revert this!"
                , icon: "warning"
                , showCancelButton: true
                , confirmButtonColor: "#d33"
                , cancelButtonColor: "#3085d6"
                , confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit(); // Submit the form after confirmation
                }
            });
        });
    });
</script>

@endsection
