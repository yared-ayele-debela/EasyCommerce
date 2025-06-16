@foreach ($products as $product)
    <div class="col-md-2">
        <x-restaurant.normal-product-card :product="$product" bgColor="btn-info" />
    </div>
@endforeach
