<?php

namespace App\Http\Controllers\Hotel\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Amenity;
use App\Models\Hotel;
use App\Models\Hotel\RoomType;
use App\Models\Room;
use App\Models\RoomAmenity;
use App\Services\ActivityLogger;
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
        $hotels = Hotel::where('admin_id', Auth::guard('admin')->user()->id)->latest()->paginate(10);

        if ($adminType === "Super Admin") {
            $rooms = Room::with('images', 'amenities')->latest()->paginate(10);
        } else {
            $hotelId = $hotels->pluck('id');
            $rooms = Room::with('images', 'amenities')->whereIn('hotel_id', $hotelId)->latest()->paginate(10);
            // dd($rooms);
        }

        // dd($hotels);
        $amenities = Amenity::all();
        $room_types= RoomType::all();
        return view('Hotel.dashboard.room.index', compact('rooms', 'hotels', 'amenities', 'room_types'));
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
            $data['image'] = asset('storage/' . $path); // Store full URL
        }

        $room = Room::create($data);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('room_images', 'public');
                $room->images()->create([
                    'photo_url' => asset('storage/' . $path) // Store full URL
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
            if ($room->image) {
                // Remove full URL to get storage path
                $oldCoverPath = str_replace(asset('storage') . '/', '', $room->image);
                Storage::disk('public')->delete($oldCoverPath);
            }
            $coverPath = $request->file('cover_image')->store('room_images', 'public');
            $data['image'] = asset('storage/' . $coverPath);
        }

        $room->update($data);

        if ($request->hasFile('images')) {
            // Delete old images
            foreach ($room->images as $oldImage) {
                $oldImagePath = str_replace(asset('storage') . '/', '', $oldImage->photo_url);
                Storage::disk('public')->delete($oldImagePath);
                $oldImage->delete();
            }

            // Upload new images with full URLs
            foreach ($request->file('images') as $image) {
                $path = $image->store('room_images', 'public');
                $room->images()->create([
                    'photo_url' => asset('storage/' . $path)
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
            $imagePath = str_replace(asset('storage') . '/', '', $image->photo_url);
            if (Storage::disk('public')->exists($imagePath)) {
                Storage::disk('public')->delete($imagePath);
            }
            $image->delete();
        }
        // Delete cover image if stored as a full URL
        if ($room->image) {
            $coverImagePath = str_replace(asset('storage') . '/', '', $room->image);

            if (Storage::disk('public')->exists($coverImagePath)) {
                Storage::disk('public')->delete($coverImagePath);
            }
        }
        // Delete the room itself
        $room->delete();

        $currentDateTime = Carbon::now();
        $formattedDateTime = $currentDateTime->toDateTimeString(); // 'Y-m-d H:i:s'
        ActivityLogger::log( 'Delete Hotel Room', Auth::guard('admin')->user()->name . " at {$formattedDateTime}");

        return redirect()->route('rooms.index')->with('success', 'Room deleted successfully.');
    }
}
