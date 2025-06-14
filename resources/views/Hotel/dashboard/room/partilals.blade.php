<div class="row">
    <div class="col-6">
        <div class="mb-3">
            <div class="form-group">
                <label for="hotel_id">Hotel</label>
                <select class="form-control" name="hotel_id" id="hotel_id" required>
                    @foreach ($hotels as $hotel)
                    <option value="{{ $hotel->id }}">{{ $hotel->name }}</option>
                    @endforeach
                </select>
            </div>
            @error('hotel_id')
            <span class="alert alert-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>
    <div class="col-6">
        <div class="mb-3">
            <div class="form-group">
                <label for="room_type">Room Type</label>
                <select class="form-control" name="room_type" id="room_type" required>
                    <option value="Presidential">Presidential</option>
                    <option value="Sweet">Sweet</option>
                    <option value="Family">Family</option>
                    <option value="Double">Double</option>
                </select>
            </div>
            @error('room_type')
            <span class="alert alert-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>
    <div class="col-md-4">
        <div class="mb-3">
            <label for="total_adult" class="form-label">Maximum Total Adult</label>
            <input type="number"  minlength="1" name="total_adult" class="form-control" required>
            @error('room_number')
            <span class="alert alert-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>
    <div class="col-md-4">
        <div class="mb-3">
            <label for="total_child" class="form-label">Maximum Total Child</label>
            <input type="number" minlength="1" name="total_child" class="form-control" required>
            @error('total_child')
            <span class="alert alert-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>
    <div class="col-md-4">
        <div class="mb-3">
            <label for="total_infant" class="form-label">Maximum Total Infant</label>
            <input type="number"  minlength="1"  name="total_infant" class="form-control" required>
            @error('total_infant')
            <span class="alert alert-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="mb-3">
            <label for="room_number" class="form-label">Room Number</label>
            <input type="number" name="room_number" class="form-control" required>
            @error('room_number')
            <span class="alert alert-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="mb-3">
            <label for="floor" class="form-label">floor</label>
            <input type="number" name="floor" class="form-control" required>
            @error('floor')
            <span class="alert alert-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>
    <div class="col-6">
        <div class="mb-3">
            <label for="capacity" class="form-label">Capacity</label>
            <input type="number" name="capacity" class="form-control" required>
            @error('capacity')
            <span class="alert alert-danger">{{ $message }}</span>
            @enderror
        </div>

    </div>
    <div class="col-6">
        <div class="mb-3">
            <label for="price" class="form-label">Price</label>
            <input type="text" name="price" class="form-control" required>
            @error('price')
            <span class="alert alert-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div class="col-6">
        <div class="mb-3">
            <label for="cover_image" class="form-label">Cover cover_image</label>
            <br>
            <span class="text-danger">height: 1254 px width: 1880 px</span>
            <input type="file" name="cover_image" class="form-control">
            @error('cover_image')
            <span class="alert alert-danger">{{ $message }}</span>
            @enderror

        </div>
    </div>
    <div class="col-md-6">
        <div class="mb-3">
            <label for="images" class="form-label">Upload Mulitiple Images</label>
            <br>
            <span class="text-danger">height: 1254 px width: 1880 px</span>
            <input type="file" name="images[]" class="form-control" multiple>
            @error('images')
            <span class="alert alert-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>
    <div class="col-6">
        <div class="mb-3 form-check">
            <input type="checkbox" name="is_available" class="form-check-input" id="is_available" value="1">
            <label for="is_available" class="form-check-label">Available</label>
            @error('is_available')
            <span class="alert alert-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>
    <div class="col-12">
        <div class="form-group">
            <label for="description" class=" form-label">Description</label>
            <textarea class="form-control" name="description" id="description" rows="3">
            {{ old('description') }}
            </textarea>
        </div>
        @error('description')
        <span class="alert alert-danger">{{ $message }}</span>
        @enderror
    </div>
    <label class="form-label">Amenities</label>
    <div class="row">
        @foreach($amenities as $amenity)
        <div class="col-2">
            <div class="form-check">
                <input type="checkbox" name="amenities[{{ $amenity->id }}]" value="{{ $amenity->id }}" id="amenity_{{ $amenity->id }}" class="form-check-input">
                <label for="amenity_{{ $amenity->id }}" class="form-check-label">
                    {{ $amenity->name }}
                </label>
            </div>
        </div>
        @endforeach
    </div>
</div>

