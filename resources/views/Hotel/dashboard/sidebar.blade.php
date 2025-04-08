<?php

?>
<aside id="sidebar" class=" colored sidebar ">
    @php
    $user = Auth::guard('admin')->user();
    @endphp
    <ul class="sidebar-nav" id="sidebar-nav">

        <li class="nav-item"> <a class="nav-link" href="{{ url('admin/hotel/dashboard') }}"> <i class="bi bi-bank "></i> <span>Hotel Dashboard</span> </a></li>

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

            <li class=" {{ request()->is('admin/hotel/my-hotel')?'nav-item active':'' }} " >
                <a href="{{ url('admin/hotel/my-hotel') }}" class="nav-link" > <i class="bi bi-house-fill"></i><span>My Hotel</span></a>
            </li>

    </ul>
</aside>

