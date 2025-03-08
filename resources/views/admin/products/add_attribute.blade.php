@extends('admindashboard.maindashboard')
@section('dashboard')
@php
$user = Auth::guard('admin')->user();
@endphp
<div class="pagetitle bg-light">
    <nav>
       <ol class="breadcrumb p-3 ">
          <li class="breadcrumb-item font-weight-bold"><a href="{{ url('admin/dashboard') }}">Home</a></li>
          <li class="breadcrumb-item">Add Attribute</li>
       </ol>
    </nav>
 </div>
 <section class="section " >
    <div class="col-lg-12">
        <div class="card" >
           <div class="card-body pt-1">
             <h5 class="card-title">Add Attributes</h5>
             @if(Session::has('error_message'))
             <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Error!</strong>{{Session::get('error_message')}}
                <button type="button" class="btn-close btn-sm" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>
             @endif
                <form class=" row g-3" action="{{ url('admin/products/addattributes/') }}" method="POST" enctype="multipart/form-data" >
                @csrf
                <input type="hidden" name="id" value="{{ $product->id }}">
                <div class="col-md-4 pt-3">
                   <label for="product_name" class="form-label">Product_name</label>
                    <input disabled type="text" class="form-control"  value="{{ $product->product_name }}"  name="product_name">
                    @error('product_name')
                    <small class=" text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="col-md-4 pt-3">
                    <label for="product_code" class="form-label">Product_code</label>
                     <input disabled type="text" class="form-control" value="{{ $product->product_code }}"   name="product_code">
                     @error('product_code')
                     <small class=" text-danger">{{ $message }}</small>
                     @enderror
                 </div>
                 <div class="col-md-4 pt-3">
                    <label for="product_color" class="form-label">Product_color</label>
                     <input disabled type="text" class="form-control" value="{{ $product->product_color}}"   name="product_color">
                     @error('product_color')
                     <small class=" text-danger">{{ $message }}</small>
                     @enderror
                 </div>
                 <div class="col-md-4 pt-3">
                  <label for="product_price" class="form-label">Product_price</label>
                   <input disabled type="number" class="form-control" value="{{ $product->product_price }}" name="product_price">
                   @error('product_price')
                   <small class=" text-danger">{{ $message }}</small>
                   @enderror
               </div>
               <div class="col-md-4 pt-3">
               <div class="row">
                  <img src="{{ asset('/storage/products/'.$product->product_image) }}" style="width:180px; margin-left:15px;  box-shadow:1px 1px 2px gray; height:200px" class=" rounded" alt="">
               </div>
               </div>
               <div class="form-group">
                <div class="field_wrapper">
                        <input type="text"  name="size[]" placeholder="Size" style="width: 120px; " required="">
                        <input type="text" placeholder="Sku" style="width: 120px;"  name="sku[]" required=""/>
                        @if($product->is_offer_price==="yes")

                        @else
                        <input type="text" placeholder="Price"style="width: 120px;"  placeholder="Price" name="price[]" required=""/>
                        @endif
                        <input type="text" placeholder="Stock" style="width: 120px;"  placeholder="Stock" name="stock[]" value=""/>
                        <a href="javascript:void(0);" class="add_button btn btn-primary" title="Add field">Add</a>
                    </div>
                </div>

               <div class="form-group pt-3 ">
                @if ($user && $user->hasPermissionByRole('add_attribute'))
                <input type="submit" class=" btn btn-primary   pt-2 pb-2 shadow" value="Submit ">
                @endif
                <input type="submit" class=" btn btn-outline-danger   pt-2 pb-2 shadow" value="Cancel ">
                </div>
              </form>
              <form action="{{ url('admin/products/attributes/'.$product['id']) }}" method="POST">
                @csrf
                <table class="table datatable ml-4 mr-4">
                    <thead>
                       <tr>
                          <th scope="col">ID</th>
                          <th scope="col">Size</th>
                          <th scope="col">SKU</th>
                          @if($product->is_offer_price=="yes")
                          @else
                          <th scope="col">Price</th>
                          @endif
                          <th scope="col">Stock</th>
                          <th scope="col">Status</th>
                          <th scope="col">Action</th>
                       </tr>
                    </thead>
                    <tbody>
                      @foreach ($product['attributes'] as $k => $attribute)
                      <input   type="text" name="attributeId[]" style="display: none" value="{{ $attribute['id'] }}">
                       <tr>
                          <td>{{ $attribute['id'] }}</td>
                          <td>{{ $attribute['size'] }}</td>
                          <td>{{ $attribute['sku'] }}</td>
                          @if($product->is_offer_price=="yes")
                          @else
                          <td><input type="number" name="price[]"  value="{{ $attribute['price'] }}" required="" style="width: 120px">
                          </td>
                          @endif
                          <td>
                            <input type="number" name="stock[]"  value="{{ $attribute['stock'] }}" required="" style="width: 120px">
                          <td>
                             @if($attribute['status']==1)
                                   <a href="{{ url('admin/products/inactive_attribute/'.$attribute['id']) }}"><span style="border-radius: 0.2rem;padding-left:3px;padding-right:3px;background-color:rgb(62, 162, 51); color:white">Active</span></a>
                             @elseif ($attribute['status']==0)
                                   <a href="{{ url('admin/products/active_attribute/'.$attribute['id']) }}"><span style="border-radius: 0.2rem;padding-left:3px;padding-right:3px;background-color:rgb(201, 34, 34); color:white">Inactive</span></a>
                              @endif
                          </td>
                          <td>
                            @if($user && $user->hasPermissionByRole('delete_product_image'))
                            <a href="{{ url('admin/products/delete_attribute/'.$attribute['id']) }}" class="btn btn-sm btn-danger">Delete</a>
                            @endif
                          </td>
                       </tr>
                       @endforeach
                    </tbody>
                 </table>
                 @if ($user && $user->hasPermissionByRole('edit_attribute'))
                 <button type="submit" class=" btn btn-primary">
                    Update Attributes
                 </button>
                 @endif
                </form>
              </div>
            </div>
          </div>
 </section>
 <script type="text/javascript">
    $(document).ready(function(){
        var maxField = 10; //Input fields increment limitation
        var addButton = $('.add_button'); //Add button selector
        var wrapper = $('.field_wrapper'); //Input field wrapper
        var fieldHTML = '<div><div style="height:10px;"></div><input type="text" placeholder="Size"  name="size[]" style="width: 120px;" />&nbsp<input type="text" placeholder="Sku" name="sku[]" style="width: 120px;" />&nbsp<input type="text" name="price[]" placeholder="Price" style="width: 120px;" />&nbsp<input type="text" placeholder="Stock" name="stock[]" style="width: 120px;" /><a  href="javascript:void(0);" class="remove_button btn btn-outline-danger">❌</a></div>'; //New input field html
        var x = 1; //Initial field counter is 1

        //Once add button is clicked
        $(addButton).click(function(){
            //Check maximum number of input fields
            if(x < maxField){
                x++; //Increment field counter
                $(wrapper).append(fieldHTML); //Add field html
            }
        });

        //Once remove button is clicked
        $(wrapper).on('click', '.remove_button', function(e){
            e.preventDefault();
            $(this).parent('div').remove(); //Remove field html
            x--; //Decrement field counter
        });
    });
    </script>
@endsection

@section('script')

@endsection
