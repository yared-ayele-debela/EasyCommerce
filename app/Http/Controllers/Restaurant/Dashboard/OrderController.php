<?php

namespace App\Http\Controllers\Restaurant\Dashboard;

use App\Http\Controllers\Controller;
use App\Mail\Restaurant\OrderStatusUpdateMail;
use App\Models\DeliveryMan;
use App\Models\DeliveryNotification;
use App\Models\OrderStatus;
use App\Models\Restaurant\Order;
use App\Models\Restaurant\Restaurant;
use App\Services\ActivityLogger;
use App\Services\NotificationService;
use App\Services\SmsService;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use RealRashid\SweetAlert\Facades\Alert;

class OrderController extends Controller
{
    //


     public function __construct()
    {
        $this->middleware('admin.permission:view_restaurant_order')->only('index','show');
        $this->middleware('admin.permission:update_restaurant_order_status')->only(methods: 'updateStatus');

    }
    public function index()
    {
        $admin=Auth::guard('admin')->user();
        $restaurant=Restaurant::where('admin_id',$admin->id)->get();
        $restaurantId=$restaurant->pluck('id');
        $adminType = Auth::guard('admin')->user()->type;
        if ($adminType === "Super Admin") {
            $orders = Order::with('orderItems.product','paymentInfo')->where('is_old', operator: false)->latest()->paginate(10);
        }
        else
        {
            $orders = Order::with('paymentInfo')->where('is_old', operator: false)->whereHas('orderItems.product', function ($query) use ($restaurantId) {
                $query->whereIn('restaurant_id', $restaurantId);
            })->with('orderItems.product')->latest()->paginate(10);
        }



        return view('Restaurant.dashboard.orders.index', compact('orders'));
    }

    // Show order details and allow status update
    public function show($id)
    {
        $delivery_mans=DeliveryMan::where('status','available')->get();

        $order = Order::with('orderItems.product','address')->findOrFail($id);

        $delivery_man="";
        $delivery_man=DeliveryMan::where('id',$order->delivery_man_id)->first();
        $notifications=DeliveryNotification::with('deliveryman')->where('order_id',$order->id)->latest()->get();
        $order_status=OrderStatus::all();
        // dd($order_status);
        return view('Restaurant.dashboard.orders.show', compact('notifications','order','delivery_mans','delivery_man','order_status'));
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

        $oldStatus=$order->status;

        // dd($request->all());
        // Update order status and delivery status
        $order->update([
            'status' => $request->order_status,
            'delivery_status' => $request->delivery_status
        ]);

        NotificationService::send(
            $order->user_id,
            'Order Status Updated',
            "Your order #{$order->id} status has changed from '{$oldStatus}' to '{$order->status}'."
        );

        $phone = $order->user->mobile ?? null;
        if ($phone) {
            // dd($phone);
            $message = "Hi {$order->user->name}, your order #{$order->id} status has been updated from '{$oldStatus}' to '{$order->status}'.";
            try {
            SmsService::send($phone, $message);
            } catch (\Exception $e) {
                // Optionally log error
                dd($e->getMessage());
            }
        }
         $currentDateTime = Carbon::now();
        $formattedDateTime = $currentDateTime->toDateTimeString(); // 'Y-m-d H:i:s'
        ActivityLogger::log( 'Update Restaurant Order Status', Auth::guard('admin')->user()->name . " at {$formattedDateTime}");


        // Mail::to($order->user->email)->send(new OrderStatusUpdateMail($order));

        return redirect()->route('restaurant.orders.show', $order->id)->with('success', 'Order status updated successfully.');
    }


    public function destroy(Order $order)
    {
        // Optional: add authorization logic here
        $order->delete();

        Alert::toast('Order deleted successfully.', 'success');
        return redirect()->back();
    }

    public function markAsOld(Order $order)
{

    $order->update(['is_old' => true]);

    Alert::toast('Order marked as old successfully.', 'success');
    return redirect()->back();
}

public function old()
{
    // dd('Old Orders');
    $oldOrders = Order::with('orderItems.product','paymentInfo')->where('is_old', operator: true)->latest()->paginate(10);

    return view('Restaurant.dashboard.orders.old_order', compact('oldOrders'));
}
}
