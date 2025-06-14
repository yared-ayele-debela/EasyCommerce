<div class="row">
    @forelse($products as $product)
            <x-ecommerce-product :product="$product" />
    @empty
        <div class="col-12 text-center py-4">
            <p class="text-muted">No products found.</p>
        </div>
    @endforelse
</div>
@if ($products->hasPages())
    <div class="d-flex justify-content-center mt-4">
        {{ $products->onEachSide(1)->links() }}
    </div>
@endif
