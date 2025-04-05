<?php

namespace App\Http\Controllers\Hotel\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Hotel;
use App\Models\HotelReview;
use Illuminate\Http\Request;

class HotelReviewController extends Controller
{
    //
    public function index($id){
        $reviews =HotelReview::where('hotel_id', $id)->with('user','hotel')->latest()->paginate(10);
        $hotel=Hotel::findOrFail($id);

        return view('hotel.dashboard.hotels.reviews', compact('reviews','hotel'));
    }
}
