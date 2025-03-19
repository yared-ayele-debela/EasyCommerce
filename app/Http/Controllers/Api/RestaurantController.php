<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Restaurant;

class RestaurantController extends Controller
{
    public function nearbyRestaurants()
    {
        return response()->json(Restaurant::all());
    }
}
