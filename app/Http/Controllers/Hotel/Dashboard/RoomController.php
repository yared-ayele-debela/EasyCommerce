<?php

namespace App\Http\Controllers\Hotel\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Amenity;
use App\Models\Hotel;
use App\Models\Hotel\RoomType;
use App\Models\HotelCoupon;
use App\Models\HotelReservationPaymentInfo;
use App\Models\Reservation;
use App\Models\Roles;
use App\Models\Room;
use App\Models\RoomAmenity;
use App\Models\User;
use App\Models\Vendor;
use App\Models\VendorWallet;
use App\Models\VendorWalletTransaction;
use App\Services\ActivityLogger;
use App\Services\NotificationService;
use App\Services\SmsService;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class RoomController extends Controller
{

      public function __construct()
    {
        $this->middleware('admin.permission:view_hotel_room')->only('index');
        $this->middleware('admin.permission:add_hotel_room')->only('store');
        $this->middleware('admin.permission:edit_hotel_room')->only(methods: 'update');
        $this->middleware('admin.permission:delete_hotel_room')->only('destroy');
    }
    public function index()
    {
        $adminType = Auth::guard('admin')->user()->type;

        $role=Roles::where('name',$adminType)->first();

        $group = $role->group ?? null;

        if ($group === "general") {
                    $hotels = Hotel::latest()->get();

            $rooms = Room::with('images', 'amenities')->latest()->paginate(10);
        } else {
                    $hotels = Hotel::where('admin_id', Auth::guard('admin')->user()->id)->latest()->get();

            $hotelId = $hotels->pluck('id');
            $rooms = Room::with('images', 'amenities')->whereIn('hotel_id', $hotelId)->latest()->paginate(10);
            // dd($rooms);
        }

        $users=User::all();

        // dd($hotels);
        $amenities = Amenity::all();
        $room_types= RoomType::all();
        return view('Hotel.dashboard.room.index', compact('rooms', 'hotels', 'amenities', 'room_types','users'));
    }

    public function create()
    {
        return view('rooms.create');
    }

    public function store(Request $request)
    {

        $request->validate([
            'hotel_id' => 'required|exists:hotels,id',
            'room_type' => 'required|string|max:255',
            'total_adult' => 'nullable|string|max:255',
            'total_child' => 'nullable|string|max:255',
            'total_infant' => 'nullable|string|max:255',
            'room_number' => 'nullable|integer|unique:rooms,room_number',
            'floor' => 'nullable|integer',
            'capacity' => 'required|integer',
            'price' => 'required',
            'is_available' => 'required|boolean',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            // 'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'nullable|string',
            'amenities' => 'array', // should be an array of amenity_ids

        ]);
        // dd($request->all());


        $data = $request->only(['hotel_id', 'room_type', 'total_adult', 'total_child', 'total_infant', 'room_number', 'floor', 'capacity', 'price', 'is_available', 'description']);

        if ($request->hasFile('cover_image')) {
            $path = $request->file('cover_image')->store('room_images', 'public');
            $data['image'] = $path; // Store relative path only
        }

        $room = Room::create($data);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('room_images', 'public');
                $room->images()->create([
                    'photo_url' => $path // Store relative path only
                ]);
            }
        }



        if ($request->has('amenities')) {
            foreach ($request->amenities as $amenity_id) {
                RoomAmenity::create([
                    'rooms_id' => $room->id,
                    'amenity_id' => $amenity_id,
                ]);
            }
        }

        $currentDateTime = Carbon::now();
        $formattedDateTime = $currentDateTime->toDateTimeString(); // 'Y-m-d H:i:s'
        ActivityLogger::log('Add Hotel Room', Auth::guard('admin')->user()->name . " at {$formattedDateTime}");


        return redirect()->route('rooms.index')->with('success', 'Room created successfully.');
    }

    public function edit(Room $room)
    {
        return view('rooms.edit', compact('room'));
    }

    public function update(Request $request, Room $room)
    {
        // dd($request->all());
        $request->validate([
            'room_type' => 'required|string|max:255',
            'total_adult' => 'nullable|string|max:255',
            'total_child' => 'nullable|string|max:255',
            'total_infant' => 'nullable|string|max:255',
            'room_number' => 'nullable|integer|unique:rooms,room_number,' . $room->id,
            'floor' => 'nullable|integer',
            'capacity' => 'required|integer',
            'price' => 'required|numeric',
            'is_available' => 'required|boolean',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            // 'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'nullable|string',
            'amenities' => 'array', // should be an array of amenity_ids
        ]);

        $data = $request->only(['room_type', 'total_adult', 'total_child', 'total_infant', 'room_number', 'floor', 'capacity', 'price', 'is_available', 'description']);
        if ($request->hasFile('cover_image')) {
    // Delete old cover image if exists
            if ($room->image) {
                $oldCoverPath = str_replace('storage/', '', $room->image); // remove 'storage/' prefix if stored as URL
                Storage::disk('public')->delete($oldCoverPath);
            }

            // Store new cover image (relative path only)
            $coverPath = $request->file('cover_image')->store('room_images', 'public');
            $data['image'] = $coverPath;
        }

        $room->update($data);

        if ($request->hasFile('images')) {
            // Delete old related images and their files
            foreach ($room->images as $oldImage) {
                if ($oldImage->photo_url) {
                    Storage::disk('public')->delete($oldImage->photo_url);
                }
                $oldImage->delete();
            }

            // Upload new images (store relative paths)
            foreach ($request->file('images') as $image) {
                $path = $image->store('room_images', 'public');
                $room->images()->create([
                    'photo_url' => $path
                ]);
            }
        }


        if ($request->has('amenities')) {
            $room->amenities()->sync($request->amenities);
        }


        $currentDateTime = Carbon::now();
        $formattedDateTime = $currentDateTime->toDateTimeString(); // 'Y-m-d H:i:s'
        ActivityLogger::log('Update Hotel Room', Auth::guard('admin')->user()->name . " at {$formattedDateTime}");


        return redirect()->route('rooms.index')->with('success', 'Room updated successfully.');
    }

    public function destroy(Room $room)
    {
        // Delete room images
        foreach ($room->images as $image) {
            // Convert full URL to storage path
              if ($image->photo_url) {
            Storage::disk('public')->delete($image->photo_url);
        }
        $image->delete();
        }
        // Delete cover image if stored as a full URL
       if ($room->image) {
        $oldCoverPath = str_replace('storage/', '', $room->image); // remove 'storage/' prefix if stored as URL
        Storage::disk('public')->delete($oldCoverPath);
    }
        // Delete the room itself
        $room->delete();

        $currentDateTime = Carbon::now();
        $formattedDateTime = $currentDateTime->toDateTimeString(); // 'Y-m-d H:i:s'
        ActivityLogger::log( 'Delete Hotel Room', Auth::guard('admin')->user()->name . " at {$formattedDateTime}");

        return redirect()->route('rooms.index')->with('success', 'Room deleted successfully.');
    }

    public function reservation(Request $request)
    {

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

        $total_price = $room->price * $request->total_night;
        // dd($total_price);

        $hotel = Hotel::findOrFail($room->hotel_id);

        $admin = Admin::findOrFail($hotel->admin_id);

        $vendor = Vendor::find($admin->vendor_id);
        // dd($vendor);

        $commissionRate = $vendor->commission ?? 5;

        // dd(vars: $commissionRate);

        // Admin commission and vendor earning
        $itemSubtotal = $total_price;
        $adminCommission = round( $itemSubtotal * $commissionRate / 100, 2);
        $vendorEarning = $itemSubtotal - $adminCommission;


        $reservation =  Reservation::create([
            'user_id' => $request->user_id,
            'hotel_id' => $room->hotel_id,
            'room_id' => $request->room_id,
            'total_night' => $request->total_night,
            'check_in_date' => Carbon::parse($request->check_in_date),
            'check_out_date' => Carbon::parse($request->check_out_date),
            'discount_amount' => 0,
            'total_price' => $total_price,
            'final_price' => $request->final_price,
            'total_adult' => $request->total_adult,
            'total_child' => $request->total_child,
            'total_infant' => $request->total_infant,
            'status' => $request->status, // Example status
            'payment_status' => $request->payment_status, // Example payment status
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

        // $payment = new HotelReservationPaymentInfo();
        // $payment->reservation_id = $reservation->id;
        // $payment->user_id = $request->user_id;
        // $payment->bank_name = $request->bank_name;
        // $payment->transaction_number = $request->transaction_number;
        // if ($request->hasFile('receipt')) {
        //     $path = $request->file('receipt')->store('hotel', 'public');
        //     $payment->receipt = asset('storage/' . $path); // Store the full URL
        // }
        // $payment->amount_paid = $request->final_price;
        // $payment->save();

        NotificationService::send(
            userId: $reservation->user_id,
            title: 'Hotel Reservation Placed',
            message: "Your hotel reservation has been placed."
        );

        $phone = $reservation->user->mobile ?? null;
        if ($phone) {
            $message = "Hi {$reservation->user->name}, Your hotel reservation has been placed.";
            try {
                SmsService::send($phone, $message);
            } catch (\Exception $e) {
                // Optionally log error
            }
        }

        return redirect('/admin/hotel/reservations')->with('success', 'Reservation created successfully!');
    }

    public function getReservedDates($room_id)
    {
        // Get all date ranges for this room
        $reservations = Reservation::where('room_id', $room_id)->get();

        $reservedDates = [];

        foreach ($reservations as $res) {
            $start = Carbon::parse($res->check_in_date);
            $end = Carbon::parse($res->check_out_date);

            while ($start->lte($end)) {
                $reservedDates[] = $start->format('Y-m-d');
                $start->addDay();
            }
        }

        return response()->json(array_unique($reservedDates));
    }
}