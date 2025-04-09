<!-- resources/views/amenities/index.blade.php -->
@extends('Hotel.dashboard.layouts')
@section('hotel-dashboard')

<div class="pagetitle shadow-sm">
    <nav class=" p-2 text-center">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.html">Home</a></li>
            <li class="breadcrumb-item active">Hotels</li>
        </ol>
    </nav>
</div>
<div class="container">
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
                            
                            <td>{{ $hotel->location }}</td>
                            <td>
                                @if($hotel->banner_image)
                                <img src="{{ asset('storage/'.$hotel->banner_image) }}" width="40">
                                @endif
                            </td>
                            <td>
                                <button class="btn btn-primary mb-3 btn-sm" data-bs-toggle="modal" data-bs-target="#addPhotoModal{{ $hotel->id }}">Add Photo</button>
                                @foreach($hotel->photos as $photo)
                                <div class="col-md-3">
                                    <div class="card mb-3">
                                        <img src="{{ asset('storage/' . $photo->photo_url) }}" width="40" class="" alt="Photo">
                                        <div class="card-body p-2">
                                            <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal_{{ $photo->id }}">
                                                x
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <!-- Delete Modal -->
                                <div class="modal fade" id="deleteModal_{{ $photo->id }}" tabindex="-1" aria-labelledby="deleteModalLabel_{{ $photo->id }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <form action="{{ route('hotel_photos.destroy', $photo->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')

                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Confirm Deletion</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    Are you sure you want to delete this photo?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-danger">Yes, Delete</button>
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                @endforeach
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
                                <form method="POST" action="{{ route('hotels.update', $hotel->id) }}" enctype="multipart/form-data" class="modal-content">
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
                                                    <img src="{{ asset('storage/'.$hotel->banner_image) }}" class="mt-2" width="60">
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="mb-3">
                                                    <label for="latitudes" class="form-label">Latitude</label>
                                                    <input type="text" id="latitudes" name="latitude" class="form-control" placeholder="Enter Latitude" required>
                                                    @error('latitude')
                                                    <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="mb-3">
                                                    <label for="longitudes" class="form-label">Longitude</label>
                                                    <input type="text" id="longitudes" name="longitude" class="form-control" placeholder="Enter Longitude" required>
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
                                                <div id="locationMessage" class="text-success"></div>
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
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="location" class="form-label">Location</label>
                                                <br>
                                                <button type="button" onclick="getLocation()" class="btn btn-secondary">Use My Location</button>
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
                }
                , function(error) {
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
                }
                , function(error) {
                    document.getElementById('locationMessages').innerText = "Error: Unable to retrieve location.";
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
            document.getElementById('locationMessage').innerText = `Selected: ${lat}, ${lng}`;
        }

        // Set default coordinates
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
