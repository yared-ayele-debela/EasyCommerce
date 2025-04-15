@extends('all_frontend_layouts.layouts')
@section('content')
<div class="container my-4">
    <div class="checkout-header">
        <a href="{{ url('/') }}">Home</a> / <span>My Wishlist</span>
      </div>

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
    <hr>

        </div>
    </div>
    <a href="{{ url('/') }}" class="btn bg-primary text-white">Return to Shop</a>
    @else
    <p>Your wishlist is empty.</p>
    @endif
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".remove-wishlist").forEach(button => {
        button.addEventListener("click", function () {
            let productId = this.getAttribute("data-product");

            // Show Confirmation Alert Before Deletion
            Swal.fire({
                title: "Are you sure?",
                text: "Do you want to remove this item from your wishlist? 💔",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Yes, remove it!",
                cancelButtonText: "Cancel"
            }).then((result) => {
                if (result.isConfirmed) {
                    // Proceed with Deletion
                    fetch("{{ route('restaurant.wishlist.remove') }}", {
                        method: "POST",
                        headers: {
                            "X-CSRF-TOKEN": "{{ csrf_token() }}",
                            "Content-Type": "application/json"
                        },
                        body: JSON.stringify({ product_id: productId })
                    }).then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire({
                                title: "Removed!",
                                text: "The product has been removed from your wishlist. 💔",
                                icon: "success",
                                timer: 2000,
                                showConfirmButton: false
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
