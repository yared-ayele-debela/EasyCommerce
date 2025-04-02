<?php

namespace App\Http\Controllers\Restaurant\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Restaurant\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
     /**
     * Display the user's orders.
     */
    public function index()
    {
        // Fetch the authenticated user's orders with related items
        $orders = Order::where('user_id', Auth::id())->with('orderItems.product')->latest()->get();

        return view('restaurant.frontend.order.orders', compact('orders'));
    }

    /**
     * Track a specific order.
     */
    public function track(Order $order)
    {
        // Ensure the user can only track their own orders
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access');
        }
        $order = Order::with('orderItems.product')->findOrFail($order->id);


        return view('restaurant.frontend.order.track', compact('order'));
    }

    public function success($orderId)
    {
        $order = Order::with('orderItems')->findOrFail($orderId); // Load order with items
        return view('restaurant.frontend.order.success', compact('order'));
    }
}