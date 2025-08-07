<?php

namespace App\Http\Controllers;

use App\Models\DeliverySetting;
use Illuminate\Http\Request;

class DeliverySettingController extends Controller
{
    //
    public function index()
    {
        $setting = DeliverySetting::firstOrCreate([], ['fee_per_km' => 0]);
        return view('admin.delivery_settings.index', compact('setting'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'fee_per_km' => 'required|numeric|min:0'
        ]);

        $setting = DeliverySetting::first();
        $setting->update(['fee_per_km' => $request->fee_per_km]);

        return redirect()->back()->with('success', 'Delivery fee updated successfully!');
    }
}