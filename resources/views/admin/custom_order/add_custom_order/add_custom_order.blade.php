
@extends('admindashboard.maindashboard')
@section('dashboard')
<style>
     .remove_button{
            color:red;
        }
        .submitbutton{
            backgroud-color:#1E665E;
        }
        .add_button{
                backgroud-color:#1E665E;
        }

        @media (max-width: 767px) {
            .add_button {
                width: 100%;
                display: block;
            }
            .remove_button{
                width: 100%;
                background-color:red;
                border-radius:0.2rem;
                color:white;
                margin-top: 3px;
                margin-bottom: 3px;
                margin-left: 15px;
                margin-right: 15px;
                padding: 10px 0px;
            }
            .submitbutton{
                width: 100%;
            }

        }
</style>
@php
$user = Auth::guard('admin')->user();
@endphp
<div class="pagetitle bg-light">
    <nav>
        <ol class="breadcrumb p-3 ">
            <li class="breadcrumb-item font-weight-bold"><a href="{{ url('admin/dashboard') }}">Home</a></li>
            <li class="breadcrumb-item">Add Blog </li>
        </ol>
    </nav>
</div>
<section class="section col-md-12">
            <form name="fast_orders shadow-0" action="{{ route('store-custom-order') }}" method="POST" onsubmit="return validateForm()">
                @csrf
                <div class="card border-0">

                    <div class="card-body border-0 ">
                        <ul class="nav nav-tabs pb-4 align-items-end card-header-tabs w-100">
                            @if ($user && $user->hasPermissionByRole('add blog'))
                            <li class="nav-item border-none">
                                <a class="nav-link bg-light active" href="{{ route('add-blog') }}"><i class="fas fa-plus"></i>Add Custom Order</a>
                            </li>
                            @endif
                            <li class="nav-item  border-none">
                                <a class="nav-link" href="{{ route('custom_orders') }}"><i class="fa fa-list mr-2"></i>All Custom Order</a>
                            </li>
                        </ul>
                        <div class="field_wrapper mb-1">
                            <div class="row mb-2">
                                <div class="col-md-3 mb-1">
                                    <input type="text" placeholder="Name" class="form-control" name="customer_name"  id="">
                                    <span id="customer_name_error" class="text-danger"></span>
                                </div>
                                <div class="col-md-4 mb-1">
                                    <input type="number" placeholder="Mobile Number" class="form-control" name="phone_number"  id="">
                                    <span id="phone_number_error" class="text-danger"></span>
                                </div>
                            </div>
                            <div class="row mb-1">
                                <div class="col-md-3 mb-1">
                                    <input type="text" class="form-control mb-2" name="productname[]" placeholder="Product Name" >
                                    <p id="productname_error" class="text-danger"></p>
                                    <input type="text" class="form-control" placeholder="Quantity" name="quantity[]">
                                    <span id="quantity_error[]" class="text-danger"></span>
                                </div>
                                <div class="col-md-4 mb-1">
                                    <textarea name="description[]" class="form-control" cols="20" rows="3" placeholder="Product description" >
                                    </textarea>
                                    <p id="description_error[]" class="text-danger"></p>

                                </div>
                                <div class="col-md-3 mb-1">
                                    <textarea name="delivery_address[]" class="form-control" id="" cols="20" placeholder="Delivery address" rows="3" >
                                     </textarea>
                                     <p id="delivery_address_error[]" class="text-danger"></p>

                                </div>
                            </div>
                            <hr class="mb-1">
                        </div>
                        <div>
                            <a href="javascript:void(0);"  class=" btn btn-outline-primary add_button btn btn-sm" title="Add field">
                                <i class="ri-add-fill  "></i>
                            </a>
                        </div>
                        <div class="form-group pt-3">
                            <input type="submit" class=" btn btn-primary submitbutton btn pt-2 pb-2 shadow"   value="Order">
                        </div>
                    </div>
                </div>
            </form>

</section>
@endsection
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<script type="text/javascript">
    $(document).ready(function(){
        var maxField = 10; // Input fields increment limitation
        var addButton = $('.add_button'); // Add button selector
        var wrapper = $('.field_wrapper'); // Input field wrapper
        var fieldHTML = '<div><div class="row"><div class="col-md-3"><input type="text" class="form-control mb-2" name="productname[]" placeholder="Product Name" ><input type="text" class="form-control mb-1" placeholder="Quantity" name="quantity[]" ></div> <div class="col-md-4 mb-1"><textarea name="description[]" class="form-control" cols="20" rows="3" placeholder="Product description" ></textarea></div><div class="col-md-3 mb-1"><textarea name="delivery_address[]" class="form-control mb-1" cols="20" placeholder="Delivery address" rows="3" ></textarea></div><div class="col-md-2 mb-1"><a href="javascript:void(0);"  class="remove_button ri-delete-bin-6-fill"></a></div></div></div></div>'; // Updated input field html
        var x = 1; // Initial field counter is 1

        // Once add button is clicked
        $(addButton).click(function(){
            // Check maximum number of input fields
            if(x < maxField){
                x++; // Increment field counter
                $(wrapper).append(fieldHTML); // Add field html
            }
        });

        // Once remove button is clicked
        $(wrapper).on('click', '.remove_button', function(e){
            e.preventDefault();
            $(this).closest('.row').remove(); // Remove entire row
            x--; // Decrement field counter
        });
    });
</script>

