@extends('Restaurant.dashboard.layouts')
@section('restaurant-dashboard')
@php
$user = Auth::guard('admin')->user();
@endphp
<nav class="breadcrumb">
    <a class="breadcrumb-item" href="#">Home</a>
    <a class="breadcrumb-item active" href="#">Product Detail</a>
</nav>
<div class="container">
    <div class="card">
        <div class="card-header">

            <h4>{{ $product->name }}</h4>
        </div>
        <div class="card-body">
            <img src="{{ $product->image }}" class=" pt-3" style="width: 200px">

            <p>Description: {{ $product->description }}</p>
            <p>Price: {{ $product->getFinalPrice() }} ETB</p>
            <h4>Product Sizes</h4>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#sizeModal" id="createSizeBtn">Add Size</button>
            @session('success')
            <div class="alert alert-success my-2" role="alert">
               <strong>
                   {{ session('success') }}
               </strong>
            </div>
           @endsession
            @session('error')
            <div class="alert alert-danger my-2" role="alert">
               <strong>
                   {{ session('error') }}
               </strong>
            </div>
           @endsession
            <table class="table table-striped mt-4">
                <thead>
                    <tr>
                        <th>Size</th>
                        <th>Price</th>
                        <th>Stock</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($product->sizes as $size)
                    <tr>
                        <td>{{ $size->size }}</td>
                        <td>{{ $size->price }} ETB</td>
                        <td>{{ $size->stock }}</td>
                        <td>
                            <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#EditsizeModal{{ $size->id }}" data-id="{{ $size->id }}" data-size="{{ $size->size }}" data-price="{{ $size->price }}" data-stock="{{ $size->stock }}">Edit</button>
                            <form action="{{ route('productSizes.destroy', ['product' => $product->id, 'size' => $size->id]) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </td>
                        <div class="modal fade" id="EditsizeModal{{ $size->id }}" tabindex="-1" aria-labelledby="EditsizeModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form action="{{ route('productSizes.update', $size->id) }}" method="POST" >
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="sizeModalLabel">Edit Product Size</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label for="size" class="form-label">Size</label>
                                                <select class="form-select" name="size" id="size">
                                                    <option value="small">Small</option>
                                                    <option value="medium">Medium</option>
                                                    <option value="large">Large</option>
                                                </select>
                                            </div>

                                            <div class="mb-3">
                                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                                <label for="price" class="form-label">Price</label>
                                                <input type="number" class="form-control" value="{{ $size->price }}" name="price" id="price" required>
                                            </div>

                                            <div class="mb-3">
                                                <label for="stock" class="form-label">Stock</label>
                                                <input type="number" class="form-control" name="stock" value="{{ $size->stock }}" id="stock" required>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Update</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <a class="btn btn-primary" href="{{ route('products.index') }}">Back To Products</a>
        </div>
    </div>

    <!-- Modal for creating/editing sizes -->
    <div class="modal fade" id="sizeModal" tabindex="-1" aria-labelledby="sizeModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('productSizes.store', $product->id) }}" method="POST" id="sizeForm">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="sizeModalLabel">Add Product Size</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="size" class="form-label">Size</label>
                            <select class="form-select" name="size" id="size">
                                <option value="small">Small</option>
                                <option value="medium">Medium</option>
                                <option value="large">Large</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="price" class="form-label">Price</label>
                            <input type="number" class="form-control" name="price" id="price" required>
                        </div>

                        <div class="mb-3">
                            <label for="stock" class="form-label">Stock</label>
                            <input type="number" class="form-control" name="stock" id="stock" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection


@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const sizeModal = document.getElementById('sizeModal');
            const sizeForm = document.getElementById('sizeForm');
            const sizeModalTitle = document.getElementById('sizeModalLabel');

            document.getElementById('createSizeBtn').addEventListener('click', function () {
                sizeModalTitle.textContent = 'Add Product Size';
                sizeForm.reset();
                sizeForm.action = '{{ route('productSizes.store', $product->id) }}';
            });

            document.querySelectorAll('button[data-bs-target="#sizeModal"]').forEach(button => {
                button.addEventListener('click', function () {
                    sizeModalTitle.textContent = 'Edit Product Size';
                    const sizeId = this.getAttribute('data-id');
                    const size = this.getAttribute('data-size');
                    const price = this.getAttribute('data-price');
                    const stock = this.getAttribute('data-stock');

                    sizeForm.action = '/product-sizes/' + sizeId;
                    sizeForm.method = 'PUT';
                    sizeForm.size.value = size;
                    sizeForm.price.value = price;
                    sizeForm.stock.value = stock;
                });
            });
        });
    </script>
@endsection
