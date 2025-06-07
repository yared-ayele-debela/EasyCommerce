<?php

namespace App\Http\Controllers\Hotel\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Amenity;
use App\Models\Hotel;
use App\Models\HotelCategory;
use App\Models\Reservation;
use App\Models\Room;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class DashboardController extends Controller
{
    //
   public function index(Request $request)
{
    // ───────────────────────────────────────────────────────────────
    // 1. Who is logged-in?
    // ───────────────────────────────────────────────────────────────
    $admin    = Auth::guard('admin')->user();
    $isSuper  = strcasecmp($admin->type, string2: 'Super Admin') === 0;   // true / false

    // ───────────────────────────────────────────────────────────────
    // 2. Which hotel IDs are we allowed to “see”?
    //    • super admin  →  ALL hotel IDs
    //    • others       →  ONLY hotels they own (admin_id = current admin)
    // ───────────────────────────────────────────────────────────────
    $hotelIds = $isSuper
        ? Hotel::pluck('id')                                // collection of all IDs
        : Hotel::where('admin_id', $admin->id)->pluck('id');

    // This query builder will be re-used for every reservation-based stat
    $reservationBase = Reservation::when(!$isSuper, fn ($q) => $q->whereIn('hotel_id', $hotelIds));

    // ───────────────────────────────────────────────────────────────
    // 3. Counts
    // ───────────────────────────────────────────────────────────────
    $total_hotel     = $hotelIds->count();                                      // owned or all
    $total_rooms     = Room   ::when(!$isSuper, fn ($q) => $q->whereIn('hotel_id', $hotelIds))->count();
    $total_bookings  = (clone $reservationBase)->count();

    // Bookings by status
    $total_pending_bookings     = (clone $reservationBase)->where('status', 'Pending')->count();
    $total_confirmed_bookings   = (clone $reservationBase)->where('status', 'Confirmed')->count();
    $total_checked_in_bookings  = (clone $reservationBase)->where('status', 'Checked_in')->count();
    $total_completed_bookings   = (clone $reservationBase)->where('status', 'Completed')->count();
    $total_cancelled_bookings   = (clone $reservationBase)->where('status', 'Cancelled')->count();

    // Customers
    $total_customers = $isSuper
        ? User::count()
        : (clone $reservationBase)->distinct('user_id')->count('user_id');      // unique guests

    // Global data that does not depend on hotel ownership
    $total_category  = HotelCategory::count();
    $total_amenities = Amenity::count();

    // ───────────────────────────────────────────────────────────────
    // 4. Month-by-month & status pie
    // ───────────────────────────────────────────────────────────────
    $monthlyReservations = (clone $reservationBase)
        ->selectRaw('MONTH(check_in_date) AS month, COUNT(*) AS total')
        ->groupBy('month')
        ->orderBy('month')
        ->pluck('total', 'month');

    $statusCounts = (clone $reservationBase)
        ->selectRaw('status, COUNT(*) AS total')
        ->groupBy('status')
        ->pluck('total', 'status');

    $monthlyIncome = (clone $reservationBase)
        ->selectRaw('MONTH(check_in_date) AS month, SUM(final_price) AS income')
        ->groupBy('month')
        ->orderBy('month')
        ->pluck('income', 'month');

    $guestCounts = [
        'Adults'   => (clone $reservationBase)->sum('total_adult'),
        'Children' => (clone $reservationBase)->sum('total_child'),
        'Infants'  => (clone $reservationBase)->sum('total_infant'),
    ];

    // ───────────────────────────────────────────────────────────────
    // 5. Top 5 hotels (only among the hotels we can see)
    // ───────────────────────────────────────────────────────────────
    $topHotels = (clone $reservationBase)
        ->selectRaw('hotel_id, COUNT(*) AS total')
        ->groupBy('hotel_id')
        ->orderByDesc('total')
        ->take(5)
        ->get();

    $hotelNames = Hotel::whereIn('id', $topHotels->pluck('hotel_id'))
        ->pluck('name', 'id');

    $topHotelsFormatted = $topHotels->map(fn ($item) => [
        'name'  => $hotelNames[$item->hotel_id] ?? 'Unknown',
        'total' => $item->total,
    ]);

    // List of hotel records (for cards / tables etc.)
    $hotels = $isSuper
        ? Hotel::all()
        : Hotel::where('admin_id', $admin->id)->get();

    // ───────────────────────────────────────────────────────────────
    // 6. Pass everything to the view
    // ───────────────────────────────────────────────────────────────
    return view('Hotel.dashboard.index', compact(
        'hotels',
        'topHotelsFormatted',
        'hotelNames',
        'topHotels',
        'guestCounts',
        'monthlyIncome',
        'statusCounts',
        'monthlyReservations',
        'total_hotel',
        'total_rooms',
        'total_bookings',
        'total_customers',
        'total_category',
        'total_amenities',
        'total_pending_bookings',
        'total_confirmed_bookings',
        'total_checked_in_bookings',
        'total_completed_bookings',
        'total_cancelled_bookings'
    ));
}


    public function filterStats(Request $request)
{
    /* -----------------------------------------------------------------
     | 1. Validate the filter form
     * -----------------------------------------------------------------*/
    $validator = Validator::make($request->all(), [
        'start_date' => 'nullable|date',
        'end_date'   => 'nullable|date|after_or_equal:start_date',
        'hotel_id'   => 'nullable|exists:hotels,id',
    ]);

    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 422);
    }

    /* -----------------------------------------------------------------
     | 2. Who is logged-in?  What can they see?
     * -----------------------------------------------------------------*/
    $admin   = Auth::guard('admin')->user();
    $isSuper = strcasecmp($admin->type, string2: 'Super Admin') === 0;

    // A collection of hotel IDs the current admin is allowed to see
    $scopedHotelIds = $isSuper
        ? Hotel::pluck('id')                           // all hotels
        : Hotel::where('admin_id', $admin->id)->pluck('id');

    /* -----------------------------------------------------------------
     | 3. Build the Reservation query
     * -----------------------------------------------------------------*/
    $query = Reservation::query();

    // Date range
    if ($request->filled(['start_date', 'end_date'])) {
        $query->whereBetween('check_in_date', [
            Carbon::parse($request->start_date)->startOfDay(),
            Carbon::parse($request->end_date)->endOfDay(),
        ]);
    }

    // Hotel scope
    if ($isSuper && $request->filled('hotel_id')) {
        // Super admin filtered by a specific hotel
        $query->whereHas('room', fn ($q) => $q->where('hotel_id', $request->hotel_id));
    } else {
        // Non-super admin (or super admin with no hotel filter) – use scoped list
        $query->whereHas('room', fn ($q) => $q->whereIn('hotel_id', $scopedHotelIds));
    }

    /* -----------------------------------------------------------------
     | 4. Get the Top-5 Rooms (reservation count)
     * -----------------------------------------------------------------*/
    $topRooms = $query->selectRaw('room_id, COUNT(*) AS total_reservations')
                      ->groupBy('room_id')
                      ->orderByDesc('total_reservations')
                      ->take(5)
                      ->get();

    // Room numbers for display
    $roomNumbers = Room::whereIn('id', $topRooms->pluck('room_id'))
                       ->pluck('room_number', 'id');

    $formatted = $topRooms->map(fn ($row) => [
        'room_number' => $roomNumbers[$row->room_id] ?? 'Unknown',
        'total'       => $row->total_reservations,
    ]);

    return response()->json($formatted);
}

}
