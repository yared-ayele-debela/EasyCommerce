@php
$edit = isset($hotel);
@endphp

<div class="row">
    <div class="col-md-6">
        <div class="mb-2">
            <label class="form-label">Name</label>
            <input type="text" name="name" class="form-control" value="{{ $edit ? $hotel->name : old('name') }}" required>
        </div>

    </div>
    <div class="col-md-6">
        <div class="mb-2">
            <label class="form-label">Category</label>
            <select name="category_id" class="form-select">
                <option value="">-- Select Category --</option>
                @foreach($categories as $category)
                <option value="{{ $category->id }}" {{ $edit && $hotel->category_id == $category->id ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="col-md-6">
        <div class="mb-2">
            <label class="form-label">Location</label>
            <input type="text" name="location" class="form-control" value="{{ $edit ? $hotel->location : old('location') }}" required>
        </div>
    </div>
    <div class="col-md-6">
        <div class="mb-2">
            <label class="form-label">Price Per Night</label>
            <input type="number" step="0.01" name="price_per_night" class="form-control" value="{{ $edit ? $hotel->price_per_night : old('price_per_night') }}" required>
        </div>
    </div>
    <div class="col-md-6">
        <div class="mb-2">
            <label class="form-label">Phone</label>
            <input type="text" name="phone" class="form-control" value="{{ $edit ? $hotel->phone : old('phone') }}">
        </div>
    </div>
    <div class="col-md-6">
        <div class="mb-2">
            <label class="form-label">Banner Image</label>
            <input type="file" name="banner_image" class="form-control">
            @if($edit && $hotel->banner_image)
            <img src="{{ asset('storage/'.$hotel->banner_image) }}" class="mt-2" width="60">
            @endif
        </div>
    </div>
    <div class="col-md-4">
        <div class="mb-3">
            <label for="latitude" class="form-label">Latitude</label>
            <input type="text" id="latitude" name="latitude" class="form-control" placeholder="Enter Latitude" required>
            @error('latitude')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
    </div>
    <div class="col-md-4">
        <div class="mb-3">
            <label for="longitude" class="form-label">Longitude</label>
            <input type="text" id="longitude" name="longitude" class="form-control" placeholder="Enter Longitude" required>
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
            <textarea name="description" class="form-control">{{ $edit ? $hotel->description : old('description') }}</textarea>
        </div>
    </div>
    <div class="col-md-12">

        <div class="mb-2 ">
            @php
            $selectedAmenities = [];

            if (isset($hotel)) {
            $selectedAmenities = is_string($hotel->amenities)
            ? json_decode($hotel->amenities, true)
            : $hotel->amenities;
            }
            @endphp

            <label class="form-label">Amenities</label>
            <div class="row">
                @foreach($amenities as $amenity)
                <div class="col-2">
                    <div class="form-check">
                        <input type="checkbox" name="amenities[{{ $amenity->id }}]" id="amenity_{{ $amenity->id }}" class="form-check-input" {{ in_array($amenity->name, $selectedAmenities) ? 'checked' : '' }}>
                        <label for="amenity_{{ $amenity->id }}" class="form-check-label">
                            {{ $amenity->name }}
                        </label>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

