<?php

namespace App\Http\Controllers\Delivery;

use App\Http\Controllers\Controller;
use App\Models\DeliveryMan;
use App\Models\Restaurant\Order;
use Illuminate\Http\Request;
use App\Events\DeliveryLocationUpdated;

class DeliveryManLocationUpdateController extends Controller
{
    // public function updateLocation(Request $request)
    // {
    //     $request->validate([
    //         'id' => 'required|exists:deliverymen,id',
    //         'lat' => 'required|numeric',
    //         'lng' => 'required|numeric',
    //     ]);

    //     $deliveryman = DeliveryMan::find($request->id);
    //     $deliveryman->current_lat = $request->lat;
    //     $deliveryman->current_lng = $request->lng;
    //     $deliveryman->save();

    //     // Broadcast the event
    //     // event(new DeliveryManLocationUpdated($deliveryman->id, $request->lat, $request->lng));

    //     return response()->json(['message' => 'Location updated successfully']);
    // }

    public function getDeliverymanLocation($orderId)
    {
        $order = Order::with(relations: 'deliveryman')->findOrFail($orderId);

        return response()->json([
            'lat' => $order->deliveryman->current_lat,
            'lng' => $order->deliveryman->current_lng
        ]);
    }

    public function updateLocation(Request $request)
    {
        $request->validate([
            'order_id' => 'required',
            'lat' => 'required|numeric',
            'lng' => 'required|numeric',
        ]);

        // Save location to DB if needed
        $order = Order::find($request->order_id);
        $order->deliveryman->update([
            'current_lat' => $request->lat,
            'current_lng' => $request->lng,
        ]);

        broadcast(new DeliveryManLocationUpdated($request->order_id, $request->lat, $request->lng))->toOthers();

        return response()->json(['message' => 'Location updated']);
    }

    
}
