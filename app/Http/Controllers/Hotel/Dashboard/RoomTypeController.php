<?php

namespace App\Http\Controllers\Hotel\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Hotel\RoomType;
use Illuminate\Http\Request;

class RoomTypeController extends Controller
{
    public function index()
{
    $roomTypes = RoomType::latest()->paginate(10);
    return view('hotel.dashboard.room-types.index', compact('roomTypes'));
}

public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
    ]);

    RoomType::create($request->all());
    return redirect()->back()->with('success', 'Room type created.');
}

public function update(Request $request, RoomType $roomType)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
    ]);

    $roomType->update($request->all());
    return redirect()->back()->with('success', 'Room type updated.');
}

public function destroy(RoomType $roomType)
{
    $roomType->delete();
    return redirect()->back()->with('success', 'Room type deleted.');
}
}