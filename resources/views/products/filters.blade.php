<?php
namespace App\Models;

use App\Models\Product;
use App\Models\Categroy;
$getCategory=Category::all()->where('status',1)->toArray();

?>
<?php use App\Models\ProductFilter;
$productFilters=ProductFilter::productFilters();

?>
<div class="col-lg-3 col-md-3 col-sm-12 filters-category">
    <!-- Fetch-Categories-from-Root-Category  -->
    <div class="fetch-categories">
        <h3 class="title-name">Browse Categories</h3>
        <h3 class="fetch-mark-category">
        </h3>
        <ul>
            @foreach ($getCategory as $category )
            <li class="border-1">
                @php $productCount=Product::productCount($category['id']) @endphp
                <a href="{{ url('category/'.$category['id']) }}">
                    {{ $category['name'] }} &nbsp; {{$productCount === 0 ? "" : "($productCount)" }}
                </a>
            </li>
            @endforeach

        </ul>

    </div>
    <!-- Fetch-Categories-from-Root-Category  /- -->
    <!-- Filters -->
    @if(!isset($_REQUEST['search']))

    <?php $getBrands=ProductFilter::getBrands($url); ?>
    <div class="facet-filter-associates">
        <h3 class="title-name">Brand</h3>
        <div class="grooverScrollDiv" style="position: relative; overflow: hidden; width: auto; height: 256px;">
            <div class="associate-wrapper" style="overflow: hidden; width: auto; height: 256px;">
                @foreach ($getBrands as $key=> $brand)
                <input type="checkbox" class="check-box brand" name="brand[]" id="brand{{ $key }}" value="{{ $brand['id'] }}">
                <label class="label-text" for="brand{{ $key }}">{{$brand['name']}}
                </label>
                @endforeach
            </div>
            <div class="grooverScrollBar" style="background: rgb(0, 0, 0); width: 7px; position: absolute; top: 0px; opacity: 0.4; display: none; border-radius: 7px; z-index: 99; right: 1px; height: 198.594px;"></div>
            <div class="grooverScrollRail" style="width: 7px; height: 100%; position: absolute; top: 0px; display: none; border-radius: 7px; background: rgb(51, 51, 51); opacity: 0.2; z-index: 90; right: 1px;"></div>
        </div>
    </div>

    <?php $getColors=ProductFilter::getColors($url); ?>
    <div class="facet-filter-associates">
        <h3 class="title-name">Color</h3>
        <div class="grooverScrollDiv" style="position: relative; overflow: hidden; width: auto; height: 256px;">
            <div class="associate-wrapper" style="overflow: hidden; width: auto; height: 256px;">
                @foreach ($getColors as $key=> $color)
                <input type="checkbox" class="check-box color" name="color[]" id="color{{ $key }}" value="{{ $color }}">
                <label class="label-text" for="color{{ $key }}">{{$color}}
                </label>
                @endforeach
            </div>
            <div class="grooverScrollBar" style="background: rgb(0, 0, 0); width: 7px; position: absolute; top: 0px; opacity: 0.4; display: none; border-radius: 7px; z-index: 99; right: 1px; height: 198.594px;"></div>
            <div class="grooverScrollRail" style="width: 7px; height: 100%; position: absolute; top: 0px; display: none; border-radius: 7px; background: rgb(51, 51, 51); opacity: 0.2; z-index: 90; right: 1px;"></div>
        </div>
    </div>


    <?php $getSizes=ProductFilter::getSizes($url); ?>
    <div class="facet-filter-associates">
        <h3 class="title-name">Size</h3>
        <div class="grooverScrollDiv" style="position: relative; overflow: hidden; width: auto; height: 256px;">
            <div class="associate-wrapper" style="overflow: hidden; width: auto; height: 256px;">
                @foreach ($getSizes as $key=> $size)
                <input type="checkbox" class="check-box size" name="size[]" id="size{{ $key }}" value="{{ $size }}">
                <label class="label-text" for="size{{ $key }}">{{$size}}
                </label>
                @endforeach
            </div>
            <div class="grooverScrollBar" style="background: rgb(0, 0, 0); width: 7px; position: absolute; top: 0px; opacity: 0.4; display: none; border-radius: 7px; z-index: 99; right: 1px; height: 198.594px;"></div>
            <div class="grooverScrollRail" style="width: 7px; height: 100%; position: absolute; top: 0px; display: none; border-radius: 7px; background: rgb(51, 51, 51); opacity: 0.2; z-index: 90; right: 1px;"></div>
        </div>
    </div>

    @foreach ($productFilters as $filter )
    <?php
    $filterAvailable=ProductFilter::filterAvailable($filter['id'],$categoryDetails['categoryDetails']['id'])
    ?>
    @if($filterAvailable=="Yes")
    @if(count($filter['filter_values'])>0)
    <!-- Filter-Brand -->
    <div class="facet-filter-associates">
        <h3 class="title-name">{{ $filter['filter_name'] }}</h3>
        <form class="facet-form" action="#" method="post">
            <div class="grooverScrollDiv" style="position: relative; overflow: hidden; width: auto; height: 84px;">
                <div class="associate-wrapper" style="overflow: hidden; width: auto; height: 84px;">
                    @foreach ($filter['filter_values'] as $value)
                    <input type="checkbox" class="check-box {{ $filter['filter_column'] }}" name="{{ $filter['filter_column'] }}[]" id="{{ $value['filter_value'] }}" value=" {{ ucwords($value['filter_value'])}}">
                    <label class="label-text" for="{{$value['filter_value']}}">
                        {{ ucwords($value['filter_value'])}}
                    </label>
                    @endforeach
                </div>
                <div class="grooverScrollBar" style="background: rgb(0, 0, 0); width: 7px; position: absolute; top: 0px; opacity: 0.4; display: block; border-radius: 7px; z-index: 99; right: 1px; height: 80.1818px;"></div>
                <div class="grooverScrollRail" style="width: 7px; height: 100%; position: absolute; top: 0px; display: none; border-radius: 7px; background: rgb(51, 51, 51); opacity: 0.2; z-index: 90; right: 1px;"></div>
            </div>
        </form>
    </div>
    @endif
    @endif
    @endforeach
    @endif

    <div class="facet-filter-by-price">
        <h3 class="title-name">Price</h3>
        <form method="POST" action="#">
            <?php  $prices =array('0-1000','1000-2000','2000-5000','5000-10000','10000-25000','25000-50000','50000-100000','100000-200000'); ?>
            @foreach ($prices as $key=> $price)
            <ul>
                <input type="checkbox" class="input-field price" name="price[]" id="price{{ $key }}" value="{{ $price }}">
                &nbsp; <a class="">
                    <label for="price{{ $key }}">ETB <b>{{$price}}</b> Birr</label></a><br>
            </ul>
            <br>
            @endforeach
        </form>
    </div>

</div>

