<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;



/**
 * @OA\Tag(
 *     name="Wishlist",
 *     description="API Endpoints for Wishlist Management"
 * )
 */
class WishlistController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/wishlist",
     *     tags={"Wishlist"},
     *     summary="Get all wishlist items",
     *     security={{"sanctum":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(type="array", @OA\Items(type="object"))
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     )
     * )
     */
    public function index()
    {
        try {
            // Fetch wishlist items logic here
            return response()->json(['message' => 'Wishlist items fetched successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch wishlist items'], 500);
        }
    }

    /**
     * @OA\Post(
     *     path="/api/wishlist/add",
     *     tags={"Wishlist"},
     *     summary="Add an item to the wishlist",
     *     security={{"sanctum":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"item_id"},
     *             @OA\Property(property="item_id", type="integer", example=1)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Item added successfully"
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Validation error"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Server error"
     *     )
     * )
     */
    public function add(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'item_id' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        try {
            // Add item to wishlist logic here
            return response()->json(['message' => 'Item added to wishlist successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to add item to wishlist'], 500);
        }
    }

    /**
     * @OA\Post(
     *     path="/api/wishlist/remove",
     *     tags={"Wishlist"},
     *     summary="Remove an item from the wishlist",
     *     security={{"sanctum":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"item_id"},
     *             @OA\Property(property="item_id", type="integer", example=1)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Item removed successfully"
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Validation error"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Server error"
     *     )
     * )
     */
    public function remove(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'item_id' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        try {
            // Remove item from wishlist logic here
            return response()->json(['message' => 'Item removed from wishlist successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to remove item from wishlist'], 500);
        }
    }
}