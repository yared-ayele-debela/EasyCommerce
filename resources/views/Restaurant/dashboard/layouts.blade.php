<?php

use App\Models\AppSetting;
use App\Models\CmsPage;

$cms_pages = CmsPage::get()->toArray();
$appsettings = AppSetting::all()->toArray();
?>
@include('Restaurant.dashboard.css.css_file')
@include('Restaurant.dashboard.header')
@include('Restaurant.dashboard.sidebar')
<main id="main" class="main">
    @yield('restaurant-dashboard')
</main>
@include('Restaurant.dashboard.footer')
@include('Restaurant.dashboard.js.js_file')
