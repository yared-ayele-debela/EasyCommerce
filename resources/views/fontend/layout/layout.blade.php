<?php
use App\Models\Group;
use App\Helper\Helper;
// $subcategory=Subcategory::subcategories();
use App\Models\AppSetting;
use App\Models\CmsPage;

$cms_pages = CmsPage::get()->toArray();
$appsettings = AppSetting::all()->toArray();

?>
<!DOCTYPE html>
<html class="no-js" lang="en-US">

<head>
    <meta charset="UTF-8">
    <!--[if IE]>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <![endif]-->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <meta name="description" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <meta name="author" content="">
    <title>{{ $appsettings[0]['application_title'] }}</title>
    <!-- Standard Favicon -->
    <link href="{{ asset('/storage/appsettings/'.$appsettings[0]['favicon']) }}" rel="shortcut icon">
    <!-- Base Google Font for Web-app -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700" rel="stylesheet">
    <!-- Google Fonts for Banners only -->
    <link href="https://fonts.googleapis.com/css?family=Raleway:400,800" rel="stylesheet">
    <!-- Bootstrap 4 -->
    <link rel="stylesheet" href="{{asset('new_frontend/css/bootstrap.min.css')}}">
    <!-- Font Awesome 5 -->
    <link rel="stylesheet" href="{{asset('new_frontend/css/fontawesome.min.css')}}">
    <!-- Ion-Icons 4 -->
    <link rel="stylesheet" href="{{asset('new_frontend/css/ionicons.min.css')}}">
    <!-- Animate CSS -->
    <link rel="stylesheet" href="{{asset('new_frontend/css/animate.min.css')}}">
    <!-- Owl-Carousel -->
    <link rel="stylesheet" href="{{asset('new_frontend/css/owl.carousel.min.css')}}">
    <!-- Jquery-Ui-Range-Slider -->
    <link rel="stylesheet" href="{{asset('new_frontend/css/jquery-ui-range-slider.min.css')}}">
    <!-- Utility -->
    <link rel="stylesheet" href="{{asset('new_frontend/css/utility.css')}}">
    <!-- Main -->
    <link rel="stylesheet" href="{{asset('new_frontend/css/bundle.green-munsell.css')}}">
   <style>
    body {

    overflow-y: scroll;

    }
    .img-circle {
        border-radius: 50%; /* Makes the image circular */
        margin: 0 auto; /* Center the image */
    }
    .featured{
        background-color: #1E665E;
        color:white;
        font-size: 7px;
        border-radius: 50%;
    }
    @media (min-width: 992px) {
    .product-image{
        max-width: 200px;
        max-height: 200px;
    }
    .img-circle {
        width: 100px;
        height: 100px;
        overflow: hidden;
        border-radius: 50%; /* Makes the image circular */
        margin: 0 auto; /* Center the image */
    }
}
</style>
</head>

<body>
<!-- app -->
<div id="app">

    <!-- Header -->
     @include('fontend.layout.haeder')
    <!-- Header /- -->

     @yield('content')

     @include('fontend.layout.footer')
    <!-- Footer /- -->
    <!-- Dummy Selectbox -->
     @include('fontend.layout.modals')
</div>

<noscript>
    <div class="app-issue">
        <div class="vertical-center">
            <div class="text-center">
                <h1>JavaScript is disabled in your browser.</h1>
                <span>Please enable JavaScript in your browser or upgrade to a JavaScript-capable browser to register for Groover.</span>
            </div>
        </div>
    </div>
    <style>
    #app {
        display: none;
    }
    </style>
</noscript>
<!-- Google Analytics: change UA-XXXXX-Y to be your site's ID. -->
<script>
window.ga = function() {
    ga.q.push(arguments)
};
ga.q = [];
ga.l = +new Date;
ga('create', 'UA-XXXXX-Y', 'auto');
ga('send', 'pageview')
</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

<script src="https://www.google-analytics.com/analytics.js" async defer></script>
<!-- Modernizr-JS -->
<script type="text/javascript" src="{{asset('new_frontend/js/vendor/modernizr-custom.min.js')}}"></script>
<!-- NProgress -->
<script type="text/javascript" src="{{asset('new_frontend/js/nprogress.min.js')}}"></script>
<!-- jQuery -->
<script type="text/javascript" src="{{asset('new_frontend/js/jquery.min.js')}}"></script>
<!-- Bootstrap JS -->
<script type="text/javascript" src="{{asset('new_frontend/js/bootstrap.min.js')}}"></script>
<!-- Popper -->
<script type="text/javascript" src="{{asset('new_frontend/js/popper.min.js')}}"></script>
<!-- ScrollUp -->
<script type="text/javascript" src="{{asset('new_frontend/js/jquery.scrollUp.min.js')}}"></script>
<!-- Elevate Zoom -->
<script type="text/javascript" src="{{asset('new_frontend/js/jquery.elevatezoom.min.js')}}"></script>
<!-- jquery-ui-range-slider -->
<script type="text/javascript" src="{{asset('new_frontend/js/jquery-ui.range-slider.min.js')}}"></script>
<!-- jQuery Slim-Scroll -->
<script type="text/javascript" src="{{asset('new_frontend/js/jquery.slimscroll.min.js')}}"></script>
<!-- jQuery Resize-Select -->
<script type="text/javascript" src="{{asset('new_frontend/js/jquery.resize-select.min.js')}}"></script>
<!-- jQuery Custom Mega Menu -->
<script type="text/javascript" src="{{asset('new_frontend/js/jquery.custom-megamenu.min.js')}}"></script>
<!-- jQuery Countdown -->
<script type="text/javascript" src="{{asset('new_frontend/js/jquery.custom-countdown.min.js')}}"></script>
<!-- Owl Carousel -->
<script type="text/javascript" src="{{asset('new_frontend/js/owl.carousel.min.js')}}"></script>
<!-- Main -->
<script type="text/javascript" src="{{asset('new_frontend/js/app.js')}}"></script>
@notifyJs
@yield('script')
</body>
</html>
