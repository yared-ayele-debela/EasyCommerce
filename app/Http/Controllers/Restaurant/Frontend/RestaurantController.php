<?php

namespace App\Http\Controllers\Restaurant\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Restaurant\Category;
use App\Models\Restaurant\Product;
use App\Models\Restaurant\Restaurant;
use Illuminate\Http\Request;

class RestaurantController extends Controller
{
    //
    public function index()
    {
        $restaurants=Restaurant::where('is_active',1)->latest()->paginate(10);
        return view('Restaurant.frontend.pages.restaurants.index',compact('restaurants'));
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

        return view('Restaurant.frontend.pages.restaurants.detail',compact('restaurant','categories', 'products'));
    }

    public function getNearbyRestaurants(Request $request)
    {
        $userLat = $request->query('lat');
        $userLng = $request->query('lng');

        if (!$userLat || !$userLng) {
            return response()->json(['error' => 'Location not provided'], 400);
        }

        // Calculate nearby restaurants using the Haversine formula
        $restaurants = Restaurant::selectRaw("
id, name, description, cover, address, latitude, longitude,
            (6371 * acos(cos(radians(?)) * cos(radians(latitude)) 
            * cos(radians(longitude) - radians(?)) 
            + sin(radians(?)) * sin(radians(latitude)))) AS distance
        ", [$userLat, $userLng, $userLat])
        ->with(['admin', 'images','ratings'])
        ->having("distance", "<", 10) // Restaurants within 10km
        ->orderBy("distance")
        ->get();

        return response()->json($restaurants);
    }


}