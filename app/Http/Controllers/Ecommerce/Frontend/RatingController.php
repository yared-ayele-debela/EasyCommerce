<?php

namespace App\Http\Controllers\Ecommerce\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Rating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RatingController extends Controller
{
    //
    public function product_rating_store(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['status' => 'error', 'message' => 'Please log in first!'], 401);
        }
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'rating' => 'required|integer|min:1|max:5',
            'review'=> 'required'
        ]);
        // Save or update the user's rating
        Rating::updateOrCreate(
            ['user_id' => Auth::id(), 'product_id' => $request->product_id],
            ['review' => $request->review, 'rating' => $request->rating]
        );
        return response()->json(['status' => 'success', 'message' => 'Rating submitted successfully!']);
    }
}
