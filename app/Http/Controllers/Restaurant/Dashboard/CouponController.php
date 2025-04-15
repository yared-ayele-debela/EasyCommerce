<?php

namespace App\Http\Controllers\Restaurant\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Restaurant\Coupon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CouponController extends Controller
{
    public function index()
    {
        $adminType = Auth::guard('admin')->user()->type;
        if ($adminType === "Super Admin") {
            $coupons = Coupon::latest()->get();
        } else {
            $coupons = Coupon::where('admin_id', Auth::guard('admin')->user()->id)->latest()->get();
        }
        // $coupons = Coupon::all();
        return view('Restaurant.dashboard.coupons.index', compact('coupons'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'admin_id' => 'nullable',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'code' => 'required|string|unique:restaurant_coupons,code',
            'type' => 'required|in:fixed,percentage',
            'value' => 'required|numeric|min:0',
            'validated_date' => 'nullable|date',
            'is_active' => 'boolean'
        ]);
        $request['admin_id'] = Auth::guard('admin')->user()->id;


        Coupon::create($request->all());

        return redirect()->back()->with('success', 'Coupon added successfully.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'code' => 'required|string|unique:restaurant_coupons,code,'.$id,
            'type' => 'required|in:fixed,percentage',
            'value' => 'required|numeric|min:0',
            'validated_date' => 'nullable|date',
            'is_active' => 'boolean'
        ]);

        $coupon = Coupon::findOrFail($id);
        $coupon->update($request->all());

        return redirect()->back()->with('success', 'Coupon updated successfully.');
    }

    public function destroy($id)
    {
        $coupon = Coupon::findOrFail($id);
        $coupon->delete();

        return redirect()->back()->with('success', 'Coupon deleted successfully.');
    }

}