<?php
use App\Models\Roles;

?>
<aside id="sidebar" class=" colored sidebar ">
    @php
    $user = Auth::guard('admin')->user();
    @endphp
    <ul class="sidebar-nav" id="sidebar-nav">
        @php
        $adminType = Auth::guard('admin')->user()->type;
        $role=Roles::where('name',$adminType)->first();
        @endphp
       @if ($role->group === "general")
        <div class="form-group mb-2">
            <label for="dashboardSwitcher">Switch Dashboard</label>
            <select class="form-control" style="background-color: #F6F9FF;color:#4154F1;" id="dashboardSwitcher">
                <option disabled>-- Choose Dashboard --</option>
                <option @if(request()->is('admin/dashboard')) selected @endif value="{{ url('admin/dashboard') }}">Ecommerce Dashboard</option>
                <option @if(request()->is('admin/restaurant*')) selected @endif value="{{ url('admin/restaurant/dashboard') }}">Restaurant Dashboard</option>
                <option @if(request()->is('admin/hotel*')) selected @endif value="{{ url('admin/hotel/dashboard') }}">Hotel Dashboard</option>
            </select>
        </div>

        <script>
            document.getElementById('dashboardSwitcher').addEventListener('change', function() {
                var url = this.value;
                if (url) {
                    window.location.href = url;
                }
            });
        </script>
        <hr>
        @endif

        @if ($role->group == "hotel")
        <li class=" {{ request()->is('admin/hotel/dashboard')?'nav-item active':'' }}">
        <a href="{{ url('admin/hotel/dashboard') }}" class="nav-link {{request()->is('admin/hotel/dashboard')}}"> <i class="bi bi-menu-button-fill"></i><span>Dashboard</span> </a>
        </li>
        @endif
        @if ($role->group == "restaurant")
        <li class=" {{ request()->is('admin/restaurant/dashboard')?'nav-item active':'' }}">
        <a href="{{ url('admin/restaurant/dashboard') }}" class="nav-link {{request()->is('admin/restaurant/dashboard')}}"> <i class="bi bi-menu-button-fill"></i><span>Dashboard</span> </a>
        </li>
        @endif
        @if($role->group == "ecomomerce")
        <li class=" {{ request()->is('admin/dashboard')?'nav-item active':'' }}">
           <a href="{{ url('admin/dashboard') }}" class="nav-link {{request()->is('admin/dashboard')}}"> <i class="bi bi-menu-button-fill"></i><span>Dashboard</span> </a>
        </li>
        @endif


        @adminCan('view_restaurant_banners')
            <li class="  {{ request()->is('admin/restaurant/slider-banners')?'nav-item active':'' }}">
                <a class="nav-link {{request()->is('admin/restaurant/slider-banners')}}" data-bs-target="#slider-nav" data-bs-toggle="collapse" href="javascripit:void(0);" aria-expanded="false"> <i class="bi bi-tag-fill"></i><span>Slider Managements</span><i class="bi bi-chevron-down  ms-auto"></i> </a>
                <ul id="slider-nav" class="nav-content collapse  {{ request()->is('admin/restaurant/slider-banners')?'show':'' }} " data-bs-parent="" style="">
                    {{-- @if ($user && $user->hasPermissionByRole('view_product')) --}}
                    <li> <a href="{{ route('slider-banners.index') }}" class=" {{ request()->is('admin/restaurant/slider-banners')?' nav-link active':'' }}"> <i class="bi bi-circle"></i><span>List of Slider Banners</span> </a></li>
                    {{-- @endif --}}
                </ul>
            </li>
