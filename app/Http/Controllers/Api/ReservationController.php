<?php

namespace App\Http\Controllers\Api;

use App\Models\Reservation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ReservationController extends Controller
{
    // Create a reservation
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'hotel_id' => 'required|exists:hotels,id',
            'room_id' => 'required|exists:rooms,id',
            'check_in_date' => 'required|date|after:today',
            'check_out_date' => 'required|date|after:check_in_date',
        ]);

        $reservation = Reservation::create($validated + [
            'total_price' => $this->calculateTotalPrice($validated['room_id'], $validated['check_in_date'], $validated['check_out_date'])
        ]);

        return response()->json($reservation, 201);
    }

    // Get user reservations
    public function userReservations($user_id)
    {
        return response()->json(Reservation::where('user_id', $user_id)->with(['hotel', 'room'])->get());
    }

    // Cancel a reservation
    public function cancel($id)
    {
        $reservation = Reservation::findOrFail($id);
        $reservation->update(['status' => 'Cancelled']);
        return response()->json(['message' => 'Reservation cancelled successfully']);
    }

    // Helper function to calculate total price
    private function calculateTotalPrice($room_id, $check_in, $check_out)
    {
        $room = \App\Models\Room::findOrFail($room_id);
        $days = (new \DateTime($check_out))->diff(new \DateTime($check_in))->days;
        return $days * $room->price;
    }
}