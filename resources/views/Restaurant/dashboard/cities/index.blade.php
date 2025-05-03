@extends('Restaurant.dashboard.layouts')
@section('restaurant-dashboard')
@php
$user = Auth::guard('admin')->user();
@endphp

<div class="container">
    <nav class="breadcrumb bg-white shadow-sm py-3 px-4 rounded d-flex justify-content-between align-items-center">
        <button class="btn btn-outline-primary btn-sm d-flex align-items-center" onclick="history.back()">
            <i class="bi bi-arrow-left mr-2"></i> &nbsp;
            <span>Back</span>
        </button>

        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item">
                <a href="{{ route('restaurant.dashboard') }}">Home</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">Cities</li>
        </ol>
    </nav>
    <div class="card">
        <div class="card-header">
            <h4 class="text-right">Manage Cities</h4>
            <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addCityModal">
                Add City
            </button>

        </div>
        <div class="card-body">

            <!-- Cities Table -->
            <table class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>City Name</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($cities as $index => $city)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $city->name }}</td>
                        <td>
                            <!-- Edit Button -->
                            <button class="btn btn-warning btn-sm edit-btn" data-id="{{ $city->id }}" data-name="{{ $city->name }}" data-bs-toggle="modal" data-bs-target="#editCityModal">
                                Edit
                            </button>

                            <!-- Delete Button -->
                            <button class="btn btn-danger btn-sm delete-btn" data-id="{{ $city->id }}">
                                Delete
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Add City Modal -->
<div class="modal fade" id="addCityModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add City</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="addCityForm">
                    @csrf
                    <div class="mb-3">
                        <label>City Name</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Add City</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Edit City Modal -->
<div class="modal fade" id="editCityModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit City</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="editCityForm">
                    @csrf
                    <input type="hidden" id="editCityId">
                    <div class="mb-3">
                        <label>City Name</label>
                        <input type="text" id="editCityName" name="name" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-warning">Update City</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- jQuery & AJAX -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        // Add City
        $('#addCityForm').submit(function(e) {
            e.preventDefault();
            $.ajax({
                url: "{{ route('cities.store') }}"
                , method: "POST"
                , data: $(this).serialize()
                , success: function(response) {
                    location.reload();
                }
            });
        });

        // Edit City Modal Data
        $('.edit-btn').click(function() {
            $('#editCityId').val($(this).data('id'));
            $('#editCityName').val($(this).data('name'));
        });

        // Update City
        $('#editCityForm').submit(function(e) {
            e.preventDefault();
            let id = $('#editCityId').val();
            $.ajax({
                url: "/admin/restaurant/cities/update/" + id
                , method: "POST"
                , data: $(this).serialize()
                , success: function(response) {
                    location.reload();
                }
            });
        });

        // Delete City

    });

</script>
<script>
    $(document).ready(function () {
        $(document).on('click', '.delete-btn', function (e) {
            e.preventDefault();
            let id = $(this).data('id');

            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "/admin/restaurant/cities/destroy/" + id,
                        method: "DELETE",
                        data: {
                            _token: "{{ csrf_token() }}"
                        },
                        success: function (response) {
                            Swal.fire({
                                title: "Deleted!",
                                text: "The city has been deleted.",
                                icon: "success",
                                timer: 1500,
                                showConfirmButton: false
                            }).then(() => {
                                location.reload(); // Reload after deletion
                            });
                        },
                        error: function () {
                            Swal.fire("Error!", "Something went wrong.", "error");
                        }
                    });
                }
            });
        });
    });
</script>

@endsection

