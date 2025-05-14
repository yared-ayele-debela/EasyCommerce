<?php

namespace App\Http\Controllers\Restaurant\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Restaurant\Category;
use App\Models\Restaurant\Restaurant;
use Illuminate\Http\Request;
use PDO;

class CategoryController extends Controller
{
    //

    public function index(){
        $categories=Category::where('is_active',1)->latest()->paginate(10);
        return view('Restaurant.frontend.pages.categories.index',compact('categories'));
    }

    public function detail($id){
        $category = Category::with(['products','subcategories'])->where('id',$id)->first();

         // Fetch restaurants that have products in this category
        // $restaurants = Restaurant::whereHas('products', function ($query) use ($id) {
        //     $query->where('category_id', $id);
        // })->get();
         $latitude = session('user_lat', 9.03); // fallback value
        $longitude = session('user_lng', 38.74);

        if (!$latitude || !$longitude) {
            dd("hello");
            return response()->json(['error' => 'Location is required'], 400);
        }

        // Calculate distance using Haversine formula
        $restaurants = Restaurant::selectRaw("
        id, name, cover, description, address, rating, start_from, latitude, longitude,
        (6371 * acos(cos(radians(?)) * cos(radians(latitude)) * cos(radians(longitude) - radians(?)) + sin(radians(?)) * sin(radians(latitude)))) AS distance
            ", [$latitude, $longitude, $latitude])
            ->whereHas('products', function ($query) use ($id) {
                $query->where('category_id', $id);
            })
            ->orderBy('distance', 'asc')
            ->get();

        // Estimate time by car (e.g., 40 km/h → 1.5 min/km)
        $carSpeed = 40; // km/h

        $restaurants->transform(function ($restaurant) use ($carSpeed) {
            $restaurant->distance = round($restaurant->distance, 1); // in km
            $restaurant->time = ceil(($restaurant->distance / $carSpeed) * 60); // in minutes
            return $restaurant;
        });
        return view('Restaurant.frontend.pages.categories.detail',compact('category','restaurants'));
    }
}