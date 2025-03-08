<?php
use App\Models\Group;
use App\Helper\Helper;
// $subcategory=Subcategory::subcategories();
use App\Models\AppSetting;
use App\Models\CmsPage;

$cms_pages = CmsPage::get()->toArray();
$appsettings = AppSetting::all()->toArray();

$groups=Group::groups();
if(Auth::user()){
// $totalWishLists=totalWishlistItems();
}

// $totalCartItems=totalCartItems();

// echo "<pre>"; print_r($groups);
?>

<header>
    <style>
        @media (min-width: 768px) {
            .modal-dialog.modal-lg {
                max-width: 500px;
                position: fixed;
                top: 0%;
                left: 30%;
            }
        }

        .remove_button {
            color: red;
        }

        .submitbutton {
            backgroud-color: #1E665E;
        }

        .add_button {
            backgroud-color: #1E665E;
        }

        @media (max-width: 767px) {
            .add_button {
                width: 100%;
                display: block;
            }

            .remove_button {
                width: 100%;
                background-color: red;
                border-radius: 0.2rem;
                color: white;
                margin-top: 3px;
                margin-bottom: 3px;
                margin-left: 15px;
                margin-right: 15px;
                padding: 10px 0px;
            }

            .submitbutton {
                width: 100%;
            }

        }

    </style>

    <div class="full-layer-outer-header shadow-sm">
        <div class="container  clearfix">
            <nav>
                <ul class="primary-nav g-nav">
                    <li>
                        <div class="d-flex pt-1">
                            <button type="button" class="btn btn-sm  text-white " style="background-color:#1E665E;" data-toggle="modal" data-target="#exampleModal">Custom Order</button>
                            &nbsp;
                            <a href="{{ url('track-custom-order') }}" style="color:#1E665E;" class="btn btn-light btn-sm">Track your custom order</a>
                        </div>
                        <div class="modal fade " id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Custom Order</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        @if ($errors->any())
                                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                            <div class="alert alert-danger" role="alert">
                                                <ul>
                                                    @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        @endif


                                        <form name="fast_orders" action="{{ route('store_custom_order') }}" method="POST" onsubmit="return validateForm()">
                                            @csrf
                                            <div class="card border-0">
                                                <div class="card-body border-0 bg-white">
                                                    <div class="field_wrapper mb-1">
                                                        <div class="row mb-2">
                                                            <div class="col-md-3 mb-1">
                                                                <input type="text" class="form-control" name="customer_name" placeholder=" Name" id="">
                                                                <span id="customer_name_error" class="text-danger"></span>

                                                            </div>
                                                            <div class="col-md-4 mb-1">
                                                                <input type="number" class="form-control" name="phone_number" placeholder="Mobile Number" id="">
                                                                <span id="phone_number_error" class="text-danger"></span>
                                                            </div>

                                                        </div>
                                                        <div class="row mb-1">
                                                            <div class="col-md-3 mb-1">
                                                                <input type="text" class="form-control mb-2" name="productname[]" placeholder="Product Name">
                                                                <p id="productname_error" class="text-danger"></p>
                                                                <input type="text" class="form-control" placeholder="Quantity" name="quantity[]">
                                                                <span id="quantity_error[]" class="text-danger"></span>
                                                            </div>
                                                            <div class="col-md-4 mb-1">
                                                                <textarea name="description[]" class="form-control" rows="3" placeholder="Product description"></textarea>
                                                                <p id="description_error[]" class="text-danger"></p>
                                                            </div>
                                                            <div class="col-md-3 mb-1">
                                                                <textarea name="delivery_address[]" class="form-control" placeholder="Delivery address" rows="3"></textarea>
                                                                <p id="delivery_address_error[]" class="text-danger"></p>
                                                            </div>
                                                        </div>
                                                        <hr class="mb-1">
                                                    </div>
                                                    <div>
                                                        <a href="javascript:void(0);" class=" button button-primary add_button btn" title="Add field">
                                                            <i class="ion ion-md-add"></i>
                                                        </a>
                                                    </div>
                                                    <div class="form-group pt-3">
                                                        <input type="submit" class=" button button-primary submitbutton btn pt-2 pb-2 shadow" value="Submit">
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li>
                        <a href="tel:+111444989">
                            <i class="fas fa-phone u-c-brand u-s-m-r-9"></i>
                            Telephone:{{ $appsettings[0]['phone_no'] }}</a>
                    </li>
                    {{-- <li>
                        <a href="mailto:contact@domain.com">
                            <i class="fas fa-envelope u-c-brand u-s-m-r-9"></i>
                            E-mail: {{ $appsettings[0]['email_address'] }}
                        </a>
                    </li> --}}

                </ul>
            </nav>
            <nav>
                <ul class="secondary-nav g-nav">
                    <li>
                        {{-- <a class="" href="{{ url('track-your-order') }}"> Track your order </a> --}}
                        @if(Auth::check())
                        <a type="submit" class="text" href="{{ url('track-your-order') }}">Track your order</a>
                        @endif
                    </li>
                    <li>
                        <a>@if(Auth::check()) My Account @else Login/Register @endif
                            <i class="fas fa-chevron-down u-s-m-l-9"></i>
                        </a>
                        <ul class="g-dropdown" style="width:200px">
                            @if(Auth::check())
                            <li>
                                <a href="{{ url('user/display/user_details_account') }}">
                                    <i class="fas fa-cog u-s-m-r-9"></i>
                                    My Profile</a>
                            </li>
                            <li>
                                <a href="{{ url('user/orders') }}">
                                    <i class="far fa-heart u-s-m-r-9"></i>
                                    My Orders</a>
                            </li>

                            <li>
                                <a href="{{ url('user/logout') }}">
                                    <i class="far fa-check-circle u-s-m-r-9"></i>
                                    Logout</a>
                            </li>
                            @else

                            <li>
                                <a href="{{ url('user/login-register') }}">
                                    <i class="fas fa-sign-in-alt u-s-m-r-9"></i>
                                    Login / Signup</a>
                            </li>
                            <li>
                                <a href="{{ url('login_register/vendor') }}">
                                    <i class="fas fa-sign-in-alt u-s-m-r-9"></i>
                                    Be come to Vendor</a>
                            </li>
                            @endif

                        </ul>
                    </li>

                    <li>
                        @php
                        App\Helper\Helper::currency_load();
                        $currency_code = session('currency_code');
                        $currency_symbol = session('currency_symbol');

                        if ($currency_symbol=="") {
                        $system_default_currency_info = session('system_default_currency_info');
                        $currency_symbol = $system_default_currency_info->symbol;
                        $currency_code = $system_default_currency_info->code;
                        }
                        @endphp
                        <a>
                            {{ $currency_code }}
                            <i class="fas fa-chevron-down u-s-m-l-9"></i>
                        </a>
                        <ul class="g-dropdown" style="width:90px">
                            @foreach(\App\Models\Currencies::all() as $currency)
                            <li>
                                <a href="javascript:;" onclick="currency_change('{{ $currency['code'] }}')" class="u-c-brand">{{ \Illuminate\Support\Str::upper($currency->code) }}</a>
                            </li>
                            @endforeach
                        </ul>
                    </li>
                    <li>
                        <a>ENG
                            <i class="fas fa-chevron-down u-s-m-l-9"></i>
                        </a>
                        <ul class="g-dropdown" style="width:70px">
                            <li>
                                <a href="#" class="u-c-brand">ENG</a>
                            </li>
                            {{-- <li>
                                <a href="#">ARB</a>
                            </li> --}}
                        </ul>
                </ul>

            </nav>
        </div>
    </div>
    <!-- Top-Header /- -->
    <!-- Mid-Header -->
    <div class="full-layer-mid-header">
        <div class="container ">
            <div class="row clearfix align-items-center">
                <div class="col-lg-3 col-md-9 col-sm-6">
                    <div class="brand-logo text-lg-center">
                        <a href="{{ url('/') }}">
                            <img src="{{ asset('/storage/appsettings/'.$appsettings[0]['logo']) }}" width="100%" height="60px" class="app-brand-logo">
                        </a>
                    </div>
                </div>
                <div class="col-lg-6 u-d-none-lg">
                    <form class="form-searchbox" action="{{ url('/search-products') }}" method="get">
                        <label class="sr-only" for="search-landscape">Search</label>
                        <input id="search-landscape" type="text" class="text-field" placeholder="Search product..." name="search" required type="text" @if(isset($_REQUEST['search']) && !empty($_REQUEST['search'])) value={{ $_REQUEST['search']}} @endif autocomplete="off">
                        <div class="select-box-position">
                            <div class="select-box-wrapper select-hide">
                                <label class="sr-only" for="select-category">Choose category for search</label>
                                <select class="select-box" name="section_id">
                                    <option selected="selected" value="">
                                        All
                                    </option>
                                    @foreach ($groups as $group)
                                    <option @if(isset($_REQUEST['section_id']) && !empty($_REQUEST['section_id']) && $_REQUEST['section_id']==$group['id']) selected="" @endif value="{{ $group['id'] }}">{{ $group['name'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <button id="btn-search" type="submit" class="button button-primary fas fa-search"></button>
                    </form>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6">
                    <nav>
                        <ul class="mid-nav g-nav">
                            <li class="u-d-none-lg">
                                <a href="{{ url('/') }}">
                                    <i class="ion ion-md-home u-c-brand"></i>
                                </a>
                            </li>
                            <li class="u-d-none-lg">
                                <a href="{{url('wishlist')}}">
                                    <i class="far fa-heart"></i>
                                    @if(Auth::check()) <span class="item-counter">
                                        @php $totalWishLists= App\Helper\Helper::totalWishlistItems(); @endphp
                                        {{ $totalWishLists }}
                                    </span>
                                    @endif
                                </a>
                            </li>
                            <li>
                                <a id="mini-cart-trigger">
                                    <i class="ion ion-md-basket"></i>
                                    <span class="item-price">
                                        @php $totalcart= App\Helper\Helper::totalCartItems(); @endphp
                                        {{ $totalcart }}
                                    </span>
                                </a>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- Mid-Header /- -->
    <!-- Responsive-Buttons -->
    <div class="fixed-responsive-container">

        <div class="fixed-responsive-wrapper">
            <a href="{{url('wishlist')}}">
                <i class="far fa-heart"></i>
                @if(Auth::check())<span class="fixed-item-counter">{{ $totalWishLists }}</span>@endif
            </a>
        </div>
    </div>
    <!-- Responsive-Buttons /- -->
    <!-- Mini Cart -->
    @include('fontend.layout.min_cart')
    <!-- Mini Cart /- -->
    <!-- Bottom-Header -->
    <div class="full-layer-bottom-header" style="background-color: #1E665E;">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-3">
                    <div class="v-menu v-close ">
                        <span class="v-title ">
                            <i class="ion ion-md-menu"></i>
                            All Categories
                            <i class="fas fa-angle-down"></i>
                        </span>
                        <nav>
                            <div class="v-wrapper">
                                <ul class="v-list animated fadeIn">
                                    @foreach ($groups as $group)
                                    @if(count($group['categories']) > 0)
                                    <li class="js-backdrop">
                                        <a href="javascript:void();">
                                            <i class="ion ion-md-archive"></i>
                                            {{$group['name']}}
                                            <i class="ion ion-ios-arrow-forward"></i>
                                        </a>
                                        <button class="v-button ion ion-md-add"></button>
                                        <div class="v-drop-right" style="width: 700px;">
                                            <div class="row">
                                                @foreach ($group['categories'] as $category )
                                                <div class="col-lg-4">
                                                    <ul class="v-level-2">
                                                        <li>
                                                            <a href="{{ url($category['url']) }}">{{ $category['name'] }}</a>
                                                            <ul>
                                                                @foreach ($category['subcategories'] as $subcategory)
                                                                <li>
                                                                    <a href="{{ url($subcategory['url']) }}">{{ $subcategory['name'] }}</a>
                                                                </li>
                                                                @endforeach
                                                            </ul>
                                                        </li>
                                                    </ul>
                                                </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </li>
                                    @endif
                                    @endforeach
                                </ul>
                            </div>
                        </nav>
                    </div>
                </div>
                <div class="col-lg-9">
                    <ul class="bottom-nav g-nav u-d-none-lg text-white">
                        <li>
                            <a href="{{ url('/') }}">
                                Home
                            </a>
                        </li>

                        <li>
                            <a href="{{ url('contact') }}">Contact Us
                            </a>
                        </li>
                        <li>
                            <a href="{{ url('blogs') }}">Blogs
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('all-vendor') }}">
                                All Vendors
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('all-categories') }}">
                                All Categories
                            </a>
                        </li>

                    </ul>
                </div>
            </div>
        </div>
    </div>
    @include('sweetalert::alert')

