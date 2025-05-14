    @forelse ($products as $product)
        <div class="col-md-3 col-6 my-2">
            <x-restaurant.product-card :product="$product" />
        </div>
    @empty
        <p class="text-center text-muted">No products found.</p>
    @endforelse
