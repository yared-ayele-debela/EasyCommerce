<?php

namespace App\Http\Controllers\Restaurant\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Restaurant\RestaurantRating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RatingController extends Controller
{
    //
    public function store(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['status' => 'error', 'message' => 'Please log in first!'], 401);
        }
        $request->validate([
            'restaurant_id' => 'required|exists:restaurants,id',
            'rating' => 'required|integer|min:1|max:5',
            'review'=> 'required'
        ]);

        // Save or update the user's rating
        RestaurantRating::updateOrCreate(
            ['user_id' => Auth::id(), 'restaurant_id' => $request->restaurant_id],
            ['rating' => $request->rating, 'review' => $request->review]
        );


        return response()->json(['status' => 'success', 'message' => 'Rating submitted successfully!']);
    }
}
