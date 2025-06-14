<?php

namespace App\Http\Controllers\Restaurant\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\DeliveryNotification;
use App\Models\Restaurant\Order;
use App\Services\ActivityLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AssignOrderController extends Controller
{
    //

     public function __construct()
    {
        $this->middleware('admin.permission:assign_restaurant_order_to_delivery_man')->only('assignToDeliveryMan');
       
    }
public function assignToDeliveryMan(Request $request, $orderId)
{
    $order = Order::findOrFail($orderId);
    $deliveryManId = $request->input('delivery_man_id');

    $order->delivery_man_id = $deliveryManId;
    $order->delivery_status = 'pending';
    $order->save();

    DeliveryNotification::create([
        'order_id' => $order->id,
        'delivery_man_id' => $deliveryManId,
    ]);

  
         $currentDateTime = Carbon::now();
        $formattedDateTime = $currentDateTime->toDateTimeString(); // 'Y-m-d H:i:s'
        ActivityLogger::log( 'Assign order to delivery man', Auth::guard('admin')->user()->name . " at {$formattedDateTime}");

    // Optional: send code to customer via email/SMS
    return redirect()->back()->with('success', 'Order assigned with confirmation code.');
}

}