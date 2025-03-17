<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Order;




/**
 * @OA\Tag(
 *     name="Orders",
 *     description="API Endpoints for managing orders"
 * )
 */
class OrderController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/orders",
     *     tags={"Orders"},
     *     summary="Get list of orders",
     *     security={{"sanctum":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation"
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
            $orders = Order::all();
            return response()->json(['success' => true, 'data' => $orders], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/orders/{id}",
     *     tags={"Orders"},
     *     summary="Get order details",
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Order ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Order not found"
     *     )
     * )
     */
    public function detail($id)
    {
        try {
            $order = Order::find($id);
            if (!$order) {
                return response()->json(['success' => false, 'message' => 'Order not found'], 404);
            }
            return response()->json(['success' => true, 'data' => $order], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * @OA\Post(
     *     path="/api/orders/cancel/{id}",
     *     tags={"Orders"},
     *     summary="Cancel an order",
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Order ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="reason", type="string", description="Reason for cancellation")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Order cancelled successfully"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Order not found"
     *     )
     * )
     */
    public function cancel(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'reason' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        try {
            $order = Order::find($id);
            if (!$order) {
                return response()->json(['success' => false, 'message' => 'Order not found'], 404);
            }

            // Assuming there's a status field in the Order model
            $order->status = 'cancelled';
            $order->cancellation_reason = $request->reason;
            $order->save();

            return response()->json(['success' => true, 'message' => 'Order cancelled successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}