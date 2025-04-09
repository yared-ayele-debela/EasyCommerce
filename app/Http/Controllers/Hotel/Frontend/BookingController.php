<?php

namespace App\Http\Controllers\Hotel\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use Illuminate\Http\Request;

class BookingController extends Controller
{

    public function checkAvailability(Request $request) {
        $roomId = $request->room_id;
        $checkInDate = $request->check_in_date;
        $checkOutDate = $request->check_out_date;
        $isAvailable = Reservation::where('room_id', $roomId)
            ->where(function ($query) use ($checkInDate, $checkOutDate) {
                $query->whereBetween('check_in_date', [$checkInDate, $checkOutDate])
                      ->orWhereBetween('check_out_date', [$checkInDate, $checkOutDate])
                      ->orWhere(function ($query) use ($checkInDate, $checkOutDate) {
                          $query->where('check_in_date', '<=', $checkInDate)
                                ->where('check_out_date', '>=', $checkOutDate);
                      });
            })
            ->exists();
    
        return response()->json(['available' => !$isAvailable]);
    }
    
}