<?php

namespace App\Http\Controllers\Restaurant\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Restaurant\DeilverySettingRestaurant;
use Illuminate\Http\Request;

class DeliverySettingsController extends Controller
{
    public function index()
    {
        $setting = DeilverySettingRestaurant::firstOrCreate([], ['fee_per_km' => 0]);
        return view('admin.delivery_settings.restaurant_index', compact('setting'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'fee_per_km' => 'required|numeric|min:0',
            'base_amount' => 'required|numeric|min:1',
        ]);

        $setting = DeilverySettingRestaurant::first();

        $setting->update([
            'fee_per_km' => $request->fee_per_km,
            'base_amount' => $request->base_amount,
        ]);


        return redirect()->back()->with('success', 'Restaurant Delivery fee updated successfully!');
    }
}
