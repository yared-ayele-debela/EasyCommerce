<?php

namespace App\Http\Controllers\Restaurant\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Restaurant\Category;
use App\Models\Restaurant\Order;
use App\Models\Restaurant\Product;
use App\Models\Restaurant\Restaurant;
use App\Models\Restaurant\RestaurantMenu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RestaurantController extends Controller
{
    //
    public function index()
    {
        $auto_restaurants=Restaurant::where('is_open',1)->latest()->paginate(10);
        $cities = Restaurant::select('city')->distinct()->pluck('city');
        $states = Restaurant::select('state')->distinct()->pluck('state');
        $delivery_zones = Restaurant::select('zone')->distinct()->pluck('zone');
        $delivery_fees = Restaurant::select('start_from')->distinct()->pluck('start_from');
        // dd($auto_restaurants);
        return view('Restaurant.frontend.pages.restaurants.index',compact( 'auto_restaurants','cities', 'states', 'delivery_zones', 'delivery_fees'));
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
        $query = Restaurant::where('is_open', 1);

        if ($request->filled('city')) {
            $query->where('city', 'like', '%' . $request->city . '%');
        }
        if ($request->filled(key: 'name')) {
            $query->where( 'name', 'like', '%' . $request->name . '%');
        }

        if ($request->filled('state')) {
            $query->where('state', 'like', '%' . $request->state . '%');
        }

        if ($request->filled('delivery_zone')) {
            $query->where('zone', 'like', '%' . $request->delivery_zone . '%');
        }

        if ($request->filled('delivery_fee')) {
            $query->where( 'start_from', '>=', $request->delivery_fee);
        }

        $auto_restaurants = $query->latest()->paginate(10);

        $html = view('all_frontend_layouts.partials.restaurant-cards', compact(var_name: 'auto_restaurants'))->render();

        return response()->json(['html' => $html]);
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
        $restaurant = Restaurant::with(['admin', 'images','ratings'])->findOrFail($id);
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
        
        $latitude = session('user_lat', 9.03);
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
