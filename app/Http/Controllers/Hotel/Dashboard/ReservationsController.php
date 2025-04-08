<?php

namespace App\Http\Controllers\Hotel\Dashboard;

use App\Http\Controllers\Controller;
use App\Mail\HotelReservationPaymentStatusUpdated;
use App\Mail\HotelReservationStatusUpdated;
use App\Models\AppSetting;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ReservationsController extends Controller
{
    //
    public function index()
    {
        // Fetch all reservations with related user, hotel, and room data
        $reservations = Reservation::with('user', 'hotel', 'room')->latest()->get();
        // dd($reservations);

        return view('hotel.dashboard.reservations.index', compact('reservations'));
    }
    public function updateStatus(Request $request, $id)
    {
        $reservation = Reservation::findOrFail($id);
        // Validate the request
        $request->validate([
            'status' => 'required|in:Pending,Confirmed,Checked_in,Completed,Cancelled',
        ]);

        // Update the status
        $reservation->status = $request->status;
        $reservation->save();

        Mail::to($reservation->user->email)->send(new HotelReservationStatusUpdated($reservation));       
        return redirect()->route('reservations.index')->with('success', 'Reservation status updated successfully');
    }
    public function updatePaymentStatus(Request $request, $id)
    {
        $reservation = Reservation::findOrFail($id);
        $request->validate([
            'payment_status' => 'required',
        ]);

        // Update the status
        $reservation->payment_status = $request->payment_status;
        $reservation->save();

        Mail::to($reservation->user->email)->send(new HotelReservationPaymentStatusUpdated($reservation));       
        return redirect()->route('reservations.index')->with('success', 'Reservation Payment Status updated successfully');
    }

    public function destroy($id)
    {
        $reservation = Reservation::findOrFail($id);
        $reservation->delete();

        return redirect()->route('reservations.index')->with('success', 'Reservation deleted successfully');
    }
    public function receipt(Request $request){
        $reservation = Reservation::with('user', 'hotel', 'room')->where('id', $request->id)->first();

        return view('Hotel.dashboard.reservations.receipt', compact('reservation'));
    }
}