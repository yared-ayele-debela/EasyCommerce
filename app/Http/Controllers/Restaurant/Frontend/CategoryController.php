<?php

namespace App\Http\Controllers\Restaurant\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Restaurant\Category;
use App\Models\Restaurant\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use PDO;

class CategoryController extends Controller
{
    //

    public function index(){
    $cacheTime = 60 * 60; // 1 hour

    $categories = Cache::remember('restaurant_categories_active_paginated', $cacheTime, function () {
        return Category::where('is_active', 1)
            ->latest()
            ->paginate(10);
    });


        return view('Restaurant.frontend.pages.categories.index',compact('categories'));
    }

    public function detail($id){
         $cacheTime = 60 * 60; // 1 hour
    $latitude = session('user_lat', 9.03);
    $longitude = session('user_lng', 38.74);

    if (!$latitude || !$longitude) {
        return response()->json(['error' => 'Location is required'], 400);
    }

    // Cache category
    $category = Cache::remember("restaurant_category_{$id}", $cacheTime, function () use ($id) {
        return Category::with(['products', 'subcategories'])->findOrFail($id);
    });

    // Cache restaurants by category and location
    $restaurants = Cache::remember("restaurants_by_category_{$id}_{$latitude}_{$longitude}", $cacheTime, function () use ($id, $latitude, $longitude) {
        return Restaurant::selectRaw("
            id, name, cover, description, address, rating, start_from, latitude, longitude,
            (6371 * acos(cos(radians(?)) * cos(radians(latitude))
                * cos(radians(longitude) - radians(?))
                + sin(radians(?)) * sin(radians(latitude)))) AS distance
        ", [$latitude, $longitude, $latitude])
        ->whereHas('products', function ($query) use ($id) {
            $query->where('category_id', $id);
        })
        ->orderBy('distance', 'asc')
        ->get()
        ->transform(function ($restaurant) {
            $carSpeed = 40; // km/h
            $restaurant->distance = round($restaurant->distance, 1);
            $restaurant->time = ceil(($restaurant->distance / $carSpeed) * 60);
            return $restaurant;
        });
    });
        return view('Restaurant.frontend.pages.categories.detail',compact('category','restaurants'));
    }
}
