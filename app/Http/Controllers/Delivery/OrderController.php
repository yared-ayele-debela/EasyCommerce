<?php

namespace App\Http\Controllers\Delivery;

use App\Helper\Helper;
use App\Http\Controllers\Controller;
use App\Models\AppSetting;
use App\Models\DeliveryMan;
use App\Models\DeliveryManTip;
use App\Models\DeliveryNotification;
use App\Models\Restaurant\Order;
use App\Models\Restaurant\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    //

    public function orders()
    {
        try {

            $appsettings = AppSetting::all()->toArray();
            $deliveryManId = DeliveryMan::where('id', Auth::guard('deliverymen')->user()->id)->first();
            $orders = Order::with('orderItems')->where('delivery_man_id', $deliveryManId->id)->orderBy('id', 'Desc')->get();

            // Notifications (unseen assigned orders)
            $notifications = DeliveryNotification::where('delivery_man_id', $deliveryManId->id)
                ->where('seen_status', 'new')
                ->with('order')
                ->latest()
                ->get();

            return view('delivery_man.restaurant.index', compact('appsettings', 'orders', 'notifications'));
        } catch (\Exception $e) {
            // Log or handle the exception as needed

            return redirect()->back();
        }
    }

    public function accept($notificationId)
    {
        $notification = DeliveryNotification::findOrFail($notificationId);
        $notification->status = 'accepted';
        $notification->seen_status = 'seen';
        $notification->save();

        $notification->order->delivery_status = 'delivering';
        $notification->order->save();

        return redirect()->back()->with('success', 'Order accepted for delivery.');
    }

    public function decline($notificationId)
    {
        $notification = DeliveryNotification::findOrFail($notificationId);
        $notification->status = 'declined';
        $notification->seen_status = 'seen';
        $notification->save();

        $notification->order->delivery_status = 'pending';
        $notification->order->delivery_man_id = null;
        $notification->order->save();

        return redirect()->back()->with('info', 'Order declined.');
    }
    public function markNotificationSeen($id)
    {
        $notification = DeliveryNotification::findOrFail($id);
        if ($notification->delivery_man_id != auth('delivery')->id()) abort(403);
        $notification->seen_status = 'seen';
        $notification->save();

        return back();
    }

    public function verifyDeliveryCode(Request $request, $orderId)
    {
        $order = Order::findOrFail($orderId);
        $orderItems = OrderItem::where('order_id', $order->id)->get();
        if (Auth::guard('deliverymen')->user()->id !== $order->delivery_man_id) {
            abort(403, 'Unauthorized');
        }
        $orderItems = OrderItem::where('order_id', $orderId)->get();

        $allPicked = $orderItems->every(fn($item) => $item->picked_status === 'picked');

        if (!$allPicked) {
            return back()->with('error', 'Not all restaurants have been picked up.');
        }

        if ($request->code === $order->delivery_code) {
            $order->delivery_status = 'delivered';
            $order->status = 'delivered';
            $order->save();
            $check = DeliveryManTip::where('order_id', $order->id)->where('type','restaurant')->first();
            if (!$check) {
                // dd($order->tip_amount);
                DeliveryManTip::create([
                    'delivery_man_id' => $order->delivery_man_id,
                    'order_type' => 'restaurant',
                    'order_id' => $order->id,
                    'commission_amount' => $order->tip_amount,
                    'status' => 'pending'
                ]);
                $delivery_men = DeliveryMan::where('id', $order->delivery_man_id)->first();
                $delivery_men->status = 'available';
                $delivery_men->total_earn += $order->tip_amount;
                $delivery_men->save();
            }else{
                // dd("available");
                $delivery_men = DeliveryMan::where('id', $order->delivery_man_id)->first();
                $delivery_men->status = 'available';
                $delivery_men->save();
            }

            return redirect()->back()->with('success', 'Delivery confirmed successfully.');
        }

        return redirect()->back()->with('error', 'Incorrect delivery code. Please try again.');
    }

    function calculateDeliveryCommission($order)
    {
        // 2% commission on total order amount
        $commissionRate = 0.02;

        return round($order->total * $commissionRate, 2);
    }

    public function confirmPickup(Request $request)
    {
        $code = $request->picked_code;

        $item = OrderItem::where('picked_code', $code)
            ->whereHas('order', fn($q) => $q->where('delivery_man_id', Auth::guard('deliverymen')->user()->id))
            ->first();

        if (!$item) {
            return back()->with('error', 'Invalid pickup code.');
        }
        if ($item->picked_status === 'picked') {
            return back()->with('error', 'This pickup has already been confirmed.');
        }
        $restaurantId = $item->product->restaurant_id;
        $orderId = $item->order_id;

        // Mark all items from this restaurant as picked
        OrderItem::where('order_id', $orderId)
            ->whereHas('product', fn($q) => $q->where('restaurant_id', $restaurantId))
            ->update(['picked_status' => 'picked']);

        return back()->with('success', 'Pickup confirmed for restaurant ID ' . $restaurantId);
    }
}
