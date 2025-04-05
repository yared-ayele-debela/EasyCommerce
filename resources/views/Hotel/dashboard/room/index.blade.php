<!-- resources/views/amenities/index.blade.php -->
@extends('Hotel.dashboard.layouts')
@section('hotel-dashboard')
<div class="pagetitle shadow-sm">
    <nav class=" p-2 text-center">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.html">Home</a></li>
            <li class="breadcrumb-item active">Reservations</li>
        </ol>
    </nav>
</div>
<div class="container">
    <div class="card">
        <div class="card-header">
            @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            <h4 class="mb-4">Room Management</h4>
            <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addRoomModal">Add Room</button>
        </div>
        <div class="card-body">
           
            <!-- Room List Table -->
            <table class="table ">
                <thead>
                    <tr>
                        <th>Room Type</th>
                        <th>Capacity</th>
                        <th>Price</th>
                        <th>Available</th>
                        <th>Images</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($rooms as $room)
                        <tr>
                            <td>{{ $room->room_type }}</td>
                            <td>{{ $room->capacity }}</td>
                            <td>{{ $room->price }}</td>
                            <td>{{ $room->is_available ? 'Yes' : 'No' }}</td>
                            <td>
                                @foreach($room->images as $img)
                                    <img src="{{ asset('storage/'.$img->image_path) }}" width="50" height="50">
                                @endforeach
                            </td>
                            <td>
                                <button class="btn btn-sm btn-warning edit-btn"
                                    data-id="{{ $room->id }}"
                                    data-room_type="{{ $room->room_type }}"
                                    data-capacity="{{ $room->capacity }}"
                                    data-price="{{ $room->price }}"
                                    data-is_available="{{ $room->is_available }}"
                                    data-hotel_id="{{ $room->hotel_id }}"
                                    data-bs-toggle="modal" data-bs-target="#editRoomModal{{ $room->id }}"><i class="bi bi-pencil-square"></i>
                                </button>
                                <!-- Edit Room Modal -->
                                <div class="modal fade" id="editRoomModal{{ $room->id }}" tabindex="-1">
                                    <div class="modal-dialog">
                                        <form method="POST" enctype="multipart/form-data" action="{{ route('rooms.update',$room->id) }}" class="modal-content">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-header">
                                                <h5 class="modal-title">Edit Room</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <div class="form-group">
                                                      <label for="hotel_id">Hotel</label>
                                                      <select class="form-control" name="hotel_id" id="hotel_id" required>
                                                        @foreach ($hotels as $hotel)
                                                        <option @if($room->hotel_id===$hotel->id) selected @endif value="{{ $hotel->id }}">{{ $hotel->name }}</option>          
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
                                                          <option @if($room->room_type==="Presidential") selected @endif  value="Presidential">Presidential</option>          
                                                          <option @if($room->room_type==="Sweet") selected @endif  value="Sweet">Sweet</option>          
                                                          <option @if($room->room_type==="Family") selected @endif  value="Family">Family</option>          
                                                          <option @if($room->room_type==="Double") selected @endif  value="Double">Double</option>          
                                                        </select>
                                                      </div>
                                                      @error('room_type')
                                                      <span class="alert alert-danger">{{ $message }}</span>
                                                  @enderror
                                                </div>
                                                
                                                <div class="mb-3">
                                                    <label for="capacity" class="form-label">Capacity</label>
                                                    <input type="number" value="{{ $room->capacity }}" name="capacity" class="form-control" required>
                                                    @error('capacity')
                                                    <span class="alert alert-danger">{{ $message }}</span>
                                                @enderror
                                                </div>
                                                
                                                <div class="mb-3">
                                                    <label for="price" class="form-label">Price</label>
                                                    <input type="text" value="{{ $room->price }}" name="price" class="form-control" required>
                                                    @error('price')
                                                    <span class="alert alert-danger">{{ $message }}</span>
                                                @enderror
                                                </div>
                                                
                                                <div class="mb-3 form-check">
                                                    <input type="checkbox" name="is_available" class="form-check-input" @if($room->is_available=="1") checked @endif id="is_available" value="1">
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
                                                    @if($room->images)
                                                        @foreach($room->images as $img)
                                                            <img src="{{ asset('storage/'.$img->image_path) }}" width="50" height="50">
                                                        @endforeach
                                                    @endif
                                                </div>
                                                
                                            </div>
                                            <div class="modal-footer">
                                                <button class="btn btn-success" type="submit">Update Room</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
        
                                <form action="{{ route('rooms.destroy', $room->id) }}" method="POST" style="display:inline;">
                                    @csrf @method('DELETE')
                                    <button  class="btn btn-sm btn-danger delete-restaurant"><i class="bi bi-trash-fill"></i></button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        </div>
    </div>
</div>

<!-- Add Room Modal -->
<div class="modal fade" id="addRoomModal" tabindex="-1">
    <div class="modal-dialog">
        <form action="{{ route('rooms.store') }}" method="POST" enctype="multipart/form-data" class="modal-content">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title">Add Room</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                @include('Hotel.dashboard.room.partilals')
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" type="submit">Save Room</button>
            </div>
        </form>
    </div>
</div>



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
