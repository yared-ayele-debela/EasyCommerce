@extends('admindashboard.maindashboard')
@section('dashboard')
@php
$user = Auth::guard('admin')->user();
@endphp
<div class="pagetitle bg-light">
    <nav>
        <ol class="breadcrumb p-3 ">
            <li class="breadcrumb-item font-weight-bold"><a href="{{ url('admin/dashboard') }}">Home</a></li>
            <li class="breadcrumb-item">Stocks</li>
        </ol>
    </nav>
</div>
<section class="section">
    <div class="card border-0 shadow-sm">
        <div class="card-body pt-3">
            <form method="POST" action="{{ url('admin/stocks/store') }}">
                @csrf
                <div class="form-group mb-3">
                    <label for="productSelect">Select Products:</label>
                    <select id="productSelect" name="selectedProducts[]" multiple class="form-control">
                        @foreach($products as $product)
                        <option class="text-black" value="{{ $product->id }}">{{ $product->product_name }}</option>
                        @endforeach
                    </select>
                </div>
                <hr>

                <div class="form-group mb-4">
                    <label for="selectedProducts">Selected Products:</label>
                    <div id="selectedProducts" class="form-control d-flex">
                    </div>
                    <input type="hidden" id="selectedProductsInput">
                </div>
                <hr>
                <div class="form-group">
                    {{-- <label for="selectedProductsTable">Selected Products:</label> --}}
                    <table class="table table-borderless">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>SKU</th>
                                <th>Warehouse</th>
                                <th>Size</th>
                                <th>Price</th>
                                <th>Stock</th>
                            </tr>
                        </thead>
                        <tbody id="selectedProductsTable">
                            {{-- @foreach($products as $product)
                            <tr>
                                <td>{{ $product->product_name }}</td>
                                <td>
                                    <select class="form-control" name="warehouse_{{ $product->id }}">
                                        <option value="" selected disabled>select</option>
                                        @foreach($warehouses as $warehouse)
                                        <option value="{{ $warehouse->id }}">{{ $warehouse->name }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td><input type="text" class="form-control" name="size_{{ $product->id }}" placeholder="Size"></td>
                                <td><input type="text" class="form-control" name="price_{{ $product->id }}" placeholder="Price"></td>
                                <td><input type="text" class="form-control" name="stock_{{ $product->id }}" placeholder="Stock"></td>
                            </tr>
                            @endforeach --}}
                        </tbody>
                    </table>
                </div>

                <button type="submit" class="btn btn-primary">Save Products</button>
            </form>
        </div>
    </div>
</section>
<script>
    $(document).ready(function() {

       $('#productSelect').change(function() {
           var selectedProducts = [];
           $('#selectedProducts').empty();
           $('#selectedProductsInput').val('');

           $('#selectedProductsTable').empty();

           $('#productSelect option:selected').each(function() {
               var product = $(this).val();
               var productName = $(this).text();

               selectedProducts.push(product);

               var warehouses = @json($warehouses); // Pass warehouses from PHP to JavaScript

               var warehouseOptions = '';
               $.each(warehouses, function(index, warehouse) {
                   warehouseOptions += `<option value="${warehouse.id}">${warehouse.name}</option>`;
               });

               var newRow = `<tr>
                               <td >${productName}</td>
                               <td><input type="text" class="form-control" name="sku_${product}" placeholder="Sku"></td>
                               <td>
                                   <select class="form-control" name="warehouse_${product}">
                                       <option value="" selected disabled>select</option>
                                       ${warehouseOptions}
                                   </select>
                               </td>
                               <td><input type="text" class="form-control" name="size_${product}" placeholder="Size"></td>
                               <td><input type="text" class="form-control" name="price_${product}" placeholder="Price"></td>
                               <td><input type="text" class="form-control" name="stock_${product}" placeholder="Stock"></td>
                           </tr>`;
               $('#selectedProductsTable').append(newRow);
               $('#selectedProducts').append('<button class="btn-sm btn-primary">' + productName + '</button>&nbsp;');

           });

           $('#selectedProductsInput').val(selectedProducts.join(', '));
       });
   });
</script>
@endsection


