<!-- resources/views/amenities/index.blade.php -->
@extends('Hotel.dashboard.layouts')
@section('hotel-dashboard')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
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
            <li class="breadcrumb-item active" aria-current="page">Rooms</li>
        </ol>
    </nav>
    <div class="card">
        <div class="card-header">

            <h4 class="mb-4">Room Management</h4>
            @adminCan('add_hotel_room')

            <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addRoomModal">Add Room</button>
            @endadminCan
            @session('success')
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
            </div>
            @endsession
        </div>
        <div class="card-body">

            <!-- Room List Table -->
            <table class="table ">
                <thead>
                    <tr>
                        <th>Room Type</th>
                        <th>Total Adult</th>
                        <th>Total Child</th>
                        <th>Total Infant</th>
                        <th>Room Number</th>
                        <th>Floor</th>
                        <th>Capacity</th>
                        <th>Price</th>
                        <th>Available</th>
                        <th>Amenities</th>
                        <th>Cover Image</th>
                        <th>Images</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($rooms as $room)
                    <tr>
                        <td>{{ $room->room_type }}</td>
                        <td>{{ $room->total_adult }}</td>
                        <td>{{ $room->total_child }}</td>
                        <td>{{ $room->total_infant }}</td>
                        <td>{{ $room->room_number }}</td>
                        <td>{{ $room->floor }}</td>
                        <td>{{ $room->capacity }}</td>
                        <td>{{ $room->price }}</td>
                        <td>
                            <div class="btn btn-sm btn-{{ $room->is_available ? 'success' : 'danger' }}">
                                {{ $room->is_available ? 'Yes' : 'No' }}
                            </div>
                        </td>
                        <td>
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#Amenities{{ $room->id }}">
                                view Amenities
                            </button>

                            <div class="modal fade" id="Amenities{{ $room->id }}" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Amenities</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            @foreach ($room->amenities as $key => $am)

                                            <a href="javascript:void(0);" class="mb-1 rounded rounded-3 btn-outline-primary list-inline-item">
                                                @php $icon = optional($am)->icon; @endphp
                                                @if($icon && Storage::exists('public/' . $icon))
                                                <img src="{{ asset('storage/' . $icon) }}" alt="{{ $am->name }}" width="24" height="24">
                                                @else
                                                <img src="{{ asset('restaurant_frontend/default-image.png') }}" alt="{{ $am->name }}" width="24" height="24">
                                                @endif
                                                <small>{{ $am->name }}</small>
                                            </a>
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
                            @if($room->image)
                            <img src="{{ asset('storage/' . $room->image) }}" loading="lazy" width="50" height="50">
                            @endif
                        </td>
                        <td>
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#imageGallery{{ $room->id }}">
                                View images
                            </button>

                            <!-- Modal -->
                            <div class="modal fade" id="imageGallery{{ $room->id }}" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Images Gallery</h5>
                                            <button type="button" class="close btn" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            @foreach($room->images as $img)
                                            <img src="{{ asset('storage/' . $img->photo_url) }}" loading="lazy" width="50" height="50" class="mb-2">
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
                            @adminCan('edit_hotel_room')

                            <button class="btn btn-sm btn-warning edit-btn" data-id="{{ $room->id }}" data-room_type="{{ $room->room_type }}" data-capacity="{{ $room->capacity }}" data-price="{{ $room->price }}" data-is_available="{{ $room->is_available }}" data-hotel_id="{{ $room->hotel_id }}" data-bs-toggle="modal" data-bs-target="#editRoomModal{{ $room->id }}"><i class="bi bi-pencil-square"></i>
                            </button>
                            <!-- Edit Room Modal -->
                            <div class="modal fade" id="editRoomModal{{ $room->id }}" tabindex="-1">
                                <div class="modal-dialog modal-lg modal-scrollbar-measure">
                                    <form method="POST" enctype="multipart/form-data" action="{{ route('rooms.update',$room->id) }}" class="modal-content">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-header">
                                            <h5 class="modal-title">Edit Room</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-md-6">
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
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <div class="form-group">
                                                            <label for="room_type">Room Type</label>
                                                            <select class="form-control" name="room_type" id="room_type" required>
                                                                @foreach ($room_types as $room_t)
                                                                <option @if($room->room_type===$room_t->name) selected @endif value="{{ $room_t->name }}">{{ $room_t->name }}</option>
                                                                @endforeach
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
                                                        <input type="number" value="{{ $room->total_adult }}" minlength="1" name="total_adult" class="form-control" required>
                                                        @error('room_number')
                                                        <span class="alert alert-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="mb-3">
                                                        <label for="total_child" class="form-label">Maximum Total Child</label>
                                                        <input type="number" value="{{ $room->total_child }}" minlength="1" name="total_child" class="form-control" required>
                                                        @error('total_child')
                                                        <span class="alert alert-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="mb-3">
                                                        <label for="total_infant" class="form-label">Maximum Total Infant</label>
                                                        <input type="number" value="{{ $room->total_infant }}" minlength="1" name="total_infant" class="form-control" required>
                                                        @error('total_infant')
                                                        <span class="alert alert-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="room_number" class="form-label">Room Number</label>
                                                        <input type="number" value="{{ $room->room_number }}" name="room_number" class="form-control" required>
                                                        @error('room_number')
                                                        <span class="alert alert-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="floor" class="form-label">floor</label>
                                                        <input type="number" value="{{ $room->floor }}" name="floor" class="form-control" required>
                                                        @error('floor')
                                                        <span class="alert alert-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="capacity" class="form-label">Capacity</label>
                                                        <input type="number" value="{{ $room->capacity }}" name="capacity" class="form-control" required>
                                                        @error('capacity')
                                                        <span class="alert alert-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="price" class="form-label">Price</label>
                                                        <input type="text" value="{{ $room->price }}" name="price" class="form-control" required>
                                                        @error('price')
                                                        <span class="alert alert-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="cover_image" class="form-label">Cover cover_image</label>
                                                        <br>
                                                        <span class="text-danger">height: 1254 px width: 1880 px</span>
                                                        <input type="file" name="cover_image" class="form-control">
                                                        @error('cover_image')
                                                        <span class="alert alert-danger">{{ $message }}</span>
                                                        @enderror
                                                        @if($room->image)
                                                        <img src="{{ asset('storage/' . $room->image) }}" width="50" height="50">
                                                        @endif
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
                                                        @if($room->images)
                                                        @foreach($room->images as $img)
                                                        <img src="{{ asset('storage/' . $img->photo_url) }}" width="50" height="50">
                                                        @endforeach
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3 form-check">
                                                        <input type="checkbox" name="is_available" class="form-check-input" @if($room->is_available=="1") checked @endif id="is_available" value="1">
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
                                                        {{ $room->description? $room->description : old('description') }}
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
                                                            <input type="checkbox" name="amenities[]" value="{{ $amenity->id }}" id="amenity_{{ $amenity->id }}" class="form-check-input" {{ in_array($amenity->id, $room->amenities->pluck('id')->toArray()) ? 'checked' : '' }}>
                                                            <label for="amenity_{{ $amenity->id }}" class="form-check-label">
                                                                {{ $amenity->name }}
                                                            </label>
                                                        </div>
                                                    </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button class="btn btn-success" type="submit">Update Room</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            @endadminCan

                            @adminCan('delete_hotel_room')

                            <form action="{{ route('rooms.destroy', $room->id) }}" method="POST" style="display:inline;">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-danger delete-restaurant"><i class="bi bi-trash-fill"></i></button>
                            </form>
                            @endadminCan
                            <!-- Button trigger modal -->
                       <button type="button" class="btn btn-sm btn-primary mt-1"
        data-bs-toggle="modal"
        data-bs-target="#reservationModal{{ $room->id }}">
    Create Reservation
