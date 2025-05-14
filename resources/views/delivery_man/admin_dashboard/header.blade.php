@php
    use App\Models\DeliveryNotification;
    $notifications=DeliveryNotification::where('delivery_man_id',Auth::guard('deliverymen')->user()->id)->latest()->take(5)->get();
    $new_notifications=DeliveryNotification::where('delivery_man_id',Auth::guard('deliverymen')->user()->id)->where('seen_status','new')->latest()->get();
@endphp
@foreach ($appsettings as $setting)
<header id="header" class="header fixed-top d-flex align-items-center">
    <div class="d-flex align-items-center justify-content-between"> <img src="{{ $appsettings[0]['panel_icon']}}" style="max-width: 40px;" ><i class="bi bi-list toggle-sidebar-btn"></i></div>
  <nav class="header-nav ms-auto">
     <ul class="d-flex align-items-center">
        <li class="nav-item dropdown">
            <a class="nav-link nav-icon " href="#" data-bs-toggle="dropdown" aria-expanded="true"> <i class="bi bi-bell"></i> <span class="badge bg-primary badge-number">{{ $new_notifications->count() }}</span> </a>
            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow notifications " data-popper-placement="bottom-end" style="position: absolute; inset: 0px 0px auto auto; margin: 0px; transform: translate3d(0.1875px, 48px, 0px);">
               <li class="dropdown-header"> You have {{ $new_notifications->count() }} new notifications <a href="{{ url('delivery/restaurant-orders') }}"><span class="badge rounded-pill bg-primary p-2 ms-2">View all</span></a></li>
               <li>
                  <hr class="dropdown-divider">
               </li>
               @foreach($notifications as $notification)
               <li class="notification-item">
                  <i class="bi bi-app-indicator text-success"></i>
                  <div>
                     <h4>New Delivery Request</h4>
                     <p>Order ID: {{ $notification->order->id }}</p>
                     <p>Customer: {{ $notification->order->user->name }}</p>

                     @if($notification->status == 'pending')
                        <form action="{{ route('delivery.accept', $notification->id) }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-success">Accept</button>
                        </form>

                        <form action="{{ route('delivery.decline', $notification->id) }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-danger">Decline</button>
                        </form>
                        @else
                        <span class="badge bg-{{ $notification->status == 'accepted' ? 'success' : 'danger' }}">{{ ucfirst($notification->status) }}</span>
                        @endif
                     <p>{{ $notification->created_at->format('M d, Y H:i') }}</p>
                  </div>
               </li>
               <li>
                  <hr class="dropdown-divider">
               </li>
               @endforeach
               <li>
                  <hr class="dropdown-divider">
               </li>
               <li class="dropdown-footer"> <a href="{{ url('delivery/restaurant-orders') }}">Show all notifications</a></li>
            </ul>
         </li>
        <li class="nav-item d-block d-lg-none"> <a class="nav-link nav-icon search-bar-toggle " href="#"> <i class="bi bi-search"></i> </a></li>
        <li class="nav-item dropdown pe-3">
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
              <li>
                 <hr class="dropdown-divider text-white">
              </li>
              <li> <a class="dropdown-item d-flex align-items-center" href="{{ url('deilvery-boy/update-password') }}"> <i class="bi bi-gear"></i> <span>Changer Your Password</span> </a></li>
              <li>
                 <hr class="dropdown-divider text-white">
              </li>
              <li> <a class="dropdown-item d-flex align-items-center" href="{{ url('delivery-boy/update-profile') }}"> <i class="bi bi-person "></i> <span>Update Your Profile</span> </a></li>
              <li> <a class="dropdown-item d-flex align-items-center" href="{{ url('delivery-boy/logout') }}"> <i class="bi bi-person"></i> <span>Logout</span> </a></li>


           </ul>
        </li>
     </ul>
     @include('sweetalert::alert')
  </nav>
</header>
@endforeach

