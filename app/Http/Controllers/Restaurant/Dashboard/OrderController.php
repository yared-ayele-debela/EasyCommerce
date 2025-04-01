<?php

namespace App\Http\Controllers\Restaurant\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Restaurant\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    //
    public function index()
    {
        // Fetch all orders with related order items and products
        $orders = Order::with('orderItems.product')->latest()->get();

        return view('restaurant.dashboard.orders.index', compact('orders'));
    }

    // Show order details and allow status update
    public function show($id)
    {
        // Fetch the order with related order items and products
        $order = Order::with('orderItems.product','address')->findOrFail($id);
        // dd($order);

        return view('restaurant.dashboard.orders.show', compact('order'));
    }

    // Update order status and delivery status
    public function updateStatus(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        // Validate request data
        $request->validate([
            'order_status' => 'required|string|in:pending,processing,completed,canceled',
            'delivery_status' => 'required|string|in:pending,shipped,delivered'
        ]);


        // dd($request->all());
        // Update order status and delivery status
        $order->update([
            'status' => $request->order_status,
            'delivery_status' => $request->delivery_status
        ]);

        return redirect()->route('restaurant.orders.show', $order->id)->with('success', 'Order status updated successfully.');
    }
}
