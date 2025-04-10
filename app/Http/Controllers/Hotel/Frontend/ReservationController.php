<?php

namespace App\Http\Controllers\Hotel\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\Room;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    //

    public function store(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'check_in_date' => 'required|date',
            'check_out_date' => 'required|date|after:check_in_date',
            'total_night' => 'required|integer|min:1',
            'total_adult' => 'required|integer|min:1',
            'total_child' => 'required|integer|min:0',
            'total_infant' => 'required|integer|min:0',
            'room_id' => 'required|exists:rooms,id',
            'user_id' => 'required|exists:users,id',
        ]);

        // dd($request->all());
        // Calculate the total price for the reservation
        $room = Room::find($request->room_id);
        $total_price = $room->price_per_night * $request->total_night;

        // Create a new reservation record
        $reservation =  Reservation::create([
            'user_id' => $request->user_id,
            'hotel_id' => $room->hotel_id,
            'room_id' => $request->room_id,
            'total_night' => $request->total_night,
            'check_in_date' => Carbon::parse($request->check_in_date),
            'check_out_date' => Carbon::parse($request->check_out_date),
            'total_price' => $total_price,
            'total_adult' => $request->total_adult,
            'total_child' => $request->total_child,
            'total_infant' => $request->total_infant,
            'status' => 'pending', // Example status
            'payment_status' => 'unpaid', // Example payment status
        ]);

        // Redirect to a confirmation page or the hotel page
        return redirect()->route('reservation.confirmation')
        ->with('success', 'Your reservation has been made successfully!')
        ->with('reservation', $reservation);

    }

        public function confirmation()
        {
            // Retrieve the reservation data from the session
            $reservation = session('reservation');
            return view('Hotel.frontend.pages.reservations.confirmation', compact('reservation'));
        }

        public function my_reservation()
        {
            $user = auth()->user()->id;
            $user=User::findOrFail($user);
            $reservations = $user->reservations()->with(['hotel', 'room'])->latest()->paginate(4);

            return view('Hotel.frontend.pages.reservations.my_reservation', compact('reservations'));
        }
}
