<?php

namespace App\Http\Controllers\Delivery\Ecommerce;

use App\Http\Controllers\Controller;
use App\Models\AppSetting;
use App\Models\DeliveryAddress;
use App\Models\Order;
use App\Models\Restaurant\Restaurant;
use App\Models\User;
use App\Models\Vendor;
use Illuminate\Http\Request;

class GetLocationController extends Controller
{
    public function pickupView($orderId,$vendorId)
    {
        $order = Order::findOrFail($orderId);
        $vendor=Vendor::findOrFail($vendorId);
        // dd($order);
        $appsettings = AppSetting::all()->toArray();

        return view('delivery_man.orders.delivery.pickup', [
            'order' => $order,
            'vendor' => $vendor,
            'appsettings' => $appsettings,
        ]);
    }


    public function getCustomerLocation($orderId){
        $order = Order::findOrFail($orderId);
        $appsettings = AppSetting::all()->toArray();

        // dd($order);
        return view(view: 'delivery_man.orders.customer.customer_location',data: compact('order','appsettings'));
    }
}