</button>


                            <!-- Reservation Modal -->
                            <div class="modal fade" id="reservationModal{{ $room->id }}" tabindex="0" aria-labelledby="reservationModalLabel{{ $room->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <form action="{{ route('reservations.store') }}" method="POST">
                                        @csrf
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="reservationModalLabel{{ $room->id }}">Create Reservation</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body row">
                                                <div class="col-md-6 mb-3">
                                                    <div class="mb-3">
                                                        <label for="user_id_{{ $room->id }}" class="form-label">Select Customer</label>
                    <select name="user_id" id="user_id_{{ $room->id }}" class="form-select select-delivery-zone" data-modal="#reservationModal{{ $room->id }}">
                                                            @foreach ($users as $user)
                                                            <option value="{{ $user->id }}">{{ $user->name }} | Address : {{ $user->address }} | {{ $user->mobile }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                </div>

                <input type="hidden" name="room_id" id="room_id_{{ $room->id }}" value="{{ $room->id }}">
                                                  <div class="mb-3">
                        <label>Check In</label>
                        <input type="text" name="check_in_date" class="form-control" id="check_in_date_{{ $room->id }}">
                    </div>
                    <div class="mb-3">
                        <label>Check Out</label>
                        <input type="text" name="check_out_date" class="form-control" id="check_out_date_{{ $room->id }}">
                    </div>
                    <div class="mb-3">
                        <label>Total Night</label>
                        <input type="text" name="total_night" class="form-control" id="total_night_{{ $room->id }}" readonly>
                    </div>
                                                <div class="col-md-4 mb-3">
                                                    <label>Total Adult</label>
                                                    <input type="number" name="total_adult" value="1" min="0" class="form-control">
                                                </div>
                                                <div class="col-md-4 mb-3">
                                                    <label>Total Child</label>
                                                    <input type="number" name="total_child" value="0" min="0" class="form-control">
                                                </div>
                                                <div class="col-md-4 mb-3">
                                                    <label>Total Infant</label>
                                                    <input type="number" name="total_infant" value="0" min="0" class="form-control">
                                                </div>

                                                <div class="col-md-6 mb-3">
                                                    <label>Status</label>
                                                    <select name="status" class="form-select">
                                                        <option value="Confirmed">Confirmed</option>
                                                        <option value="Pending">Pending</option>
                                                        <option value="Cancelled">Cancelled</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label>Payment Status</label>
                                                    <select name="payment_status" class="form-select">
                                                        <option value="Pending">Pending</option>
                                                        <option value="paid">Paid</option>
                                                        <option value="unpaid">Unpaid</option>
                                                    </select>
                                                </div>


                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-success">Create</button>
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <div>
                {{ $rooms->links() }}
            </div>
        </div>
    </div>
</div>
</div>

<!-- Add Room Modal -->
<div class="modal fade" id="addRoomModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-scrollbar-measure">
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
    document.addEventListener('DOMContentLoaded', function () {
    const modals = document.querySelectorAll('[id^="reservationModal"]');

    modals.forEach(modal => {
        modal.addEventListener('shown.bs.modal', function () {
            const roomId = modal.getAttribute('id').replace('reservationModal', '');

            const checkInInput = modal.querySelector(`#check_in_date_${roomId}`);
            const checkOutInput = modal.querySelector(`#check_out_date_${roomId}`);
            const totalNightInput = modal.querySelector(`#total_night_${roomId}`);
            const roomIdInput = modal.querySelector(`#room_id_${roomId}`);

            if (!checkInInput || !checkOutInput || !totalNightInput || !roomIdInput) {
                console.warn("Missing inputs for room:", roomId);
                return;
            }

            // Fetch reserved dates for this room
            fetch(`/admin/hotel/rooms/${roomId}/reserved-dates`)
                .then(res => res.json())
                .then(disabledDates => {
                    let checkOutPicker;

                    flatpickr(checkInInput, {
                        dateFormat: 'Y-m-d',
                        disable: disabledDates,
                        minDate: 'today',
                        onChange: function (selectedDates, selectedDateStr) {
                            if (checkOutPicker) {
                                checkOutPicker.destroy();
                                checkOutInput.value = '';
                                totalNightInput.value = '';
                            }

                            if (!selectedDateStr) return;

                            checkOutPicker = flatpickr(checkOutInput, {
                                dateFormat: 'Y-m-d',
                                disable: disabledDates,
                                minDate: selectedDateStr,
                                onChange: function (selectedOutDates, selectedOutDateStr) {
                                    const start = new Date(selectedDateStr);
                                    const end = new Date(selectedOutDateStr);
                                    const nights = Math.floor((end - start) / (1000 * 60 * 60 * 24));
                                    totalNightInput.value = nights;
                                }
                            });
                        }
                    });
                });
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
@endsection
