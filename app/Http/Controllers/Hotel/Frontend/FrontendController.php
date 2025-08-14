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
use Illuminate\Support\Facades\Cache;
class FrontendController extends Controller
{
    //
    public function index()
    {

        $cacheTime = 60 * 60; // 60 minutes

        $banners = Cache::remember('hotel_slider_active', $cacheTime, function () {
            return HotelSlider::where('is_active', 1)->latest()->get();
        });

        $categories = Cache::remember('hotel_categories_latest', $cacheTime, function () {
            return HotelCategory::latest()->get();
        });

        $rooms = Cache::tags(['rooms'])->remember('available_rooms_latest', $cacheTime, function () {
            return Room::where('is_available', 1)->latest()->get();
        });

        $discounted_hotels = Cache::tags(['hotels'])->remember('discounted_hotels_latest', $cacheTime, function () {
            return Hotel::where('discount', '>', 0)->latest()->get();
        });

        $hotels = Cache::tags(['hotels'])->remember('active_hotels_latest', $cacheTime, function () {
            return Hotel::where('is_active', 1)->latest()->get();
        });


        $after_discount_hotels = Cache::remember('advert_after_discount_hotels', $cacheTime, function () {
            return Advertisement::where('position', 'after_discount_hotels')->where('is_approved', 1)->first();
        });

        $after_latest_rooms = Cache::remember('advert_after_latest_rooms', $cacheTime, function () {
            return Advertisement::where('position', 'after_latest_rooms')->where('is_approved', 1)->first();
        });

        $after_latest_hotels = Cache::remember('advert_after_latest_hotels', $cacheTime, function () {
            return Advertisement::where('position', 'after_latest_hotels')->where('is_approved', 1)->first();
        });

        return view('all_frontend_layouts.hotel_index', compact('banners', 'categories', 'hotels', 'rooms', 'discounted_hotels',  'after_discount_hotels', 'after_latest_rooms', 'after_latest_hotels'));
    }
}
