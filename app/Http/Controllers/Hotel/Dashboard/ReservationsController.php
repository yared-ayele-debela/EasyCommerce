<?php

namespace App\Http\Controllers\Hotel\Dashboard;

use App\Http\Controllers\Controller;
use App\Mail\HotelReservationPaymentStatusUpdated;
use App\Mail\HotelReservationStatusUpdated;
use App\Models\AppSetting;
use App\Models\HotelReservationPaymentInfo;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class ReservationsController extends Controller
{
    //
    public function index()
    {
        $adminType = Auth::guard('admin')->user()->type;
        if ($adminType === "Super Admin") {
            $reservations = Reservation::with('user', 'hotel', 'room', 'hotel_reservation_payment_info')->latest()->get();
        } else {
            $hotelIds = Auth::guard('admin')->user()->hotel()->pluck('id'); // assuming a relationship `hotels()`

            $reservations = Reservation::with(['user', 'hotel', 'room', 'hotel_reservation_payment_info'])
                ->whereIn('hotel_id', $hotelIds)
                ->latest()
                ->get();
            }
    
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
        $receipt = HotelReservationPaymentInfo::where('reservation_id', $id)->first();

        $request->validate([
            'payment_status' => 'required',
        ]);

        // Update the status
        $reservation->payment_status = $request->payment_status;
        $reservation->save();

        $receipt->payment_status = $request->payment_status;
        $receipt->save();


        Mail::to($reservation->user->email)->send(new HotelReservationPaymentStatusUpdated($reservation));
        return redirect()->route('reservations.index')->with('success', 'Reservation Payment Status updated successfully');
    }

    public function destroy($id)
    {
        $reservation = Reservation::findOrFail($id);
        $reservation->delete();

        return redirect()->route('reservations.index')->with('success', 'Reservation deleted successfully');
    }
    public function receipt(Request $request)

    {
        $id=decrypt($request->id);
        $reservation = Reservation::with('user', 'hotel', 'room')->where('id', $id)->first();
        $settings=AppSetting::first();

        return view('Hotel.dashboard.reservations.receipt', compact('reservation','settings'));
    }
}