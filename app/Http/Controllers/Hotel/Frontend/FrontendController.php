<?php

namespace App\Http\Controllers\Hotel\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Advertisement;
use App\Models\Hotel;
use App\Models\HotelCategory;
use App\Models\HotelSlider;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FrontendController extends Controller
{
    //
    public function index()
    {

        $banners = HotelSlider::where('is_active', 1)->latest()->get();
        $categories = HotelCategory::latest()->get();
        // dd($categories);
        $rooms = Room::where('is_available', 1)->latest()
            ->get();
        $discounted_hotels=Hotel::where('discount','>','0')->latest()->get();
        $hotels= Hotel::where('is_active',1)->latest()->get();

        $latitude = 9.03;
        $longitude = 38.74;
        $radius = 20;

        $nearbyHotels = Hotel::select('*', DB::raw("
            (6371 * acos(
                cos(radians($latitude)) *
                cos(radians(latitude)) *
                cos(radians(longitude) - radians($longitude)) +
                sin(radians($latitude)) *
                sin(radians(latitude))
            )) AS distance
        "))
        ->having('distance', '<=', $radius)
        ->orderBy('distance')
        ->where('is_active', true)
        ->take(10)
        ->get();

        $after_discount_hotels=Advertisement::where('position','after_discount_hotels')->where('is_approved',1)->first();
        $after_latest_rooms=Advertisement::where('position','after_latest_rooms')->where('is_approved',1)->first();
        $after_latest_hotels=Advertisement::where('position','after_latest_hotels')->where('is_approved',1)->first();

        return view('all_frontend_layouts.hotel_index', compact('banners', 'categories',  'hotels','rooms','discounted_hotels','nearbyHotels','after_discount_hotels','after_latest_rooms','after_latest_hotels'));
    }
}
