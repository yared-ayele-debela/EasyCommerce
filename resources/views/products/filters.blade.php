<?php
namespace App\Models;

use App\Models\Product;
use App\Models\Categroy;
$getCategory=Category::all()->where('status',1)->toArray();

?>
<?php use App\Models\ProductFilter;
$productFilters=ProductFilter::productFilters();

?>
<div class="col-md-3 offer-card p-4 filters-category">
    <div class="d-flex justify-content-between align-content-center ">
        <h6 class="fw-bold border-bottom pb-2">Browse Categories </h6>
       
        <div id="toggleFilterBtn" role="button">
            <i class="bi bi-toggle-on text-primary" style="font-size: 20px;"></i>
        </div>
    </div>
    <div id="filterSidebar">
    <div class="mb-4">
        <ul class="list-unstyled mb-0">
            @foreach ($getCategory as $category)
                @php $productCount = Product::productCount($category['id']); @endphp
                <li class="py-1">
                    <a href="{{ url('ecommerce/category/' . encrypt($category['id'])) }}" class="text-decoration-none text-dark">
                        {{ $category['name'] }}
                        @if($productCount) <span class="text-muted">({{ $productCount }})</span> @endif
                    </a>
                </li>
            @endforeach
        </ul>
    </div>

    @if (!isset($_REQUEST['search']))
        <!-- Brand Filter -->
        @php $getBrands = ProductFilter::getBrands($url); @endphp
        @if(count($getBrands))
        <div class="mb-4">
            <h5 class="fw-bold border-bottom pb-2">Brand</h5>
            <div class="form-check-group overflow-auto" style="max-height: 240px;">
                @foreach ($getBrands as $key => $brand)
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input brand" name="brand[]" id="brand{{ $key }}" value="{{ $brand['id'] }}">
                        <label class="form-check-label" for="brand{{ $key }}">{{ $brand['name'] }}</label>
                    </div>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Color Filter -->
        @php $getColors = ProductFilter::getColors($url); @endphp
        @if(count($getColors))
        <div class="mb-4">
            <h5 class="fw-bold border-bottom pb-2">Color</h5>
            <div class="form-check-group overflow-auto" style="max-height: 240px;">
                @foreach ($getColors as $key => $color)
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input color" name="color[]" id="color{{ $key }}" value="{{ $color }}">
                        <label class="form-check-label" for="color{{ $key }}">{{ ucfirst($color) }}</label>
                    </div>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Size Filter -->
        @php $getSizes = ProductFilter::getSizes($url); @endphp
        @if(count($getSizes))
        <div class="mb-4">
            <h5 class="fw-bold border-bottom pb-2">Size</h5>
            <div class="form-check-group overflow-auto" style="max-height: 240px;">
                @foreach ($getSizes as $key => $size)
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input size" name="size[]" id="size{{ $key }}" value="{{ $size }}">
                        <label class="form-check-label" for="size{{ $key }}">{{ $size }}</label>
                    </div>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Dynamic Filters -->
        @foreach ($productFilters as $filter)
            @php
                $filterAvailable = ProductFilter::filterAvailable($filter['id'], $categoryDetails['categoryDetails']['id']);
            @endphp
            @if($filterAvailable == "Yes" && count($filter['filter_values']))
                <div class="mb-4">
                    <h5 class="fw-bold border-bottom pb-2">{{ $filter['filter_name'] }}</h5>
                    <div class="form-check-group overflow-auto" style="max-height: 180px;">
                        @foreach ($filter['filter_values'] as $value)
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input {{ $filter['filter_column'] }}" name="{{ $filter['filter_column'] }}[]" id="{{ $value['filter_value'] }}" value="{{ ucwords($value['filter_value']) }}">
                                <label class="form-check-label" for="{{ $value['filter_value'] }}">{{ ucwords($value['filter_value']) }}</label>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        @endforeach
    @endif

    <!-- Price Filter -->
    <div class="mb-4">
        <h5 class="fw-bold border-bottom pb-2">Price</h5>
        @php $prices = ['0-1000','1000-2000','2000-5000','5000-10000','10000-25000','25000-50000','50000-100000','100000-200000']; @endphp
        <div class="form-check-group">
            @foreach ($prices as $key => $price)
                <div class="form-check">
                    <input type="checkbox" class="form-check-input price" name="price[]" id="price{{ $key }}" value="{{ $price }}">
                    <label class="form-check-label" for="price{{ $key }}">ETB <strong>{{ $price }}</strong> Birr</label>
                </div>
            @endforeach
        </div>
    </div>
    </div>
</div>

