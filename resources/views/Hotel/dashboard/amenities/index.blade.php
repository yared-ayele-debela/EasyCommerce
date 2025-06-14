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
            <li class="breadcrumb-item active" aria-current="page">Amenities</li>
        </ol>
    </nav>
    <div class="card">
        <div class="card-header">
            <h4 class="mb-4">Amenities</h4>
            @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @adminCan('add_hotel_amenity')
            <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addAmenityModal">Add Amenity</button>
            @endadminCan
        </div>
        <div class="card-body">
            <!-- Amenities Table -->
            <div class="table-responsive">
                <table class="table ">
                    <thead>
                        <tr>
                            <th>Icon</th>
                            <th>Name</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($amenities as $amenity)
                        <tr>
                            <td>
                                @if($amenity->icon)
                                <img src="{{ $amenity->icon }}" width="40" height="40" alt="icon">
                                @else
                                <img src="{{ asset('restaurant_frontend/default-image.png') }}" width="40" height="40" alt="">
                                @endif
                            </td>
                            <td>{{ $amenity->name }}</td>
                            <td>
                                <!-- Edit -->
                                @adminCan('edit_hotel_amenity')
                                <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#editAmenityModal{{ $amenity->id }}"><i class="bi bi-pencil-fill"></i></button>
                                @endadminCan
                                <!-- Delete -->
                                @adminCan('delete_hotel_amenity')
                                <form action="{{ route('amenities.destroy', $amenity->id) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Are you sure?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger"><i class="bi bi-trash-fill"></i></button>
                                </form>
                                @endadminCan
                            </td>
                        </tr>

                        <!-- Update Modal -->
                        <div class="modal fade" id="editAmenityModal{{ $amenity->id }}" tabindex="-1" aria-labelledby="editAmenityLabel{{ $amenity->id }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <form method="POST" action="{{ route('amenities.update', $amenity->id) }}" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Edit Amenity</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label>Name</label>
                                                <input type="text" class="form-control" name="name" value="{{ $amenity->name }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label>Icon (optional)</label>
                                                <input type="file" class="form-control" name="icon">
                                                @if($amenity->icon)
                                                <img src="{{ $amenity->icon }}" class="mt-2" width="60" height="60">
                                                @endif
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-success">Update</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{ $amenities->links() }}
        </div>
        <div class="modal fade" id="addAmenityModal" tabindex="-1" aria-labelledby="addAmenityLabel" aria-hidden="true">
            <div class="modal-dialog">
                <form method="POST" action="{{ route('amenities.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Add Amenity</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label>Name</label>
                                <input type="text" class="form-control" name="name" required>
                            </div>
                            <div class="mb-3">
                                <label>Icon</label>
                                <input type="file" class="form-control" name="icon">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script>
    function openModal() {
        // Reset form values
        document.getElementById('amenityForm').reset();
        document.getElementById('amenityId').value = '';
        document.getElementById('amenityModalLabel').innerText = 'Add Amenity';
    }
    function editAmenity(id) {
        fetch(`/amenities/${id}/edit`)
            .then(response => response.json())
            .then(data => {
                document.getElementById('amenityId').value = data.id;
                document.getElementById('name').value = data.name;
                document.getElementById('icon').value = data.icon;
                document.getElementById('amenityModalLabel').innerText = 'Edit Amenity';
                new bootstrap.Modal(document.getElementById('amenityModal')).show();
            });
    }
    document.getElementById('amenityForm').addEventListener('submit', function(e) {
        e.preventDefault();

        const amenityId = document.getElementById('amenityId').value;
        const name = document.getElementById('name').value;
        const icon = document.getElementById('icon').value;

        const formData = new FormData();
        formData.append('name', name);
        formData.append('icon', icon);

        let method = 'POST';
        let url = '/amenities';

        if (amenityId) {
            method = 'PUT';
            url = `/amenities/${amenityId}`;
        }

        fetch(url, {
                method: method
                , body: formData
            , })
            .then(response => response.json())
            .then(data => {
                if (data.message) {
                    alert(data.message);
                    location.reload(); // Reload to show updated list
                }
            })
            .catch(error => console.error('Error:', error));
    });

    function deleteAmenity(id) {
        if (confirm('Are you sure you want to delete this amenity?')) {
            fetch(`/amenities/${id}`, {
                    method: 'DELETE'
                , })
                .then(response => response.json())
                .then(data => {
                    if (data.message) {
                        alert(data.message);
                        document.getElementById(`amenity-${id}`).remove(); // Remove row from table
                    }
                })
                .catch(error => console.error('Error:', error));
        }
    }

</script>
@endsection

