<?php

namespace App\Http\Controllers\Hotel\Frontend;

use App\Http\Controllers\Controller;
use App\Mail\ReservationConfirmationMail;
use App\Models\Admin;
use App\Models\Bank;
use App\Models\Hotel;
use App\Models\HotelCoupon;
use App\Models\HotelReservationPaymentInfo;
use App\Models\HotelReview;
use App\Models\Reservation;
use App\Models\Room;
use App\Models\User;
use App\Models\Vendor;
use App\Models\VendorWallet;
use App\Models\VendorWalletTransaction;
use App\Services\NotificationService;
use App\Services\SmsService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Response;

class ReservationController extends Controller
{
    //

    public function store(Request $request)
    {

        // dd($request->all());
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
            'bank_name' => 'required|string',
            'transaction_number' => 'nullable',
            'receipt' => 'nullable|max:2048',
            'coupon_code' => 'nullable|string',
        ]);

        // dd($request->all());
        // Calculate the total price for the reservation
        $room = Room::find($request->room_id);


        $total_price = $room->price * $request->total_night;
        // dd($total_price);

        $hotel = Hotel::findOrFail($room->hotel_id);

        $admin = Admin::findOrFail($hotel->admin_id);

        $vendor = Vendor::find($admin->vendor_id);

        $commissionRate = $vendor->commission ?? 5;

        // dd(vars: $commissionRate);

        // Admin commission and vendor earning
        $itemSubtotal = $request->final_price;
        $adminCommission = round($itemSubtotal * $commissionRate / 100, 2);
        $vendorEarning = $itemSubtotal - $adminCommission;


        $reservation =  Reservation::create([
            'user_id' => $request->user_id,
            'hotel_id' => $room->hotel_id,
            'room_id' => $request->room_id,
            'total_night' => $request->total_night,
            'check_in_date' => Carbon::parse($request->check_in_date),
            'check_out_date' => Carbon::parse($request->check_out_date),
            'discount_amount' => $request->discount_amount,
            'total_price' => $request->total_price,
            'final_price' => $request->final_price,
            'total_adult' => $request->total_adult,
            'total_child' => $request->total_child,
            'total_infant' => $request->total_infant,
            'status' => 'Pending', // Example status
            'payment_status' => 'Pending', // Example payment status
            'admin_commission' => $adminCommission,
            'vendor_earning' => $vendorEarning
        ]);


        $vendorId = $vendor->id;
        $vendorWallet = VendorWallet::firstOrCreate(['vendor_id' => $vendorId]);
        $vendorWallet->available_balance += $vendorEarning;
        $vendorWallet->save();

        VendorWalletTransaction::create([
            'vendor_id' => $vendorId,
            'type' => 'credit',
            'amount' => $vendorEarning,
            'description' => 'Earning from reservation #' . $reservation->id
        ]);

        if ($request->input('discount_amount') > 0) {
            $coupon = HotelCoupon::find($request->input('coupon_id'));
            if ($coupon) {
                $coupon->increment('used');
            }
        }

        $payment = new HotelReservationPaymentInfo();
        $payment->reservation_id = $reservation->id;
        $payment->user_id = $request->user_id;
        $payment->bank_name = $request->bank_name;
        $payment->transaction_number = $request->transaction_number;
        if ($request->hasFile('receipt')) {
            $path = $request->file('receipt')->store('hotel', 'public');
            $payment->receipt = asset('storage/' . $path); // Store the full URL
        }
        $payment->amount_paid = $request->final_price;
        $payment->save();

        NotificationService::send(
            userId: $reservation->user_id,
            title: 'Hotel Reservation Placed',
            message: "Your hotel reservation has been placed."
        );

        $phone = $reservation->user->mobile ?? null;
        if ($phone) {
            // dd($phone);
            $message = "Hi {$reservation->user->name}, Your hotel reservation has been placed.";
            try {
                SmsService::send($phone, $message);
            } catch (\Exception $e) {
                // Optionally log error
            }
        }

        // Mail::to($reservation->user->email)->send(new ReservationConfirmationMail($reservation));

        return redirect()->route('reservations.receipt', ['id' => encrypt($reservation->id)])
            ->with('success', 'Your reservation has been made successfully!');
    }
    public function preview(Request $request)
    {
        $validated = $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'check_in_date' => 'required|date',
            'check_out_date' => 'required|date|after:check_in_date',
            'total_night' => 'required|integer|min:1',
            'total_adult' => 'required|integer|min:1',
            'total_child' => 'nullable|integer|min:0',
            'total_infant' => 'nullable|integer|min:0',
        ]);

        $room = Room::findOrFail($request->room_id);
        $av_rating = HotelReview::where('room_id', $room->id)->avg('rating');

        $banks = Bank::all();
        return view('Hotel.frontend.pages.reservations.preview', compact('validated', 'room', 'banks', 'av_rating'));
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
        $user = User::findOrFail($user);
        $reservations = $user->reservations()->with(['hotel', 'room', 'hotel_reservation_payment_info'])->latest()->paginate(4);

        return view('Hotel.frontend.pages.reservations.my_reservation', compact('reservations'));
    }


    public function apply(Request $request)
    {
        $request->validate([
            'coupon_code' => 'required|string'
        ]);

        $coupon = HotelCoupon::where('code', $request->coupon_code)
            ->where(function ($query) {
                $query->whereNull('expires_at')
                    ->orWhere('expires_at', '>=', Carbon::today());
            })
            ->where(function ($query) {
                $query->whereNull('usage_limit')
                    ->orWhereColumn('used', '<', 'usage_limit');
            })
            ->first();

        if (!$coupon) {
            return Response::json(['error' => 'Invalid or expired coupon.'], 400);
        }

        return response()->json([
            'type' => $coupon->type,
            'coupon' => $coupon->id,
            'value' => $coupon->value,
            'message' => 'Coupon applied successfully!',
        ]);
    }
}