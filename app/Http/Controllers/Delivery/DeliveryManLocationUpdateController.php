<?php

namespace App\Http\Controllers\Delivery;

use App\Http\Controllers\Controller;
use App\Models\DeliveryMan;
use DeliveryManLocationUpdated;
use Illuminate\Http\Request;

class DeliveryManLocationUpdateController extends Controller
{
    public function updateLocation(Request $request)
{
    $request->validate([
        'id' => 'required|exists:deliverymen,id',
        'lat' => 'required|numeric',
        'lng' => 'required|numeric',
    ]);

    $deliveryman = DeliveryMan::find($request->id);
    $deliveryman->current_lat = $request->lat;
    $deliveryman->current_lng = $request->lng;
    $deliveryman->save();

    // Broadcast the event
    // event(new DeliveryManLocationUpdated($deliveryman->id, $request->lat, $request->lng));

    return response()->json(['message' => 'Location updated successfully']);
}
}