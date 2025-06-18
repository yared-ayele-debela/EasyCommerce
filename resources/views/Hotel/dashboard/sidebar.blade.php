<?php

?>
<aside id="sidebar" class=" colored sidebar ">
    @php
    $user = Auth::guard('admin')->user();
    @endphp
    <ul class="sidebar-nav" id="sidebar-nav">

        @php
        $adminType = Auth::guard('admin')->user()->type;
        @endphp
       @if ($adminType === "Super Admin" || $adminType === "admin")
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
        @if ($adminType === "Hotel Manager")
        <li class=" {{ request()->is('admin/hotel/dashboard')?'nav-item active':'' }}">
        <a href="{{ url('admin/hotel/dashboard') }}" class="nav-link {{request()->is('admin/hotel/dashboard')}}"> <i class="bi bi-menu-button-fill"></i><span>Dashboard</span> </a>
        </li>
        @endif
        @if ($adminType === "Restaurant Manager")
        <li class=" {{ request()->is('admin/restaurant/dashboard')?'nav-item active':'' }}">
        <a href="{{ url('admin/restaurant/dashboard') }}" class="nav-link {{request()->is('admin/restaurant/dashboard')}}"> <i class="bi bi-menu-button-fill"></i><span>Dashboard</span> </a>
        </li>
        @endif
        @if($adminType === "Ecomomerce Manager" || $adminType === "vendor")
        <li class=" {{ request()->is('admin/dashboard')?'nav-item active':'' }}">
           <a href="{{ url('admin/dashboard') }}" class="nav-link {{request()->is('admin/dashboard')}}"> <i class="bi bi-menu-button-fill"></i><span>Dashboard</span> </a>
        </li>
        @endif


            @adminCan('view_hotel_slider')
            <li class="  {{ request()->is('admin/hotel/hotel-slider-banners')?'nav-item active':'' }}">
                <a class="nav-link {{request()->is('admin/hotel/hotel-slider-banners')}}" data-bs-target="#hotel-slider-banners-nav" data-bs-toggle="collapse" href="javascripit:void(0);" aria-expanded="false"> <i class="bi bi-image"></i><span>Hotel Banners Managements</span><i class="bi bi-chevron-down  ms-auto"></i> </a>
                <ul id="hotel-slider-banners-nav" class="nav-content collapse  {{ request()->is('admin/hotel/hotel-slider-banners')?'show':'' }} " data-bs-parent="" style="">
                    {{-- @if ($user && $user->hasPermissionByRole('view_product')) --}}
                    <li> <a href="{{ route('hotel-slider-banners.index') }}" class=" {{ request()->is('admin/hotel/hotel-slider-banners')?' nav-link active':'' }}"> <i class="bi bi-circle"></i><span>List of Banners</span> </a></li>
                    {{-- @endif --}}
                </ul>
            </li>
            @endadminCan

            @adminCan('view_hotel_amenity')
            <li class="  {{ request()->is('admin/hotel/amenities')?'nav-item active':'' }}">
                <a class="nav-link {{request()->is('admin/hotel/amenities')}}" data-bs-target="#amenities-nav" data-bs-toggle="collapse" href="javascripit:void(0);" aria-expanded="false"> <i class="bi bi-command"></i><span>Amenities Managements</span><i class="bi bi-chevron-down  ms-auto"></i> </a>
                <ul id="amenities-nav" class="nav-content collapse  {{ request()->is('admin/hotel/amenities')?'show':'' }} " data-bs-parent="" style="">
                    {{-- @if ($user && $user->hasPermissionByRole('view_product')) --}}
                    <li> <a href="{{ route('amenities.index') }}" class=" {{ request()->is('admin/hotel/amenities')?' nav-link active':'' }}"> <i class="bi bi-circle"></i><span>List of Amenities</span> </a></li>
                    {{-- @endif --}}
                </ul>
            </li>
            @endadminCan
            @adminCan('view_hotel_coupon')
            <li class="{{ request()->is('admin/hotel/coupons')?'nav-item active':'' }}">
                <a class="nav-link {{request()->is('admin/hotel/coupons')}}" data-bs-target="#coupons-nav" data-bs-toggle="collapse" href="javascripit:void(0);" aria-expanded="false"> <i class="bi bi-cart-dash"></i><span>Coupon Managements</span><i class="bi bi-chevron-down  ms-auto"></i> </a>
                <ul id="coupons-nav" class="nav-content collapse  {{ request()->is('admin/hotel/coupons')?'show':'' }} " data-bs-parent="" style="">
                    {{-- @if ($user && $user->hasPermissionByRole('view_product')) --}}
                    <li> <a href="{{ route('hotel.coupon.index') }}" class=" {{ request()->is('admin/hotel/coupons')?' nav-link active':'' }}"> <i class="bi bi-circle"></i><span>List of Coupons</span> </a></li>
                    {{-- @endif --}}
                </ul>
            </li>
@endadminCan
            @adminCan('view_hotel_hotel_category')
            <li class="{{ request()->is('admin/hotel/hotel-categories')?'nav-item active':'' }}">
                <a class="nav-link {{request()->is('admin/hotel/hotel-categories')}}" data-bs-target="#hotel-categories-nav" data-bs-toggle="collapse" href="javascripit:void(0);" aria-expanded="false"> <i class="bi bi-bookmark"></i><span>Hotel Categories Managements</span><i class="bi bi-chevron-down  ms-auto"></i> </a>
                <ul id="hotel-categories-nav" class="nav-content collapse  {{ request()->is('admin/hotel/hotel-categories')?'show':'' }} " data-bs-parent="" style="">
                    {{-- @if ($user && $user->hasPermissionByRole('view_product')) --}}
                    <li> <a href="{{ route('hotel-categories.index') }}" class=" {{ request()->is('admin/hotel/hotel-categories')?' nav-link active':'' }}"> <i class="bi bi-circle"></i><span>List of Hotel Categories</span> </a></li>
                    {{-- @endif --}}
                </ul>
            </li>
