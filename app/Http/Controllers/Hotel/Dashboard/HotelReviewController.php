<?php

namespace App\Http\Controllers\Hotel\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Hotel;
use App\Models\HotelReview;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HotelReviewController extends Controller
{
    //
    public function index($id){
        $hotel=Hotel::findOrFail($id);
        if($hotel->admin_id != Auth::guard('admin')->user()->id){
            return redirect()->back();
        }
        $reviews =HotelReview::where('hotel_id', $id)->with('user','hotel')->latest()->paginate(10);
        $hotel=Hotel::findOrFail($id);

        return view('Hotel.dashboard.hotels.reviews', compact('reviews','hotel'));
    }
}
