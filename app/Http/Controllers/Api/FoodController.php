<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Food;
use OpenApi\Annotations as OA;

/**
 * @OA\Tag(
 *     name="Foods",
 *     description="API Endpoints for managing foods"
 * )
 */
class FoodController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/foods",
     *     summary="Get all foods",
     *     tags={"Foods"},
     *     operationId="getFoods",
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation"))
     */
    public function index()
    {
        return response()->json(Food::all());
    }

    /**
     * @OA\Post(
     *     path="/api/foods",
     *     summary="Create a new food item",
     *     tags={"Foods"},
     *     operationId="createFood",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"restaurant_id", "category_id", "name", "price"},
     *             @OA\Property(property="restaurant_id", type="integer", example=1),
     *             @OA\Property(property="category_id", type="integer", example=2),
     *             @OA\Property(property="name", type="string", example="Pasta"),
     *             @OA\Property(property="price", type="number", format="float", example=12.99)
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Food created successfully"
     *     ),
     *     @OA\Response(response=422, description="Validation error")
     * )
     */
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

    /**
     * @OA\Get(
     *     path="/api/foods/special-offers",
     *     summary="Get all food items with discounts",
     *     tags={"Foods"},
     *     operationId="getSpecialOffers",
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation"
     * ))
     */
    public function specialOffers()
    {
        return response()->json(Food::where('discount', '>', 0)->get());
    }
}
