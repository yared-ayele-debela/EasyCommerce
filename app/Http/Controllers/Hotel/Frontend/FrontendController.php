<?php

namespace App\Http\Controllers\Hotel\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Hotel;
use App\Models\HotelCategory;
use App\Models\HotelSlider;
use App\Models\Room;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    //
    public function index()
    {

        $banners = HotelSlider::where('is_active', 1)->latest()->get();
        $categories = HotelCategory::latest()->get();
        $rooms = Room::where('is_available', 1)->latest()
            ->get();
        $discounted_hotels=Hotel::where('discount','>','0')->latest()->get();
        $hotels= Hotel::where('is_active',1)->latest()->get();
        // dd($discounted_hotels);
        return view('all_frontend_layouts.hotel_index', compact('banners', 'categories',  'hotels','rooms','discounted_hotels'));
    }
}