@foreach($auto_scroll_products as $product)
<div class="col-md-3 col-4 col-lg-2">
   <x-restaurant.normal-product-card :product="$product" badge="" bgColor="" />
</div>
@endforeach
