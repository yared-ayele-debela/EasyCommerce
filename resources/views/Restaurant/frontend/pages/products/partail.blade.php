<div class="row">
    @forelse ($products as $product)
        <div class="col-md-3 col-6 my-2">
            <div class="offer-card p-3 h-100">
                <a href="{{ url('restaurant/product-detail/'.$product->id) }}">
                    @php
                        $off = $product->price - $product->getFinalPrice();
                    @endphp
                    @if($off > 0)
                        <div class="badge-offer">
                            {{ $off }} ETB OFF
                        </div>
                    @endif
                    <img src="{{ asset('storage/' . $product->image) }}" class="img-fluid mb-2" alt="{{ $product->name }}">
                    <h6 class="text-dark">{{ $product->name }}</h6>
                    <p class="mb-0">
                        <span class="price">{{ $product->getFinalPrice() }} ETB</span>
                        <span class="price-old">{{ $product->price }} ETB</span>
                    </p>
                </a>
                <div class="hover-buttons">
                    <button onclick="window.location.href='{{ url('restaurant/product-detail/'.$product->id) }}'" class="btn-view">
                        <i class="bi bi-eye-fill"></i>
                    </button>
                    <button class="btn-cart add-to-cart" data-product="{{ $product->id }}">
                        <i class="bi bi-cart-check-fill"></i>
                    </button>
                    <button class="btn-wishlist add-to-wishlist" data-product="{{ $product->id }}">
                        <i class="bi bi-heart text-white"></i>
                    </button>
                </div>
            </div>
        </div>
    @empty
        <p class="text-center text-muted">No products found.</p>
    @endforelse
</div>

<!-- Pagination -->
<div class="d-flex justify-content-start">
    {{ $products->links() }}
</div>
