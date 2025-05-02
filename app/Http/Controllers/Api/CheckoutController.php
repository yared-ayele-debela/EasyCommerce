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
                'user_id' => 'required|integer|exists:users,id',
                'items' => 'required',
                'items.*.product_id' => 'required|integer|exists:products,id',
                'items.*.quantity' => 'required|integer|min:1',
                'payment_method' => 'required|string|in:cash_on_delivery,bank_transfer',
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

            // Calculate order details
            $items = json_decode($request->input('items'), true);
            $subtotal = collect($items)->reduce(function ($carry, $item) {
                $product = \App\Models\Product::find($item['product_id']);
                return $carry + ($product->price * $item['quantity']);
            }, 0);

            $shippingCharges = 50.00; // Example shipping charge
            $couponDiscount = 0.00;

            if ($couponCode = $request->input('coupon_code')) {
                $coupon = \App\Models\Coupon::where('code', $couponCode)->first();
                if (!$coupon || ($coupon->expires_at && $coupon->expires_at < now())) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Invalid or expired coupon code'
                    ], 400);
                }
                $couponDiscount = $coupon->discount_amount;
            }

            $grandTotal = $subtotal + $shippingCharges - $couponDiscount;

            // Save order details
            $user = \App\Models\User::find($request->input('user_id'));

            $order = \App\Models\Order::create([
                'user_id' => $user->id,
                'name' => $user->name,
                'address' => $user->address,
                'city' => $user->city,
                'state' => $user->state,
                'country' => $user->country,
                'pincode' => $user->pincode,
                'mobile' => $user->mobile,
                'email' => $user->email,
                'shipping_charges' => $shippingCharges,
                'coupon_code' => $couponCode,
                'coupon_amount' => $couponDiscount,
                'payment_method' => $request->input('payment_method'),
                'payment_gateway' => $request->input('payment_method'),
                'transaction_id' => $request->input('transaction_id'),
                'grand_total' => $grandTotal
            ]);

            // Save order items
            foreach ($items as $item) {
                \App\Models\OrderItem::create([
                    'order_id' => $order->id,
                    'menu_item_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'price' => \App\Models\Product::find($item['product_id'])->product_price
                ]);
            }

            // Save screenshot if provided
            if ($request->hasFile('screenshot')) {
                $screenshotPath = $request->file('screenshot')->store('screenshots', 'public');
                $order->update(['screenshot_path' => $screenshotPath]);
                $screenshotUrl = asset('storage/' . $screenshotPath);
            }

            return response()->json([
                'success' => true,
                'message' => 'Checkout successful',
                'order_id' => $order->id,
                'grand_total' => $grandTotal
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
     *     path="/api/hotel-reservation-checkout",
     *     summary="Process hotel reservation checkout",
     *     tags={"Checkout"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="user_id", type="integer", example=1),
     *             @OA\Property(property="hotel_id", type="integer", example=10),
     *             @OA\Property(property="room_id", type="integer", example=101),
     *             @OA\Property(property="check_in_date", type="string", format="date", example="2023-12-01"),
     *             @OA\Property(property="check_out_date", type="string", format="date", example="2023-12-05"),
     *             @OA\Property(property="coupon_code", type="string", example="HOTEL10"),
     *             @OA\Property(property="price", type="numeric", example=5000),
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
                'user_id' => 'required|integer|exists:users,id',
                'hotel_id' => 'required|integer|exists:hotels,id',
                'room_id' => 'required|integer|exists:rooms,id',
                'check_in_date' => 'required|date|after_or_equal:today',
                'check_out_date' => 'required|date|after:check_in_date',
                'coupon_code' => 'nullable|string|max:50',
                'price' => 'required|numeric|min:0',
                'transaction_id' => 'nullable|string|max:100',
                'screenshot' => 'nullable|file|mimes:jpeg,png,jpg|max:2048',
                'payment_method' => 'required|string|in:credit_card,cash_on_delivery,bank_transfer'
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

            $couponDiscount = 0.00;
            if ($couponCode = $request->input('coupon_code')) {
                $coupon = \App\Models\Coupon::where('code', $couponCode)->first();
                if (!$coupon || ($coupon->expires_at && $coupon->expires_at < now())) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Invalid or expired coupon code'
                    ], 400);
                }
                $couponDiscount = $coupon->discount_amount;
            }

            $totalPrice = $request->input('price') - $couponDiscount;

            $reservation = \App\Models\Reservation::create([
                'user_id' => $request->input('user_id'),
                'hotel_id' => $request->input('hotel_id'),
                'room_id' => $request->input('room_id'),
                'check_in_date' => $request->input('check_in_date'),
                'check_out_date' => $request->input('check_out_date'),
                'total_price' => $totalPrice,
                'coupon_code' => $couponCode,
                'discount' => $couponDiscount,
                'payment_method' => $request->input('payment_method'),
                'transaction_id' => $request->input('transaction_id'),
                'screenshot_path' => $request->hasFile('screenshot') 
                    ? $request->file('screenshot')->store('screenshots', 'public') 
                    : null
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Hotel reservation checkout successful',
                'reservation_id' => $reservation->id,
                'total_price' => $totalPrice
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
                'items' => 'required',
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

            $items = json_decode($request->input('items'),true);
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
                'screenshot' => $request->hasFile('screenshot') 
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