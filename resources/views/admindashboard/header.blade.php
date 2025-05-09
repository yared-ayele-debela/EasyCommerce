
@php
use App\Models\OutOfStockRequest;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
    $admin=Auth::guard('admin')->user();

    $vendor=$admin->vendor_id;
    // dd($notifications);
    $newNotifications = OutOfStockRequest::with(['product', 'customer'])
    ->where('vendor_id', $vendor)
    ->where('is_new', 0)
    ->latest()
    ->get();

@endphp
<header id="header" class="header fixed-top d-flex align-items-center">
    <div class="d-flex align-items-center justify-content-between"> <a href="{{ route('maindashboard') }}" class="logo d-flex align-items-center"> <img src="{{ $appsettings[0]['logo'] }}" alt=""> </a> <i class="bi bi-list toggle-sidebar-btn"></i></div>

    <!-- layouts/dashboard.blade.php -->
    <nav class="header-nav ms-auto">
        <ul class="d-flex align-items-center">
            <li class="nav-item dropdown">
                <a class="nav-link nav-icon " href="#" data-bs-toggle="dropdown" aria-expanded="true"> <i class="bi bi-bell"></i> <span class="badge bg-primary badge-number">{{ $newNotifications->count() }}</span> </a>
                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow notifications " data-popper-placement="bottom-end" style="position: absolute; inset: 0px 0px auto auto; margin: 0px; transform: translate3d(0.1875px, 48px, 0px);">
                   <li class="dropdown-header"> You have {{ $newNotifications->count() }} new notifications <a href="{{ route('vendor-notification') }}"><span class="badge rounded-pill bg-primary p-2 ms-2">View all</span></a></li>
                   <li>
                      <hr class="dropdown-divider">
                   </li>
                   @foreach ($newNotifications as $notification)
                   <li class="notification-item">
                      <i class="bi bi-app-indicator text-success"></i>
                      <div>
                         <h4>{{ $notification->customer->name }}</h4>
                         <p>{{ $notification->message ?? '—' }}</p>
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
                   <li class="dropdown-footer"> <a href="#">Show all notifications</a></li>
                </ul>
             </li>
                        <li class="nav-item dropdown pe-3">
                <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown"> <img src="{{ Auth::guard('admin')->user()->image }}" alt="Profile" class="rounded-circle"> <span class="d-none d-md-block dropdown-toggle ps-2">{{ Auth::guard('admin')->name }}</span> </a>
                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                    <li class="dropdown-header">
                        <h6>{{ Auth::guard('admin')->name }}</h6>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li>
                        <a class="dropdown-item d-flex align-items-center" href="{{ route('updateadmindetails') }}"> <i class="bi bi-person"></i> <span>My Profile</span> </a></li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li> <a class="dropdown-item d-flex align-items-center" href="{{ route('update_admin_password') }}"> <i class="bi bi-lock"></i> <span>Change Password</span> </a></li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <hr class="dropdown-divider">
            </li>
            <li> <a class="dropdown-item d-flex align-items-center" href="{{ route('adminlogout') }}"> <i class="bi bi-box-arrow-right"></i> <span>Sign Out</span> </a></li>
        </ul>

    </nav>
    @include('sweetalert::alert')

</header>
