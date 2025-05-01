@extends('Hotel.dashboard.layouts')
@section('hotel-dashboard')

 <nav class="breadcrumb">
    <a class="breadcrumb-item" href="{{ url('admin/hotel/dashboard') }}">Home</a>
    <a class="breadcrumb-item active" href="#">Banners</a>
 </nav>
<div class="container">
    <div class="card">
        <div class="card-header">
            <h4>Slider Banners</h4>

            <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#createBannerModal">Add Banner</button>
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
        </div>
        <div class="card-body">


    <table class="table">
        <tr>
            <th>ID</th>
            <th>Image</th>
            <th>Title</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
        @foreach($banners as $banner)
        <tr>
            <td>{{ $banner->id }}</td>
            <td><img src="{{ $banner->image }}" width="100"></td>
            <td>{{ $banner->title }}</td>
            <td>
                <div class="btn btn-sm {{ $banner->is_active ? 'btn-success' : 'btn-warning' }}">
                    {{ $banner->is_active ? 'Active' : 'Inactive' }}
                </div>
            </td>
            <td>
                <button class="btn btn-warning btn-sm editBannerBtn"
                        data-bs-toggle="modal"
                        data-bs-target="#editBannerModal"
                        data-id="{{ $banner->id }}"
                        data-title="{{ $banner->title }}"
                        data-description="{{ $banner->description }}"
                        data-link="{{ $banner->link }}"
                        data-image="{{ $banner->image }}"
                        data-is_active={{ $banner->is_active }}
                        >
                    <i class="bi bi-pencil-fill"></i>
                </button>

                <button class="btn btn-danger btn-sm deleteBannerBtn"
                        data-id="{{ $banner->id }}">
                    <i class="bi bi-trash-fill"></i>
                </button>
            </td>
        </tr>
        @endforeach
    </table>
        </div>
    </div>
</div>

<!-- Create Banner Modal -->
<div class="modal fade" id="createBannerModal" tabindex="-1" aria-labelledby="createBannerModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form action="{{ route('hotel-slider-banners.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New Banner</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <label>Title:</label>
                <input type="text" name="title" class="form-control">

                <label>Description:</label>
                <textarea name="description" class="form-control"></textarea>

                <label>Link:</label>
                <input type="url" name="link" class="form-control">

                <label>Image:</label>
                <br>
                <span class="text-danger">Image size must be height: 407px and width: 683px</span>
                <input type="file" name="image" class="form-control" required>

                <label>Active:</label>
                <select name="is_active" class="form-control">
                    <option value="1" selected>Yes</option>
                    <option value="0">No</option>
                </select>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Save</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </form>
  </div>
</div>

<!-- Edit Banner Modal -->
<div class="modal fade" id="editBannerModal" tabindex="-1" aria-labelledby="editBannerModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form id="editBannerForm" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Banner</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="id" id="editBannerId">

                <label>Title:</label>
                <input type="text" name="title" id="editBannerTitle" class="form-control">

                <label>Description:</label>
                <textarea name="description" id="editBannerDescription" class="form-control"></textarea>

                <label>Link:</label>
                <input type="url" name="link" id="editBannerLink" class="form-control">

                <label>Current Image:</label><br>
                <img id="editBannerImage" src="" width="100"><br>

                <label>New Image:</label>
                <br>
                <span class="text-danger">Image size must be height: 407px and width: 683px</span>
                <input type="file" name="image" class="form-control">

                <label>Active:</label>
                <select name="is_active" id="editBannerActive" class="form-control">
                    <option value="1">Yes</option>
                    <option value="0">No</option>
                </select>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-warning">Update</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </form>
  </div>
</div>

<!-- Delete Banner Modal -->
<div class="modal fade" id="deleteBannerModal" tabindex="-1" aria-labelledby="deleteBannerModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form id="deleteBannerForm" method="POST">
        @csrf
        @method('DELETE')
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Delete Banner</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this banner?
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-danger">Delete</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            </div>
        </div>
    </form>
  </div>
</div>

<!-- JavaScript for Handling Modals -->
<script>
document.addEventListener("DOMContentLoaded", function() {
    // Edit Banner Modal
    document.querySelectorAll(".editBannerBtn").forEach(button => {
        button.addEventListener("click", function() {
            const id = this.getAttribute("data-id");
            const title = this.getAttribute("data-title");
            const description = this.getAttribute("data-description");
            const link = this.getAttribute("data-link");
            const image = this.getAttribute("data-image");
            const is_active = this.getAttribute("data-is_active");

            document.getElementById("editBannerId").value = id;
            document.getElementById("editBannerTitle").value = title;
            document.getElementById("editBannerDescription").value = description;
            document.getElementById("editBannerLink").value = link;
            document.getElementById("editBannerImage").src = image;
            document.getElementById("editBannerActive").value=is_active;
            document.getElementById("editBannerForm").action = `/admin/hotel/hotel-slider-banners/${id}`;
        });
    });

    // Delete Banner Modal

});
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).ready(function () {
        $(document).on("click", ".deleteBannerBtn", function (e) {
            e.preventDefault();
            let id = $(this).data("id");

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
                        url: `/admin/hotel/hotel-slider-banners/${id}`,
                        method: "DELETE",
                        data: {
                            _token: "{{ csrf_token() }}"
                        },
                        success: function (response) {
                            Swal.fire({
                                title: "Deleted!",
                                text: "The banner has been deleted.",
                                icon: "success",
                                timer: 1500,
                                showConfirmButton: false
                            }).then(() => {
                                location.reload(); // Refresh the page after deletion
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
