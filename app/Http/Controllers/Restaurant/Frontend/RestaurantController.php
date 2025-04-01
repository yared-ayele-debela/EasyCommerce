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
        $latitude = $request->latitude;
        $longitude = $request->longitude;

        if (!$latitude || !$longitude) {
            return response()->json(['error' => 'Location is required'], 400);
        }

        // Calculate distance using Haversine formula
        $restaurants = Restaurant::selectRaw("
            id, name, cover, description, address,rating,start_from,
            (6371 * acos(cos(radians(?)) * cos(radians(latitude)) * cos(radians(longitude) - radians(?)) + sin(radians(?)) * sin(radians(latitude)))) AS distance
        ", [$latitude, $longitude, $latitude])
            ->having('distance', '<=', 10) // Show restaurants within 10 km radius
            ->orderBy('distance', 'asc') // Order by nearest first
            ->get();

        return response()->json([
            'success' => true,
            'restaurants' => $restaurants
        ]);
    }


}