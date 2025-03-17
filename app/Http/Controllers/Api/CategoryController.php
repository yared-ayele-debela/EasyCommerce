<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\JsonResponse;

class CategoryController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/categories",
     *     summary="Get all categories",
     *     tags={"Categories"},
     *     @OA\Response(response=200, description="List of categories"),
     *     @OA\Response(response=500, description="Internal Server Error")
     * )
     */
    public function index(): JsonResponse
    {
        try {
            $categories = Category::all();
            return response()->json($categories, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch categories'], 500);
        }
    }
}