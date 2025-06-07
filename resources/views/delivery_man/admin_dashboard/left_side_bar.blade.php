<?php
 use App\Models\TransferRequest;
 use App\Models\Order;
 use App\Models\ReturnRequest;
 use App\Models\CustomOrder;
 use App\Models\DeliveryMan;
 use App\Models\AssignStockProduct;

 $deliveryBoy = DeliveryMan::where('id',Auth::guard('deliverymen')->user()->id)->first();

 $assigneedproduct=AssignStockProduct::all()->where('delivery_man_id',$deliveryBoy->id)->count();
?>
@php
$user = Auth::guard('deliverymen')->user();
@endphp

<aside id="sidebar" class="sidebar">
    <ul class="sidebar-nav" id="sidebar-nav">
       <li class="nav-item"> <a class="nav-link " href="{{ url('delivery-boy/dashboard') }}"> <i class="bi bi-grid"></i> <span>Dashboard</span> </a></li>
       @if ($user && $user->hasPermissionByRole('view transfered stock product'))
       <li class="nav-item active">
           <a href="{{ url('delivery-boy/orders') }}" class="nav-link" href="javascript:void(0)"> <i class="bx bxs-building-house  "></i><span>List of Goods Orders</span></a>
       </li>
       @endif
       @if ($user && $user->hasPermissionByRole('view transfered stock product'))
       <li class=" {{ request()->is('delivey-boy/stock-products')?'nav-item active':'' }} {{ request()->is('delivery-boy/stock-product/detail/*')?'nav-item active':'' }} ">
           <a href="{{ route('delivery.restaurant-orders') }}" class="nav-link" href="javascript:void(0)"> <i class="bx bxs-building-house  "></i><span>Restaurant Orders</span></a>
       </li>
       @endif
       @if ($user && $user->hasPermissionByRole('view custom order'))
       <li class=" {{ request()->is('delivery-boy/custom-orders')?'nav-item active':'' }} {{ request()->is('delivery-boy/custom-orders/*')?'nav-item active':'' }}  ">
           <a class="nav-link" data-bs-target="#custom_order-nav" data-bs-toggle="collapse" href="javascript:void(0)"> <i class="bx bxs-shopping-bag-alt  "></i><span>Custom Orders</span>&nbsp; <i class="bi bi-chevron-down ms-auto"></i> </a>
           <ul id="custom_order-nav" class="nav-content collapse  {{ request()->is('delivery-boy/custom-orders')?'show':'' }} {{ request()->is('delivery-boy/custom-orders*')?'show':'' }}  " data-bs-parent="#sidebar-nav">
               <li> <a href="{{ route('delivery_boy_custom_orders') }}" class="{{ request()->is('delivery-boy/custom-orders*')?'nav-link active':'' }}"> <i class=" bi bi-circle active "></i><span>List of orders</span></a></li>
           </ul>
       </li>
       @endif
       {{-- @if ($user && $user->hasPermissionByRole('view transfered stock product'))
       <li class=" {{ request()->is('delivey-boy/stock-products')?'nav-item active':'' }} {{ request()->is('delivery-boy/stock-product/detail/*')?'nav-item active':'' }} ">
           <a class="nav-link" data-bs-target="#stock_products-nav" data-bs-toggle="collapse" href="javascript:void(0)"> <i class="bx bxs-building-house  "></i><span>Stock Transfer Product</span>&nbsp; <i class="bi bi-chevron-down ms-auto"></i> </a>
           <ul id="stock_products-nav" class="nav-content collapse {{ request()->is('delivey-boy/stock-products')?'show':'' }} {{ request()->is('delivey-boy/stock-product/detail/*')?'show':'' }} " data-bs-parent="#sidebar-nav">
               <li> <a href="{{ route('delivery-boy-stock-products') }}" class="{{ request()->is('delivey-boy/stock-products')?'nav-link active':'' }} {{ request()->is('delivey-boy/stock-product/detail/*')?'nav-link active':'' }} "> <i class=" bi bi-circle active "></i><span>List of stock transfer products</span></a></li>
           </ul>
       </li>
       @endif --}}
       <li class="{{ request()->is('delivery-boy/update-profile')?'nav-item active':'' }}  ">
         <a class="nav-link " href="{{ url('delivery-boy/update-profile') }}"> <i class="bi bi-person-fill "></i> <span>Your Profile</span>
        </a>
        </li>
    </ul>
 </aside>
