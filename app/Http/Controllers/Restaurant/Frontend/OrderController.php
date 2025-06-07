<?php

namespace App\Http\Controllers\Restaurant\Frontend;

use App\Http\Controllers\Controller;
use App\Models\AppSetting;
use App\Models\Order as ModelsOrder;
use App\Models\Restaurant\Order;
use App\Models\User;
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
        $orders = Order::where('user_id', Auth::user()->id)->with('orderItems.product','paymentInfo')->latest()->paginate(9);
        $user = auth()->user()->id;
        $user = User::findOrFail($user);
        $reservations = $user->reservations()->with(['hotel', 'room','hotel_reservation_payment_info'])->latest()->paginate(9);
        $good_orders = ModelsOrder::with('orders_products','paymentInfo')->where('user_id', Auth::user()->id)->latest()->paginate(9);

        return view('all_frontend_layouts.my_orders.inex', compact('orders','reservations','good_orders'));
    }

    /**
     * Track a specific order.
     */
    public function track(Order $order)
    {
        // Ensure the user can only track their own orders
        if ($order->user_id !== Auth::user()->id) {
            abort(403, 'Unauthorized access');
        }

        $order = Order::with('orderItems.product','deliveryman','address')->findOrFail($order->id);

        // dd($order);

        return view('Restaurant.frontend.order.track', compact('order'));
    }

    public function success($orderId)
    {
        $order = Order::with('orderItems')->findOrFail($orderId); // Load order with items
        return view('Restaurant.frontend.order.success', compact('order'));
    }

    public function receipt(Request $request){

        $order=Order::with('orderItems','address')->findOrFail($request->order_id); // Load order with items

        $settings=AppSetting::first();
        return view('Restaurant.frontend.order.receipt',compact('order','settings'));
    }
}
