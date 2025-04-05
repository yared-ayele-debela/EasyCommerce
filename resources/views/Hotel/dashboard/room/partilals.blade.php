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

<div class="mb-3">
    <label for="capacity" class="form-label">Capacity</label>
    <input type="number" name="capacity" class="form-control" required>
    @error('capacity')
    <span class="alert alert-danger">{{ $message }}</span>
@enderror
</div>

<div class="mb-3">
    <label for="price" class="form-label">Price</label>
    <input type="text" name="price" class="form-control" required>
    @error('price')
    <span class="alert alert-danger">{{ $message }}</span>
@enderror
</div>

<div class="mb-3 form-check">
    <input type="checkbox" name="is_available" class="form-check-input" id="is_available" value="1">
    <label for="is_available" class="form-check-label">Available</label>
    @error('is_available')
    <span class="alert alert-danger">{{ $message }}</span>
@enderror
</div>

<div class="mb-3">
    <label for="images" class="form-label">Upload Mulitiple Images</label>
    <input type="file" name="images[]" class="form-control" multiple>
    @error('images')
    <span class="alert alert-danger">{{ $message }}</span>
    @enderror
</div>
