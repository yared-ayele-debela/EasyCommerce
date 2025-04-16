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
     *     tags={"Product Categories"},
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
    /**
     * @OA\Get(
     *     path="/api/categories/main",
     *     summary="Get main categories",
     *     tags={"Product Categories"},
     *     @OA\Response(response=200, description="List of main categories"),
     *     @OA\Response(response=500, description="Internal Server Error")
     * )
     */
    public function mainCategories(): JsonResponse
    {
        try {
            $mainCategories = Category::where('parent_id', 0)->get();
            return response()->json($mainCategories, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch main categories'], 500);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/categories/sub/{parentId}",
     *     summary="Get subcategories by parent category ID",
     *     tags={"Product Categories"},
     *     @OA\Parameter(
     *         name="parentId",
     *         in="path",
     *         required=true,
     *         description="Parent category ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="List of subcategories"),
     *     @OA\Response(response=500, description="Internal Server Error")
     * )
     */
    public function subCategories(int $parentId): JsonResponse
    {
        try {
            $subCategories = Category::where('parent_id', $parentId)->get();
            return response()->json($subCategories, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch subcategories'], 500);
        }
    }
}