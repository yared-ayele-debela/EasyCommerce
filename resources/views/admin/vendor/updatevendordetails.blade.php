@extends('admindashboard.maindashboard')
@section('dashboard')
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

</style>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<style>
    #map { height: 400px; width: 100%; margin-bottom: 20px; }
</style>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"></script>
{{-- <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" /> --}}
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
            <li class="breadcrumb-item active" aria-current="page">Update detail information</li>
        </ol>
    </nav>
    <h1 class="card-title">Welcome <span style="font-size: 20px; color:rgb(44, 10, 144)"> {{ Auth::guard('admin')->user()->name }}</span></h1>

    <div class="card">
        <div class="card-header">
           <h5 class="text-dark"> Update Vendor Details</h5>
        </div>
        <div class="card-body ">
            <form id="loginForm" action="{{ url('admin/update_vendor_details') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-6">
                        <div class="row">
<div class="col-md-4 pt-3">
                    <label for="vendor_email" class="form-label">Email</label>
                    <input type="text" class="form-control " readonly value="{{  $vendorDetails['email'] }}" name="vendor_email" required>
                    @error('vendor_email')
                    <small class=" text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="col-md-4 pt-3">
                    <label for="vendor_name" class="form-label">Name</label>
                    <input type="text" class="form-control" value="{{  $vendorDetails['name'] }}" id="name" name="vendor_name" pattern="[A-Za-z\s]+" title="Only letters and spaces are allowed" required>
                    @error('vendor_name')
                    <small class=" text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="col-md-4 pt-3">
                    <label for="vendor_address" class="form-label">Address</label>
                    <input type="text" class="form-control" value="{{  $vendorDetails['address'] }}" id="address" name="vendor_address" required>
                    @error('vendor_address')
                    <small class=" text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="col-md-4 pt-3">
                    <div class="form-group">
                      <label for="zone">Delivery zone</label>
                      <select class="form-control select-delivery-zone" name="zone"  id="zone" required>
                        <option value="" selected disabled>Select delivery zone</option>
                        @foreach ($zones as $zoon)
                        <option value="{{ $zoon->name }}" @if($zoon->name==$vendorDetails['zone']) selected @endif>{{ $zoon->name }}</option>
                        @endforeach
                      </select>
                    </div>
                </div>
                <div class="col-md-4 pt-3">
                    <label for="vendor_city" class="form-label">City</label>
                    <input type="text" class="form-control" value="{{  $vendorDetails['city'] }}" id="city" name="vendor_city" required>
                    @error('vendor_city')
                    <small class=" text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="col-md-4 pt-3">
                    <label for="vendor_state" class="form-label">State</label>
                    <input type="text" class="form-control" value="{{  $vendorDetails['state'] }}" id="state" name="vendor_state" required>
                    @error('vendor_state')
                    <small class=" text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="col-md-4 pt-3">
                    <label for="vendor_country" class="form-label">Country</label>
                    <select class="form-select" id="vendor_country" id="country" name="vendor_country">
                        <option value="">Select country</option>
                        @foreach ($country as $country)
                        <option value="{{ $country['country_name'] }}" @if($country['country_name']==$vendorDetails['country']) selected @endif>{{ $country['country_name'] }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4 pt-3">
                    <label for="vendor_pincode" class="form-label">Pincode</label>
                    <input type="text" class="form-control" id="pincode" value="{{  $vendorDetails['pincode'] }}" name="vendor_pincode" required>
                    @error('vendor_pincode')
                    <small class=" text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="col-md-4 pt-3">
                    <label for="vendor_mobile" class="form-label">Mobile</label>
                    <input type="text" class="form-control" id="mobile" value="{{  $vendorDetails['mobile'] }}" name="vendor_mobile" pattern=".{10,}" title="Enter vaid phone number">
                    @error('vendor_mobile')
                    <small class=" text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="col-md-4 pt-3">
                    <label for="vendor_image" class="form-label">Image</label>
                    <input type="file" class="form-control" placeholder="" name="vendor_image">
                    @error('vendor_image')
                    <small class=" text-danger">{{ $message }}</small>
                    @enderror
                    @if(!empty(Auth::guard('admin')->user()->image))
                    <img src="{{ asset('storage/' . Auth::guard('admin')->user()->image) }}" style="width: 40px; height:40px;" class="" alt="">
                    @endif
                </div>
                 <div class="col-md-6 mb-2">
                                <label for="latitude" class="form-label">Latitude:</label>
                                <input type="text" id="latitude" class="form-control" name="latitude" value="{{ $vendorDetails['latitude']??'' }}" readonly>
                                </div>

                                <div class="col-md-6 mb-2">
                                    <label for="longitude" class="form-label">Longitude:</label>
                                   <input type="text" id="longitude" class="form-control" name="longitude" value="{{ $vendorDetails['longitude']??'' }}" readonly>
                                </div>
                        </div>
                        @if(empty($vendorDetails['latitude'] && $vendorDetails['longitude']))
                        <div class="col-md-12 pt-3">
                            <div class="alert alert-warning" role="alert">
                                <strong>Note:</strong> Please select your location on the map below to update latitude and longitude.
                            </div>
                            <p class="text-muted">Click on the map to select your location. The latitude and longitude will be automatically filled in the fields above.</p>
                        </div>
                        @endif
                    </div>

                    <div class="col-md-6">
                         <div class="form-group mb-2">
                            <label for="search-address" class=" form-label">Search Address</label>
                            <input type="text" id="search-address" class="form-control" placeholder="e.g. Kezira">
                            <div id="loading-spinner">
                                <div class="spinner-border text-primary" role="status"></div>
                            </div>
                            <div id="map-search-results" class="list-group mt-1 bg-white shadow-sm rounded"></div>
                        </div>
                        <div class="mb-3">
                            <button type="button" class="btn btn-outline-primary mb-3" id="getLocationBtn"> <i class="bi bi-map-fill"></i> Get My Current Location</button>
                        </div>
                        <div class="mb-3">
                            <div id="locationMessage" style="margin-top: 10px; font-weight: bold;"></div>
                            <div id="map"></div>
                        </div>
                          <input type="hidden" name="delivery_lat" id="delivery-lat">
                        <input type="hidden" name="delivery_lng" id="delivery-lng">
                        <input type="hidden" name="delivery_address" id="delivery-address">

                        <div class="form-group mt-3">
                            <label class="form-label">Selected Address:</label>
                            <p id="selected-address-text" class="fw-semibold text-success"></p>
                        </div>
                    </div>
                </div>
                <hr>

                <div class="form-group pt-3">
                    <input type="submit" class=" btn lightblue btn-primary pt-2 pb-2 shadow" value="Update Vendor Details">
                </div>
            </form>
        </div>
    </div>
</section>
<script>
    document.addEventListener('DOMContentLoaded', () => {

        let map = L.map('map').setView([9.6040976, 41.8207994], 13);
        let marker;

        // Set tile layer
        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);

        const highlightIcon = L.icon({
            iconUrl: 'https://unpkg.com/leaflet@1.9.3/dist/images/marker-icon.png',
            iconSize: [25, 41],
            iconAnchor: [12, 41],
            popupAnchor: [1, -34],
            shadowUrl: 'https://unpkg.com/leaflet@1.9.3/dist/images/marker-shadow.png',
            shadowSize: [41, 41]
        });

        // Reverse geocoding on map click
        map.on('click', async function(e) {
            const lat = e.latlng.lat;
            const lon = e.latlng.lng;

            try {
                const res = await fetch(`/api/reverse-geocode?lat=${lat}&lon=${lon}`);
                const data = await res.json();

                if (data.data && data.data.length > 0) {
                    const location = data.data[0];
                    const address = location.name + ", " + location.City;
                    setLocationOnMap(lat, lon, address);
                }
            } catch (err) {
                console.error('Reverse geocode error:', err);
            }
        });

        // Forward geocoding via search
        document.getElementById('search-address').addEventListener('keyup', async function () {
    const searchText = this.value.trim();
    if (searchText.length < 3) return;

    const container = document.getElementById('map-search-results');
    const spinner = document.getElementById('loading-spinner');

    container.innerHTML = '';
    spinner.style.display = 'block';

    try {
        const bounds = '41.766,9.550,41.920,9.640'; // minLng,minLat,maxLng,maxLat
        const apiKey = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJjb21wYW55bmFtZSI6IkVhc3kgZS1jb21tZXJjZSBob3RlbCBib29raW5nIGFuZCBkZWxpdmVyeSIsImRlc2NyaXB0aW9uIjoiMGU4ZDhhZDMtZmJhYy00OTJkLWE4OWYtZGFiZjQxNTFlNDc2IiwiaWQiOiI3OWY1ODRlYy0yZDA3LTRjNWQtYTI2Ny00MjBhNzVlMDY2NzMiLCJ1c2VybmFtZSI6ImJlZmk3NzU2In0.JgSoBiAoa4Te6ccg-jSJSifq26PZV4FnGbkhQKiTnuo'; // if you have one, insert it here

        const res = await fetch(`https://mapapi.gebeta.app/api/v1/route/geocoding?name=${encodeURIComponent(searchText)}&apiKey=${apiKey}&bounds=${bounds}`);
        const results = await res.json();

        spinner.style.display = 'none';

        if (results.data && results.data.length > 0) {
            results.data.forEach(loc => {
                const item = document.createElement('a');
                item.href = "javascript:void(0)";
                item.classList.add('list-group-item', 'list-group-item-action');
                item.textContent = loc.name + (loc.City ? `, ${loc.City}` : '');

                item.addEventListener('click', () => {
                    const lat = loc.latitude;
                    const lng = loc.longitude;
                    const address = loc.name + (loc.City ? `, ${loc.City}` : '');

                    setLocationOnMap(lat, lng, address);
                    container.innerHTML = '';
                    document.getElementById('search-address').value = address;
                });
                container.appendChild(item);
            });
        } else {
            container.innerHTML = '<div class="list-group-item text-muted">No results found</div>';
        }

    } catch (err) {
        console.error('Forward geocode error:', err);
        container.innerHTML = '<div class="list-group-item text-danger">Error fetching results</div>';
    } finally {
        spinner.style.display = 'none';
    }
});


        function setLocationOnMap(lat, lng, address) {
            map.setView([lat, lng], 15);
            if (marker) map.removeLayer(marker);
            marker = L.marker([lat, lng], {
                icon: highlightIcon
            }).addTo(map)
                .bindPopup(`<strong>${address}</strong>`)
                .openPopup();
            document.getElementById('selected-address-text').innerText = address;
            document.getElementById('delivery-address').value = address;
            document.getElementById('delivery-lat').value = lat;
            document.getElementById('delivery-lng').value = lng;
            document.getElementById('latitude').value = lat;
            document.getElementById('longitude').value = lng;
            document.getElementById('address').value=address;
        }

        document.addEventListener('shown.bs.modal', function (event) {
            if (event.target.id === 'addressModal') {
                setTimeout(() => {
                    map.invalidateSize();
                }, 300); // Delay ensures modal animation completes
            }
        });
    });
</script>

<script>
    document.getElementById('getLocationBtn').addEventListener('click', function () {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function (position) {
                document.getElementById('latitude').value = position.coords.latitude;
                document.getElementById('longitude').value = position.coords.longitude;
            }, function (error) {
            });
        } else {
        }
    });
</script>
@endsection

