<?php

use App\Models\AppSetting;
use App\Models\CmsPage;

$cms_pages = CmsPage::get()->toArray();
$appsettings = AppSetting::all()->toArray();
?>
@include('Hotel.dashboard.css.css_file')
@include('Hotel.dashboard.header')
@include('Hotel.dashboard.sidebar')

<main id="main" class="main">
    @yield('hotel-dashboard')
</main>
@include('Hotel.dashboard.footer')
@include('Hotel.dashboard.js.js_file')
