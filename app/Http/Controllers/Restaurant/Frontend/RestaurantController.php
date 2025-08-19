<?php

namespace App\Http\Controllers\Restaurant\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Restaurant\Category;
use App\Models\Restaurant\Order;
use App\Models\Restaurant\Product;
use App\Models\Restaurant\Restaurant;
use App\Models\Restaurant\RestaurantMenu;
use App\Services\LocationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class RestaurantController extends Controller
{
    //
    public function index()
    {
        $auto_restaurants = Cache::remember('restaurants_page_1', now()->addMinutes(10), function () {
            return Restaurant::where('is_open', 1)->latest()->paginate(10);
        });

        $cities = Cache::remember('restaurants_cities', now()->addHours(1), function () {
            return Restaurant::select('city')->distinct()->pluck('city');
        });

        $states = Cache::remember('restaurants_states', now()->addHours(1), function () {
            return Restaurant::select('state')->distinct()->pluck('state');
        });

        $delivery_zones = Cache::remember('restaurants_zones', now()->addHours(1), function () {
            return Restaurant::select('zone')->distinct()->pluck('zone');
        });

        $delivery_fees = Cache::remember('restaurants_fees', now()->addHours(1), function () {
            return Restaurant::select('start_from')->distinct()->pluck('start_from');
        });

        // dd($auto_restaurants);
        return view('Restaurant.frontend.pages.restaurants.index', compact('auto_restaurants', 'cities', 'states', 'delivery_zones', 'delivery_fees'));
    }
    public function filterProducts(Request $request)
    {
        $categoryId = $request->category_id;

        $products = $categoryId
            ? Product::where('category_id', $categoryId)->get()
            : Product::all();

        return view('components.restaurant.filtered-products', compact('products'))->render();
    }

    public function filter(Request $request)
    {
        $cacheKey = 'restaurants_filter_' . md5(json_encode($request->all()));

        $auto_restaurants = Cache::remember($cacheKey, now()->addMinutes(10), function () use ($request) {
            $query = Restaurant::where('is_open', 1);

            if ($request->filled('city'))
                $query->where('city', 'like', '%' . $request->city . '%');
            if ($request->filled('name'))
                $query->where('name', 'like', '%' . $request->name . '%');
            if ($request->filled('state'))
                $query->where('state', 'like', '%' . $request->state . '%');
            if ($request->filled('delivery_zone'))
                $query->where('zone', 'like', '%' . $request->delivery_zone . '%');
            if ($request->filled('delivery_fee'))
                $query->where('start_from', '>=', $request->delivery_fee);

            return $query->latest()->paginate(10);
        });

        $html = view('all_frontend_layouts.partials.restaurant-cards', compact('auto_restaurants'))->render();

        return response()->json(['html' => $html]);
    }

    public function fetchRestaurant(Request $request)
{
    $perPage = 4;

    // Don’t cache pagination, just the query results if needed
    $query = Restaurant::where('is_open', 1)->latest();

    $auto_restaurants = $query->paginate($perPage);

    if ($request->ajax()) {
        return view('all_frontend_layouts.partials.restaurant-cards', compact('auto_restaurants'))->render();
    }

    return view('aaa.restaurant', compact('auto_restaurants'));
}

    public function detail($id)
    {
        $cacheTime = now()->addMinutes(60); // cache for 10 minutes

        // Cache restaurant details
        $restaurant = Cache::remember("restaurant_detail_{$id}", $cacheTime, function () use ($id) {
            return Restaurant::with(['admin', 'images', 'ratings'])->findOrFail($id);
        });

        // Cache categories that have products for this restaurant
        $categories = Cache::remember("restaurant_categories_{$id}", $cacheTime, function () use ($id) {
            return Category::whereHas('products', function ($query) use ($id) {
                $query->where('restaurant_id', $id);
            })->get();
        });

        // Cache products for this restaurant, optionally filtered by category
        $categoryId = request('category_id');
        $products = Cache::remember("restaurant_products_{$id}_category_{$categoryId}", $cacheTime, function () use ($id, $categoryId) {
            return Product::where('restaurant_id', $id)
                ->when($categoryId, function ($query) use ($categoryId) {
                    $query->where('category_id', $categoryId);
                })
                ->get();
        });

        return view('Restaurant.frontend.pages.restaurants.detail', compact('restaurant', 'categories', 'products'));
    }

    public function getNearbyRestaurants(Request $request, LocationService $locationService)
    {
        // dd($request->all());
        $latitude = $request->latitude;
        $longitude = $request->longitude;
        $radius = $request->radius ?? 30; // default radius 30 km if not provided

        if (!$latitude || !$longitude) {
            return response()->json(['error' => 'Location is required'], 400);
        }

        // Calculate distance using Haversine formula
        $restaurants = Restaurant::selectRaw("
        id, name, cover, description, address, rating, start_from, latitude, longitude,delivery_radius,
        (6371 * acos(cos(radians(?)) * cos(radians(latitude)) * cos(radians(longitude) - radians(?)) + sin(radians(?)) * sin(radians(latitude)))) AS distance
            ", [$latitude, $longitude, $latitude])
            ->having('distance', '<=', $radius)
            ->orderBy('distance', 'asc')
            ->get();

        $carSpeed = 40; // km/h

        $restaurants->transform(function ($restaurant) use ($carSpeed, $locationService, $latitude, $longitude) {
            $restaurant->distance = round($restaurant->distance, 1); // in km
            $restaurant->time = ceil(($restaurant->distance / $carSpeed) * 60); // in minutes
            $restaurant->diff_distance = $locationService->getDistance($latitude, $longitude, $restaurant->latitude, $restaurant->longitude);

            return $restaurant;
        });

        return response()->json([
            'success' => true,
            'restaurants' => $restaurants
        ]);
    }


}
