<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;

/**
 * @OA\Tag(
 *     name="Products",
 *     description="API Endpoints for managing products"
 * )
 */
class ProductController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/products/deal-of-the-day",
     *     summary="Get deal of the day products",
     *     tags={"Products"},
     *     operationId="getDealOfTheDayProducts",
     *     @OA\Response(
     *         response=200,
     *         description="List of deal of the day products retrieved successfully"
     *     ),
     *     @OA\Response(response=500, description="Server error")
     * )
     */
    public function dealOfTheDay()
    {
        try {
            $products = Product::where('deal_of_the_day', true)->get();
            return response()->json($products, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch deal of the day products'], 500);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/products/trending",
     *     summary="Get trending products",
     *     tags={"Products"},
     *     operationId="getTrendingProducts",
     *     @OA\Response(
     *         response=200,
     *         description="List of trending products retrieved successfully"
     *     ),
     *     @OA\Response(response=500, description="Server error")
     * )
     */
    public function trending()
    {
        try {
            $products = Product::where('trending', true)->get();
            return response()->json($products, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch trending products'], 500);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/products/latest",
     *     summary="Get latest products",
     *     tags={"Products"},
     *     operationId="getLatestProducts",
     *     @OA\Response(
     *         response=200,
     *         description="List of latest products retrieved successfully"
     *     ),
     *     @OA\Response(response=500, description="Server error")
     * )
     */
    public function latest()
    {
        try {
            $products = Product::orderBy('created_at', 'desc')->take(10)->get();
            return response()->json($products, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch latest products'], 500);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/products/new-arrivals",
     *     summary="Get new arrival products",
     *     tags={"Products"},
     *     operationId="getNewArrivals",
     *     @OA\Response(
     *         response=200,
     *         description="List of new arrival products retrieved successfully"
     *     ),
     *     @OA\Response(response=500, description="Server error")
     * )
     */
    public function newArrivals()
    {
        try {
            $products = Product::where('new_arrival', true)->get();
            return response()->json($products, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch new arrivals'], 500);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/products/sponsored",
     *     summary="Get sponsored products",
     *     tags={"Products"},
     *     operationId="getSponsoredProducts",
     *     @OA\Response(
     *         response=200,
     *         description="List of sponsored products retrieved successfully"
     *     ),
     *     @OA\Response(response=500, description="Server error")
     * )
     */
    public function sponsored()
    {
        try {
            $products = Product::where('sponsored', true)->get();
            return response()->json($products, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch sponsored products'], 500);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/products/{id}",
     *     summary="Get product details",
     *     tags={"Products"},
     *     operationId="getProductDetail",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Product ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Product details retrieved successfully"
     *     ),
     *     @OA\Response(response=404, description="Product not found"),
     *     @OA\Response(response=500, description="Server error")
     * )
     */
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


