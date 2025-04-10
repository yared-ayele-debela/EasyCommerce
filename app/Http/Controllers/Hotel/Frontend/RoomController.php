<?php

namespace App\Http\Controllers\Hotel\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Amenity;
use App\Models\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    //
    public function index($id){


        $room=Room::with('images','amenities','hotel')->findOrFail($id);
        return view('Hotel.frontend.pages.room.detail',compact('room'));
    }

    public function indexs()
    {
        $amenities = Amenity::all();
        return view('Hotel.frontend.pages.room.search', compact('amenities'));
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
