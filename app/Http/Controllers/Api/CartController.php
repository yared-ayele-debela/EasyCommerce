<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


/**
 * @OA\Tag(
 *     name="Products",
 *     description="API Endpoints for managing products"
 * )
 */
class CartController extends Controller
{
    
    /**
 * @OA\Get(
 *     path="/api/cart",
 *     summary="Get cart items",
 *     tags={"Cart"},
 *     @OA\Parameter(
 *         name="product_type",
 *         in="query",
 *         required=false,
 *         description="Filter cart items by product type (goods or foods)",
 *         @OA\Schema(type="string", enum={"goods", "foods"})
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="List of cart items"
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Failed to fetch cart items"
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
            $userId = Auth::id();
            $sessionId = $request->session()->getId(); // fallback for guest users
            $productType = $request->query('product_type', null); // optional filter

            $query = Cart::query();

            if ($userId) {
                $query->where('user_id', $userId);
            } else {
                $query->where('session_id', $sessionId);
            }

            if ($productType) {
                $query->where('product_type', $productType);
            }

            $cartItems = $query->get();

            return response()->json(['success' => true, 'data' => $cartItems], 200);
        } catch (\Exception $e) {
            Log::error($e);
            return response()->json(['success' => false, 'message' => 'Failed to fetch cart items'], 500);
        }
    }

    

    /**
 * @OA\Post(
 *     path="/api/cart/add",
 *     summary="Add item to cart",
 *     tags={"Cart"},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="product_id", type="integer", example=1),
 *             @OA\Property(property="quantity", type="integer", example=2),
 *             @OA\Property(property="product_type", type="string", example="goods", enum={"goods", "foods"}),
 *             @OA\Property(property="size", type="string", example="Large")
 *         )
 *     ),
 *     @OA\Response(response=200, description="Item added to cart"),
 *     @OA\Response(response=422, description="Validation error"),
 *     @OA\Response(response=500, description="Failed to add item to cart")
 * )
 */

    public function add(Request $request)
    {
        try {
            $user = auth()->user();
            if (!$user) {
                return response()->json(['success' => false, 'message' => 'Forbidden'], 403);
            }
            $validated = $request->validate([
                'product_id' => 'required|integer|exists:products,id',
                'quantity' => 'required|integer|min:1',
                'size' => 'required|string',
                'product_type' => 'required|in:goods,food',
            ]);

            $userId = Auth::id();
            $sessionId = $request->session()->getId();

            $cartItem = Cart::updateOrCreate(
                [
                    'product_id' => $validated['product_id'],
                    'user_id' => $userId,
                    'session_id' => $userId ? null : $sessionId,
                    'product_type' => $validated['product_type'],
                    'size' => $validated['size']
                ],
                [
                    'quantity' => \DB::raw("quantity + {$validated['quantity']}"),
                ]
            );

            return response()->json(['success' => true, 'data' => $cartItem, 'message' => 'Item added to cart successfully'], 200);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['success' => false, 'message' => $e->errors()], 422);
        } catch (\Exception $e) {
            Log::error($e);
            return response()->json(['success' => false, 'message' => 'Failed to add item to cart'], 500);
        }
    }

   

    /**
 * @OA\Post(
 *     path="/api/cart/remove",
 *     summary="Remove item from cart",
 *     tags={"Cart"},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="product_id", type="integer", example=1),
 *             @OA\Property(property="product_type", type="string", example="foods", enum={"goods", "foods"})
 *         )
 *     ),
 *     @OA\Response(response=200, description="Item removed from cart"),
 *     @OA\Response(response=422, description="Validation error"),
 *     @OA\Response(response=500, description="Failed to remove item from cart")
 * )
 */

    public function remove(Request $request)
    {
        try {
            $user = auth()->user();
            if (!$user) {
                return response()->json(['success' => false, 'message' => 'Forbidden'], 403);
            }

            $validated = $request->validate([
                'product_id' => 'required|integer|exists:products,id',
                'size' => 'required|string',
                'product_type' => 'required|in:goods,food',
            ]);

            $userId = Auth::id();
            $sessionId = $request->session()->getId();

            $cartItem = Cart::where('product_id', $validated['product_id'])
                ->where('size', $validated['size'])
                ->where('product_type', $validated['product_type'])
                ->when($userId, fn($q) => $q->where('user_id', $userId))
                ->when(!$userId, fn($q) => $q->where('session_id', $sessionId))
                ->first();

            if ($cartItem) {
                $cartItem->delete();
                return response()->json(['success' => true, 'message' => 'Item removed from cart successfully'], 200);
            }

            return response()->json(['success' => false, 'message' => 'Cart item not found'], 404);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['success' => false, 'message' => $e->errors()], 422);
        } catch (\Exception $e) {
            Log::error($e);
            return response()->json(['success' => false, 'message' => 'Failed to remove item from cart'], 500);
        }
    }

    
    /**
 * @OA\Post(
 *     path="/api/cart/update",
 *     summary="Update cart item quantity",
 *     tags={"Cart"},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="product_id", type="integer", example=1),
 *             @OA\Property(property="quantity", type="integer", example=3),
 *             @OA\Property(property="product_type", type="string", example="goods", enum={"goods", "foods"})
 *         )
 *     ),
 *     @OA\Response(response=200, description="Cart item updated"),
 *     @OA\Response(response=422, description="Validation error"),
 *     @OA\Response(response=500, description="Failed to update cart item")
 * )
 */

    public function update(Request $request)
    {
        try {
            $user = auth()->user();
            if (!$user) {
                return response()->json(['success' => false, 'message' => 'Forbidden'], 403);
            }
            $validated = $request->validate([
                'product_id' => 'required|integer|exists:products,id',
                'quantity' => 'required|integer|min:1',
                'size' => 'required|string',
                'product_type' => 'required|in:goods,food',
            ]);

            $userId = Auth::id();
            $sessionId = $request->session()->getId();

            $cartItem = Cart::where('product_id', $validated['product_id'])
                ->where('size', $validated['size'])
                ->where('product_type', $validated['product_type'])
                ->when($userId, fn($q) => $q->where('user_id', $userId))
                ->when(!$userId, fn($q) => $q->where('session_id', $sessionId))
                ->first();

            if (!$cartItem) {
                return response()->json(['success' => false, 'message' => 'Cart item not found'], 404);
            }

            $cartItem->update(['quantity' => $validated['quantity']]);

            return response()->json(['success' => true, 'data' => $cartItem, 'message' => 'Cart item updated successfully'], 200);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['success' => false, 'message' => $e->errors()], 422);
        } catch (\Exception $e) {
            Log::error($e);
            return response()->json(['success' => false, 'message' => 'Failed to update cart item'], 500);
        }
    }

    

  
}