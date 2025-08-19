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
        return view('all_frontend_layouts.hotel_index');
    }

    public function getBanners()
    {
        $cacheTime = 60 * 60; // Cache for 1 hour
        $banners = Cache::remember('hotel_slider_active', $cacheTime, function () {
            return HotelSlider::where('is_active', 1)->latest()->get();
        });

        return response()->json(['banners' => $banners]);
    }

    public function getCategories()
    {
        $cacheTime = 60 * 60; // Cache for 1 hour
        $categories = Cache::remember('hotel_categories_latest', $cacheTime, function () {
            return HotelCategory::latest()->get();
        });

        return response()->json(['categories' => $categories]);
    }

    public function getRenderedCategories()
    {
        $cacheTime = 60 * 60; // Cache for 1 hour
        $categories = Cache::remember('hotel_categories_latest', $cacheTime, function () {
            return HotelCategory::latest()->get();
        });

        $html = '';
        foreach ($categories as $category) {
            $html .= view('components.hotel.category-card', ['category' => $category])->render();
        }

        return response()->json(['html' => $html]);
    }

    public function getDiscountedHotels()
    {
        $cacheTime = 60 * 60; // Cache for 1 hour
        $hotels = Cache::tags(['hotels'])->remember('discounted_hotels_latest', $cacheTime, function () {
            return Hotel::where('discount', '>', 0)->latest()->get();
        });

        return response()->json(['hotels' => $hotels]);
    }

    public function getRenderedDiscountedHotels()
    {
        $cacheTime = 60 * 60; // Cache for 1 hour
        $hotels = Cache::tags(['hotels'])->remember('discounted_hotels_latest', $cacheTime, function () {
            return Hotel::where('discount', '>', 0)->latest()->get();
        });

        $html = '';
        foreach ($hotels as $hotel) {
            $html .= view('components.hotel.hotel-card', ['hotel' => $hotel])->render();
        }

        return response()->json(['html' => $html]);
    }

    public function getNearbyHotels(Request $request)
    {
        $cacheTime = 60 * 60; // Cache for 1 hour
        $radius = $request->query('radius', 100);
        $hotels = Cache::tags(['hotels'])->remember("nearby_hotels_radius_{$radius}", $cacheTime, function () use ($radius) {
            // Assuming a method to filter hotels by radius; adjust based on your logic
            return Hotel::where('is_active', 1)->latest()->take(10)->get();
        });

        $html = view('components.hotel.nearby-hotel-cards', ['hotels' => $hotels])->render();
        return response()->json(['html' => $html]);
    }

    public function getLatestHotels()
    {
        $cacheTime = 60 * 60; // Cache for 1 hour
        $hotels = Cache::tags(['hotels'])->remember('active_hotels_latest', $cacheTime, function () {
            return Hotel::where('is_active', 1)->latest()->get();
        });

        return response()->json(['hotels' => $hotels]);
    }

    public function getRenderedLatestHotels()
    {
        $cacheTime = 60 * 60; // Cache for 1 hour
        $hotels = Cache::tags(['hotels'])->remember('active_hotels_latest', $cacheTime, function () {
            return Hotel::where('is_active', 1)->latest()->get();
        });

        $html = '';
        foreach ($hotels as $hotel) {
            $html .= view('components.hotel.hotel-card', ['hotel' => $hotel])->render();
        }

        return response()->json(['html' => $html]);
    }

    public function getLatestRooms()
    {
        $cacheTime = 60 * 60; // Cache for 1 hour
        $rooms = Cache::tags(['rooms'])->remember('available_rooms_latest', $cacheTime, function () {
            return Room::where('is_available', 1)->latest()->get();
        });

        return response()->json(['rooms' => $rooms]);
    }

    public function getRenderedLatestRooms()
    {
        $cacheTime = 60 * 60; // Cache for 1 hour
        $rooms = Cache::tags(['rooms'])->remember('available_rooms_latest', $cacheTime, function () {
            return Room::where('is_available', 1)->latest()->get();
        });

        $html = '';
        foreach ($rooms as $room) {
            $html .= view('components.hotel.room-card', ['room' => $room])->render();
        }

        return response()->json(['html' => $html]);
    }

    public function getAdvertisements()
    {
        $cacheTime = 60 * 60; // Cache for 1 hour
        $after_discount_hotels = Cache::remember('advert_after_discount_hotels', $cacheTime, function () {
            return Advertisement::where('position', 'after_discount_hotels')->where('is_approved', 1)->first();
        });

        $after_latest_hotels = Cache::remember('advert_after_latest_hotels', $cacheTime, function () {
            return Advertisement::where('position', 'after_latest_hotels')->where('is_approved', 1)->first();
        });

        $after_latest_rooms = Cache::remember('advert_after_latest_rooms', $cacheTime, function () {
            return Advertisement::where('position', 'after_latest_rooms')->where('is_approved', 1)->first();
        });

        return response()->json([
            'after_discount_hotels' => $after_discount_hotels,
            'after_latest_hotels' => $after_latest_hotels,
            'after_latest_rooms' => $after_latest_rooms
        ]);
    }
}
