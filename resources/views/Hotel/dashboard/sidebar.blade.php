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
        @if ($adminType === "Super Admin")
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


           {{-- @if ($user && $user->hasPermissionByRole('view_product')) --}}
            <li class="  {{ request()->is('admin/hotel/hotel-slider-banners')?'nav-item active':'' }}">
                <a class="nav-link {{request()->is('admin/hotel/hotel-slider-banners')}}" data-bs-target="#hotel-slider-banners-nav" data-bs-toggle="collapse" href="javascripit:void(0);" aria-expanded="false"> <i class="bi bi-image"></i><span>Hotel Banners Managements</span><i class="bi bi-chevron-down  ms-auto"></i> </a>
                <ul id="hotel-slider-banners-nav" class="nav-content collapse  {{ request()->is('admin/hotel/hotel-slider-banners')?'show':'' }} " data-bs-parent="" style="">
                    {{-- @if ($user && $user->hasPermissionByRole('view_product')) --}}
                    <li> <a href="{{ route('hotel-slider-banners.index') }}" class=" {{ request()->is('admin/hotel/hotel-slider-banners')?' nav-link active':'' }}"> <i class="bi bi-circle"></i><span>List of Banners</span> </a></li>
                    {{-- @endif --}}
                </ul>
            </li>
            {{-- @endif --}}

            {{-- @if ($user && $user->hasPermissionByRole('view_product')) --}}
            <li class="  {{ request()->is('admin/hotel/amenities')?'nav-item active':'' }}">
                <a class="nav-link {{request()->is('admin/hotel/amenities')}}" data-bs-target="#amenities-nav" data-bs-toggle="collapse" href="javascripit:void(0);" aria-expanded="false"> <i class="bi bi-command"></i><span>Amenities Managements</span><i class="bi bi-chevron-down  ms-auto"></i> </a>
                <ul id="amenities-nav" class="nav-content collapse  {{ request()->is('admin/hotel/amenities')?'show':'' }} " data-bs-parent="" style="">
                    {{-- @if ($user && $user->hasPermissionByRole('view_product')) --}}
                    <li> <a href="{{ route('amenities.index') }}" class=" {{ request()->is('admin/hotel/amenities')?' nav-link active':'' }}"> <i class="bi bi-circle"></i><span>List of Amenities</span> </a></li>
                    {{-- @endif --}}
                </ul>
            </li>
            {{-- @endif --}}
            {{-- @if ($user && $user->hasPermissionByRole('view_product')) --}}
            <li class="  {{ request()->is('admin/hotel/coupons')?'nav-item active':'' }}">
                <a class="nav-link {{request()->is('admin/hotel/coupons')}}" data-bs-target="#coupons-nav" data-bs-toggle="collapse" href="javascripit:void(0);" aria-expanded="false"> <i class="bi bi-cart-dash"></i><span>Coupon Managements</span><i class="bi bi-chevron-down  ms-auto"></i> </a>
                <ul id="coupons-nav" class="nav-content collapse  {{ request()->is('admin/hotel/coupons')?'show':'' }} " data-bs-parent="" style="">
                    {{-- @if ($user && $user->hasPermissionByRole('view_product')) --}}
                    <li> <a href="{{ route('hotel.coupon.index') }}" class=" {{ request()->is('admin/hotel/coupons')?' nav-link active':'' }}"> <i class="bi bi-circle"></i><span>List of Coupons</span> </a></li>
                    {{-- @endif --}}
                </ul>
            </li>
            {{-- @endif --}}

           {{-- @if ($user && $user->hasPermissionByRole('view_product')) --}}
            <li class="{{ request()->is('admin/hotel/hotel-categories')?'nav-item active':'' }}">
                <a class="nav-link {{request()->is('admin/hotel/hotel-categories')}}" data-bs-target="#hotel-categories-nav" data-bs-toggle="collapse" href="javascripit:void(0);" aria-expanded="false"> <i class="bi bi-bookmark"></i><span>Hotel Categories Managements</span><i class="bi bi-chevron-down  ms-auto"></i> </a>
                <ul id="hotel-categories-nav" class="nav-content collapse  {{ request()->is('admin/hotel/hotel-categories')?'show':'' }} " data-bs-parent="" style="">
                    {{-- @if ($user && $user->hasPermissionByRole('view_product')) --}}
                    <li> <a href="{{ route('hotel-categories.index') }}" class=" {{ request()->is('admin/hotel/hotel-categories')?' nav-link active':'' }}"> <i class="bi bi-circle"></i><span>List of Hotel Categories</span> </a></li>
                    {{-- @endif --}}
                </ul>
            </li>
            {{-- @endif --}}
           {{-- @if ($user && $user->hasPermissionByRole('view_product')) --}}
            <li class="{{ request()->is('admin/hotels')?'nav-item active':'' }}">
                <a class="nav-link {{request()->is('admin/hotels')}}" data-bs-target="#nav-hotelss" data-bs-toggle="collapse" href="javascripit:void(0);" aria-expanded="false"> <i class="bi bi-building"></i><span>Hotels Management</span><i class="bi bi-chevron-down  ms-auto"></i> </a>
                <ul id="nav-hotelss" class="nav-content collapse  {{ request()->is('admin/hotels')?'show':'' }} " data-bs-parent="" style="">
                    {{-- @if ($user && $user->hasPermissionByRole('view_product')) --}}
                    <li> <a href="{{ route('hotels.index') }}" class=" {{ request()->is('admin/hotels')?' nav-link active':'' }}"> <i class="bi bi-circle"></i><span>List of Hotels</span> </a></li>
                    {{-- @endif --}}
                </ul>
            </li>
            {{-- @endif --}}
           {{-- @if ($user && $user->hasPermissionByRole('view_product')) --}}
            <li class="{{ request()->is('admin/hotel/rooms')?'nav-item active':'' }}">
                <a class="nav-link {{request()->is('admin/hotel/rooms')}}" data-bs-target="#nav-hotell" data-bs-toggle="collapse" href="javascripit:void(0);" aria-expanded="false"> <i class="bi bi-door-open"></i><span>Rooms Management</span><i class="bi bi-chevron-down  ms-auto"></i> </a>
                <ul id="nav-hotell" class="nav-content collapse  {{ request()->is('admin/hotel/rooms')?'show':'' }} " data-bs-parent="" style="">
                    {{-- @if ($user && $user->hasPermissionByRole('view_product')) --}}
                    <li> <a href="{{ route('rooms.index') }}" class=" {{ request()->is('admin/hotel/rooms')?' nav-link active':'' }}"> <i class="bi bi-circle"></i><span>List of Rooms</span> </a></li>
                    {{-- @endif --}}
                </ul>
            </li>
            {{-- @endif --}}
           {{-- @if ($user && $user->hasPermissionByRole('view_product')) --}}
            <li class="{{ request()->is('admin/hotel/reservation*')?'nav-item active':'' }}">
                <a class="nav-link {{request()->is('admin/hotel/reservation*')}}" data-bs-target="#nav-hotel-re" data-bs-toggle="collapse" href="javascripit:void(0);" aria-expanded="false"> <i class="bi bi-calendar3-event"></i><span>Reservations Management</span><i class="bi bi-chevron-down  ms-auto"></i> </a>
                <ul id="nav-hotel-re" class="nav-content collapse  {{ request()->is('admin/hotel/reservation*')?'show':'' }} " data-bs-parent="" style="">
                    {{-- @if ($user && $user->hasPermissionByRole('view_product')) --}}
                    <li> <a href="{{ route('reservations.index') }}" class=" {{ request()->is('admin/hotel/reservation*')?' nav-link active':'' }}"> <i class="bi bi-circle"></i><span>List of Reservations</span> </a></li>
                    {{-- @endif --}}
                </ul>
            </li>
            {{-- @endif --}}

            <br>

            {{-- <li class=" {{ request()->is('admin/hotel/my-hotel')?'nav-item active':'' }} " >
                <a href="{{ url('admin/hotel/my-hotel') }}" class="nav-link" > <i class="bi bi-house-fill"></i><span>My Hotel</span></a>
            </li> --}}
            <li class="nav-heading">My Settings</li>
            <li class=" {{ request()->is('admin/update_admin_password')?'nav-item active':'' }} {{ request()->is('admin/updateadmindetails')?'nav-item active':'' }} ">
                <a class="nav-link" data-bs-target="#settings-nav" data-bs-toggle="collapse" href="javascripit:void(0);"> <i class="bi bi-person-bounding-box  "></i><span>My Profile</span><i class="bi bi-chevron-down ms-auto"></i> </a>
                <ul id="settings-nav" class="nav-content collapse  {{ request()->is('admin/update_admin_password')?'show':'' }}  {{ request()->is('admin/updateadmindetails')?'show':'' }}" data-bs-parent="#sidebar-nav">
                    <li> <a href="{{ route('update_admin_password') }}" class="{{ request()->is('admin/update_admin_password*')?'nav-link active':'' }}"> <i class=" bi bi-circle active "></i><span>Update Password</span> </a></li>
                    <li> <a href="{{ route('updateadmindetails') }}" class="{{ request()->is('admin/updateadmindetails*')?'nav-link active':'' }}"> <i class="bi bi-circle"></i><span>Update Details</span></a></li>
                </ul>
            </li>
    </ul>
</aside>