@endadminCan

            @adminCan('view_restaurant_category')
            <li class=" {{ request()->is('admin/restaurant/categories')?'nav-item active':'' }}">
                <a class="nav-link  {{request()->is('admin/restaurant/categories')}}" data-bs-target="#categories-nav" data-bs-toggle="collapse" href="javascripit:void(0);" aria-expanded="false"> <i class="bi bi-tags-fill"></i><span>Category Managements</span><i class="bi bi-chevron-down  ms-auto"></i> </a>
                <ul id="categories-nav" class="nav-content collapse {{ request()->is('admin/restaurant/categories')?'show':'' }} " data-bs-parent="" style="">
                    {{-- @if ($user && $user->hasPermissionByRole('view_coupon')) --}}
                    <li> <a href="{{ url('admin/restaurant/categories') }}" class=" {{ request()->is('admin/restaurant/categories')?' nav-link active':'' }}"> <i class="bi bi-circle"></i><span>List of Categories</span> </a></li>
                    {{-- @endif --}}
                </ul>
            </li>
           @endadminCan
            @adminCan('view_restaurant_category')
            <li class=" {{ request()->is('admin/restaurant/subcategories')?'nav-item active':'' }}">
                <a class="nav-link  {{request()->is('admin/restaurant/subcategories')}}" data-bs-target="#subcategories-nav" data-bs-toggle="collapse" href="javascripit:void(0);" aria-expanded="false"> <i class="bi bi-tag-fill"></i><span>Sub Category Managements</span><i class="bi bi-chevron-down  ms-auto"></i> </a>
                <ul id="subcategories-nav" class="nav-content collapse {{ request()->is('admin/restaurant/subcategories')?'show':'' }} " data-bs-parent="" style="">
                    {{-- @if ($user && $user->hasPermissionByRole('view_coupon')) --}}
                    <li> <a href="{{ url('admin/restaurant/subcategories') }}" class=" {{ request()->is('admin/restaurant/subcategories')?' nav-link active':'' }}"> <i class="bi bi-circle"></i><span>List of Sub Categories</span> </a></li>
                    {{-- @endif --}}
                </ul>
            </li>
            @endadminCan
            @adminCan('view_restaurant_restaurant_menu')
            <li class=" {{ request()->is('admin/restaurant/menus')?'nav-item active':'' }}">
                <a class="nav-link  {{request()->is('admin/restaurant/menus')}}" data-bs-target="#menus-nav" data-bs-toggle="collapse" href="javascripit:void(0);" aria-expanded="false"> <i class="bi bi-list-check"></i><span>Menus Managements</span><i class="bi bi-chevron-down  ms-auto"></i> </a>
                <ul id="menus-nav" class="nav-content collapse {{ request()->is('admin/restaurant/menus')?'show':'' }} " data-bs-parent="" style="">
                    {{-- @if ($user && $user->hasPermissionByRole('view_coupon')) --}}
                    <li> <a href="{{ url('admin/restaurant/menus') }}" class=" {{ request()->is('admin/restaurant/menus')?' nav-link active':'' }}"> <i class="bi bi-circle"></i><span>List of Menus</span> </a></li>
                    {{-- @endif --}}
                </ul>
            </li>
            @endadminCan

            @adminCan('view_restaurant_coupon')
            <li class=" {{ request()->is('admin/restaurant/coupons')?'nav-item active':'' }}">
                <a class="nav-link  {{request()->is('admin/restaurant/coupons')}}" data-bs-target="#coupons-nav" data-bs-toggle="collapse" href="javascripit:void(0);" aria-expanded="false"> <i class="bi bi-tag"></i><span>Coupon Managements</span><i class="bi bi-chevron-down  ms-auto"></i> </a>
                <ul id="coupons-nav" class="nav-content collapse {{ request()->is('admin/restaurant/coupons')?'show':'' }} " data-bs-parent="" style="">
                    {{-- @if ($user && $user->hasPermissionByRole('view_coupon')) --}}
                    <li> <a href="{{ route('coupons.index') }}" class=" {{ request()->is('admin/restaurant/coupons')?' nav-link active':'' }}"> <i class="bi bi-circle"></i><span>List of Coupon</span> </a></li>
                    {{-- @endif --}}
                </ul>
            </li>
            @endadminCan



            @adminCan('view_restaurant_product')
            <li class=" {{ request()->is('admin/restaurant/products')?'nav-item active':'' }}">
                <a class="nav-link  {{request()->is('admin/restaurant/products')}}" data-bs-target="#produts-nav" data-bs-toggle="collapse" href="javascripit:void(0);" aria-expanded="false"> <i class="bi bi-box"></i><span>Product Managements</span><i class="bi bi-chevron-down  ms-auto"></i> </a>
                <ul id="produts-nav" class="nav-content collapse {{ request()->is('admin/restaurant/products')?'show':'' }} " data-bs-parent="" style="">
                    {{-- @if ($user && $user->hasPermissionByRole('view_coupon')) --}}
                    <li> <a href="{{ route('products.index') }}" class=" {{ request()->is('admin/restaurant/products')?' nav-link active':'' }}"> <i class="bi bi-circle"></i><span>List of Products</span> </a></li>
                    {{-- @endif --}}
                </ul>
            </li>
            @endadminCan


            @adminCan('view_restaurant_restaurant')
               <li class=" {{ request()->is('admin/restaurant/restaurants')?'nav-item active':'' }}">
                <a class="nav-link  {{request()->is('admin/restaurant/restaurants')}}" data-bs-target="#restaurantes-nav" data-bs-toggle="collapse" href="javascripit:void(0);" aria-expanded="false"> <i class="bi bi-house-fill"></i><span>Restaurant Managements</span><i class="bi bi-chevron-down  ms-auto"></i> </a>
                <ul id="restaurantes-nav" class="nav-content collapse {{ request()->is('admin/restaurant/restaurants')?'show':'' }} " data-bs-parent="" style="">
                    <li> <a href="{{ route('restaurants.index') }}" class=" {{ request()->is('admin/restaurant/restaurants')?' nav-link active':'' }}"> <i class="bi bi-circle"></i><span>List of Restaurants</span> </a></li>
                </ul>
            </li>
            @endadminCan

            @adminCan('view_restaurant_order')
              <li class=" {{ request()->is('admin/restaurant/order*')?'nav-item active':'' }}">
                <a class="nav-link  {{request()->is('admin/restaurant/order*')}}" data-bs-target="#order_produts-nav" data-bs-toggle="collapse" href="javascripit:void(0);" aria-expanded="false"> <i class="bi bi-box"></i><span>Orders Managements</span><i class="bi bi-chevron-down ms-auto"></i> </a>
                <ul id="order_produts-nav" class="nav-content collapse {{ request()->is('admin/restaurant/order*')?'show':'' }} " data-bs-parent="" style="">
                    <li> <a href="{{ route('restaurant.orders.index') }}" class=" {{ request()->is('admin/restaurant/order*')?' nav-link active':'' }}"> <i class="bi bi-circle"></i><span>List of Orders</span> </a></li>
                </ul>
              </li>
            @endadminCan

              @adminCan('manage_call_center')
              <li class=" {{ request()->is('admin/restaurant/call-center/new-orde*')?'nav-item active':'' }}">
                <a class="nav-link  {{request()->is('admin/restaurant/call-center/new-orde*')}}" data-bs-target="#call_center-nav" data-bs-toggle="collapse" href="javascripit:void(0);" aria-expanded="false"> <i class="bi bi-phone-vibrate-fill"></i><span>Call Center</span><i class="bi bi-chevron-down ms-auto"></i> </a>
                <ul id="call_center-nav" class="nav-content collapse {{ request()->is('admin/restaurant/call-center/new-orde*')?'show':'' }} " data-bs-parent="" style="">
                    <li> <a href="{{ url('admin/restaurant/call-center/new-order') }}" class=" {{ request()->is('admin/restaurant/call-center/new-orde*')?' nav-link active':'' }}"> <i class="bi bi-circle"></i><span>Create Order</span> </a></li>
                </ul>
              </li>
            @endadminCan
            <br>
              <li class="{{ request()->is('admin/restaurantvendor/wallet')?'nav-item active':'' }}">
                <a class="nav-link" data-bs-target="#withdrawal-nav" data-bs-toggle="collapse" href="javascripit:void(0);">
                    <svg id='Withdrawal_16' width='24' height='24' viewBox='0 0 16 16' xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink'><rect width='16' height='16' stroke='none' fill='#000000' opacity='0'/>
                        <g transform="matrix(0.5 0 0 0.5 8 8)" >
                        <g style="" >
                        <g transform="matrix(1 0 0 1 0 1)" >
                        <path style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-dashoffset: 0; stroke-linejoin: miter; stroke-miterlimit: 4; fill: #4154F1; fill-rule: nonzero; opacity: 0.3;" transform=" translate(-12, -13)" d="M 12 9 C 9.790861000676827 9 8 10.790861000676827 8 13 C 8 15.209138999323173 9.790861000676827 17 12 17 C 14.209138999323173 17 16 15.209138999323173 16 13 C 16 10.790861000676827 14.209138999323173 9 12 9 Z" stroke-linecap="round" />
                        </g>
                        <g transform="matrix(1 0 0 1 0 -0.5)" >
                        <path style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-dashoffset: 0; stroke-linejoin: miter; stroke-miterlimit: 4; fill: #4154F1; fill-rule: nonzero; opacity: 1;" transform=" translate(-12, -11.5)" d="M 8 6 L 12 2 L 16 6 z M 20 8 L 20 19 L 4 19 L 4 8 L 2 8 L 2 19 C 2 20.103 2.8970000000000002 21 4 21 L 20 21 C 21.103 21 22 20.103 22 19 L 22 8 L 20 8 z" stroke-linecap="round" />
                        </g>
                        <g transform="matrix(1 0 0 1 0 1)" >
                        <path style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-dashoffset: 0; stroke-linejoin: miter; stroke-miterlimit: 4; fill: #4154F1; fill-rule: nonzero; opacity: 1;" transform=" translate(-12, -13)" d="M 12 8 C 9.239 8 7 10.239 7 13 C 7 15.761 9.239 18 12 18 C 14.761 18 17 15.761 17 13 C 17 10.239 14.761 8 12 8 z M 12 16 C 10.343 16 9 14.657 9 13 C 9 11.343 10.343 10 12 10 C 13.657 10 15 11.343 15 13 C 15 14.657 13.657 16 12 16 z" stroke-linecap="round" />
                        </g>
                        <g transform="matrix(1 0 0 1 -0.41 1)" >
                        <path style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-dashoffset: 0; stroke-linejoin: miter; stroke-miterlimit: 4; fill: #4154F1; fill-rule: nonzero; opacity: 1;" transform=" translate(-11.59, -13)" d="M 12.408 11 L 10.509 11.777 L 10.509 12.814 L 11.303 12.507 L 11.303 15 L 12.663 15 L 12.663 11 z" stroke-linecap="round" />
                        </g>
                        </g>
                        </g>
                    </svg>
                    <span>Your Wallet</span><i class="bi bi-chevron-down ms-auto"></i> </a>
                <ul id="withdrawal-nav" class="nav-content collapse {{ request()->is('admin/restaurant/vendor/wallet')?'show':'' }}" data-bs-parent="#sidebar-nav">
                    <li> <a href="{{ url('admin/restaurant/vendor/wallet') }}" class="{{ request()->is('admin/restaurant/vendor/wallet')?'nav-link active':'' }}"> <i class=" bi bi-circle active"></i><span>Your Wallet</span></a></li>
                </ul>
            </li>
            <li class="nav-heading">My Settings</li>
            <li class=" {{ request()->is('admin/update_admin_password')?'nav-item active':'' }} {{ request()->is('admin/updateadmindetails')?'nav-item active':'' }} ">
                <a class="nav-link" data-bs-target="#settings-nav" data-bs-toggle="collapse" href="javascripit:void(0);"> <i class="bi bi-person-bounding-box  "></i><span>My Profile</span><i class="bi bi-chevron-down ms-auto"></i> </a>
                <ul id="settings-nav" class="nav-content collapse  {{ request()->is('admin/update_admin_password')?'show':'' }}  {{ request()->is('admin/updateadmindetails')?'show':'' }}" data-bs-parent="#sidebar-nav">
                    <li> <a href="{{ route('update_admin_password') }}" class="{{ request()->is('admin/update_admin_password*')?'nav-link active':'' }}"> <i class=" bi bi-circle active "></i><span>Update Password</span> </a></li>
                    <li> <a href="{{ route('updateadmindetails') }}" class="{{ request()->is('admin/updateadmindetails*')?'nav-link active':'' }}"> <i class="bi bi-circle"></i><span>Update Details</span></a></li>
                </ul>
            </li>
            @if(Auth::guard('admin')->user()->type==="Restaurant Manager")
            <li class="{{ request()->is('admin/hotel/update-vendor-details')?'nav-item active':'' }} {{ request()->is('admin/hotel/update-vendor-bank-details')?'nav-item active':'' }} {{ request()->is('admin/hotel/update-vendor-business-details')?'nav-item active':'' }}">
                <a class="nav-link " data-bs-target="#vendordetails-nav" data-bs-toggle="collapse" href="javascripit:void(0);"> <i class="bi bi-person-badge"></i><span>My Details</span><i class="bi bi-chevron-down ms-auto"></i> </a>
                <ul id="vendordetails-nav" class=" nav-content collapse {{ request()->is('admin/hotel/update-vendor-details')?'show':'' }} {{ request()->is('admin/hotel/update-vendor-bank-details')?'show':'' }} {{ request()->is('admin/hotel/update-vendor-business-details')?'show':'' }}" data-bs-parent="#sidebar-nav">
                    <li> <a href="{{ route('restaurant.updatevendordetails') }}" class="{{ request()->is('admin/restaurant/update-vendor-details*')?'nav-link active':'' }}"> <i class=" bi bi-circle active "></i><span>Personal Details</span> </a></li>
                    <li> <a href="{{ route('restaurant.updatevendorbankdetails') }}" class="{{ request()->is('admin/restaurant/update-vendor-bank-details*')?'nav-link active':'' }}"> <i class="bi bi-circle"></i><span>Bank Details</span></a></li>
                </ul>
            </li>
            @endif
    </ul>
</aside>

