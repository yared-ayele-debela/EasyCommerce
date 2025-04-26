<?php

namespace App\Http\Controllers\Hotel\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Amenity;
use App\Models\HotelReview;
use App\Models\Reservation;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoomController extends Controller
{
    //
    public function index($id){


        $room=Room::with('images','amenities','hotel','rating')->findOrFail($id);
        $is_reserved = false;
        if(Auth::check()){
        $user= Reservation::where('room_id',$id)->where('user_id',auth()->user()->id)->first();
        if($user){
            $is_reserved = true;
        }
       }
        // dd($room);
        return view('Hotel.frontend.pages.room.detail',compact('room','is_reserved'));
    }

    public function room_rating_store(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['status' => 'error', 'message' => 'Please log in first!'], 401);
        }
        $request->validate([
            'hotel_id' => 'required|exists:hotels,id',
            'room_id' => 'required|exists:rooms,id',
            'rating' => 'required|integer|min:1|max:5',
            'review'=> 'required'
        ]);
        // Save or update the user's rating
        HotelReview::updateOrCreate(
            ['user_id' => Auth::id(), 'hotel_id' => $request->hotel_id, 'room_id' => $request->room_id],
            ['rating' => $request->rating, 'review' => $request->review]
        );
        return response()->json(['status' => 'success', 'message' => 'Rating submitted successfully!']);
    }


    public function indexs(Request $request)
    {
        $amenities = Amenity::all();
        return view('Hotel.frontend.pages.room.search', compact('amenities','request'));
    }
    public function filter(Request $request)
    {
        $rooms = Room::with('amenities')
            ->when($request->search, fn($q) => $q->where('room_type', 'like', "%{$request->search}%"))
            ->when($request->min_price, fn($q) => $q->where('price', '>=', $request->min_price))
            ->when($request->max_price, fn($q) => $q->where('price', '<=', $request->max_price))
            ->when($request->capacity, fn($q) => $q->where('capacity', '>=', $request->capacity))
            ->when($request->total_adult, fn($q) => $q->where('total_adult', '>=', $request->total_adult))
            ->when($request->total_child, fn($q) => $q->where('total_child', '>=', $request->total_child))
            ->when($request->total_infant, fn($q) => $q->where('total_infant', '>=', $request->total_infant))
            ->when($request->amenities, function ($q) use ($request) {
                $q->whereHas('amenities', function ($q2) use ($request) {
                    $q2->whereIn('amenities.id', $request->amenities);
                });
            })
            ->get();

        return response()->json(['rooms' => $rooms]);
    }


}
