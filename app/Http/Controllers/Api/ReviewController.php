<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class ProductController extends Controller
{
    // public function dealOfTheDay()
    // {
    //     try {
    //         // Your logic here
    //         return response()->json(['message' => 'Deal of the day products fetched successfully'], 200);
    //     } catch (\Exception $e) {
    //         return response()->json(['error' => 'Something went wrong'], 500);
    //     }
    // }

    // public function trending()
    // {
    //     try {
    //         // Your logic here
    //         return response()->json(['message' => 'Trending products fetched successfully'], 200);
    //     } catch (\Exception $e) {
    //         return response()->json(['error' => 'Something went wrong'], 500);
    //     }
    // }

    // public function latest()
    // {
    //     try {
    //         // Your logic here
    //         return response()->json(['message' => 'Latest products fetched successfully'], 200);
    //     } catch (\Exception $e) {
    //         return response()->json(['error' => 'Something went wrong'], 500);
    //     }
    // }

    // public function newArrivals()
    // {
    //     try {
    //         // Your logic here
    //         return response()->json(['message' => 'New arrivals fetched successfully'], 200);
    //     } catch (\Exception $e) {
    //         return response()->json(['error' => 'Something went wrong'], 500);
    //     }
    // }

    // public function sponsored()
    // {
    //     try {
    //         // Your logic here
    //         return response()->json(['message' => 'Sponsored products fetched successfully'], 200);
    //     } catch (\Exception $e) {
    //         return response()->json(['error' => 'Something went wrong'], 500);
    //     }
    // }

    public function search(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'query' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        try {
            // Your logic here
            return response()->json(['message' => 'Search results fetched successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Something went wrong'], 500);
        }
    }

    public function similar($id)
    {
        try {
            // Your logic here
            return response()->json(['message' => 'Similar products fetched successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Something went wrong'], 500);
        }
    }

    // public function detail($id)
    // {
    //     try {
    //         // Your logic here
    //         return response()->json(['message' => 'Product details fetched successfully'], 200);
    //     } catch (\Exception $e) {
    //         return response()->json(['error' => 'Something went wrong'], 500);
    //     }
    // }
}