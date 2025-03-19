<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;

class RestaurantOrderController extends Controller
{
    public function runningOrders()
    {
        return response()->json(Order::where('status', 'processing')->get());
    }

    public function orderRequests()
    {
        return response()->json(Order::where('status', 'pending')->get());
    }

    public function store(Request $request)
    {
        $request->validate([
            'restaurant_id' => 'required|exists:restaurants,id',
            'delivery_address_id' => 'required|exists:delivery_addresses,id',
            'items' => 'required|array',
        ]);

        $order = Order::create([
            'user_id' => Auth::id(),
            'restaurant_id' => $request->restaurant_id,
            'delivery_address_id' => $request->delivery_address_id,
            'total_price' => 0,
            'status' => 'pending',
            'payment_method' => $request->payment_method ?? 'cash',
        ]);

        $totalPrice = 0;
        foreach ($request->items as $item) {
            $totalPrice += $item['price'] * $item['quantity'];
            OrderItem::create([
                'order_id' => $order->id,
                'food_id' => $item['food_id'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
            ]);
        }

        $order->update(['total_price' => $totalPrice]);

        return response()->json($order, 201);
    }
}
