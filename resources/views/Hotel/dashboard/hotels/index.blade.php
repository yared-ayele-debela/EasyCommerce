<!-- resources/views/amenities/index.blade.php -->
@extends('Hotel.dashboard.layouts')
@section('hotel-dashboard')
<style>
    #map-search-results {
        display: block;
        max-height: 250px;
        overflow-y: auto;
        z-index: 1000;
        position: absolute;
        width: 100%;
    }

    #loading-spinner {
        display: none;
        text-align: center;
        padding: 10px;
    }

    #loading-spinner .spinner-border {
        width: 1.5rem;
        height: 1.5rem;
    }

    #map {
        width: 100%;
        height: 70vh;
        border-radius: 10px;
    }

</style>

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
            @adminCan('add_hotel_hotel')
            <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#createHotelModal">Add Hotel</button>
            @endadminCan
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
                                @adminCan('view_hotel_hotel_photo')

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
                                                            <img src="{{$photo->photo_url }}" class=" img-fluid" alt="Photo">
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
                                @endadminCan
                                @adminCan('add_hotel_hotel_photo')
                                <button class="btn btn-primary mb-3 btn-sm" data-bs-toggle="modal" data-bs-target="#addPhotoModal{{ $hotel->id }}">Add Photo</button>
                                @endadminCan
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
                                                        <br>
                                                        <span class="text-danger">height: 1254 px width: 1880 px</span>
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
                                @adminCan('view_hotel_review')
                                <a href="{{ url('admin/hotel/'.$hotel->id.'/reviews') }}" class="btn btn-sm btn-warning text-white"><i class="bi bi-star-fill"></i></a>
                                @endadminCan
                                @adminCan('edit_hotel_hotel')
                                <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#editHotelModal{{ $hotel->id }}"><i class="bi bi-pencil-square"></i></button>
                                @endadminCan
                                @adminCan('delete_hotel_hotel')
                                <form action="{{ route('hotels.destroy', $hotel->id) }}" method="POST" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-danger delete-restaurant"><i class=" bi bi-trash-fill"></i></button>
                                </form>
                                @endadminCan
                                @adminCan('view_hotel_hotel')

                                <form action="{{ route('my-hotel') }}" method="GET" class="d-inline">
                                    @csrf
                                    <input type="hidden" name="id" id="id" value="{{ $hotel->id }}">
                                    <button class="btn btn-sm btn-secondary text-white"><i class="bi bi-eye-fill"></i> Hotel</button>
                                </form>
                                @endadminCan

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
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            @include('Hotel.dashboard.hotels.partials.map')
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
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
                                                                <input type="text" name="location" class="form-control location" value="{{ $hotel ? $hotel->location : old('location') }}" required>
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
                                                                <br>
                                                                <span class="text-danger">height: 1254 px width: 1880 px</span>
                                                                <input type="file" name="banner_image" class="form-control">
                                                                @if($hotel && $hotel->banner_image)
                                                                <img src="{{ $hotel->banner_image }}" class="mt-2" width="60">
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="mb-3">
                                                                <label for="latitudes" class="form-label">Latitude</label>
                                                                <input type="text" id="latitudes" name="latitude" class="form-control latitude" value="{{ $hotel->latitude }}" placeholder="Enter Latitude" required>
                                                                @error('latitude')
                                                                <small class="text-danger">{{ $message }}</small>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="mb-3">
                                                                <label for="longitudes" class="form-label">Longitude</label>
                                                                <input type="text" id="longitudes" name="longitude" class="form-control longitude" value="{{ $hotel->longitude }}" placeholder="Enter Longitude" required>
                                                                @error('longitude')
                                                                <small class="text-danger">{{ $message }}</small>
                                                                @enderror
                                                            </div>
                                                        </div>


                                                        <div class="col-md-12">
                                                            <div class="mb-2">
                                                                <label class="form-label">Description</label>
                                                                <textarea name="description" class="form-control">{{ $hotel ? $hotel->description : old('description') }}</textarea>
                                                            </div>
                                                        </div>
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

                                        @include('Hotel.dashboard.hotels.partials.map')
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
                                                <input type="text" name="location" id="location" class="form-control location" required>
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
                                                <br>
                                                <span class="text-danger">height: 1254 px width: 1880 px</span>
                                                <input type="file" name="banner_image" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="latitude" class="form-label">Latitude</label>
                                                <input type="text" id="latitude" name="latitude" class="form-control latitude" placeholder="Enter Latitude" required disabled>
                                                @error('latitude')
                                                <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="longitude" class="form-label">Longitude</label>
                                                <input type="text" id="longitude" name="longitude" class="form-control  longitude" placeholder="Enter Longitude" required disabled>
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
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        let initializedMaps = new Set();

        document.querySelectorAll('.modal').forEach(modal => {
            modal.addEventListener('shown.bs.modal', function() {
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
                    iconUrl: 'https://unpkg.com/leaflet@1.9.3/dist/images/marker-icon.png'
                    , iconSize: [25, 41]
                    , iconAnchor: [12, 41]
                    , shadowUrl: 'https://unpkg.com/leaflet@1.9.3/dist/images/marker-shadow.png'
                    , shadowSize: [41, 41]
                });

                let marker;

                map.on('click', async function(e) {
                    const lat = e.latlng.lat;
                    const lng = e.latlng.lng;
                    try {
                        const res = await fetch(`/api/reverse-geocode?lat=${lat}&lon=${lng}`);
                        const data = await res.json();
                        if (data.data ? .length) {
                            const address = data.data[0].name + ", " + data.data[0].City;
                            setLocation(lat, lng, address);
                        }
                    } catch (err) {
                        console.error('Reverse geocoding error:', err);
                    }
                });

                if (searchInput) {
                    searchInput.addEventListener('keyup', async function() {
                        const q = this.value.trim();
                        if (q.length < 3) return;

                        spinner.style.display = 'inline-block';
                        resultsContainer.innerHTML = '';

                        try {
                            const res = await fetch(`/api/forward-geocode?name=${encodeURIComponent(q)}`);
                            const data = await res.json();
                            spinner.style.display = 'none';

                            if (data.data ? .length) {
                                data.data.forEach(loc => {
                                    const item = document.createElement('a');
                                    item.href = "#";
                                    item.className = 'list-group-item list-group-item-action';
                                    item.textContent = `${loc.name}, ${loc.City}`;
                                    item.onclick = () => {
                                        setLocation(loc.latitude, loc.longitude, `${loc.name}, ${loc.City}`);
                                        resultsContainer.innerHTML = '';
                                    };
                                    resultsContainer.appendChild(item);
                                });
                            } else {
                                resultsContainer.innerHTML = '<div class="list-group-item">No results found</div>';
                            }

                        } catch (err) {
                            spinner.style.display = 'none';
                            resultsContainer.innerHTML = '<div class="list-group-item text-danger">Error</div>';
                        }
                    });
                }

                function setLocation(lat, lng, address) {
                    if (marker) map.removeLayer(marker);
                    marker = L.marker([lat, lng], {
                        icon
                    }).addTo(map).bindPopup(address).openPopup();
                    map.setView([lat, lng], 15);

                    selectedText.textContent = address;
                    latField.value = lat;
                    lngField.value = lng;
                    latitude.value = lat;
                    longtidue.value = lng;
                    location.value = address;
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
<script>
    function getLocation() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                function(position) {
                    document.getElementById('latitude').value = position.coords.latitude;
                    document.getElementById('longitude').value = position.coords.longitude;
                    document.getElementById('latitudes').value = position.coords.latitude;
                    document.getElementById('longitudes').value = position.coords.longitude;
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

</script>
@endsection

