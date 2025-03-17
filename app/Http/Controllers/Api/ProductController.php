<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function dealOfTheDay()
    {
        try {
            $products = Product::where('deal_of_the_day', true)->get();
            return response()->json($products, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch deal of the day products'], 500);
        }
    }

    public function trending()
    {
        try {
            $products = Product::where('trending', true)->get();
            return response()->json($products, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch trending products'], 500);
        }
    }

    public function latest()
    {
        try {
            $products = Product::orderBy('created_at', 'desc')->take(10)->get();
            return response()->json($products, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch latest products'], 500);
        }
    }

    public function newArrivals()
    {
        try {
            $products = Product::where('new_arrival', true)->get();
            return response()->json($products, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch new arrivals'], 500);
        }
    }

    public function sponsored()
    {
        try {
            $products = Product::where('sponsored', true)->get();
            return response()->json($products, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch sponsored products'], 500);
        }
    }

    public function detail($id)
    {
        try {
            $product = Product::findOrFail($id);
            return response()->json($product, 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['error' => 'Product not found'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch product details'], 500);
        }
    }
}
