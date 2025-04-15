<?php

namespace App\Http\Controllers\Hotel\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Amenity;
use App\Models\Hotel;
use App\Models\Hotel\RoomType;
use App\Models\Room;
use App\Models\RoomAmenity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class RoomController extends Controller
{
    public function index()
    {
        $adminType = Auth::guard('admin')->user()->type;
        $hotels = Hotel::where('admin_id',Auth::guard('admin')->user()->id)->latest()->get();

        if($adminType==="Super Admin"){
            $rooms = Room::with('images','amenities')->latest()->get();
        }else{
            $hotelId= $hotels->pluck('id');
            $rooms = Room::with('images','amenities')->whereIn('hotel_id',$hotelId)->latest()->get();
            // dd($rooms);
        }
     
        // dd($hotels);
        $amenities = Amenity::all();
        return view('hotel.dashboard.room.index', compact('rooms','hotels','amenities'));
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


        $data = $request->only(['hotel_id', 'room_type','total_adult','total_child','total_infant','room_number','floor', 'capacity', 'price', 'is_available','description']);

        if ($request->hasFile('cover_image')) {
            $path = $request->file('cover_image')->store('room_images', 'public');
            $data['cover_image'] = $path;
        }

        $room = Room::create($data);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('room_images', 'public');
                $room->images()->create(['image_path' => $path]);
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

        $data = $request->only(['room_type','total_adult','total_child','total_infant','room_number','floor', 'capacity', 'price', 'is_available','description']);
        if ($request->hasFile('cover_image')) {
            if ($room->cover_image) {
                Storage::delete('public/' . $room->cover_image);
            }
            $data['cover_image'] = $request->file('cover_image')->store('room_images', 'public');
        }

        $room->update($data);

        if ($request->hasFile('images')) {
            foreach ($room->images as $oldImage) {
                Storage::delete('public/' . $oldImage->image_path);
                $oldImage->delete();
            }
            foreach ($request->file('images') as $image) {
                $path = $image->store('room_images', 'public');
                $room->images()->create(['image_path' => $path]);
            }
        }

        if ($request->has('amenities')) {
            $room->amenities()->sync($request->amenities);
        }



        return redirect()->route('rooms.index')->with('success', 'Room updated successfully.');
    }

    public function destroy(Room $room)
    {
        // Delete room images
        foreach ($room->images as $image) {
            Storage::delete('public/' . $image->image_path);
            $image->delete();
        }

        // Delete room
        $room->delete();

        return redirect()->route('rooms.index')->with('success', 'Room deleted successfully.');
    }
}