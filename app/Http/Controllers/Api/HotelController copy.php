<?php

namespace App\Http\Controllers\Api;

use App\Models\Hotel;
use Illuminate\Http\Request;

class HotelController extends Controller
{
    // Get all hotels
    public function index()
    {
        return response()->json(Hotel::with(['category', 'reviews'])->get());
    }

    // Store a new hotel
    public function store(Request $request)
    {
        $hotel = Hotel::create($request->all());
        return response()->json($hotel, 201);
    }

    public function search(Request $request)
    {
        $query = Hotel::query();

        if ($request->has('location')) {
            $query->where('location', 'LIKE', "%{$request->location}%");
        }

        if ($request->has('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->has('price_min') && $request->has('price_max')) {
            $query->whereBetween('price_per_night', [$request->price_min, $request->price_max]);
        }

        if ($request->has('rating')) {
            $query->where('rating', '>=', $request->rating);
        }

        return response()->json($query->get());
    }

    // Show hotel details
    public function show($id)
    {
        $hotel = Hotel::with(['category', 'reviews'])->findOrFail($id);
        return response()->json($hotel);
    }

    // Update hotel
    public function update(Request $request, $id)
    {
        $hotel = Hotel::findOrFail($id);
        $hotel->update($request->all());
        return response()->json($hotel);
    }

    // Delete hotel
    public function destroy($id)
    {
        Hotel::destroy($id);
        return response()->json(null, 204);
    }
}