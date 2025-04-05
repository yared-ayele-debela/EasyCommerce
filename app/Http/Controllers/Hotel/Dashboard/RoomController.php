<?php

namespace App\Http\Controllers\Hotel\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Hotel;
use App\Models\Hotel\RoomType;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RoomController extends Controller
{
    public function index()
    {
        $rooms = Room::with('images')->get();
        $hotels=Hotel::all();
        return view('hotel.dashboard.room.index', compact('rooms','hotels'));
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
            'capacity' => 'required|integer',
            'price' => 'required|numeric',
            'is_available' => 'required|boolean',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $room = Room::create($request->only(['hotel_id', 'room_type', 'capacity', 'price', 'is_available']));

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('room_images', 'public');
                $room->images()->create(['image_path' => $path]);
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
            'capacity' => 'required|integer',
            'price' => 'required|numeric',
            'is_available' => 'required|boolean',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $room->update($request->only(['room_type', 'capacity', 'price', 'is_available']));

        if ($request->hasFile('images')) {
            // ✅ Delete all old images first
            foreach ($room->images as $oldImage) {
                Storage::delete('public/' . $oldImage->image_path);
                $oldImage->delete();
            }
        
            // ✅ Then upload and save the new ones
            foreach ($request->file('images') as $image) {
                $path = $image->store('room_images', 'public');
                $room->images()->create(['image_path' => $path]);
            }
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