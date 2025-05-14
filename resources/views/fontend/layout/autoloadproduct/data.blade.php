
<?php use App\Models\Product;?>
<?php use App\Models\ProductFilter;
$productFilters=ProductFilter::productFilters();
?>
@foreach ($all_products as $product)
<x-product-card :product="$product" />
@endforeach

