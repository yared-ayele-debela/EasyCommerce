<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Wishlist;
use Illuminate\Support\Facades\Auth;

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
     *     summary="Get all wishlist items with optional product type filter",
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(
     *         name="product_type",
     *         in="query",
     *         required=false,
     *         description="Filter wishlist by product type (restaurant, food, hotel, goods)",
     *         @OA\Schema(type="string", enum={"restaurant", "food", "hotel", "goods"})
     *     ),
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
    public function index(Request $request)
    {
        
        try {
            $user = auth()->user();
            if (!$user) {
                return response()->json(['success' => false, 'message' => 'Forbidden'], 403);
            }
            $query = Wishlist::where('user_id', $user->id);

            // If product_type is provided, filter by product_type
            if ($request->has('product_type')) {
                $query->where('product_type', $request->product_type);
            }

            $wishlists = $query->get();
            return response()->json(['data' => $wishlists], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch wishlist items','err'=>$e->getMessage()], 500);
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
     *             required={"product_id", "product_type"},
     *             @OA\Property(property="product_id", type="integer", example=1),
     *             @OA\Property(property="product_type", type="string", example="restaurant")
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
        // Check if the user is authenticated
        $user = auth()->user();
            if (!$user) {
                return response()->json(['success' => false, 'message' => 'Forbidden'], 403);
            }

        $validator = Validator::make($request->all(), [
            'product_id' => 'required|integer',
            'product_type' => 'required|string|in:restaurant,food,hotel,goods',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        try {
            // $user = Auth::user();

            // Check for duplicate
            $exists = Wishlist::where('user_id', $user->id)
                ->where('product_id', $request->product_id)
                ->where('product_type', $request->product_type)
                ->exists();

            if ($exists) {
                return response()->json(['message' => 'Item already in wishlist'], 200);
            }

            Wishlist::create([
                'user_id' => $user->id,
                'product_id' => $request->product_id,
                'product_type' => $request->product_type,
            ]);

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
     *             required={"product_id", "product_type"},
     *             @OA\Property(property="product_id", type="integer", example=1),
     *             @OA\Property(property="product_type", type="string", example="restaurant")
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
        // Check if the user is authenticated
        $user = auth()->user();
            if (!$user) {
                return response()->json(['success' => false, 'message' => 'Forbidden'], 403);
            }

        $validator = Validator::make($request->all(), [
            'product_id' => 'required|integer',
            'product_type' => 'required|string|in:restaurant,food,hotel,goods',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        try {
            // $user = Auth::user();

            Wishlist::where('user_id', $user->id)
                ->where('product_id', $request->product_id)
                ->where('product_type', $request->product_type)
                ->delete();

            return response()->json(['message' => 'Item removed from wishlist successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to remove item from wishlist'], 500);
        }
    }
}
