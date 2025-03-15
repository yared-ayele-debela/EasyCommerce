<?php use App\Models\Product;?>
<?php use App\Models\ProductFilter;
$productFilters=ProductFilter::productFilters();

?>
@extends('fontend.layout.layout')
@section('content')
<style>
    .list-images {
    position: relative;
    width: 100%;
    min-height: 1px;
    padding-right: 10px;
    padding-left: 10px;
  }
  .filters-category{
    position: relative;
    width: 100%;
    min-height: 1px;
    padding-right: 15px;
    padding-left: 15px;
  }
</style>
<div class="page-shop u-s-p-t-80">
    <div class="container">
        <div class="row">
            <!-- Shop-Left-Side-Bar-Wrapper -->
             @include('products.filters')
            <!-- Shop-Left-Side-Bar-Wrapper /- -->
            <!-- Shop-Right-Wrapper -->
            <div class="col-lg-9 col-md-9 col-sm-12 filters-category">
                <!-- Page-Bar -->
                <div class="page-bar clearfix">
                    <div class="shop-settings">
                        <a id="list-anchor" >
                            <i class="fas fa-th-list"></i>
                        </a>
                        <a id="grid-anchor" class="active">
                            <i class="fas fa-th"></i>
                        </a>
                    </div>
                    <!-- Toolbar Sorter 1  -->
                    @if(!isset($_REQUEST['search']))

                    <form name="sortProducts" id="sortProducts" action="">
                        <input type="hidden" name="url" id="url" value="{{ $url }}">
                    <div class="toolbar-sorter">
                        <div class="select-box-wrapper">
                            <label class="sr-only" for="sort-by">Sort By</label>
                            <select class="select-box" name="sort" id="sortproo" class="relevant_sort">
                                <option  selected="" value=""> Sort By </option>
                                <option value="product_latest" @if(isset($_GET['sort'])&& $_GET['sort']=="product_latest") selected=""
                                @endif>Sort By: Latest</option>
                                <option value="price_lowest" @if(isset($_GET['sort'])&& $_GET['sort']=="price_lowest") selected=""
                                @endif>Sort By: Lowest Price</option>
                                <option value="price_heighst" @if(isset($_GET['sort'])&& $_GET['sort']=="price_heighst") selected=""
                                @endif>Sort By: Highest Price </option>
                                <option value="sort_a_z" @if(isset($_GET['sort'])&& $_GET['sort']=="sort_a_z") selected=""
                                @endif>Sort By:Name A-Z</option>
                                <option value="sort_z_a" @if(isset($_GET['sort'])&& $_GET['sort']=="sort_z_a") selected=""
                                @endif>Sort By: Name Z-A </option>
                            </select>
                        </div>
                    </div>
                    </form>
                    @endif

                    <!-- //end Toolbar Sorter 1  -->
                    <!-- Toolbar Sorter 2  -->
                    <div class="toolbar-sorter-2">
                        <div class="select-box-wrapper">
                            <label class="sr-only" for="show-records">Show Records Per Page</label>
                            <select class="select-box" id="show-records">
                                <option selected="selected" value="">Show: {{ count($categoryProducts) }}</option>
                                <option value="">Showing All</option>
                            </select>
                        </div>
                    </div>
                    <!-- //end Toolbar Sorter 2  -->
                </div>
                <!-- Page-Bar /- -->
                <!-- Row-of-Product-Container -->
                <div class="row product-container list-style filter_products"  id="filter_products">
                    @include('products.ajax_products_listing')

                </div>
             

                @if(!isset($_REQUEST['search']))

                @if(isset($_GET['sort']))
                <div>{{ $categoryProducts->appends(['sort'=>$_GET['sort']])->links() }}</div>
                @else
                <div>{{ $categoryProducts->links() }}</div>
                @endif
                @endif
                <div>&nbsp;</div>
                <div>{{$categoryDetails['categoryDetails']['description']  }}</div>
                <!-- Row-of-Product-Container /- -->
            </div>
            <!-- Shop-Right-Wrapper /- -->
        </div>
    </div>
