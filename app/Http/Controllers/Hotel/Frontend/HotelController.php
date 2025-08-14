<?php

namespace App\Http\Controllers\Hotel\Frontend;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Country;
use App\Models\Hotel;
use App\Models\HotelCategory;
use App\Models\HotelReview;
use App\Models\Room;
use App\Models\State;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class HotelController extends Controller
{
    protected $cacheTime = 60; // cache duration in minutes

    //
    public function index($id)
    {
        try {
            $hotel = Cache::tags(['hotels'])->remember("hotel_with_rooms_{$id}", $this->cacheTime, function () use ($id) {
            return Hotel::with('rooms')->findOrFail($id);
        });


        $rooms = $hotel->rooms()->latest()->paginate(10);
            return view('Hotel.frontend.pages.hotel.detail', compact('hotel', 'rooms'));
        } catch (Exception $e) {
            return redirect()->back();
        }
    }
    public function gallery($id)
    {
        try {
            $hotel = Cache::tags(['hotels'])->remember("hotel_gallery_{$id}", $this->cacheTime, function () use ($id) {
            return Hotel::findOrFail($id);
        });
            return view('Hotel.frontend.pages.hotel.gallery', compact('hotel'));
        } catch (Exception $e) {
            return redirect()->back();
        }
    }

    public function select_date($id)
    {

        $id = decrypt($id);
        $room = Cache::tags(['rooms'])->remember("room_details_{$id}", $this->cacheTime, function () use ($id) {
        return Room::with('images', 'amenities', 'hotel')->findOrFail($id);
    });

    $av_rating = Cache::remember("room_avg_rating_{$id}", $this->cacheTime, function () use ($id) {
        return HotelReview::where('room_id', $id)->avg('rating');
    });
        // dd($room);
        return view('Hotel.frontend.pages.room.select_date', compact('room', 'av_rating'));
    }

    public function discounted()
    {

        $hotels = Cache::tags(['hotels'])->remember('discounted_hotels_paginated_page_' . request('page', 1), $this->cacheTime, function () {
                return Hotel::with('photos')->where('discount', '>', '0')->latest()->paginate(10);
            });
        $name = "Discounted Hotels";
        // dd($hotels);

        return view('Hotel.frontend.pages.hotel.index', compact('hotels', 'name'));
    }
    public function latest()
    {

       $cities = Cache::remember('cities_all', $this->cacheTime, fn() => City::all());
    $countries = Cache::remember('countries_all', $this->cacheTime, fn() => Country::all());
    $states = Cache::remember('states_all', $this->cacheTime, fn() => State::all());
    $categories = Cache::remember('hotel_categories_all', $this->cacheTime, fn() => HotelCategory::all());


        return view('Hotel.frontend.pages.hotel.search', compact('cities', 'countries', 'states', 'categories'));
    }

    public function nearby()
    {
        return view('Hotel.frontend.pages.hotel.nearby');
    }
    public function getNearbyHotels(Request $request)
    {
        $latitude = $request->lat;
        $longitude = $request->lng;
        $radius = $request->radius ?? 100; // km

        $hotels = Hotel::select('*', DB::raw("
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
            // ->take(8)
            ->get();

        $check_all = false;

        // Render partial blade view and return as HTML
        $html = view('Hotel.frontend.pages.hotel.partials.nearby-hotels', compact('hotels', 'check_all'))->render();

        return response()->json(['html' => $html]);
    }


    public function filter(Request $request)
    {
        // Filtering hotels based on provided parameters
        $hotels = Hotel::with('category')
            ->when($request->search, fn($q) => $q->where('name', 'like', "%{$request->search}%"))
            ->when($request->min_price, fn($q) => $q->where('price_per_night', '>=', $request->min_price))
            ->when($request->max_price, fn($q) => $q->where('price_per_night', '<=', $request->max_price))
            ->when($request->rating, fn($q) => $q->where('rating', '>=', $request->rating))
            ->when($request->category, fn($q) => $q->where('category_id', $request->category))
            ->when($request->country, fn($q) => $q->where('country', $request->country))
            ->when($request->state, fn($q) => $q->where('state', $request->state))
            ->when($request->city, fn($q) => $q->where('city', $request->city))
            ->when($request->location, fn($q) => $q->where('location', 'like', "%{$request->location}%"))
            ->when($request->is_featured, fn($q) => $q->where('is_featured', $request->is_featured))
            ->orderBy('price_per_night', 'desc') // Sorting by price descending
            ->get();

        return response()->json(['hotels' => $hotels]);
    }

}
