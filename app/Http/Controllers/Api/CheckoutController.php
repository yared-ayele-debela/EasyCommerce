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
    *             @OA\Property(property="payment_method", type="string", example="cash_on_delivery"),
    *             @OA\Property(property="coupon_code", type="string", example="DISCOUNT10"),
    *             @OA\Property(property="transaction_id", type="string", example="TRX123456"),
    *             @OA\Property(property="screenshot", type="string", format="binary", example="screenshot.jpg")
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
            'payment_method' => 'required|string',
            'coupon_code' => 'nullable|string',
            'transaction_id' => 'nullable|string',
            'screenshot' => 'nullable|file|mimes:jpeg,png,jpg|max:2048'
        ]);

        if ($validator->fails()) {
            return response()->json([
            'success' => false,
            'message' => 'Validation error',
            'errors' => $validator->errors()
            ], 400);
        }

        // Logic for processing checkout
        $userId = $request->input('user_id');
        $items = $request->input('items');
        $paymentMethod = $request->input('payment_method');

        // Example: Save order details to the database
        $order = new \App\Models\Order();
        $order->user_id = $userId;
        $order->payment_method = $paymentMethod;
        $order->transaction_id = $request->input('transaction_id');
        $order->coupon_code = $request->input('coupon_code');
        $order->save();

        // Save order items
        foreach ($items as $item) {
            $orderItem = new \App\Models\OrderItem();
            $orderItem->order_id = $order->id;
            $orderItem->product_id = $item['product_id'];
            $orderItem->quantity = $item['quantity'];
            $orderItem->save();
        }

        $couponCode = $request->input('coupon_code');
        if ($couponCode) {
            // Example: Validate and apply the coupon code
            $coupon = \App\Models\Coupon::where('code', $couponCode)->first();
            if (!$coupon) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid coupon code'
            ], 400);
            }

            // Check if the coupon is expired
            if ($coupon->expires_at && $coupon->expires_at < now()) {
            return response()->json([
                'success' => false,
                'message' => 'Coupon code has expired'
            ], 400);
            }

            // Apply the coupon discount (example logic)
            $order->discount = $coupon->discount_amount;
            $order->save();
        }

        // Save the screenshot file
        if ($request->hasFile('screenshot')) {
            $screenshotPath = $request->file('screenshot')->store('screenshots', 'public');
        }

        return response()->json([
            'success' => true,
            'message' => 'Checkout successful',
            'transaction_id' => $request->input('transaction_id'),
            'screenshot_path' => $screenshotPath ?? null
        ], 200);
        }  catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Internal server error',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * @OA\Post(
     *     path="/api/hotel-reservation-checkout",
     *     summary="Process hotel reservation checkout",
     *     tags={"Checkout"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="user_id", type="integer", example=1),
     *             @OA\Property(property="room_id", type="integer", example=101),
     *             @OA\Property(property="check_in_date", type="string", format="date", example="2023-12-01"),
     *             @OA\Property(property="check_out_date", type="string", format="date", example="2023-12-05"),
     *             @OA\Property(property="coupon_code", type="string", example="HOTEL10"),
     *             @OA\Property(property="price", type="integer", example=5000),
     *             @OA\Property(property="payment_method", type="string", example="credit_card"),
     *             @OA\Property(property="transaction_id", type="string", example="TRX123456"),
     *             @OA\Property(property="screenshot", type="string", format="binary", example="receipt.jpg")
     *         )
     *     ),
     *     @OA\Response(response=200, description="Hotel reservation checkout successful"),
     *     @OA\Response(response=400, description="Validation error"),
     *     @OA\Response(response=500, description="Internal server error")
     * )
     */
    public function hotelReservationCheckout(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'user_id' => 'required|integer',
                'room_id' => 'required|integer',
                'check_in_date' => 'required|date|after_or_equal:today',
                'check_out_date' => 'required|date|after:check_in_date',
                'coupon_code' => 'nullable|string|max:50',
                'price' => 'required|numeric|min:0',
                'transaction_id' => 'required|string|max:100',
                'screenshot' => 'nullable|file|mimes:jpeg,png,jpg|max:2048',
                'payment_method' => 'nullable|string'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation error',
                    'errors' => $validator->errors()
                ], 400);
            }

            // Logic for processing hotel reservation checkout
            $reservation = new \App\Models\Reservation();
            $reservation->user_id = $request->input('user_id');
            $reservation->hotel_id = $request->input('hotel_id');
            $reservation->room_id = $request->input('room_id');
            $reservation->check_in_date = $request->input('check_in_date');
            $reservation->check_out_date = $request->input('check_out_date');
            $reservation->total_price = $request->input('price');

            $couponCode = $request->input('coupon_code');
            if ($couponCode) {
                $coupon = \App\Models\Coupon::where('code', $couponCode)->first();
                if (!$coupon || ($coupon->expires_at && $coupon->expires_at < now())) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Invalid or expired coupon code'
                    ], 400);
                }
                $reservation->discount = $coupon->discount_amount;
            }

            $reservation->save();

            return response()->json([
                'success' => true,
                'message' => 'Hotel reservation checkout successful'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Internal server error',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * @OA\Post(
     *     path="/api/restaurant-order-checkout",
     *     summary="Process restaurant food order checkout",
     *     tags={"Checkout"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="user_id", type="integer", example=1),
     *             @OA\Property(property="items", type="array", @OA\Items(type="object", 
     *                 @OA\Property(property="food_id", type="integer", example=201),
     *                 @OA\Property(property="quantity", type="integer", example=2)
     *             )),
     *             @OA\Property(property="coupon_code", type="string", example="FOOD20"),
     *             @OA\Property(property="delivery_address_id", type="integer", example=123),
     *             @OA\Property(property="payment_method", type="string", example="cash_on_delivery"),
     *             @OA\Property(property="screenshot", type="string", format="binary", example="receipt.jpg")
     *         )
     *     ),
     *     @OA\Response(response=200, description="Restaurant food order checkout successful"),
     *     @OA\Response(response=400, description="Validation error"),
     *     @OA\Response(response=500, description="Internal server error")
     * )
     */
    public function restaurantOrderCheckout(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'user_id' => 'required|integer',
                'items' => 'required|array',
                'items.*.food_id' => 'required|integer|exists:foods,id',
                'items.*.size' => 'nullable|string',
                'items.*.quantity' => 'required|integer|min:1',
                'coupon_code' => 'nullable|string',
                'delivery_address_id' => 'nullable|integer|exists:delivery_address,id',
                'payment_method' => 'required|string|in:cash_on_delivery,bank_transfer'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation error',
                    'errors' => $validator->errors()
                ], 400);
            }

            if ($request->input('payment_method') === 'bank_transfer' && !$request->hasFile('screenshot')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Screenshot is required for bank transfer payment method'
                ], 400);
            }

            $items = $request->input('items');
            $subtotal = collect($items)->reduce(function ($carry, $item) {
                $product = \App\Models\Food::find($item['food_id']);
                if (!$product) {
                    throw new \Exception('Invalid menu item ID: ' . $item['food_id']);
                }
                return $carry + ($product->price * $item['quantity']);
            }, 0);

            $deliveryFee = 15.00;
            $discount = 0.00;

            if ($couponCode = $request->input('coupon_code')) {
                $coupon = \App\Models\Coupon::where('coupon_code', $couponCode)->first();
                if (!$coupon || ($coupon->expires_at && $coupon->expires_at < now())) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Invalid or expired coupon code'
                    ], 400);
                }
                $discount = $coupon->discount_amount;
            }

            $total = $subtotal + $deliveryFee - $discount;

            $order = \App\Models\RestaurantOrder::create([
                'user_id' => $request->input('user_id'),
                'subtotal' => $subtotal,
                'discount' => $discount,
                'delivery_fee' => $deliveryFee,
                'total' => $total,
                'payment_method' => $request->input('payment_method'),
                'delivery_address_id' => $request->input('delivery_address_id'),
                'screenshot_path' => $request->hasFile('screenshot') 
                    ? $request->file('screenshot')->store('screenshots', 'public') 
                    : null
            ]);

            foreach ($items as $item) {
                $product = \App\Models\Food::find($item['food_id']);
                \App\Models\RestaurantOrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['food_id'],
                    'size' => $item['size'] ?? null,
                    'quantity' => $item['quantity'],
                    'price' => $product->price,
                    'total' => $product->price * $item['quantity']
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Restaurant food order checkout successful',
                'order_id' => $order->id,
                'total' => $total,
                'screenshot_path' => $order->screenshot_path
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