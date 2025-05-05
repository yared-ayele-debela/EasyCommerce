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
    public function index(Request $request)

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

        $monthlyReservations = Reservation::selectRaw('MONTH(check_in_date) as month, COUNT(*) as total')
        ->groupBy('month')
        ->orderBy('month')
        ->pluck('total', 'month');

        $statusCounts = Reservation::selectRaw('status, COUNT(*) as total')
        ->groupBy('status')
        ->pluck('total', 'status');

        $monthlyIncome = Reservation::selectRaw('MONTH(check_in_date) as month, SUM(final_price) as income')
        ->groupBy('month')
        ->orderBy('month')
        ->pluck('income', 'month');

        $guestCounts = [
            'Adults' => Reservation::sum('total_adult'),
            'Children' => Reservation::sum('total_child'),
            'Infants' => Reservation::sum('total_infant'),
        ];

        $topHotels = Reservation::selectRaw('hotel_id, COUNT(*) as total')
        ->groupBy('hotel_id')
        ->orderByDesc('total')
        ->take(5)
        ->get();

        $hotelNames = Hotel::whereIn('id', $topHotels->pluck('hotel_id'))
            ->pluck('name', 'id');

        $topHotelsFormatted = $topHotels->map(function ($item) use ($hotelNames) {
            return [
                'name' => $hotelNames[$item->hotel_id] ?? 'Unknown',
                'total' => $item->total
            ];
        });
        $hotels=Hotel::all();


        return view('Hotel.dashboard.index', compact('hotels','topHotelsFormatted','hotelNames','topHotels','guestCounts','monthlyIncome','statusCounts','monthlyReservations','total_hotel', 'total_rooms', 'total_bookings', 'total_customers', 'total_category', 'total_amenities', 'total_pending_bookings', 'total_confirmed_bookings', 'total_checked_in_bookings', 'total_completed_bookings', 'total_cancelled_bookings'));
    }

    public function filterStats(Request $request)
    {
        $startDate = $request->start_date;
        $endDate = $request->end_date;
        $hotelId = $request->hotel_id;

        $query = Reservation::query();

        if ($startDate && $endDate) {
            $query->whereBetween('check_in_date', [$startDate, $endDate]);
        }

        if ($hotelId) {
            $query->whereHas('room', function ($q) use ($hotelId) {
                $q->where('hotel_id', $hotelId);
            });
        }

        $topRooms = $query->selectRaw('room_id, COUNT(*) as total_reservations')
            ->groupBy('room_id')
            ->orderByDesc('total_reservations')
            ->take(5)
            ->get();

        $roomNames = Room::whereIn('id', $topRooms->pluck('room_id'))->pluck('room_number', 'id');

        $formatted = $topRooms->map(function ($item) use ($roomNames) {
            return [
                'room_number' => $roomNames[$item->room_id] ?? 'Unknown',
                'total' => $item->total_reservations
            ];
        });

        return response()->json($formatted);
    }
}