</header>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    function currency_change(currency_code) {
        $.ajax({
            type: "POST"
            , url: "{{route('currency.load')}}"
            , data: {
                currency_code: currency_code
                , _token: '{{ csrf_token() }}'
            , }
            , success: function(response) {
                if (response['status']) {
                    location.reload();
                } else {
                    alert('Server | error');
                }
            }
        });
        // You can perform additional actions here based on the selected currency code
    }

</script>
<script>
    $(document).ready(function() {
        var isModalOpen = localStorage.getItem('isModalOpen');

        // Show the modal if the storage indicates it was open
        if (isModalOpen === 'true') {
            $('#exampleModal').modal('show');
        }

        // When the modal is shown, update the storage
        $('#exampleModal').on('shown.bs.modal', function() {
            localStorage.setItem('isModalOpen', 'true');
        });

        // When the modal is hidden, update the storage
        $('#exampleModal').on('hidden.bs.modal', function() {
            localStorage.setItem('isModalOpen', 'false');
        });

        // Open the modal when the button is clicked
        $('#customOrderButton').click(function() {
            $('#exampleModal').modal('show');
        });
    });

</script>
<script>
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }

</script>
<script type="text/javascript">
    $(document).ready(function() {
        var maxField = 10; //Input fields increment limitation
        var addButton = $('.add_button'); //Add button selector
        var wrapper = $('.field_wrapper'); //Input field wrapper
        var fieldHTML = '<div><div class="row"><div class="col-md-3"><input type="text" class="form-control mb-2" name="productname[]" placeholder="Product Name" ><input type="text" class="form-control mb-1" placeholder="Quantity" name="quantity[]" > </div> <div class="col-md-4 mb-1"> <textarea name="description[]" class="form-control" cols="20" rows="3" placeholder="Product description" ></textarea></div><div class="col-md-3 mb-1"><textarea name="delivery_address[]" class="form-control mb-1" cols="20" placeholder="Delivery address" rows="3" ></textarea></div><a  href="javascript:void(0);"  class="remove_button ion ion-md-trash"></a></div></div></div>'; //New input field html
        var x = 1; //Initial field counter is 1

        //Once add button is clicked
        $(addButton).click(function() {
            //Check maximum number of input fields
            if (x < maxField) {
                x++; //Increment field counter
                $(wrapper).append(fieldHTML); //Add field html
            }
        });

        //Once remove button is clicked
        $(wrapper).on('click', '.remove_button', function(e) {
            e.preventDefault();
            $(this).parent('div').remove(); //Remove field html
            x--; //Decrement field counter
        });
    });

</script>
{{-- <script>
    $(document).ready(function () {
        // Use AJAX to submit the form
        $('form[name=fast_orders]').submit(function (e) {
            e.preventDefault(); // Prevent the form from submitting the traditional way
            $('.text-danger').text('');
                $.ajax({
                    url: $(this).attr('action'), // Form action URL
                    type: 'POST', // Form submission type
                    data: new FormData(this), // Form data
                    processData: false,
                    contentType: false,
                    success: function (response) {
                        var successAlert = `
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <strong>Success!</strong> Order placed successfully.
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>`;
                        $('#alert-container').html(successAlert);
                    },
                    error: function (error) {
                        console.log('Error:', error);

                        if (error.status === 422) {
                            var errors = error.responseJSON.errors;
                            $.each(errors, function (key, value) {
                                // Check if the key contains array notation
                                if (key.includes("[]")) {
                                    // Remove the brackets to match the HTML element ID
                                    key = key.replace("[]", "");
                                }
                                $(`[name="${key}"]`).siblings('p.text-danger').text(value[0]);


                            });
                        } else {
                            alert("Something went wrong. Please try again.");
                        }
                    }

             });
        });
    });
</script> --}}

