<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\JsonResponse;
use OpenApi\Annotations as OA;

/**
 * @OA\Tag(
 *     name="Categories",
 *     description="API Endpoints for managing restaurant categories"
 * )
 */
class RestaurantCategoryController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/restaurant-categories",
     *     summary="Get all restaurant categories",
     *     tags={"Categories"},
     *     operationId="getRestaurantCategories",
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation"
     *     ),
     *     @OA\Response(response=500, description="Failed to fetch categories")
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