</div>
@endsection
@section('script')
<script>

 $(document).ready(function(){
    //sort by brand
    $(".brand").on("change", function() {
             // $(".myDiv").load(".myDiv")
             //  this.form.submit();
             // alert("hello");
            var price=get_filter('price');
            var brand=get_filter('brand');
            var color=get_filter('color');
            var size=get_filter('size');
            var sort=$("#sortproo").val();
            var url=$("#url").val();
            @foreach ($productFilters as $filters)
                var {{ $filters['filter_column'] }} =get_filter('{{ $filters['filter_column'] }}');
            @endforeach

            // alert(url);
            $.ajax({
                url:url,
                method:'Post',
                data:{
                 @foreach ($productFilters as $filters)
                  {{ $filters['filter_column'] }}:{{ $filters['filter_column'] }},
                 @endforeach

                sort:sort,size:size,color:color,price:price,brand:brand,
                url:url,_token: '{{csrf_token()}}'
                },
                success:function(data){
                      $('#filter_products').html(data);
                },error:function(){
                    alert("Error");
                }

            });
        });
    //sort by price
     $(".price").on("change", function() {
             // $(".myDiv").load(".myDiv")
             //  this.form.submit();
             // alert("hello");
            var brand=get_filter('brand');
            var price=get_filter('price');
            var color=get_filter('color');
            var size=get_filter('size');
            var sort=$("#sortproo").val();
            var url=$("#url").val();
            @foreach ($productFilters as $filters)
                var {{ $filters['filter_column'] }} =get_filter('{{ $filters['filter_column'] }}');
            @endforeach

            // alert(url);
            $.ajax({
                url:url,
                method:'Post',
                data:{
                 @foreach ($productFilters as $filters)
                  {{ $filters['filter_column'] }}:{{ $filters['filter_column'] }},
                 @endforeach

                sort:sort,size:size,color:color,price:price,brand:brand,
                url:url,_token: '{{csrf_token()}}'
                },
                success:function(data){
                      $('#filter_products').html(data);
                },error:function(){
                    alert("Error");
                }

            });
        });

    //Sort by color
    $(".color").on("change", function() {
            // $(".myDiv").load(".myDiv")
            //  this.form.submit();
         // alert("hello");
            var brand=get_filter('brand');
            var color=get_filter('color');
            var size=get_filter('size');
            var sort=$("#sortproo").val();
            var price=get_filter('price');
            var url=$("#url").val();
            @foreach ($productFilters as $filters)
                var {{ $filters['filter_column'] }} =get_filter('{{ $filters['filter_column'] }}');
            @endforeach

            // alert(url);
            $.ajax({
                url:url,
                method:'Post',
                data:{
                 @foreach ($productFilters as $filters)
                  {{ $filters['filter_column'] }}:{{ $filters['filter_column'] }},
                 @endforeach

                sort:sort,size:size,color:color,price:price,brand:brand,
                url:url,_token: '{{csrf_token()}}'
                },
                success:function(data){
                      $('#filter_products').html(data);
                },error:function(){
                    alert("Error");
                }

            });
        });

          //Sort by Size
         $(".size").on("change", function() {
            // $(".myDiv").load(".myDiv")
            //  this.form.submit();
           // alert("hello");
            var price=get_filter('price');
            var color=get_filter('color');
            var size=get_filter('size');
            var brand=get_filter('brand');
            var sort=$("#sortproo").val();
            var url=$("#url").val();
            @foreach ($productFilters as $filters)
                var {{ $filters['filter_column'] }} =get_filter('{{ $filters['filter_column'] }}');
            @endforeach

            // alert(url);
            $.ajax({
                url:url,
                method:'Post',
                data:{
                 @foreach ($productFilters as $filters)
                  {{ $filters['filter_column'] }}:{{ $filters['filter_column'] }},
                 @endforeach

                sort:sort,size:size,color:color,price:price,brand:brand,
                url:url,_token: '{{csrf_token()}}'
                },
                success:function(data){
                      $('#filter_products').html(data);
                },error:function(){
                    alert("Error");
                }

            });
        });


        //Sort by Filter
        $("#sortproo").on("change", function() {
            // $(".myDiv").load(".myDiv")
            //  this.form.submit();
         // alert("hello");
            var brand=get_filter('brand');
            var price=get_filter('price');
            var sort=$("#sortproo").val();
            var url=$("#url").val();
            var color=get_filter('color');
            var size=get_filter('size');
            @foreach ($productFilters as $filters)
                var {{ $filters['filter_column'] }} =get_filter('{{ $filters['filter_column'] }}');
            @endforeach

            // alert(url);
            $.ajax({
                url:url,
                method:'Post',
                data:{
                 @foreach ($productFilters as $filters)
                  {{ $filters['filter_column'] }}:{{ $filters['filter_column'] }},
                 @endforeach

                sort:sort,size:size,color:color,price:price,brand:brand,
                url:url,_token: '{{csrf_token()}}'
                },
                success:function(data){
                      $('#filter_products').html(data);
                },error:function(){
                    alert("Error");
                }

            });
        });


        //dynamic filters
        @foreach ($productFilters as $filter)
         $('.{{ $filter['filter_column'] }}').on('click',function(){
            var url=$("#url").val();
            var price=get_filter('price');
            var brand=get_filter('brand');
            var color=get_filter('color');
            var size=get_filter('size');
            var sort=$("#sortproo option:selected").val();
            @foreach ($productFilters as $filters)
                var {{ $filters['filter_column'] }} =get_filter('{{ $filters['filter_column'] }}');
            @endforeach
            $.ajax({

                url:url,
                method:'Post',
                data:
                {
                 @foreach ($productFilters as $filters)
                  {{ $filters['filter_column'] }}:{{ $filters['filter_column'] }},
                 @endforeach

                sort:sort,size:size,color:color,price:price,brand:brand,
                url:url,_token: '{{csrf_token()}}'
                },
                success:function(data){
                    $('#filter_products').html(data);
                },error:function(){
                    alert("Error");
                }
            });
         });
         @endforeach

         function get_filter(class_name){
            var filter=[];
            $('.'+class_name+':checked').each(function(){
                filter.push($(this).val());
            });
            return filter;

         }
});
</script>

@endsection
