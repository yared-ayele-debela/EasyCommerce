<?php

namespace App\Http\Controllers\Restaurant\Dashboard;

use App\Http\Controllers\Controller;
use App\Mail\Restaurant\OrderStatusUpdateMail;
use App\Models\DeliveryMan;
use App\Models\DeliveryNotification;
use App\Models\Restaurant\Order;
use App\Models\Restaurant\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{
    //
    public function index()
    {
        $admin=Auth::guard('admin')->user();
        $restaurant=Restaurant::where('admin_id',$admin->id)->get();
        $restaurantId=$restaurant->pluck('id');
        $adminType = Auth::guard('admin')->user()->type;
        if ($adminType === "Super Admin") {
            $orders = Order::with('orderItems.product','paymentInfo')->latest()->get();
        }
        else
        {
            $orders = Order::with('paymentInfo')->whereHas('orderItems.product', function ($query) use ($restaurantId) {
                $query->whereIn('restaurant_id', $restaurantId);
            })->with('orderItems.product')->latest()->get();
        }


        return view('Restaurant.dashboard.orders.index', compact('orders'));
    }

    // Show order details and allow status update
    public function show($id)
    {
        $delivery_mans=DeliveryMan::where('status','available')->get();
        // Fetch the order with related order items and products
        $order = Order::with('orderItems.product','address')->findOrFail($id);
        // dd($order);
        $delivery_man="";
        $delivery_man=DeliveryMan::where('id',$order->delivery_man_id)->first();
        $notifications=DeliveryNotification::with('deliveryman')->where('order_id',$order->id)->latest()->get();

        return view('Restaurant.dashboard.orders.show', compact('notifications','order','delivery_mans','delivery_man'));
    }

    // Update order status and delivery status
    public function updateStatus(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        // Validate request data
        $request->validate([
            'order_status' => 'required|string',
            'delivery_status' => 'required|string'
        ]);


        // dd($request->all());
        // Update order status and delivery status
        $order->update([
            'status' => $request->order_status,
            'delivery_status' => $request->delivery_status
        ]);

        // Mail::to($order->user->email)->send(new OrderStatusUpdateMail($order));


        return redirect()->route('restaurant.orders.show', $order->id)->with('success', 'Order status updated successfully.');
    }
}
