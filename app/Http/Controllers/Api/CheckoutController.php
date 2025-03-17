<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CheckoutController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/checkout",
     *     summary="Process checkout",
     *     tags={"Checkout"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="user_id", type="integer", example=1),
     *             @OA\Property(property="items", type="array", @OA\Items(type="object", 
     *                 @OA\Property(property="product_id", type="integer", example=101),
     *                 @OA\Property(property="quantity", type="integer", example=2)
     *             )),
     *             @OA\Property(property="payment_method", type="string", example="credit_card")
     *         )
     *     ),
     *     @OA\Response(response=200, description="Checkout successful"),
     *     @OA\Response(response=400, description="Validation error"),
     *     @OA\Response(response=500, description="Internal server error")
     * )
     */
    public function process(Request $request)
    {
        try {
            // Validate the request
            $validator = Validator::make($request->all(), [
                'user_id' => 'required|integer',
                'items' => 'required|array',
                'items.*.product_id' => 'required|integer',
                'items.*.quantity' => 'required|integer|min:1',
                'payment_method' => 'required|string'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation error',
                    'errors' => $validator->errors()
                ], 400);
            }

            // Logic for processing checkout
            // Example: Save order to the database, process payment, etc.

            return response()->json([
                'success' => true,
                'message' => 'Checkout successful'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Internal server error',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}