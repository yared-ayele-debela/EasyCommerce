<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Food;

class FoodController extends Controller
{
    public function index()
    {
        return response()->json(Food::all());
    }

    public function store(Request $request)
    {
        $request->validate([
            'restaurant_id' => 'required|exists:restaurants,id',
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string',
            'price' => 'required|numeric',
        ]);

        $food = Food::create($request->all());

        return response()->json($food, 201);
    }

    public function specialOffers()
    {
        return response()->json(Food::where('discount', '>', 0)->get());
    }
}
