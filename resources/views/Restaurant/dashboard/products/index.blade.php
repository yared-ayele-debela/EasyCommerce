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
            <li class="breadcrumb-item active" aria-current="page">Products</li>
        </ol>
    </nav>
    <div class="card">
        <div class="card-header">
            <h4>Products</h4>
            <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addProductModal">
                Add Product
            </button>
        </div>
        <div class="card-body">
           <div class="table-responsiv">
            <table class="table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Sub Category</th>
                        <th>Menu</th>
                        <th>City</th>
                        <th>Price</th>
                        <th>Tax</th>
                        <th>Discount Type</th>
                        <th>Discount</th>
                        <th>Cover Image</th>
                        <th>Other Image</th>
                        <th>Most Popular</th>
                        <th>Best Seller</th>
                        <th>Is Free Delivery</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $product)
                    <tr>
                        <td>{{ $product->name }}</td>
                        <td>
                            @if($product->category)
                            {{ $product->category->name }}
                            @else
                            @endif
                        </td>
                        <td>
                            {{ $product->subcategory ? $product->subcategory->name : "" }}
                        </td>
                        <td>{{ $product->menu? $product->menu->name:'' }}</td>
                        <td>{{ $product->city? $product->city->name:'' }}</td>
                        <td>{{ $product->price }} Birr</td>
                        <td>{{ $product->product_tax }} Birr</td>
                        <td>{{ $product->discount_type }}</td>
                        <td>{{ $product->discount }} Birr</td>
                        <td>
                            <img src="{{$product->image}}" width="50">
                        </td>
                        <td>
                            @foreach($product->images as $image)
                                <img src="{{ $image->image_path }}" width="50">
                            @endforeach
                        </td>
                        <td>
                            <div class="btn btn-sm btn-{{ $product->most_populer ? 'success' : 'secondary' }}">
                                {{ $product->most_populer ? 'Yes' : 'No' }}
                            </div>

                        </td>
                        <td>
                            <div class="btn btn-sm btn-{{ $product->best_seller ? 'success' : 'secondary' }}">
                                {{ $product->best_seller ? 'Yes' : 'No' }}
                            </div>
                        </td>
                        <td>
                            <div class="btn btn-sm btn-{{ $product->is_free ? 'success' : 'secondary' }}">
                                {{ $product->is_free ? 'Yes' : 'No' }}
                            </div>
                        </td>
                        <td>
                            <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editProductModal{{ $product->id }}"><i class="bi bi-pencil-fill"></i></button>
                            <a href="{{ url('admin/restaurant/products/'.$product->id) }}" class="btn btn-primary btn-sm" ><i class="bi bi-eye-fill"></i></a>
                            {{-- <form action="{{ route('products.destroy', $product->id) }}" method="POST" style="display:inline;">
                                @csrf @method('DELETE') --}}
                                <button class="btn btn-danger btn-sm delete-product" data-id="{{ $product->id }}"><i class="bi bi-trash-fill"></i></button>
                            {{-- </form> --}}
                        </td>
                    </tr>
                    <!-- Edit Product Modal -->
                    <div class="modal fade" id="editProductModal{{ $product->id }}" tabindex="-1">
                        <div class="modal-dialog modal-lg modal-dialog-scrollable">
                            <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5>Edit Product</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <input type="hidden" name="admin_id" value="{{ Auth::guard('admin')->user()->id }}">
                                                    <label for="name" class="form-label">Product Name</label>
                                                    <input type="text" class="form-control" id="name" name="name" value="{{ $product->name }}" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="description" class="form-label">Description</label>
                                                    <textarea class="form-control" id="description" name="description">
                                                        {{ $product->description }}
                                                    </textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="category_id" class="form-label">Category</label>
                                                    <select class="form-control" id="category_id" name="category_id" required>
                                                        <option value="">Select Category</option>
                                                        @foreach($categories as $category)
                                                        <option @if($category->id===$product->category_id) selected @endif value="{{ $category->id }}">{{ $category->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="subcategory_id" class="form-label">Sub Category</label>
                                                    <select class="form-control" id="subcategory_id" name="subcategory_id" required>
                                                        @foreach($subcategories as $subcategory)
                                                        <option @if($subcategory->id===$product->subcategory_id) selected @endif value="{{ $subcategory->id }}" data-category="{{ $subcategory->category_id }}">{{ $subcategory->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="menu_id" class="form-label">Menu</label>
                                                    <select class="form-control" id="menu_id" name="menu_id" required>
                                                        <option value="">Select Menu</option>
                                                        @foreach($menus as $menu)
                                                        <option @if($menu->id===$product->menu_id) selected @endif value="{{ $menu->id }}">{{ $menu->name }}</option>
                                                        @endforeach
                                                        <!-- Categories dynamically populated here -->
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="city_id" class="form-label">City</label>
                                                    <select class="form-control" id="city_id" name="city_id" required>
                                                        <option value="">Select City</option>
                                                        @foreach($cities as $city)
                                                        <option @if($city->id===$product->city_id) selected @endif value="{{ $city->id }}">{{ $city->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="mb-3">
                                                    <label for="price" class="form-label">Price</label>
                                                    <input type="number" class="form-control" id="price" name="price" value="{{ $product->price }}" required>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="mb-3">
                                                <label for="product_tax"  class="form-label">Product Tax</label>
                                                <select class="form-control" name="product_tax" id="product_tax">
                                                    @foreach ($taxs as $tax)
                                                    <option @if($tax->percentage===$product->product_tax) selected @endif value="{{ $tax->percentage }}">{{ $tax->taxname }} ({{ $tax->percentage }}%)</option>
                                                    @endforeach
                                                </select>
                                                </div>
                                                @error('product_tax')
                                                <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="discount_type" class="form-label">Discount Type</label>
                                                    <select class="form-control" id="discount_type" name="discount_type">
                                                        <option @if($product->discount_type==="fixed") selected @endif value="fixed">Fixed</option>
                                                        <option @if($product->discount_type==="percentage") selected @endif value="percentage">Percentage</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="discount" class="form-label">Discount</label>
                                                    <input type="number" min="1" class="form-control" id="discount" value="{{ $product->discount }}" name="discount">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="cover_image" class="form-label">Cover Images</label>
                                                    <input type="file" class="form-control" id="cover_image" name="cover_image">
                                                    @if($product->image)
                                                    <img src="{{ $product->image }}" width="50">
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="images" class="form-label">Product Images</label>
                                                    <input type="file" class="form-control" id="images" name="images[]" multiple>
                                                    @foreach($product->images as $image)
                                                    <img src="{{ $image->image_path }}" width="50">
                                                    @endforeach
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-check">
                                                    <label class="form-check-label">
                                                      <input type="checkbox" class="form-check-input" name="most_populer" id="most_populer" value="1" @if($product->most_populer) checked @endif>
                                                      most popular
                                                    </label>
                                                  </div>
                                                  <div class="form-check">
                                                    <label class="form-check-label">
                                                      <input type="checkbox" class="form-check-input" name="best_seller" id="best_seller" value="1" @if($product->best_seller) checked @endif>
                                                      Best Seller
                                                    </label>
                                                  </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <div class="form-group">
                                                      <label for="is_free" class="form-label">Is Free Delivery</label>
                                                      <select class="form-control" name="is_free" id="is_free">
                                                        <option @if($product->is_free=="1") selected @endif value="1">Yes</option>
                                                        <option @if($product->is_free=="0") selected @endif value="0">No</option>
                                                      </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6" id="delivery_fee2">
                                                <div class="mb-3">
                                                    <div class="form-group">
                                                      <label for="delivery_fee" class="form-label">Delivery Fee in 1 KM in (ETB)</label>
                                                      <input type="number" name="delivery_fee" class="form-control" id="delivery_fee" value="{{ $product->delivery_fee }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <div class="form-group">
                                                      <label for="delivery_time" class="form-label">Delivered estimated Time in 1 KM</label>
                                                      <input type="number" name="delivery_time" class="form-control" id="delivery_time" value="{{ $product->delivery_time }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-success">Update Product</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    @endforeach
                </tbody>
            </table>
           </div>
        </div>
    </div>
</div>
<!-- Add Product Modal -->
<div class="modal fade" id="addProductModal" tabindex="-1" aria-labelledby="addProductModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addProductModalLabel">Add Product</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addProductForm" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <input type="hidden" name="admin_id" value="{{ Auth::guard('admin')->user()->id }}">
                                <label for="name" class="form-label">Product Name</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control" id="description" name="description"></textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="category_id" class="form-label">Category</label>
                                <select class="form-control" id="addcategory_id" name="category_id" required>
                                    <option value="">Select Category</option>
                                    @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="subcategory_id" class="form-label">Sub Category</label>
                                <select class="form-control" id="addsubcategory_id" name="subcategory_id" required>
\                                    @foreach($subcategories as $subcategory)
                                    <option value="{{ $subcategory->id }}" data-category="{{ $subcategory->category_id }}">{{ $subcategory->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="menu_id" class="form-label">Menu</label>
                                <select class="form-control" id="menu_id" name="menu_id" required>
                                    <option value="">Select Menu</option>
                                    @foreach($menus as $menu)
                                    <option value="{{ $menu->id }}">{{ $menu->name }}</option>
                                    @endforeach
                                    <!-- Categories dynamically populated here -->
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="city_id" class="form-label">City</label>
                                <select class="form-control" id="city_id" name="city_id" required>
                                    <option value="">Select City</option>
                                    @foreach($cities as $city)
                                    <option value="{{ $city->id }}">{{ $city->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="price" class="form-label">Price</label>
                                <input type="number" class="form-control" id="price" name="price" required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                            <label for="product_tax"  class="form-label">Product Tax</label>
                            <select class="form-control" name="product_tax" id="product_tax">
                                @foreach ($taxs as $tax)
                                <option value="{{ $tax->percentage }}">{{ $tax->taxname }} ({{ $tax->percentage }}%)</option>
                                @endforeach
                            </select>
                            </div>
                            @error('product_tax')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="discount_type" class="form-label">Discount Type</label>
                                <select class="form-control" id="discount_type" name="discount_type">
                                    <option value="fixed">Fixed</option>
                                    <option value="percentage">Percentage</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="discount" class="form-label">Discount</label>
                                <input type="number" min="1" class="form-control" id="discount" name="discount">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="cover_image" class="form-label">Cover Images</label>
                                <input type="file" class="form-control" id="cover_image" name="cover_image">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="images" class="form-label">Product Images</label>
                                <input type="file" class="form-control" id="images" name="images[]" multiple>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-check">
                                <label class="form-check-label">
                                  <input type="checkbox" class="form-check-input" name="most_populer" id="most_populer" value="1">
                                  most popular
                                </label>
                              </div>
                              <div class="form-check">
                                <label class="form-check-label">
                                  <input type="checkbox" class="form-check-input" name="best_seller" id="best_seller" value="1">
                                  Best Seller
                                </label>
                              </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <div class="form-group">
                                  <label for="is_free" class="form-label">Is Free Delivery</label>
                                  <select class="form-control" name="is_free" id="is_freea">
                                    <option value="1" selected>Yes</option>
                                    <option value="0">No</option>
                                  </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6" id="delivery_feeId">
                            <div class="mb-3">
                                <div class="form-group">
                                  <label for="delivery_fee" class="form-label">Delivery Fee in 1 KM in (ETB)</label>
                                  <input type="number" name="delivery_fee" class="form-control" id="delivery_fee">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <div class="form-group">
                                  <label for="delivery_time" class="form-label">Delivered estimated Time in 1 KM</label>
                                  <input type="number" name="delivery_time" class="form-control" id="delivery_time">
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Save Product</button>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener("DOMContentLoaded", function () {

        $("#is_freea").change(function() {
            if ($(this).val() == "0") {
                $("#delivery_feeId").fadeIn();
            } else {
                $("#delivery_feeId").fadeOut();
            }
        }).trigger("change"); // Trigger change on page load
        $("#is_free").change(function() {
            if ($(this).val() == "0") {
                $("#delivery_fee2").fadeIn();
            } else {
                $("#delivery_fee2").fadeOut();
            }
        }).trigger("change"); // Trigger change on page load

        const categorySelect = document.getElementById("category_id");
        const subcategorySelect = document.getElementById("subcategory_id");
        const allSubcategories = Array.from(subcategorySelect.options);

        function filterSubcategories() {
            const selectedCategory = categorySelect.value;
            subcategorySelect.innerHTML = '<option value="">Select Sub Category</option>';

            allSubcategories.forEach(option => {
                if (option.dataset.category === selectedCategory || option.value === "") {
                    subcategorySelect.appendChild(option);
                }
            });
        }

        categorySelect.addEventListener("change", filterSubcategories);
        filterSubcategories();  // Call on page load in case a category is pre-selected

        const addcategorySelect = document.getElementById("addcategory_id");
        const addsubcategorySelect = document.getElementById("addsubcategory_id");
        const addallSubcategories = Array.from(addsubcategorySelect.options);

        function addfilterSubcategories() {
            const selectedCategory = addcategorySelect.value;
            addsubcategorySelect.innerHTML = '<option value="">Select Sub Category</option>';

            addallSubcategories.forEach(option => {
                if (option.dataset.category === selectedCategory || option.value === "") {
                    addsubcategorySelect.appendChild(option);
                }
            });
        }

        addcategorySelect.addEventListener("change", addfilterSubcategories);
        addfilterSubcategories();  // Call on page load in case a category is pre-selected
    });
</script>
<script>
        $(document).on('click', '.delete-product', function() {
            let productId = $(this).data('id');
            let row = $('#row-' + productId);

            Swal.fire({
                title: "Are you sure to delete this product?",
                text: "This action cannot be undone!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('products.destroy', '') }}/" + productId,
                        type: "DELETE",
                        data: {
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            Swal.fire("Deleted!", response.success, "success");
                            row.remove();
                            location.reload();
                        },
                        error: function() {
                            Swal.fire("Error!", "Something went wrong.", "error");
                        }
                    });
                }
            });
        });
    $(document).ready(function() {
        $('#addProductForm').submit(function(e) {
            e.preventDefault();
            let formData = new FormData(this);
            $.ajax({
                url: "{{ route('products.store') }}",
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    $('#addProductModal').modal('hide');
                    location.reload();
                },
                error: function(error) {
                    alert('Error adding product!');
                }
            });
        });
    });
</script>


@endsection
