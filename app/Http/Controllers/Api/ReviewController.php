<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class ProductController extends Controller
{
    

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

    
}