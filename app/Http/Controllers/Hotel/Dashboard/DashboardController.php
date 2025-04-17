<?php

namespace App\Http\Controllers\Hotel\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Amenity;
use App\Models\Hotel;
use App\Models\HotelCategory;
use App\Models\Reservation;
use App\Models\Room;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    //
    public function index()

    {
        $total_hotel=Hotel::count();
        $total_rooms=Room::count();
        $total_bookings=Reservation::count();
        $total_pending_bookings=Reservation::where('status', 'Pending')->count();
        $total_confirmed_bookings=Reservation::where('status', 'Confirmed')->count();
        $total_checked_in_bookings=Reservation::where('status', 'Checked_in')->count();
        $total_completed_bookings=Reservation::where('status', 'Completed')->count();
        $total_cancelled_bookings=Reservation::where('status', 'Cancelled')->count();

        $total_customers=User::count();
        $total_category=HotelCategory::count();
        $total_amenities=Amenity::count();
        return view('Hotel.dashboard.index', compact('total_hotel', 'total_rooms', 'total_bookings', 'total_customers', 'total_category', 'total_amenities', 'total_pending_bookings', 'total_confirmed_bookings', 'total_checked_in_bookings', 'total_completed_bookings', 'total_cancelled_bookings'));
    }
}
