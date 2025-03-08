@foreach ($appsettings as $setting)

<header id="header" class="header fixed-top d-flex align-items-center">
    <div class="d-flex align-items-center justify-content-between"> <img src="{{ asset('/storage/appsettings/'.$appsettings[0]['panel_icon']) }}" style="max-width: 180px;" ><i class="bi bi-list toggle-sidebar-btn"></i></div>
  <nav class="header-nav ms-auto">
     <ul class="d-flex align-items-center">
        <li class="nav-item d-block d-lg-none"> <a class="nav-link nav-icon search-bar-toggle " href="#"> <i class="bi bi-search"></i> </a></li>

        <li class="nav-item dropdown pe-3">
            {{-- {{ asset('/storage/delivery_man/'.$deliveryman->delivery_man_image) }} --}}
         @if(!empty(Auth::guard('deliverymen')->user()->delivery_man_image))
           <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
             <img class=" rounded object-cover" src="{{ asset('/storage/delivery_man/'.Auth::guard('deliverymen')->user()->delivery_man_image) }}" alt=""> &nbsp; {{ Auth::guard('deliverymen')->user()->first_name }}<span class="d-none d-md-block dropdown-toggle ps-2"></span>
            </a>
         @else
         <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
            <img class=" rounded object-cover" src="{{ asset('/storage/products/noimagefile.png') }}" alt=""> {{ Auth::guard('deliverymen')->user()->first_name }}<span class="d-none d-md-block dropdown-toggle ps-2"></span>
           </a>
         @endif
           <ul class="dropdown-menu border-0 shadow-sm dropdown-menu-end dropdown-menu-arrow profile">
              <li class="dropdown-header">
                 <h6></h6>
                 <span>Settings</span>
              </li>
              <li>
                 <hr class="dropdown-divider text-white">
              </li>
              <li> <a class="dropdown-item d-flex align-items-center" href="{{ url('delivery-boy/logout') }}"> <i class="bi bi-person"></i> <span>Logout</span> </a></li>
              <li>
                 <hr class="dropdown-divider text-white">
              </li>
              <li> <a class="dropdown-item d-flex align-items-center" href="{{ url('deilvery-boy/update-password') }}"> <i class="bi bi-gear"></i> <span>Changer Your Password</span> </a></li>
              <li>
                 <hr class="dropdown-divider text-white">
              </li>
              <li> <a class="dropdown-item d-flex align-items-center" href="{{ url('delivery-boy/update-profile') }}"> <i class="bi bi-person "></i> <span>Update Your Profile</span> </a></li>


           </ul>
        </li>
     </ul>
     @include('sweetalert::alert')
  </nav>
</header>
@endforeach

