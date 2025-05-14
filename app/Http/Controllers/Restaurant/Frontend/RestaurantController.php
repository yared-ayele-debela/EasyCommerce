<?php

namespace App\Http\Controllers\Restaurant\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Restaurant\Category;
use App\Models\Restaurant\Product;
use App\Models\Restaurant\Restaurant;
use App\Models\Restaurant\RestaurantMenu;
use Illuminate\Http\Request;

class RestaurantController extends Controller
{
    //
    public function index()
    {
        $restaurants=Restaurant::where('is_open',1)->latest()->paginate(10);
        return view('Restaurant.frontend.pages.restaurants.index',compact('restaurants'));
    }
    public function fetchRestaurant(Request $request)
    {
        $auto_restaurants=Restaurant::where('is_open',1)->latest()->paginate(4);

        if ($request->ajax()) {
            return view('all_frontend_layouts.partials.restaurant-cards', compact('auto_restaurants'))->render();
        }

        return view('all_frontend_layouts.index', compact('auto_restaurants'));
    }

    public function detail($id)
    {
        $restaurant = Restaurant::with(['admin', 'images','ratings'])->where('id',$id)->first();
        $categories = Category::whereHas('products', function ($query) use ($id) {
            $query->where('restaurant_id', $id);
        })->get();

        $products = Product::where('restaurant_id', $id)
        ->when(request('category_id'), function ($query) {
            return $query->where('category_id', request('category_id'));
        })
        ->get();

        // // Get unique menus for this restaurant's products
        // $menus = RestaurantMenu::whereHas('products', function ($query) use ($id) {
        //     $query->where('restaurant_id', $id);
        // })->with(['products' => function ($query) use ($id) {
        //     $query->where('restaurant_id', $id);
        // }])->get();

        return view('Restaurant.frontend.pages.restaurants.detail',compact('restaurant','categories', 'products'));
    }

    public function getNearbyRestaurants(Request $request)
    {
        // $latitude = $request->latitude;
        // $longitude = $request->longitude;

        $latitude = session('user_lat', 9.03); // fallback value
        $longitude = session('user_lng', 38.74);

        if (!$latitude || !$longitude) {
            return response()->json(['error' => 'Location is required'], 400);
        }

        // Calculate distance using Haversine formula
        $restaurants = Restaurant::selectRaw("
        id, name, cover, description, address, rating, start_from, latitude, longitude,
        (6371 * acos(cos(radians(?)) * cos(radians(latitude)) * cos(radians(longitude) - radians(?)) + sin(radians(?)) * sin(radians(latitude)))) AS distance
            ", [$latitude, $longitude, $latitude])
            ->having('distance', '<=', 10) // Restaurants within 10 km
            ->orderBy('distance', 'asc')
            ->get();

        // Estimate time by car (e.g., 40 km/h → 1.5 min/km)
        $carSpeed = 40; // km/h

        $restaurants->transform(function ($restaurant) use ($carSpeed) {
            $restaurant->distance = round($restaurant->distance, 1); // in km
            $restaurant->time = ceil(($restaurant->distance / $carSpeed) * 60); // in minutes
            return $restaurant;
        });

        return response()->json([
            'success' => true,
            'restaurants' => $restaurants
        ]);
    }


}