<?php

namespace App\Http\Controllers\Restaurant\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\DeliveryNotification;
use App\Models\Restaurant\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AssignOrderController extends Controller
{
    //

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


    // Optional: send code to customer via email/SMS
    return redirect()->back()->with('success', 'Order assigned with confirmation code.');
}

}