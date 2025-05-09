<?php

namespace App\Http\Controllers\Delivery;

use App\Http\Controllers\Controller;
use App\Models\AppSetting;
use App\Models\DeliveryMan;
use App\Models\DeliveryNotification;
use App\Models\Restaurant\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    //

    public function orders(){
        try{

        $appsettings=AppSetting::all()->toArray();
        $deliveryBoy = DeliveryMan::where('id',Auth::guard('deliverymen')->user()->id)->first();
        $orders = Order::with('orderItems')->where('delivery_man_id',$deliveryBoy->id)->orderBy( 'id', 'Desc')->get()->toArray();

        return view('delivery_man.orders.restaurant_orders',compact('appsettings','orders'));
        } catch (\Exception $e) {
            // Log or handle the exception as needed
           
            return redirect()->back();
        }
    }
    
    public function accept($notificationId)
    {
        $notification = DeliveryNotification::findOrFail($notificationId);
        $notification->status = 'accepted';
        $notification->save();

        $notification->order->delivery_status = 'delivering';
        $notification->order->save();

        return redirect()->back()->with('success', 'Order accepted for delivery.');
    }

    public function decline($notificationId)
    {
        $notification = DeliveryNotification::findOrFail($notificationId);
        $notification->status = 'declined';
        $notification->save();

        $notification->order->delivery_status = 'declined';
        $notification->order->save();

        return redirect()->back()->with('info', 'Order declined.');
    }
}