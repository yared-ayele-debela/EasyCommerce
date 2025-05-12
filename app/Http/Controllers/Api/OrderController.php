<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
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
     *     summary="Get list of user's orders",
     *     security={{"sanctum":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(property="id", type="integer", description="Order ID"),
     *                     @OA\Property(property="order_code", type="string", description="Order Code"),
     *                     @OA\Property(property="name", type="string", description="Customer Name"),
     *                     @OA\Property(property="address", type="string", description="Delivery Address"),
     *                     @OA\Property(property="city", type="string", description="City"),
     *                     @OA\Property(property="state", type="string", description="State"),
     *                     @OA\Property(property="country", type="string", description="Country"),
     *                     @OA\Property(property="pincode", type="string", description="Pincode"),
     *                     @OA\Property(property="latitude", type="string", description="Latitude"),
     *                     @OA\Property(property="longitude", type="string", description="Longitude"),
     *                     @OA\Property(property="mobile", type="string", description="Customer Mobile Number"),
     *                     @OA\Property(property="email", type="string", description="Customer Email"),
     *                     @OA\Property(property="shipping_charges", type="number", format="float", description="Shipping Charges"),
     *                     @OA\Property(property="tax_charge", type="number", format="float", description="Tax Charges"),
     *                     @OA\Property(property="coupon_code", type="string", description="Coupon Code"),
     *                     @OA\Property(property="coupon_amount", type="string", description="Coupon Amount"),
     *                     @OA\Property(property="order_status", type="string", description="Order Status"),
     *                     @OA\Property(property="payment_method", type="string", description="Payment Method"),
     *                     @OA\Property(property="payment_gateway", type="string", description="Payment Gateway"),
     *                     @OA\Property(property="grand_total", type="number", format="float", description="Grand Total"),
     *                     @OA\Property(property="payment_currency", type="string", description="Payment Currency"),
     *                     @OA\Property(property="courier_name", type="string", description="Courier Name"),
     *                     @OA\Property(property="tracking_number", type="string", description="Tracking Number"),
     *                     @OA\Property(property="itemquantity", type="integer", description="Quantity of Items"),
     *                     @OA\Property(property="created_at", type="string", format="date-time", description="Creation Date"),
     *                     @OA\Property(property="updated_at", type="string", format="date-time", description="Update Date")
     *                 )
     *             )
     *         ),
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

            $orders = Order::where('user_id', $user->id)->get(); // Fetch only the user's orders

            // Include itemquantity, trackingnumber, and order status
            $ordersWithDetails = $orders->map(function ($order) {
                // $order->itemquantity = $order->orderItems->sum('quantity');  // Assuming orderItems is a related model
                $order->tracking_number = $order->tracking_number;
                $order->order_status = $order->order_status;
                return $order;
            });

            return response()->json(['success' => true, 'data' => $ordersWithDetails], 200);
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
    public function getOrderDetails($id)
    {
        try {
            $user = auth()->user();
            if (!$user) {
                return response()->json(['success' => false, 'message' => 'Unauthorized'], 401);
            }

            $order = Order::with(['orders_products'])->find($id); // Fetch order along with items
            if (!$order) {
                return response()->json(['success' => false, 'message' => 'Order not found'], 404);
            }

            // Add itemquantity and trackingnumber to the response
            // $order->itemquantity = $order->orderItems->sum('quantity');  // Sum of all item quantities
            $order->trackingnumber = $order->tracking_number;  // Assuming tracking_number is in the order table

            return response()->json(['success' => true, 'data' => $order], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/orders/myorder",
     *     tags={"Orders"},
     *     summary="Get user's orders based on type",
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(
     *         name="type",
     *         in="query",
     *         required=true,
     *         description="Type of order",
     *         @OA\Schema(type="string", enum={"food", "hotel", "ecommerce"})
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Orders retrieved successfully"
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid input"
     *     )
     * )
     */
    public function getUserOrders(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['success' => false, 'message' => 'Forbidden'], 403);
        }

        $validator = Validator::make($request->all(), [
            'type' => 'required|string|in:food,hotel,ecommerce',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        try {
            $user = $request->user(); // Get the authenticated user

            switch ($request->query('type')) {
                case 'food':
                    $orders = \App\Models\RestaurantOrder::with('restaurant')->where('user_id', $user->id)->get();
                    break;
                case 'hotel':
                    $orders = \App\Models\Reservation::with('hotel')->where('user_id', $user->id)->get();
                    break;
                case 'ecommerce':
                    $orders = \App\Models\Order::with('orders_products')->where('user_id', $user->id)->get();
                    break;
                default:
                    return response()->json(['success' => false, 'message' => 'Invalid order type'], 400);
            }

            return response()->json(['success' => true, 'data' => $orders], 200);
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
        $user = auth()->user();
        if (!$user) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 401);
        }

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

            $order->status = 'cancelled';
            $order->cancellation_reason = $request->reason;
            $order->save();

            return response()->json(['success' => true, 'message' => 'Order cancelled successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
    /**
     * @OA\Post(
     *     path="/api/orders/reorder/{id}",
     *     tags={"Orders"},
     *     summary="Reorder an existing order",
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
     *         description="Order placed successfully"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Order not found"
     *     )
     * )
     */
    public function reorder($id)
    {
        try {
            $user = auth()->user();
            if (!$user) {
                return response()->json(['success' => false, 'message' => 'Forbidden'], 403);
            }

            $order = Order::find($id);
            if (!$order) {
                return response()->json(['success' => false, 'message' => 'Order not found'], 404);
            }

            $newOrder = $order->replicate();
            $newOrder->status = 'pending'; // Reset status for the new order
            $newOrder->created_at = now();
            $newOrder->updated_at = now();
            $newOrder->save();

            return response()->json(['success' => true, 'message' => 'Order placed successfully', 'data' => $newOrder], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}