@endadminCan
            @adminCan('view_hotel_hotel')
            <li class="{{ request()->is('admin/hotels')?'nav-item active':'' }}">
                <a class="nav-link {{request()->is('admin/hotels')}}" data-bs-target="#nav-hotelss" data-bs-toggle="collapse" href="javascripit:void(0);" aria-expanded="false"> <i class="bi bi-building"></i><span>Hotels Management</span><i class="bi bi-chevron-down  ms-auto"></i> </a>
                <ul id="nav-hotelss" class="nav-content collapse  {{ request()->is('admin/hotels')?'show':'' }} " data-bs-parent="" style="">
                    {{-- @if ($user && $user->hasPermissionByRole('view_product')) --}}
                    <li> <a href="{{ route('hotels.index') }}" class=" {{ request()->is('admin/hotels')?' nav-link active':'' }}"> <i class="bi bi-circle"></i><span>List of Hotels</span> </a></li>
                    {{-- @endif --}}
                </ul>
            </li>
            @endadminCan
            @adminCan('view_hotel_room')
            <li class="{{ request()->is('admin/hotel/rooms')?'nav-item active':'' }}">
                <a class="nav-link {{request()->is('admin/hotel/rooms')}}" data-bs-target="#nav-hotell" data-bs-toggle="collapse" href="javascripit:void(0);" aria-expanded="false"> <i class="bi bi-door-open"></i><span>Rooms Management</span><i class="bi bi-chevron-down  ms-auto"></i> </a>
                <ul id="nav-hotell" class="nav-content collapse  {{ request()->is('admin/hotel/rooms')?'show':'' }} " data-bs-parent="" style="">
                    {{-- @if ($user && $user->hasPermissionByRole('view_product')) --}}
                    <li> <a href="{{ route('rooms.index') }}" class=" {{ request()->is('admin/hotel/rooms')?' nav-link active':'' }}"> <i class="bi bi-circle"></i><span>List of Rooms</span> </a></li>
                    {{-- @endif --}}
                </ul>
            </li>
            @endadminCan
                       @adminCan('view_hotel_reservation')

            <li class="{{ request()->is('admin/hotel/reservation*')?'nav-item active':'' }}">
                <a class="nav-link {{request()->is('admin/hotel/reservation*')}}" data-bs-target="#nav-hotel-re" data-bs-toggle="collapse" href="javascripit:void(0);" aria-expanded="false"> <i class="bi bi-calendar3-event"></i><span>Reservations Management</span><i class="bi bi-chevron-down  ms-auto"></i> </a>
                <ul id="nav-hotel-re" class="nav-content collapse  {{ request()->is('admin/hotel/reservation*')?'show':'' }} " data-bs-parent="" style="">
                    {{-- @if ($user && $user->hasPermissionByRole('view_product')) --}}
                    <li> <a href="{{ route('reservations.index') }}" class=" {{ request()->is('admin/hotel/reservation*')?' nav-link active':'' }}"> <i class="bi bi-circle"></i><span>List of Reservations</span> </a></li>
                    {{-- @endif --}}
                </ul>
            </li>
            @endadminCan

            <br>

              <li class="{{ request()->is('admin/hotel/vendor/wallet')?'nav-item active':'' }}">
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
                <ul id="withdrawal-nav" class="nav-content collapse {{ request()->is('admin/hotel/vendor/wallet')?'show':'' }}" data-bs-parent="#sidebar-nav">
                    <li> <a href="{{ url('admin/hotel/vendor/wallet') }}" class="{{ request()->is('admin/hotel/vendor/wallet')?'nav-link active':'' }}"> <i class=" bi bi-circle active"></i><span>Your Wallet</span></a></li>
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
             @if(Auth::guard('admin')->user()->type=="Hotel Manager")
            <li class="{{ request()->is('admin/hotel/update-vendor-details')?'nav-item active':'' }} {{ request()->is('admin/hotel/update-vendor-bank-details')?'nav-item active':'' }} {{ request()->is('admin/hotel/update-vendor-business-details')?'nav-item active':'' }}">
                <a class="nav-link " data-bs-target="#vendordetails-nav" data-bs-toggle="collapse" href="javascripit:void(0);"> <i class="bi bi-person-badge"></i><span>My Details</span><i class="bi bi-chevron-down ms-auto"></i> </a>
                <ul id="vendordetails-nav" class=" nav-content collapse {{ request()->is('admin/hotel/update-vendor-details')?'show':'' }} {{ request()->is('admin/hotel/update-vendor-bank-details')?'show':'' }} {{ request()->is('admin/hotel/update-vendor-business-details')?'show':'' }}" data-bs-parent="#sidebar-nav">
                    <li> <a href="{{ route('hotel.updatevendordetails') }}" class="{{ request()->is('admin/hotel/update-vendor-details*')?'nav-link active':'' }}"> <i class=" bi bi-circle active "></i><span>Personal Details</span> </a></li>
                    <li> <a href="{{ route('hotel.updatevendorbankdetails') }}" class="{{ request()->is('admin/hotel/update-vendor-bank-details*')?'nav-link active':'' }}"> <i class="bi bi-circle"></i><span>Bank Details</span></a></li>
                </ul>
            </li>
            @endif
    </ul>
</aside>

