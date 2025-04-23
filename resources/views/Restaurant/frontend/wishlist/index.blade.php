@extends('all_frontend_layouts.layouts')
@section('content')
<div class="container my-4">
    <div class="header">
        <button class="btn btn-link text-dark" onclick="history.back()">
            <i class="bi bi-arrow-left"></i>
        </button>
        <h5 class="my-4 text-dark text-center">My wishlist</h5>
    </div>

    <div class="row">
        <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="pills-restaurant-tab" data-bs-toggle="pill" data-bs-target="#pills-restaurant" type="button" role="tab" aria-controls="pills-restaurant" aria-selected="true">Restaurant Wishlist</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="pills-product-tab" data-bs-toggle="pill" data-bs-target="#pills-product" type="button" role="tab" aria-controls="pills-product" aria-selected="false">Product Wishlist</button>
            </li>
        </ul>
        <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade show active" id="pills-restaurant" role="tabpanel" aria-labelledby="pills-restaurant-tab">
                <div class="row">
                    <div class="col-md-10">
                        @if(count($wishlist) > 0)
                        <table class="table table-borderless">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Price</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($wishlist as $item)
                                @php
                                $product = isset($item->product) ? $item->product : \App\Models\Product::find($item['product_id']);
                                @endphp
                                <tr>
                                    <td>
                                        <a href="{{ url('restaurant/product-detail/'.encrypt($product->id)) }}" class="text-dark">
                                            <img src="{{ asset('storage/' . $product->image) }}" width="50">
                                            {{ $product->name }}
                                        </a>
                                    </td>
                                    <td>{{ number_format($product->price, 2) }} ETB</td>
                                    <td>
                                        <button class="btn btn-danger btn-sm remove-wishlist" data-product="{{ $product->id }}"><i class="bi bi-trash-fill"></i></button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="pills-product" role="tabpanel" aria-labelledby="pills-product-tab">
                <div class="row">
                    <div class="col-md-10">
                        @if(count($ecommerce_wishlist) > 0)
                        <table class="table table-borderless">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Price</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($ecommerce_wishlist as $item)
                                @php
                                $product = isset($item->product) ? $item->product : \App\Models\Product::find($item['product_id']);
                                @endphp
                                <tr>
                                    <td>
                                        <a href="{{ url('restaurant/product-detail/'.encrypt($product->id)) }}" class="text-dark">
                                            <img src="{{ asset('/storage/products/'.$product['product_image']) }}" width="50">
                                            {{ $product->product_name }}
                                        </a>
                                    </td>
                                    <td>{{ number_format($product->product_price, 2) }} ETB</td>
                                    <td>
                                        <button class="btn btn-danger remove-wishlist-btn btn-sm" data-id="{{ $item->id }}">
                                          <i class="bi bi-trash-fill"></i>
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <a href="{{ url('/') }}" class="btn bg-primary text-white">Return to Shop</a>
    @else
    <p>Your wishlist is empty.</p>
    @endif
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function () {
        $('.remove-wishlist-btn').click(function (e) {
            e.preventDefault();
            const itemId = $(this).data('id');

            $.ajax({
                url: "{{ route('wishlist.remove') }}",
                type: "POST",
                data: {
                    id: itemId,
                    _token: "{{ csrf_token() }}"
                },
                success: function (response) {
                    if (response.status === 'removed') {
                        $('#wishlist-item-' + itemId).fadeOut();

                        showAlert('success', 'Item removed from wishlist');
                        location.reload();

                    }
                },
                error: function () {
                    showAlert('error', 'Something went wrong!');
                }
            });
        });
    });
    </script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        document.querySelectorAll(".remove-wishlist").forEach(button => {
            button.addEventListener("click", function() {
                let productId = this.getAttribute("data-product");

                // Show Confirmation Alert Before Deletion
                Swal.fire({
                    title: "Are you sure?"
                    , text: "Do you want to remove this item from your wishlist? 💔"
                    , icon: "warning"
                    , showCancelButton: true
                    , confirmButtonColor: "#d33"
                    , cancelButtonColor: "#3085d6"
                    , confirmButtonText: "Yes, remove it!"
                    , cancelButtonText: "Cancel"
                }).then((result) => {
                    if (result.isConfirmed) {
                        fetch("{{ route('restaurant.wishlist.remove') }}", {
                                method: "POST"
                                , headers: {
                                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                                    , "Content-Type": "application/json"
                                }
                                , body: JSON.stringify({
                                    product_id: productId
                                })
                            }).then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    Swal.fire({
                                        title: "Removed!"
                                        , text: "The product has been removed from your wishlist. 💔"
                                        , icon: "success"
                                        , timer: 2000
                                        , showConfirmButton: false
                                    });

                                    // Reload after short delay
                                    setTimeout(() => {
                                        location.reload();
                                    }, 1500);
                                }
                            });
                    }
                });
            });
        });
    });
</script>
@endsection

