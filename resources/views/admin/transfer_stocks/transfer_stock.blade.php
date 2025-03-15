@extends('admindashboard.maindashboard')
@section('dashboard')
@php
$user = Auth::guard('admin')->user();
@endphp
<div class="pagetitle bg-light">
    <nav>
        <ol class="breadcrumb p-3 ">
            <li class="breadcrumb-item font-weight-bold"><a href="{{ url('admin/dashboard') }}">Home</a></li>
            <li class="breadcrumb-item">Transfer stock products</li>
        </ol>
    </nav>
</div>
<section class="section">
    <div class="card border-0 shadow-sm">
        <div class="card-body pt-3">
            <form method="POST" action="{{ route('store-transfer-stock-product') }}">
                @csrf
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label for="from_warehouse_id">From Warehouse:</label>
                            <select class="form-control" id="from_warehouse_id" name="from_warehouse_id">
                                <option value="" selected disabled>select</option>
                                @foreach($fromwarehouses as $warehouse)
                                <option value="{{ $warehouse->id }}">{{ $warehouse->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label for="to_warehouse_id">To Warehouse:</label>
                            <select class="form-control" id="to_warehouse_id" name="to_warehouse_id">
                                <option value="" selected disabled>select</option>
                                @foreach($warehouses as $warehouse)
                                <option value="{{ $warehouse->id }}">{{ $warehouse->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    {{-- <div class="col">
                        <div class="form-group">
                            <label for="reference_number">Reference Number:</label>
                            <input type="text" class="form-control" id="reference_number" name="reference_number" required>
                        </div>

                    </div> --}}
                    <div class="col">
                        <div class="form-group">
                            <label for="transfer_date">Transfer Date:</label>
                            <input type="date" class="form-control" id="transfer_date" name="transfer_date" required>
                        </div>
                    </div>
                </div>

                <br>
                <div class="form-group mb-3">
                    <div class="form-group mb-4">
                        <label for="selectedProducts">Selected Products:</label>
                        <div id="selectedProducts" class="form-control d-flex">
                        </div>
                        <input type="hidden" id="selectedProductsInput">
                    </div>
                    <select id="productSelect" name="selectedProducts[]" multiple class="form-control">

                        @foreach($products as $product)
                        <option class="text-black" value="{{ $product->id }}" data-price="{{ $product->product_price }}">{{ $product->product_name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    {{-- <label for="selectedProductsTable">Selected Products:</label> --}}
                    <table class="table table-borderless">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Quantity</th>
                                <th>Size</th>

                            </tr>
                        </thead>
                        <tbody id="selectedProductsTable">

                        </tbody>
                    </table>
                </div>
                <div class="form-group">
                    <label for="note">Note:</label>
                    <textarea class="form-control" id="note" placeholder="please add some note" name="note" rows="3"></textarea>
                    </div>
                    <br>
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
               var productPrice = $(this).data('price'); // Retrieve the price using data-price attribute

               selectedProducts.push(product);


               var newRow = `<tr>
                               <td >${productName}</td>
                               <input type="hidden" value="${productPrice}" name="price_${product}">
                               <td><input type="number" class="form-control" name="stock_${product}" placeholder="Quantity"></td>
                               <td><input type="text" class="form-control" name="size_${product}" placeholder="Size"></td>
                           </tr>`;
               $('#selectedProductsTable').append(newRow);
               $('#selectedProducts').append('<button class="btn-sm btn-primary">' + productName + '</button>&nbsp;');

           });

           $('#selectedProductsInput').val(selectedProducts.join(', '));
       });
   });
</script>
@endsection

{{-- @section('script') --}}
<!-- Add this jQuery section below your existing HTML -->



{{-- @endsection --}}

