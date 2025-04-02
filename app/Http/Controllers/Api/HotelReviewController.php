<?php

namespace App\Http\Controllers\Api;

use App\Models\Review;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HotelReviewController extends Controller
{
    public function store(Request $request)
    {
        $review = Review::create($request->all());
        return response()->json($review, 201);
    }

    public function show($hotel_id)
    {
        return response()->json(Review::where('hotel_id', $hotel_id)->get());
    }
}