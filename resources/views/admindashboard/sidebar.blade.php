<?php
 use App\Models\TransferRequest;
 use App\Models\Order;
 use App\Models\ReturnRequest;
 use App\Models\CustomOrder;

 $count_transfer_request=TransferRequest::where('status','pending')->count();
 $count_order=Order::all()->count();
 $count_return_request=ReturnRequest::all()->count();
 $count_custom_order=CustomOrder::all()->count();

 $adminType = Auth::guard('admin')->user()->type;
 $vendor_id = Auth::guard('admin')->user()->vendor_id;
 $orderCount = Order::countOrdersForVendor($vendor_id);
 $ReturnCount= Order::countReturnRequestForVendor($vendor_id);

?>
<aside id="sidebar" class=" colored sidebar ">
    @php
    $user = Auth::guard('admin')->user();
    @endphp
    <ul class="sidebar-nav" id="sidebar-nav">
        @if(session()->has('admin_id'))
        <li class="nav-item">
            <a class="nav-link" href="{{ url('admin/dashboard') }}">
            <i class="bi bi-arrow-right-square-fill"></i>
            <form action="{{ route('switch-back-to-admin') }}" method="POST">
                @csrf
                <button type="submit" class="shadow-none btn-sm btn" style="color:rgb(65,84,241);"><b>Switch back to Admin</b></button>
            </form>
           </a>
       </li>
       @endif
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
        @if($adminType === "Ecommerce Manager" || $adminType === "vendor" || $adminType==="Super Admin")
        <li class=" {{ request()->is('admin/dashboard')?'nav-item active':'' }}">
           <a href="{{ url('admin/dashboard') }}" class="nav-link {{request()->is('admin/dashboard')}}"> <i class="bi bi-menu-button-fill"></i><span>Dashboard</span> </a>
        </li>
        @endif


        @if(Auth::guard('admin')->user()->type=="vendor" || Auth::guard('admin')->user()->type=="Ecommerce Manager")
        @if ($user && $user->hasPermissionByRole('view withdrawal request'))
            <li class="{{ request()->is('admin/vendor/wallet')?'nav-item active':'' }}">
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
                <ul id="withdrawal-nav" class="nav-content collapse {{ request()->is('admin/vendor/wallet')?'show':'' }}" data-bs-parent="#sidebar-nav">
                    <li> <a href="{{ url('admin/vendor/wallet') }}" class="{{ request()->is('admin/vendor/wallet')?'nav-link active':'' }}"> <i class=" bi bi-circle active"></i><span>Your Wallet</span></a></li>
                </ul>
            </li>
            @endif
             @if ($user && $user->hasPermissionByRole('view_product'))
            <li class="  {{ request()->is('admin/products*')?'nav-item active':'' }}">
                <a class="nav-link {{request()->is('admin/products*')}}" data-bs-target="#charts-nav" data-bs-toggle="collapse" href="javascripit:void(0);" aria-expanded="false"> <i class="bi bi-bar-chart"></i><span>Catelog Managements</span><i class="bi bi-chevron-down  ms-auto"></i> </a>
                <ul id="charts-nav" class="nav-content collapse  {{ request()->is('admin/products*')?'show':'' }} " data-bs-parent="" style="">
                    @if ($user && $user->hasPermissionByRole('view_product'))
                    <li> <a href="{{ route('products') }}" class=" {{ request()->is('admin/products*')?' nav-link active':'' }}"> <i class="bi bi-circle"></i><span>Products</span> </a></li>
                    @endif
                </ul>
            </li>
            @endif
            @if ($user && $user->hasPermissionByRole('view_coupon'))
            <li class=" {{ request()->is('admin/coupons*')?'nav-item active':'' }}">
                <a class="nav-link  {{request()->is('admin/coupons*')}}" data-bs-target="#coupons-nav" data-bs-toggle="collapse" href="javascripit:void(0);" aria-expanded="false"> <i class="bi bi-clipboard-check "></i><span>Coupon Managements</span><i class="bi bi-chevron-down  ms-auto"></i> </a>
                <ul id="coupons-nav" class="nav-content collapse {{ request()->is('admin/coupons*')?'show':'' }} " data-bs-parent="" style="">
                    @if ($user && $user->hasPermissionByRole('view_coupon'))
                    <li> <a href="{{ route('coupons') }}" class=" {{ request()->is('admin/coupons*')?' nav-link active':'' }}"> <i class="bi bi-circle"></i><span>Coupons</span> </a></li>
                    @endif
                </ul>
            </li>
            @endif
            @if ($user && $user->hasPermissionByRole('view_product_rating'))
            <li class=" {{ request()->is('admin/ratings')?'nav-item active':'' }} {{ request()->is('admin/ratings*')?'nav-item active':'' }}   ">
                <a class="nav-link" data-bs-target="#ratings-nav" data-bs-toggle="collapse" href="javascripit:void(0);"> <i class="bx bxs-star"></i><span>Product Ratings</span><i class="bi bi-chevron-down ms-auto"></i> </a>
                <ul id="ratings-nav" class="nav-content collapse  {{ request()->is('admin/ratings')?'show':'' }} {{ request()->is('admin/ratings*')?'show':'' }} " data-bs-parent="#sidebar-nav">
                    <li> <a href="{{ url('admin/ratings')}}" class="{{ request()->is('admin/ratings*')?'nav-link active':'' }} "> <i class=" bi bi-circle active "></i><span>List Product Ratings</span></a></li>
                </ul>
            </li>
            @endif
            @if ($user && $user->hasPermissionByRole('view_orders'))
            <li class=" {{ request()->is('admin/orders')?'nav-item active':'' }}  ">
                <a class="nav-link" data-bs-target="#order-nav" data-bs-toggle="collapse" href="javascripit:void(0);"> <i class="bi bi-bag"></i><span>Orders Managements </span> &nbsp; @if($orderCount)<span class="badge bg-danger">{{$orderCount}}</span>@endif<i class="bi bi-chevron-down ms-auto"></i> </a>
                <ul id="order-nav" class="nav-content collapse  {{ request()->is('admin/orders')?'show':'' }}  " data-bs-parent="#sidebar-nav">
                    <li> <a href="{{ route('allorders') }}" class="{{ request()->is('admin/orders*')?'nav-link active':'' }}"> <i class=" bi bi-circle active "></i><span>Orders</span></a></li>
                </ul>
            </li>
            @endif
            @if ($user && $user->hasPermissionByRole('view_return_request'))
            <li class=" {{ request()->is('admin/return_request')?'nav-item active':'' }}  ">
                <a class="nav-link" data-bs-target="#return-nav" data-bs-toggle="collapse" href="javascripit:void(0);"> <i class="bx bx-download"></i><span>Return Request</span> &nbsp; @if($ReturnCount)<span class="badge bg-danger">{{$ReturnCount}}</span>@endif <i class="bi bi-chevron-down ms-auto"></i> </a>
                <ul id="return-nav" class="nav-content collapse  {{ request()->is('admin/return_request')?'show':'' }}  " data-bs-parent="#sidebar-nav">
                    <li> <a href="{{ route('return_request') }}" class="{{ request()->is('admin/return_request*')?'nav-link active':'' }}"> <i class=" bi bi-circle active "></i><span>List Return Requests</span> </a></li>
                </ul>
            </li>
            @endif
            @if($user && $user->hasPermissionByRole('view product reports') || $user->hasPermissionByRole('view stock product reports') || $user->hasPermissionByRole('view stock transferred reports') || $user->hasPermissionByRole('view order reports') || $user->hasPermissionByRole('view order product reports') || $user->hasPermissionByRole('view custom order reports') || $user->hasPermissionByRole('view vendor reports') || $user->hasPermissionByRole('view customer reports'))
            <li class="{{ request()->is('admin/report/custom-order-report')?'nav-item active':'' }} {{ request()->is('admin/report/stock-report')?'nav-item active':'' }} {{ request()->is('admin/report/vendors-report')?'nav-item active':'' }} {{ request()->is('admin/report/order-report')?'nav-item active':'' }}  {{ request()->is('admin/report/order-report')?'nav-item active':'' }} {{ request()->is('admin/report/order-product-report')?'nav-item active':'' }} {{ request()->is('admin/report/transfer-stock-report')?'nav-item active':'' }} {{ request()->is('admin/report/product-report')?'nav-item active':'' }}   ">
                <a class="nav-link" data-bs-target="#reports-nav" data-bs-toggle="collapse" href="javascripit:void(0);"> <i class="bi bi-graph-up-arrow"></i><span>Reports</span><i class="bi bi-chevron-down ms-auto"></i> </a>
                <ul id="reports-nav" class="nav-content collapse {{ request()->is('admin/report/vendors-report')?'show':'' }} {{ request()->is('admin/report/transfer-stock-report')?'show':'' }} {{ request()->is('admin/report/customer-report')?'show':'' }} {{ request()->is('admin/report/stock-report')?'show':'' }} {{ request()->is('admin/report/custom-order-report')?'show':'' }} {{ request()->is('admin/report/order-report')?'show':'' }} {{ request()->is('admin/report/product-report')?'show':'' }} {{ request()->is('admin/report/order-product-report')?'show':'' }} " data-bs-parent="#sidebar-nav">
                    @if ($user && $user->hasPermissionByRole('view product reports'))
                    <li> <a href="{{ url('admin/report/product-report')}}" class="{{ request()->is('admin/report/product-report')?'nav-link active':'' }} "> <i class=" bi bi-circle active "></i><span>Product Reports</span></a></li>
                    @endif

                    @if ($user && $user->hasPermissionByRole('view order product reports'))
                    <li> <a href="{{ url('admin/report/order-product-report')}}" class="{{ request()->is('admin/report/order-product-report')?'nav-link active':'' }} "> <i class=" bi bi-circle active "></i><span>Order Product Reports</span></a></li>
                    @endif
                </ul>
            </li>
            @endif


        @endif


        @if(Auth::guard('admin')->user()->type!=="vendor" && Auth::guard('admin')->user()->type!=="Ecommerce Manager")

        @if ($user->hasPermissionByRole('view_permission') || $user->hasPermissionByRole('view_role') || $user->hasPermissionByRole('view_admin'))
        <li class="{{ request()->is('admin/permissions')?'nav-item active':'' }} {{ request()->is('admin/permissions*')?'nav-item active':'' }} {{ request()->is('admin/all-delivery-boys')?'nav-item active':'' }} {{ request()->is('admin/delivery-boy/*')?'nav-item active':'' }} {{ request()->is('admin/permissions/create')?'nav-item active':'' }} {{ request()->is('admin/roles')?'nav-item active':'' }} {{ request()->is('admin/roles/*')?'nav-item active':'' }}  {{ request()->is('admin/all-admins')?'nav-item active':'' }}">
            <a class="nav-link " data-bs-target="#manage-nav" data-bs-toggle="collapse" href="javascripit:void(0);"> <i class="bi bi-people-fill "></i><span>Role and Permissions</span><i class="bi bi-chevron-down ms-auto"></i> </a>
            <ul id="manage-nav" class=" nav-content collapse {{ request()->is('admin/permissions')?'show':'' }} {{ request()->is('admin/permissions*')?'show':'' }}  {{ request()->is('admin/all-delivery-boys')?'show':'' }}  {{ request()->is('admin/delivery-boy/*')?'show':'' }} {{ request()->is('admin/role*')?'show':'' }} {{ request()->is('admin/roles*')?'show':'' }} {{ request()->is('admin/permissions/*')?'show':'' }} {{ request()->is('admin/roles')?'show':'' }} {{ request()->is('admin/all-admins')?'show':'' }}" data-bs-parent="#sidebar-nav">
                @if ($user && $user->hasPermissionByRole('view_permission'))
                <li> <a href="{{ route('permissions.index') }}" class="{{ request()->is('admin/permissions')?'nav-link active':'' }} {{ request()->is('admin/permissions*')?'nav-link active':'' }} {{ request()->is('admin/permissions/*')?'nav-link active':'' }}"> <i class=" bi bi-circle active "></i><span>All Permissions </span> </a></li>
                @endif
                @if ($user && $user->hasPermissionByRole('view_role'))
                <li> <a href="{{ route('roles.index') }}" class="{{ request()->is('admin/roles')?'nav-link active':'' }} {{ request()->is('admin/role*')?'nav-link active':'' }}  {{ request()->is('admin/roles/*')?'nav-link active':'' }}"> <i class="bi bi-circle"></i><span>All Roles</span></a></li>
                @endif
                @if ($user && $user->hasPermissionByRole('view_admin'))
                <li> <a href="{{ route('all-admins.index') }}" class="{{ request()->is('admin/all-admins')?'nav-link active':'' }}"> <i class=" bi bi-circle active "></i><span>All admins</span></a></li>
                @endif
                @if ($user && $user->hasPermissionByRole('view_delivery_boy'))
                <li> <a href="{{ route('all-delivery-boy.index') }}" class="{{ request()->is('admin/all-delivery-boys')?'nav-link active':'' }} {{ request()->is('admin/delivery-boy*')?'nav-link active':'' }}"> <i class=" bi bi-circle active "></i><span>All delivery boys</span></a></li>
                @endif
            </ul>
        </li>
        @endif

        @if ($user->hasPermissionByRole('view_admin') || $user->hasPermissionByRole('create_admin'))
        <li class="{{ request()->is('admin/add_admin')?'nav-item active':'' }} {{ request()->is('admin/edit_admin/*')?'nav-item active':'' }} ">
            <a class="nav-link " data-bs-target="#manageadmin-nav" data-bs-toggle="collapse" href="javascripit:void(0);"> <i class="bi bi-people-fill "></i><span>Admin Managements</span><i class="bi bi-chevron-down ms-auto"></i> </a>
            <ul id="manageadmin-nav" class=" nav-content collapse {{ request()->is('admin/all/admins')?'show':'' }} {{ request()->is('admin/edit_admin/*')?'show':'' }}  {{ request()->is('admin/add_admin')?'show':'' }}" data-bs-parent="#sidebar-nav">
                @if ($user && $user->hasPermissionByRole('view_admin'))
                <li> <a href="{{ route('alladmins') }}" class="{{ request()->is('admin/all/admins*')?'nav-link active':'' }}"> <i class="bi bi-circle"></i><span>List Admin</span></a></li>
                @endif
                @if ($user && $user->hasPermissionByRole('create_admin'))
                <li> <a href="{{ url('admin/add_admin') }}" class="{{ request()->is('admin/add_admin*')?'nav-link active':'' }}"> <i class=" bi bi-circle active "></i><span>Add Admins</span></a></li>
                @endif
            </ul>
        </li>
        @endif

        @if ($user && $user->hasPermissionByRole('view_vendor'))
        <li class="{{ request()->is('admin/vendors')?'nav-item active':'' }} {{ request()->is('admin/vendors/details*')?'nav-item active':'' }} {{ request()->is('admin/vendor/withdraw-requests')?'nav-item active':'' }}">
            <a class="nav-link" data-bs-target="#vendor-nav" data-bs-toggle="collapse" href="javascripit:void(0);"> <i class=" ri-admin-fill "></i><span>Vendors & Wthdrawal Request</span><i class="bi bi-chevron-down ms-auto"></i> </a>
            <ul id="vendor-nav" class="nav-content collapse {{ request()->is('admin/vendors')?'show':'' }} {{ request()->is('admin/vendor/withdraw-requests')?'show':'' }} {{ request()->is('admin/vendors/details*')?'show':'' }}" data-bs-parent="#sidebar-nav">
                <li> <a href="{{ route('vendors') }}" class="{{ request()->is('admin/vendors')?'nav-link active':'' }} {{ request()->is('admin/vendors/details*')?'nav-link active':'' }} "> <i class=" bi bi-circle active "></i><span>List Vendors</span></a></li>
                <li> <a href="{{ url('admin/vendor/withdraw-requests') }}" class="{{ request()->is('admin/vendor/withdraw-requests')?'nav-link active':'' }}"> <i class=" bi bi-circle active "></i><span>List Vendors Withdrawal Request</span></a></li>
            </ul>
        </li>
        @endif

        @if ($user && $user->hasPermissionByRole('view_users'))
        <li class=" {{ request()->is('admin/users')?'nav-item active':'' }} {{ request()->is('admin/edit_user*')?'nav-item active':'' }}  ">
            <a class="nav-link" data-bs-target="#users-nav" data-bs-toggle="collapse" href="javascripit:void(0);"> <i class=" ri-group-2-fill"></i><span>Customers</span><i class="bi bi-chevron-down ms-auto"></i> </a>
            <ul id="users-nav" class="nav-content collapse   {{ request()->is('admin/edit_user*')?'show':'' }}   {{ request()->is('admin/users')?'show':'' }}  " data-bs-parent="#sidebar-nav">
                <li> <a href="{{ route('users') }}" class="{{ request()->is('admin/users*')?'nav-link active':'' }} {{ request()->is('admin/edit_user*')?'nav-link active':'' }}"> <i class=" bi bi-circle active "></i><span>List Customers</span></a></li>
            </ul>
        </li>
        @endif
        @if ($user && $user->hasPermissionByRole('view_delivery_boy') || $user->hasPermissionByRole('view delivery zone') || $user->hasPermissionByRole('view deliveryman type') || $user->hasPermissionByRole('view vehicle type'))
        <li class="{{ request()->is('admin/vehicle_type')?'nav-item active':'' }} {{ request()->is('admin/withdrawals')?'nav-item active':'' }} {{ request()->is('admin/vehicle_type*')?'nav-item active':'' }}  {{ request()->is('admin/delivery_zone')?'nav-item active':'' }} {{ request()->is('admin/delivery_man/type*')?'nav-item active':'' }} {{ request()->is('admin/delivery_zone*')?'nav-item active':'' }} {{ request()->is('admin/delivery_man/type')?'nav-item active':'' }} {{ request()->is('admin/delivery_boy')?'nav-item active':'' }} {{ request()->is('admin/delivery_boy/*')?'nav-item active':'' }}  ">
            <a class="nav-link" data-bs-target="#delivery-nav" data-bs-toggle="collapse" href="javascript:void();"> <i class="bx bxs-file"></i><span>Delivery Man</span><i class="bi bi-chevron-down ms-auto"></i> </a>
            <ul id="delivery-nav" class="nav-content collapse {{ request()->is('admin/delivery_zone')?'show':'' }} {{ request()->is('admin/withdrawals')?'show':'' }} {{ request()->is('admin/delivery_zone*')?'show':'' }} {{ request()->is('admin/delivery_man/type')?'show':'' }} {{ request()->is('admin/delivery_man/type*')?'show':'' }} {{ request()->is('admin/vehicle_type')?'show':'' }} {{ request()->is('admin/vehicle_type*')?'show':'' }}  {{ request()->is('admin/delivery_boy')?'show':'' }}  {{ request()->is('admin/delivery_boy/*')?'show':'' }}    " data-bs-parent="#sidebar-nav">
                    @if( $user->hasPermissionByRole('view_delivery_boy'))
                <li> <a href="{{ route('delivery_boy.index') }}" class="{{ request()->is('admin/delivery_boy')?'nav-link active':'' }} {{ request()->is('admin/delivery_boy/*')?'nav-item active':'' }} "> <i class=" bi bi-circle active "></i><span>List Delivery man</span> </a></li>
                @endif
                @if( $user->hasPermissionByRole('view delivery zone'))
                <li> <a href="{{ url('admin/withdrawals') }}" class="{{ request()->is('admin/withdrawals')?'nav-link active':'' }} {{ request()->is('admin/withdrawals')?'nav-item active':'' }} "> <i class=" bi bi-zoom-in  active "></i><span>Delivery Men Withdraw Requests</span> </a></li>
                @endif
                @if( $user->hasPermissionByRole('view delivery zone'))
                <li> <a href="{{ route('delivery_zone') }}" class="{{ request()->is('admin/delivery_zone')?'nav-link active':'' }} {{ request()->is('admin/delivery_zone*')?'nav-item active':'' }} "> <i class=" bi bi-zoom-in  active "></i><span>Delivery Zone</span> </a></li>
                @endif
                @if( $user->hasPermissionByRole('view deliveryman type'))
                <li> <a href="{{ route('delivery_man_type') }}" class="{{ request()->is('admin/delivery_man/type')?'nav-link active':'' }} {{ request()->is('admin/delivery_man/type*')?'nav-item active':'' }} "> <i class=" bi bi-type  active "></i><span>Delivery Man Type</span> </a></li>
                @endif
                @if( $user->hasPermissionByRole('view vehicle type'))
                <li> <a href="{{ route('vehicle_type') }}" class="{{ request()->is('admin/vehicle_type')?'nav-link active':'' }} {{ request()->is('admin/vehicle_type*')?'nav-item active':'' }} "> <i class=" bi bi-bicycle active "></i><span>Vehicle Type</span> </a></li>
                @endif

            </ul>
        </li>
        @endif
       @if ($user && $user->hasPermissionByRole('view sales_person'))
        <li class="{{ request()->is('admin/sales-user*')?'nav-item active':'' }} ">
            <a class="nav-link" data-bs-target="#sales-nav" data-bs-toggle="collapse" href="javascripit:void(0);"> <i class="ri-user-follow-fill"></i><span>Sales Persons</span><i class="bi bi-chevron-down ms-auto"></i> </a>
            <ul id="sales-nav" class="nav-content collapse {{ request()->is('admin/sales-user*')?'show':'' }}" data-bs-parent="#sidebar-nav">
                <li> <a href="{{ route('sales-users') }}" class="{{ request()->is('admin/sales-user*')?'nav-link active':'' }} "> <i class=" bi bi-circle active "></i><span>List Sales Persons</span></a></li>
            </ul>
        </li>
        @endif

        @if($user && $user->hasPermissionByRole('view_group') || $user->hasPermissionByRole('view_color') || $user->hasPermissionByRole('view_category') || $user->hasPermissionByRole('view_brand') || $user->hasPermissionByRole('view_filters') || $user->hasPermissionByRole('view_coupon') || $user->hasPermissionByRole('view_product'))
        <li class="{{ request()->is('admin/color*')?'nav-item active':'' }} {{ request()->is('admin/products*')?'nav-item active':'' }} {{ request()->is('admin/coupons*')?'nav-item active':'' }} {{ request()->is('admin/section*')?'nav-item active':'' }} {{ request()->is('admin/categories*')?'nav-item active':'' }} {{ request()->is('admin/groups*')?'nav-item active':'' }} {{ request()->is('admin/subcategories*')?'nav-item active':'' }} {{ request()->is('admin/brands*')?'nav-item active':''}} {{ request()->is('admin/filters*')?'nav-item active':''}}">
            <a class="nav-link " data-bs-target="#charts-nav" data-bs-toggle="collapse" href="javascripit:void(0);" aria-expanded="false"> <i class="ri-gift-2-fill"></i><span>Catelog Managements</span><i class="bi bi-chevron-down  ms-auto"></i> </a>
            <ul id="charts-nav" class="nav-content collapse {{ request()->is('admin/products*')?'show':'' }} {{ request()->is('admin/color*')?'show':'' }} {{ request()->is('admin/subcategories*')?'show':'' }} {{ request()->is('admin/section*')?'show':'' }} {{ request()->is('admin/categories*')?'show':'' }} {{ request()->is('admin/groups*')?'show':'' }} {{ request()->is('admin/brands*')?'show':'' }}{{ request()->is('admin/filters*')?'show':'' }}{{ request()->is('admin/coupons*')?'show':'' }}" data-bs-parent="" style="">
                @if($user && $user->hasPermissionByRole('view_color'))
                <li> <a href="{{ route('colors') }}" class="{{ request()->is('admin/color*')?'nav-link active':'' }}"> <i class="bi bi-circle"></i><span>Colors</span> </a></li>
                @endif
                @if ($user && $user->hasPermissionByRole('view_group'))
                <li> <a href="{{ route('groups') }}" class="{{ request()->is('admin/groups*')?'nav-link active':'' }}"> <i class="bi bi-circle"></i><span>Groups</span> </a></li>
                @endif
                @if ($user && $user->hasPermissionByRole('view_category'))
                <li> <a href="{{ route('categories') }}" class=" {{ request()->is('admin/categories*')?' nav-link active':'' }}"> <i class="bi bi-circle"></i><span>Categories</span> </a></li>
                @endif
                @if ($user && $user->hasPermissionByRole('view_brand'))
                <li> <a href="{{ route('brands') }}" class=" {{ request()->is('admin/brand*')?' nav-link active':'' }}"> <i class="bi bi-circle"></i><span>Brands</span> </a></li>
                @endif
                @if ($user && $user->hasPermissionByRole('view_filters'))
                <li> <a href="{{ route('filters') }}" class=" {{ request()->is('admin/filters*')?' nav-link active':'' }}"> <i class="bi bi-circle"></i><span>Filters</span> </a></li>
                @endif
                @if ($user && $user->hasPermissionByRole('view_coupon'))
                <li> <a href="{{ route('coupons') }}" class=" {{ request()->is('admin/coupons*')?' nav-link active':'' }}"> <i class="bi bi-circle"></i><span>Coupons</span> </a></li>
                @endif
                @if ($user && $user->hasPermissionByRole('view_product'))
                <li> <a href="{{ route('products') }}" class=" {{ request()->is('admin/products*')?' nav-link active':'' }}"> <i class="bi bi-circle"></i><span>Products</span> </a></li>
                @endif
            </ul>
        </li>
        @endif

        @if ($user && $user->hasPermissionByRole('view_flash_deal'))
        <li class=" {{ request()->is('admin/flash_deals')?'nav-item active':'' }} {{ request()->is('admin/flash_deals*')?'nav-item active':'' }}  ">
            <a class="nav-link" data-bs-target="#flash_deals-nav" data-bs-toggle="collapse" href="javascripit:void(0);"> <i class="bx bxs-discount"></i><span>Flash Deals</span><i class="bi bi-chevron-down ms-auto"></i> </a>
            <ul id="flash_deals-nav" class="nav-content collapse   {{ request()->is('admin/flash_deals*')?'show':'' }}   {{ request()->is('admin/flash_deals')?'show':'' }}  " data-bs-parent="#sidebar-nav">
                <li> <a href="{{ route('flash_deals.index') }}" class="{{ request()->is('admin/flash_deals*')?'nav-link active':'' }} {{ request()->is('admin/flash_deals*')?'nav-link active':'' }}"> <i class=" bi bi-circle active "></i><span>Lists of flashdeal</span></a></li>
            </ul>
        </li>
        @endif
        @if ($user && $user->hasPermissionByRole('view_orders'))
        <li class=" {{ request()->is('admin/orders')?'nav-item active':'' }} {{ request()->is('admin/orders/*')?'nav-item active':'' }}  ">
            <a class="nav-link" data-bs-target="#order-nav" data-bs-toggle="collapse" href="javascripit:void(0);"> <i class="bx bxs-shopping-bags"></i><span>Orders</span> &nbsp; @if($count_order)<span class="badge bg-danger">{{$count_order}}</span>@endif<i class="bi bi-chevron-down ms-auto"></i> </a>
            <ul id="order-nav" class="nav-content collapse  {{ request()->is('admin/orders')?'show':'' }} {{ request()->is('admin/orders*')?'show':'' }}  " data-bs-parent="#sidebar-nav">
                <li> <a href="{{ route('allorders') }}" class="{{ request()->is('admin/orders*')?'nav-link active':'' }}"> <i class=" bi bi-circle active "></i><span>Orders</span></a></li>
            </ul>
        </li>
        @endif
        @if ($user && $user->hasPermissionByRole('view custom order'))
        <li class=" {{ request()->is('admin/custom-orders')?'nav-item active':'' }} {{ request()->is('admin/custom-orders/*')?'nav-item active':'' }}  ">
            <a class="nav-link" data-bs-target="#custom_order-nav" data-bs-toggle="collapse" href="javascripit:void(0);"> <i class="bx bxs-shopping-bag-alt  "></i><span>Custom-orders</span> &nbsp;@if($count_custom_order)<span class="badge bg-danger">{{$count_custom_order}}</span>@endif <i class="bi bi-chevron-down ms-auto"></i> </a>
            <ul id="custom_order-nav" class="nav-content collapse  {{ request()->is('admin/custom-orders')?'show':'' }} {{ request()->is('admin/custom-orders*')?'show':'' }}  " data-bs-parent="#sidebar-nav">
                <li> <a href="{{ route('custom_orders') }}" class="{{ request()->is('admin/custom-orders*')?'nav-link active':'' }}"> <i class=" bi bi-circle active "></i><span>Custom orders</span></a></li>
            </ul>
        </li>
        @endif

        @if ($user && $user->hasPermissionByRole('view_return_request'))
        <li class=" {{ request()->is('admin/return_request')?'nav-item active':'' }}  ">
            <a class="nav-link" data-bs-target="#return-nav" data-bs-toggle="collapse" href="javascripit:void(0);"> <i class="bx bx-download"></i><span>Return Request</span> &nbsp; @if($count_return_request)<span class="badge bg-danger">{{$count_return_request}}</span>@endif <i class="bi bi-chevron-down ms-auto"></i> </a>
            <ul id="return-nav" class="nav-content collapse  {{ request()->is('admin/return_request')?'show':'' }}  " data-bs-parent="#sidebar-nav">
                <li> <a href="{{ route('return_request') }}" class="{{ request()->is('admin/return_request*')?'nav-link active':'' }}"> <i class=" bi bi-circle active "></i><span>List Return Requests</span> </a></li>
            </ul>
        </li>
        @endif


        @if ($user && $user->hasPermissionByRole('view payment'))
        <li class=" {{ request()->is('admin/all-payments')?'nav-item active':'' }} ">
            <a class="nav-link" data-bs-target="#pay-nav" data-bs-toggle="collapse" href="javascripit:void(0);"> <i class="bx bx-money-withdraw"></i><span>Payment Report</span> <i class="bi bi-chevron-down ms-auto"></i> </a>
            <ul id="pay-nav" class="nav-content collapse  {{ request()->is('admin/all-payments')?'show':'' }}" data-bs-parent="#sidebar-nav">
                <li> <a href="{{ route('all-payments') }}" class="{{ request()->is('admin/all-payments*')?'nav-link active':'' }}"> <i class=" bi bi-circle active "></i><span>Payments</span></a></li>
            </ul>
        </li>
        @endif

        {{-- @if ($user && $user->hasPermissionByRole('view transaction'))
        <li class=" {{ request()->is('admin/transaction')?'nav-item active':'' }} {{ request()->is('admin/transaction*')?'nav-item active':'' }}  ">
            <a class="nav-link" data-bs-target="#transaction-nav" data-bs-toggle="collapse" href="javascripit:void(0);"> <i class="bx bxs-wallet"></i><span>Transactions</span><i class="bi bi-chevron-down ms-auto"></i> </a>
            <ul id="transaction-nav" class="nav-content collapse  {{ request()->is('admin/transaction')?'show':'' }} {{ request()->is('admin/transaction*')?'show':'' }}  " data-bs-parent="#sidebar-nav">
                <li> <a href="{{ route('all-transactions') }}" class="{{ request()->is('admin/transaction*')?'nav-link active':'' }}"> <i class=" bi bi-circle active "></i><span>Transactions </span></a></li>
            </ul>
        </li>
        @endif
 --}}

        @if ($user && $user->hasPermissionByRole('view blog') || $user->hasPermissionByRole('view blog category') || $user->hasPermissionByRole('view blog comment'))
        <li class=" {{ request()->is('admin/blog-categories')?'nav-item active':'' }} {{ request()->is('admin/blog-comments')?'nav-item active':'' }} {{ request()->is('admin/blog/category*')?'nav-item active':'' }} {{ request()->is('admin/blogs*')?'nav-item active':'' }} {{ request()->is('admin/blogs')?'nav-item active':'' }}">
            <a class="nav-link" data-bs-target="#blog-nav" data-bs-toggle="collapse" href="javascripit:void(0);"> <i class=" ri-newspaper-fill"></i><span>News / Blogs</span><i class="bi bi-chevron-down ms-auto"></i> </a>
            <ul id="blog-nav" class="nav-content collapse {{ request()->is('admin/blog-categories')?'show':'' }} {{ request()->is('admin/blog-comments')?'show':'' }} {{ request()->is('admin/blog/category*')?'show':'' }} {{ request()->is('admin/blogs*')?'show':'' }} {{ request()->is('admin/blogs')?'show':'' }}" data-bs-parent="#sidebar-nav">
                @if($user->hasPermissionByRole('view blog'))
                <li> <a href="{{ route('blogs') }}" class="{{ request()->is('admin/blogs')?'nav-link active':'' }} {{ request()->is('admin/blogs*')?'nav-link active':'' }}"> <i class=" bi bi-circle active "></i><span>List Blogs</span></a></li>
                @endif
                @if($user->hasPermissionByRole('view blog category'))
                <li> <a href="{{ route('blog-categories') }}" class="{{ request()->is('admin/blog-categories')?'nav-link active':'' }} {{ request()->is('admin/blog/category*')?'nav-link active':''}}"> <i class=" bi bi-circle active "></i><span> Blog Categories</span></a></li>
                @endif
                @if($user->hasPermissionByRole('view blog comment'))
                <li> <a href="{{ route('blog-comments') }}" class="{{ request()->is('admin/blog-comments')?'nav-link active':'' }} {{ request()->is('admin/blog/category*')?'nav-link active':''}}"> <i class=" bi bi-circle active "></i><span> Blog Comments</span></a></li>
                @endif
            </ul>
        </li>
        @endif


        @if ($user && $user->hasPermissionByRole('view_advertisment'))
        <li class=" {{ request()->is('admin/adverstisements')?'nav-item active':'' }}  ">
            <a class="nav-link" data-bs-target="#adv-nav" data-bs-toggle="collapse" href="javascripit:void(0);"> <i class=" ri-layout-top-2-line"></i><span>Adverstisements </span><i class="bi bi-chevron-down ms-auto"></i> </a>
            <ul id="adv-nav" class="nav-content collapse  {{ request()->is('admin/adverstisements')?'show':'' }}  " data-bs-parent="#sidebar-nav">
                <li> <a href="{{ route('adverstisements') }}" class="{{ request()->is('admin/adverstisements*')?'nav-link active':'' }}"> <i class=" bi bi-circle active "></i><span>All Adverstisements</span> </a></li>
            </ul>
        </li>
        @endif

        @if ($user && $user->hasPermissionByRole('view_banners'))
        <li class=" {{ request()->is('admin/banners')?'nav-item active':'' }}  ">
            <a class="nav-link" data-bs-target="#banner-nav" data-bs-toggle="collapse" href="javascripit:void(0);"> <i class=" ri-layout-top-2-line"></i><span>Banner Managements</span><i class="bi bi-chevron-down ms-auto"></i> </a>
            <ul id="banner-nav" class="nav-content collapse  {{ request()->is('admin/banners')?'show':'' }}  " data-bs-parent="#sidebar-nav">
                <li> <a href="{{ route('banners') }}" class="{{ request()->is('admin/banners*')?'nav-link active':'' }}"> <i class=" bi bi-circle active "></i><span>Slider Banners</span> </a></li>
            </ul>
        </li>
        @endif

        @if ($user && $user->hasPermissionByRole('view_shipping_charge'))
        <li class=" {{ request()->is('admin/shipping-charges')?'nav-item active':'' }}  ">
            <a class="nav-link" data-bs-target="#shipping-nav" data-bs-toggle="collapse" href="javascripit:void(0);"> <i class="ri-map-pin-2-fill"></i><span>Shipping Management</span><i class="bi bi-chevron-down ms-auto"></i> </a>
            <ul id="shipping-nav" class="nav-content collapse  {{ request()->is('admin/shipping-charges')?'show':'' }}  " data-bs-parent="#sidebar-nav">
                <li> <a href="{{ url('admin/shipping-charges') }}" class="{{ request()->is('admin/shipping-charges*')?'nav-link active':'' }}"> <i class=" bi bi-circle active "></i><span>Shipping Charges</span></a></li>
            </ul>
        </li>
        @endif

        @if ($user && $user->hasPermissionByRole('view_cmspage') || $user->hasPermissionByRole('create_cmspage'))
        <li class=" {{ request()->is('admin/cms-pages')?'nav-item active':'' }}  {{ request()->is('admin/add_cms_page')?'nav-item active':'' }}  {{ request()->is('admin/edit_cms_page')?'nav-item active':'' }}  ">
            <a class="nav-link" data-bs-target="#cms-nav" data-bs-toggle="collapse" href="javascripit:void(0);"> <i class="bx bxl-microsoft-teams"></i><span>Cms Pages Management</span><i class="bi bi-chevron-down ms-auto"></i> </a>
            <ul id="cms-nav" class="nav-content collapse  {{ request()->is('admin/cms-pages')?'show':'' }} {{ request()->is('admin/add_cms_page')?'show':'' }}  {{ request()->is('admin/edit_cms_page*')?'show':'' }}  " data-bs-parent="#sidebar-nav">
                @if($user->hasPermissionByRole('view_cmspage'))
                <li> <a href="{{ url('admin/add_cms_page') }}" class="{{ request()->is('admin/add_cms_page*')?'nav-link active':'' }}"> <i class=" bi bi-circle active "></i><span>Add Cms Page</span></a></li>
                @endif
                @if($user->hasPermissionByRole('create_cmspage'))
                <li> <a href="{{ url('admin/cms-pages') }}" class="{{ request()->is('admin/cms-pages*')?'nav-link active':'' }} {{ request()->is('admin/edit_cms_page*')?'nav-link active':'' }}"> <i class=" bi bi-circle active "></i><span>All Cms Pages</span></a></li>
                @endif
            </ul>
        </li>
        @endif

        @if ($user && $user->hasPermissionByRole('send_newsletters') || $user->hasPermissionByRole('view_newsletters'))
        <li class=" {{ request()->is('admin/newslettersubscribers')?'nav-item active':'' }} {{ request()->is('admin/send-email-to-all')?'nav-item active':'' }} ">
            <a class="nav-link" data-bs-target="#news-nav" data-bs-toggle="collapse" href="javascripit:void(0);"> <i class="bx bxs-file"></i><span>Newsletter Subscribers</span><i class="bi bi-chevron-down ms-auto"></i> </a>
            <ul id="news-nav" class="nav-content collapse  {{ request()->is('admin/newslettersubscribers')?'show':'' }}  {{ request()->is('admin/send-email-to-all')?'show':'' }}  " data-bs-parent="#sidebar-nav">
                @if($user->hasPermissionByRole('view_newsletters'))
                <li> <a href="{{ route('newslettersubscribers') }}" class="{{ request()->is('admin/newslettersubscribers*')?'nav-link active':'' }}"> <i class=" bi bi-circle active "></i><span>All Newsletter Subscribers</span> </a></li>
                @endif
                @if($user->hasPermissionByRole('send_newsletters'))
                <li> <a href="{{ route('send-email-to-all') }}" class="{{ request()->is('admin/send-email-to-all')?'nav-link active':'' }}"> <i class=" bi bi-circle active "></i><span>Sent Email To All</span> </a></li>
                @endif
            </ul>
        </li>
        @endif

        @if ($user && $user->hasPermissionByRole('view_faq') || $user->hasPermissionByRole('add_faq'))
        <li class=" {{ request()->is('admin/faq')?'nav-item active':'' }}  ">
            <a class="nav-link" data-bs-target="#faq-nav" data-bs-toggle="collapse" href="javascripit:void(0);"> <i class="bx bxs-file"></i><span>FAQ</span><i class="bi bi-chevron-down ms-auto"></i> </a>
            <ul id="faq-nav" class="nav-content collapse  {{ request()->is('admin/faq')?'show':'' }}  {{ request()->is('admin/faq/add')?'show':'' }}  {{ request()->is('admin/allfaq')?'show':'' }}   " data-bs-parent="#sidebar-nav">
                @if($user->hasPermissionByRole('view_faq'))
                <li> <a href="{{ route('allfaq') }}" class="{{ request()->is('admin/allfaq*')?'nav-link active':'' }}"> <i class=" bi bi-circle active "></i><span> All FAQ</span> </a></li>
                @endif
                @if($user->hasPermissionByRole('add_faq'))
                <li> <a href="{{ route('add_faq') }}" class="{{ request()->is('admin/faq/add*')?'nav-link active':'' }}"> <i class=" bi bi-circle active "></i><span>Add FAQs</span> </a></li>
                @endif
            </ul>
        </li>
        @endif

        @if ($user && $user->hasPermissionByRole('view_product_rating'))
        <li class=" {{ request()->is('admin/ratings')?'nav-item active':'' }} {{ request()->is('admin/ratings*')?'nav-item active':'' }}   ">
            <a class="nav-link" data-bs-target="#ratings-nav" data-bs-toggle="collapse" href="javascripit:void(0);"> <i class="bx bxs-star"></i><span>Product Ratings</span><i class="bi bi-chevron-down ms-auto"></i> </a>
            <ul id="ratings-nav" class="nav-content collapse  {{ request()->is('admin/ratings')?'show':'' }} {{ request()->is('admin/ratings*')?'show':'' }} " data-bs-parent="#sidebar-nav">
                <li> <a href="{{ url('admin/ratings')}}" class="{{ request()->is('admin/ratings*')?'nav-link active':'' }} "> <i class=" bi bi-circle active "></i><span>List Product Ratings</span></a></li>
            </ul>
        </li>
        @endif


        @if($user && $user->hasPermissionByRole('view product reports') || $user->hasPermissionByRole('view stock product reports') || $user->hasPermissionByRole('view stock transferred reports') || $user->hasPermissionByRole('view order reports') || $user->hasPermissionByRole('view order product reports') || $user->hasPermissionByRole('view custom order reports') || $user->hasPermissionByRole('view vendor reports') || $user->hasPermissionByRole('view customer reports'))
        <li class="{{ request()->is('admin/report/custom-order-report')?'nav-item active':'' }} {{ request()->is('admin/report/stock-report')?'nav-item active':'' }} {{ request()->is('admin/report/vendors-report')?'nav-item active':'' }} {{ request()->is('admin/report/order-report')?'nav-item active':'' }}  {{ request()->is('admin/report/order-report')?'nav-item active':'' }} {{ request()->is('admin/report/order-product-report')?'nav-item active':'' }} {{ request()->is('admin/report/transfer-stock-report')?'nav-item active':'' }} {{ request()->is('admin/report/product-report')?'nav-item active':'' }}   ">
            <a class="nav-link" data-bs-target="#reports-nav" data-bs-toggle="collapse" href="javascripit:void(0);"> <i class="bi bi-graph-up-arrow"></i><span>Reports</span><i class="bi bi-chevron-down ms-auto"></i> </a>
            <ul id="reports-nav" class="nav-content collapse {{ request()->is('admin/report/vendors-report')?'show':'' }} {{ request()->is('admin/report/transfer-stock-report')?'show':'' }} {{ request()->is('admin/report/customer-report')?'show':'' }} {{ request()->is('admin/report/stock-report')?'show':'' }} {{ request()->is('admin/report/custom-order-report')?'show':'' }} {{ request()->is('admin/report/order-report')?'show':'' }} {{ request()->is('admin/report/product-report')?'show':'' }} {{ request()->is('admin/report/order-product-report')?'show':'' }} " data-bs-parent="#sidebar-nav">
                @if ($user && $user->hasPermissionByRole('view product reports'))
                <li> <a href="{{ url('admin/report/product-report')}}" class="{{ request()->is('admin/report/product-report')?'nav-link active':'' }} "> <i class=" bi bi-circle active "></i><span>Product Reports</span></a></li>
                @endif
                {{-- @if ($user && $user->hasPermissionByRole('view stock product reports'))
                <li> <a href="" class="{{ request()->is('admin/report/stock-report')?'nav-link active':'' }} "> <i class=" bi bi-circle active "></i><span>Stock Product Reports</span></a></li>
                @endif
                @if ($user && $user->hasPermissionByRole('view stock transferred reports'))
                <li> <a href="" class="{{ request()->is('admin/report/transfer-stock-report')?'nav-link active':'' }} "> <i class=" bi bi-circle active "></i><span>Transfer Stock Product Reports</span></a></li>
                @endif --}}
                @if ($user && $user->hasPermissionByRole('view order reports'))
                <li> <a href="{{ url('admin/report/order-report')}}" class="{{ request()->is('admin/report/order-report')?'nav-link active':'' }} "> <i class=" bi bi-circle active "></i><span>Order Reports</span></a></li>
                @endif
                @if ($user && $user->hasPermissionByRole('view order product reports'))
                <li> <a href="{{ url('admin/report/order-product-report')}}" class="{{ request()->is('admin/report/order-product-report')?'nav-link active':'' }} "> <i class=" bi bi-circle active "></i><span>Order Product Reports</span></a></li>
                @endif
                @if ($user && $user->hasPermissionByRole('view custom order reports'))
                <li> <a href="{{ url('admin/report/custom-order-report')}}" class="{{ request()->is('admin/report/custom-order-report')?'nav-link active':'' }} "> <i class=" bi bi-circle active "></i><span>Custom Order Reports</span></a></li>
                @endif
                @if ($user && $user->hasPermissionByRole('view customer reports'))
                <li> <a href="{{ url('admin/report/customer-report')}}" class="{{ request()->is('admin/report/customer-report')?'nav-link active':'' }} "> <i class=" bi bi-circle active "></i><span>Customer Reports</span></a></li>
                @endif
                @if ($user && $user->hasPermissionByRole('view vendor reports'))
                <li> <a href="{{ url('admin/report/vendors-report')}}" class="{{ request()->is('admin/report/vendors-report')?'nav-link active':'' }} "> <i class=" bi bi-circle active "></i><span>Vendor Reports </span></a></li>
                @endif
            </ul>
        </li>
        @endif

        <li class=" {{ request()->is('admin/account-deletion-requests')?'nav-item active':'' }} ">
        <a class="nav-link" href="{{ url('admin/account-deletion-requests') }}"> <i class="bi bi-person-bounding-box  "></i><span>Account Deletion Requests</span><i class="bi bi-chevron-down ms-auto"></i> </a>
        </li>
        <li class="nav-heading">Business Settings</li>
        @if ($user && $user->hasPermissionByRole('view email template')  || $user->hasPermissionByRole('view currency') || $user->hasPermissionByRole('view invoice') || $user->hasPermissionByRole('manage_appsetting'))
        <li class="{{ request()->is('admin/restaurant-delivery-settings')?'nav-item active':'' }} {{ request()->is('admin/withdraw-settings')?'nav-item active':'' }} {{ request()->is('admin/delivery-settings')?'nav-item active':'' }} {{ request()->is('admin/banks')?'nav-item active':'' }} {{ request()->is('admin/tips')?'nav-item active':'' }} {{ request()->is('admin/appsettings')?'nav-item active':'' }} {{ request()->is('admin/tax-settings')?'nav-item active':'' }} {{ request()->is('admin/currency*')?'nav-item active':'' }}  {{ request()->is('admin/currencies')?'nav-item active':'' }}  {{ request()->is('admin/invoice-setting*')?'nav-item active':'' }} {{ request()->is('admin/email-template*')?'nav-item active':'' }}  ">
            <a class="nav-link" data-bs-target="#app-nav" data-bs-toggle="collapse" href="javascripit:void(0);"> <i class=" ri-group-2-fill"></i><span>Website Settings</span><i class="bi bi-chevron-down ms-auto"></i> </a>
            <ul id="app-nav" class="nav-content collapse {{ request()->is('admin/delivery-settings')?'show':'' }} {{ request()->is('admin/restaurant-delivery-settings')?'show':'' }} {{ request()->is('admin/withdraw-settings')?'show':'' }} {{ request()->is('admin/banks')?'show':'' }} {{ request()->is('admin/tips')?'show':'' }} {{ request()->is('admin/currency*')?'show':'' }} {{ request()->is('admin/tax-settings')?'show':'' }} {{ request()->is('admin/currencies')?'show':'' }}    {{ request()->is('admin/appsettings')?'show':'' }} {{ request()->is('admin/invoice-setting*')?'show':'' }}  {{ request()->is('admin/email-template*')?'show':'' }}  " data-bs-parent="#sidebar-nav">
                @if($user->hasPermissionByRole('manage_appsetting'))
                <li> <a href="{{ url('admin/appsettings') }}" class="{{ request()->is('admin/appsettings*')?'nav-link active':'' }}"> <i class=" bi bi-circle active "></i><span>General Settings</span></a></li>
                @endif
                @if($user->hasPermissionByRole('manage_appsetting'))
                <li> <a href="{{ url('admin/tips') }}" class="{{ request()->is('admin/tips')?'nav-link active':'' }}"> <i class=" bi bi-circle active "></i><span>Tips Setting</span></a></li>
                @endif
                @if($user->hasPermissionByRole('manage_appsetting'))
                <li> <a href="{{ url('admin/banks') }}" class="{{ request()->is('admin/banks')?'nav-link active':'' }}"> <i class=" bi bi-circle active "></i><span>Banks Account Setting</span></a></li>
                @endif
                @if($user->hasPermissionByRole('manage_appsetting'))
                <li> <a href="{{ url('admin/delivery-settings') }}" class="{{ request()->is('admin/delivery-settings')?'nav-link active':'' }}"> <i class=" bi bi-circle active "></i><span>Ecommerce Delivery Setting</span></a></li>
                @endif
                @if($user->hasPermissionByRole('manage_appsetting'))
                <li> <a href="{{ url('admin/restaurant-delivery-settings') }}" class="{{ request()->is('admin/restaurant-delivery-settings')?'nav-link active':'' }}"> <i class=" bi bi-circle active "></i><span>Restaurant Delivery Setting</span></a></li>
                @endif
                @if($user->hasPermissionByRole('view email template'))
                <li> <a href="{{ route('email_templates') }}" class="{{ request()->is('admin/email-template*')?'nav-link active':'' }}"> <i class=" bi bi-circle active "></i><span>Email Settings</span></a></li>
                @endif
                @if($user->hasPermissionByRole('view invoice'))
                <li> <a href="{{ route('invoice-settings') }}" class="{{ request()->is('admin/invoice-setting*')?'nav-link active':'' }}"> <i class=" bi bi-circle active "></i><span>Invoice Settings</span></a></li>
                @endif
                {{-- @if($user->hasPermissionByRole('view currency'))
                <li> <a href="{{ route('currencies') }}" class="{{ request()->is('admin/currency*')?'nav-link active':'' }} {{ request()->is('admin/currencies*')?'nav-link active':'' }}"> <i class=" bi bi-circle active "></i><span>Currencies</span></a></li>
                @endif --}}
                @if($user->hasPermissionByRole('view tax'))
                <li> <a href="{{ route('tax-settings.index') }}" class="{{ request()->is('admin/tax-setting*')?'nav-link active':'' }}"> <i class=" bi bi-circle active "></i><span>Tax Settings</span></a></li>
                @endif
                @if($user->hasPermissionByRole('view tax'))
                <li> <a href="{{ route('withdraw-settings.index') }}" class="{{ request()->is('admin/withdraw-settings')?'nav-link active':'' }}"> <i class=" bi bi-circle active "></i><span>Withdrawal Settings</span></a></li>
                @endif
            </ul>
        </li>
        @endif

        @if ($user && $user->hasPermissionByRole('view country') || $user->hasPermissionByRole('view city')|| $user->hasPermissionByRole('view state'))
        <li class="{{ request()->is('admin/sub-cities')?'nav-item active':'' }}{{ request()->is('admin/streets')?'nav-item active':'' }}{{ request()->is('admin/states')?'nav-item active':'' }} {{ request()->is('admin/countries')?'nav-item active':'' }} {{ request()->is('admin/country*')?'nav-item active':'' }} {{ request()->is('admin/cities')?'nav-item active':'' }} {{ request()->is('admin/city*')?'nav-item active':'' }} {{ request()->is('admin/state*')?'nav-item active':'' }}">
            <a class="nav-link" data-bs-target="#location-nav" data-bs-toggle="collapse" href="javascripit:void(0);"> <i class="ri ri-map-2-fill"></i><span>Location</span><i class="bi bi-chevron-down ms-auto"></i> </a>
            <ul id="location-nav" class="nav-content collapse {{ request()->is('admin/countries')?'show':'' }}  {{ request()->is('admin/country*')?'show':'' }} {{ request()->is('admin/state*')?'show':'' }} {{ request()->is('admin/city*')?'show':'' }} {{ request()->is('admin/cities')?'show':'' }} {{ request()->is('admin/states')?'show':'' }} {{ request()->is('admin/streets')?'show':'' }} {{ request()->is('admin/sub-cities')?'show':'' }} " data-bs-parent="#sidebar-nav">
                @if($user->hasPermissionByRole('view country'))
                <li> <a href="{{ url('admin/countries') }}" class="{{ request()->is('admin/country*')?'nav-link active':'' }} {{ request()->is('admin/countries')?'nav-link active':'' }}"> <i class=" bi bi-circle active "></i><span>Countries</span></a></li>
                @endif
                @if($user->hasPermissionByRole('view state'))
                <li> <a href="{{ url('admin/states') }}" class="{{ request()->is('admin/state*')?'nav-link active':'' }} {{ request()->is('admin/states')?'nav-link active':'' }}"> <i class=" bi bi-circle active "></i><span>States</span></a></li>
                @endif
                @if($user->hasPermissionByRole('view city'))
                <li> <a href="{{ url('admin/cities') }}" class="{{ request()->is('admin/cities')?'nav-link active':'' }} {{ request()->is('admin/city*')?'nav-link active':'' }}"> <i class=" bi bi-circle active "></i><span>Cities</span></a></li>
                @endif
                @if($user->hasPermissionByRole('view city'))
                <li> <a href="{{ url('admin/sub-cities') }}" class="{{ request()->is('admin/sub-cities')?'nav-link active':'' }} {{ request()->is('admin/sub-cities*')?'nav-link active':'' }}"> <i class=" bi bi-circle active "></i><span>Sub Cities</span></a></li>
                @endif
                @if($user->hasPermissionByRole('view city'))
                <li> <a href="{{ url('admin/streets') }}" class="{{ request()->is('admin/streets')?'nav-link active':'' }} {{ request()->is('admin/streets*')?'nav-link active':'' }}"> <i class=" bi bi-circle active "></i><span>Streets</span></a></li>
                @endif

            </ul>
        </li>
        @endif
{{--
        @if ($user && $user->hasPermissionByRole('view warehouse'))
        <li class=" {{ request()->is('admin/all-warehouse')?'nav-item active':'' }} {{ request()->is('admin/warehouses*')?'nav-item active':'' }}">
            <a class="nav-link" data-bs-target="#werehouse-nav" data-bs-toggle="collapse" href="javascripit:void(0);"> <i class=" ri ri-home-3-line   "></i><span>Warehouse</span><i class="bi bi-chevron-down ms-auto"></i> </a>
            <ul id="werehouse-nav" class="nav-content collapse {{ request()->is('admin/all-warehouse')?'show':'' }}  {{ request()->is('admin/warehouses*')?'show':'' }} " data-bs-parent="#sidebar-nav">
                <li> <a href="{{ url('admin/all-warehouse') }}" class="{{ request()->is('admin/all-warehouse*')?'nav-link active':'' }} {{ request()->is('admin/warehouses*')?'nav-link active':'' }}"> <i class=" bi bi-circle active "></i><span>Warehouse</span></a></li>
            </ul>
        </li>
        @endif --}}
        @endif

        @if(Auth::guard('admin')->user()->type=="vendor" || Auth::guard('admin')->user()->type=="Ecommerce Manager" || Auth::guard('admin')->user()->type=="Hotel Manager" || Auth::guard('admin')->user()->type=="Restaurant Manager")
        <li class="pt-4 {{ request()->is('admin/update-vendor-details')?'nav-item active':'' }} {{ request()->is('admin/update-vendor-bank-details')?'nav-item active':'' }} {{ request()->is('admin/update-vendor-business-details')?'nav-item active':'' }}">
            <a class="nav-link " data-bs-target="#vendordetails-nav" data-bs-toggle="collapse" href="javascripit:void(0);"> <i class="bi bi-person-bounding-box  "></i><span>Your Details</span><i class="bi bi-chevron-down ms-auto"></i> </a>
            <ul id="vendordetails-nav" class=" nav-content collapse {{ request()->is('admin/update-vendor-details')?'show':'' }} {{ request()->is('admin/update-vendor-bank-details')?'show':'' }} {{ request()->is('admin/update-vendor-business-details')?'show':'' }}" data-bs-parent="#sidebar-nav">
                <li> <a href="{{ route('updatevendordetails') }}" class="{{ request()->is('admin/update-vendor-details*')?'nav-link active':'' }}"> <i class=" bi bi-circle active "></i><span>Personal Details</span> </a></li>
                <li> <a href="{{ route('updatevendorbusinessdetails') }}" class="{{ request()->is('admin/update-vendor-business-details*')?'nav-link active':'' }}"> <i class=" bi bi-circle active "></i><span>Business Details</span></a></li>
                <li> <a href="{{ route('updatevendorbankdetails') }}" class="{{ request()->is('admin/update-vendor-bank-details*')?'nav-link active':'' }}"> <i class="bi bi-circle"></i><span>Bank Details</span></a></li>
            </ul>
        </li>
        @endif

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

