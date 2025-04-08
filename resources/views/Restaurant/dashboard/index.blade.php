@extends('Restaurant.dashboard.layouts')
@section('restaurant-dashboard')
<div class="pagetitle shadow-sm">
    <nav class="p-4 text-center">
       <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.html">Home</a></li>
          <li class="breadcrumb-item active">Dashboard</li>
       </ol>
    </nav>
 </div>
 <section class="section dashboard">
    <div class="row">
       <div class="col-lg-12">
        <div class="row">
            {{-- Total Slider --}}
            <x-dashboard-card title="Total Sliders" count="{{ $total_slider }}" icon="bi-images" bg="primary" description="All slider banners" />
        
            {{-- Total Category --}}
            <x-dashboard-card title="Categories" count="{{ $total_category }}" icon="bi-grid-3x3-gap-fill" bg="success" description="Main categories" />
        
            {{-- Total Subcategory --}}
            <x-dashboard-card title="Subcategories" count="{{ $total_subcategory }}" icon="bi-grid" bg="info" description="All subcategories" />
        
            {{-- Total Menu --}}
            <x-dashboard-card title="Menus" count="{{ $total_menu }}" icon="bi-book-fill" bg="dark" description="Restaurant menus" />
        
            {{-- Total Coupon --}}
            <x-dashboard-card title="Coupons" count="{{ $total_coupon }}" icon="bi-ticket-perforated" bg="secondary" description="All active coupons" />
        
            {{-- Total Product --}}
            <x-dashboard-card title="Products" count="{{ $total_product }}" icon="bi-box-seam" bg="warning" description="Total products" />
        
            {{-- Total Restaurant --}}
            <x-dashboard-card title="Restaurants" count="{{ $total_restaurant }}" icon="bi-shop" bg="danger" description="All listed restaurants" />
        
            {{-- Total Orders --}}
            <x-dashboard-card title="Orders" count="{{ $total_order }}" icon="bi-cart-check-fill" bg="success" description="All orders" />
        
            {{-- Pending Orders --}}
            <x-dashboard-card title="Pending Orders" count="{{ $total_pending_order }}" icon="bi-clock" bg="warning" description="Awaiting processing" />
        
            {{-- Processing Orders --}}
            <x-dashboard-card title="Processing Orders" count="{{ $total_processing_order }}" icon="bi-arrow-repeat" bg="primary" description="Orders in progress" />
        
            {{-- Completed Orders --}}
            <x-dashboard-card title="Completed Orders" count="{{ $total_completed_order }}" icon="bi-check-circle-fill" bg="info" description="Successfully delivered" />
        
            {{-- Canceled Orders --}}
            <x-dashboard-card title="Canceled Orders" count="{{ $total_canceled_order }}" icon="bi-x-circle-fill" bg="danger" description="Order was canceled" />
        </div>
        
       </div>
    </div>
 </section>
@endsection

