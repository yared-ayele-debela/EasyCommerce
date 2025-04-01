<?php

?>
<aside id="sidebar" class=" colored sidebar ">
    @php
    $user = Auth::guard('admin')->user();
    @endphp
    <ul class="sidebar-nav" id="sidebar-nav">

        <li class="nav-item"> <a class="nav-link" href="{{ url('admin/restaurant/dashboard') }}"> <i class="bi bi-bank "></i> <span>Restaurant Dashboard</span> </a></li>

           {{-- @if ($user && $user->hasPermissionByRole('view_product')) --}}
            <li class="  {{ request()->is('admin/restaurant/slider-banners')?'nav-item active':'' }}">
                <a class="nav-link {{request()->is('admin/restaurant/slider-banners')}}" data-bs-target="#slider-nav" data-bs-toggle="collapse" href="javascripit:void(0);" aria-expanded="false"> <i class="bi bi-tag-fill"></i><span>Slider Managements</span><i class="bi bi-chevron-down  ms-auto"></i> </a>
                <ul id="slider-nav" class="nav-content collapse  {{ request()->is('admin/restaurant/slider-banners')?'show':'' }} " data-bs-parent="" style="">
                    {{-- @if ($user && $user->hasPermissionByRole('view_product')) --}}
                    <li> <a href="{{ route('slider-banners.index') }}" class=" {{ request()->is('admin/restaurant/slider-banners')?' nav-link active':'' }}"> <i class="bi bi-circle"></i><span>List of Slider Banners</span> </a></li>
                    {{-- @endif --}}
                </ul>
            </li>
            {{-- @endif --}}


            {{-- @if ($user && $user->hasPermissionByRole('view_coupon')) --}}
            <li class=" {{ request()->is('admin/restaurant/categories')?'nav-item active':'' }}">
                <a class="nav-link  {{request()->is('admin/restaurant/categories')}}" data-bs-target="#categories-nav" data-bs-toggle="collapse" href="javascripit:void(0);" aria-expanded="false"> <i class="bi bi-tags-fill"></i><span>Category Managements</span><i class="bi bi-chevron-down  ms-auto"></i> </a>
                <ul id="categories-nav" class="nav-content collapse {{ request()->is('admin/restaurant/categories')?'show':'' }} " data-bs-parent="" style="">
                    {{-- @if ($user && $user->hasPermissionByRole('view_coupon')) --}}
                    <li> <a href="{{ url('admin/restaurant/categories') }}" class=" {{ request()->is('admin/restaurant/categories')?' nav-link active':'' }}"> <i class="bi bi-circle"></i><span>List of Categories</span> </a></li>
                    {{-- @endif --}}
                </ul>
            </li>
            {{-- @endif --}}
            {{-- @if ($user && $user->hasPermissionByRole('view_coupon')) --}}
            <li class=" {{ request()->is('admin/restaurant/subcategories')?'nav-item active':'' }}">
                <a class="nav-link  {{request()->is('admin/restaurant/subcategories')}}" data-bs-target="#subcategories-nav" data-bs-toggle="collapse" href="javascripit:void(0);" aria-expanded="false"> <i class="bi bi-tag-fill"></i><span>Sub Category Managements</span><i class="bi bi-chevron-down  ms-auto"></i> </a>
                <ul id="subcategories-nav" class="nav-content collapse {{ request()->is('admin/restaurant/subcategories')?'show':'' }} " data-bs-parent="" style="">
                    {{-- @if ($user && $user->hasPermissionByRole('view_coupon')) --}}
                    <li> <a href="{{ url('admin/restaurant/subcategories') }}" class=" {{ request()->is('admin/restaurant/subcategories')?' nav-link active':'' }}"> <i class="bi bi-circle"></i><span>List of Sub Categories</span> </a></li>
                    {{-- @endif --}}
                </ul>
            </li>
            {{-- @endif --}}
            {{-- @if ($user && $user->hasPermissionByRole('view_coupon')) --}}
            <li class=" {{ request()->is('admin/restaurant/menus')?'nav-item active':'' }}">
                <a class="nav-link  {{request()->is('admin/restaurant/menus')}}" data-bs-target="#menus-nav" data-bs-toggle="collapse" href="javascripit:void(0);" aria-expanded="false"> <i class="bi bi-list-check"></i><span>Menus Managements</span><i class="bi bi-chevron-down  ms-auto"></i> </a>
                <ul id="menus-nav" class="nav-content collapse {{ request()->is('admin/restaurant/menus')?'show':'' }} " data-bs-parent="" style="">
                    {{-- @if ($user && $user->hasPermissionByRole('view_coupon')) --}}
                    <li> <a href="{{ url('admin/restaurant/menus') }}" class=" {{ request()->is('admin/restaurant/menus')?' nav-link active':'' }}"> <i class="bi bi-circle"></i><span>List of Menus</span> </a></li>
                    {{-- @endif --}}
                </ul>
            </li>
            {{-- @endif --}}
            {{-- @if ($user && $user->hasPermissionByRole('view_coupon')) --}}
            <li class=" {{ request()->is('admin/restaurant/coupons')?'nav-item active':'' }}">
                <a class="nav-link  {{request()->is('admin/restaurant/coupons')}}" data-bs-target="#coupons-nav" data-bs-toggle="collapse" href="javascripit:void(0);" aria-expanded="false"> <i class="bi bi-tag"></i><span>Coupon Managements</span><i class="bi bi-chevron-down  ms-auto"></i> </a>
                <ul id="coupons-nav" class="nav-content collapse {{ request()->is('admin/restaurant/coupons')?'show':'' }} " data-bs-parent="" style="">
                    {{-- @if ($user && $user->hasPermissionByRole('view_coupon')) --}}
                    <li> <a href="{{ route('coupons.index') }}" class=" {{ request()->is('admin/restaurant/coupons')?' nav-link active':'' }}"> <i class="bi bi-circle"></i><span>List of Coupon</span> </a></li>
                    {{-- @endif --}}
                </ul>
            </li>
            {{-- @endif --}}
            {{-- @if ($user && $user->hasPermissionByRole('view_coupon')) --}}
            <li class=" {{ request()->is('admin/restaurant/cities')?'nav-item active':'' }}">
                <a class="nav-link  {{request()->is('admin/restaurant/cities')}}" data-bs-target="#city-nav" data-bs-toggle="collapse" href="javascripit:void(0);" aria-expanded="false"> <i class="bi bi-map-fill"></i><span>City Managements</span><i class="bi bi-chevron-down  ms-auto"></i> </a>
                <ul id="city-nav" class="nav-content collapse {{ request()->is('admin/restaurant/cities')?'show':'' }} " data-bs-parent="" style="">
                    {{-- @if ($user && $user->hasPermissionByRole('view_coupon')) --}}
                    <li> <a href="{{ route('cities.index') }}" class=" {{ request()->is('admin/restaurant/cities')?' nav-link active':'' }}"> <i class="bi bi-circle"></i><span>List of Cities</span> </a></li>
                    {{-- @endif --}}
                </ul>
            </li>
            {{-- @endif --}}


            {{-- @if ($user && $user->hasPermissionByRole('view_coupon')) --}}
            <li class=" {{ request()->is('admin/restaurant/products')?'nav-item active':'' }}">
                <a class="nav-link  {{request()->is('admin/restaurant/products')}}" data-bs-target="#produts-nav" data-bs-toggle="collapse" href="javascripit:void(0);" aria-expanded="false"> <i class="bi bi-box"></i><span>Product Managements</span><i class="bi bi-chevron-down  ms-auto"></i> </a>
                <ul id="produts-nav" class="nav-content collapse {{ request()->is('admin/restaurant/products')?'show':'' }} " data-bs-parent="" style="">
                    {{-- @if ($user && $user->hasPermissionByRole('view_coupon')) --}}
                    <li> <a href="{{ route('products.index') }}" class=" {{ request()->is('admin/restaurant/products')?' nav-link active':'' }}"> <i class="bi bi-circle"></i><span>List of Products</span> </a></li>
                    {{-- @endif --}}
                </ul>
            </li>
            {{-- @endif --}}


               {{-- @if ($user && $user->hasPermissionByRole('view_coupon')) --}}
               <li class=" {{ request()->is('admin/restaurant/restaurants')?'nav-item active':'' }}">
                <a class="nav-link  {{request()->is('admin/restaurant/restaurants')}}" data-bs-target="#restaurantes-nav" data-bs-toggle="collapse" href="javascripit:void(0);" aria-expanded="false"> <i class="bi bi-house-fill"></i><span>Restaurant Managements</span><i class="bi bi-chevron-down  ms-auto"></i> </a>
                <ul id="restaurantes-nav" class="nav-content collapse {{ request()->is('admin/restaurant/restaurants')?'show':'' }} " data-bs-parent="" style="">
                    {{-- @if ($user && $user->hasPermissionByRole('view_coupon')) --}}
                    <li> <a href="{{ route('restaurants.index') }}" class=" {{ request()->is('admin/restaurant/restaurants')?' nav-link active':'' }}"> <i class="bi bi-circle"></i><span>List of Restaurants</span> </a></li>
                    {{-- @endif --}}
                </ul>
            </li>
            {{-- @endif --}}
            
              {{-- @if ($user && $user->hasPermissionByRole('view_coupon')) --}}
              <li class=" {{ request()->is('admin/restaurant/order*')?'nav-item active':'' }}">
                <a class="nav-link  {{request()->is('admin/restaurant/order*')}}" data-bs-target="#order_produts-nav" data-bs-toggle="collapse" href="javascripit:void(0);" aria-expanded="false"> <i class="bi bi-box"></i><span>Orders Managements</span><i class="bi bi-chevron-down ms-auto"></i> </a>
                <ul id="order_produts-nav" class="nav-content collapse {{ request()->is('admin/restaurant/order*')?'show':'' }} " data-bs-parent="" style="">
                    {{-- @if ($user && $user->hasPermissionByRole('view_coupon')) --}}
                    <li> <a href="{{ route('restaurant.orders.index') }}" class=" {{ request()->is('admin/restaurant/order*')?' nav-link active':'' }}"> <i class="bi bi-circle"></i><span>List of Orders</span> </a></li>
                    {{-- @endif --}}
                </ul>
            </li>
            {{-- @endif --}}
            <br>
            <li class=" {{ request()->is('admin/restaurant/my-restaurant')?'nav-item active':'' }} " >
                <a href="{{ url('admin/restaurant/my-restaurant') }}" class="nav-link" > <i class="bi bi-textarea-resize"></i><span>My Restaurant</span></a>
            </li>

    </ul>
</aside>

