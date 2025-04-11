<?php

namespace App\Http\Controllers\Hotel\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\HotelCoupon;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CouponController extends Controller
{
    public function index()
    {
        $adminType = Auth::guard('admin')->user()->type;
        if($adminType==="Super Admin"){
            $coupons = HotelCoupon::latest()->get();
        }else{
            $coupons = HotelCoupon::where('admin_id',Auth::guard('admin')->user()->id)->latest()->get();
        }
        return view('hotel.dashboard.coupon.index', compact('coupons'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'admin_id' => 'required',
            'code' => 'required|unique:hotel_coupons,code',
            'type' => 'required|in:fixed,percent',
            'value' => 'required|numeric',
            'usage_limit' => 'nullable|integer',
            'expires_at' => 'nullable|date',
        ]);
        $validated['expires_at'] = $validated['expires_at']
            ? Carbon::parse($validated['expires_at'])
            : null;


        HotelCoupon::create($validated);
        return redirect()->back()->with('success', 'Coupon created successfully!');
    }

    public function update(Request $request, HotelCoupon $coupon)
    {
        $validated = $request->validate([
            'code' => 'required|unique:hotel_coupons,code,' . $coupon->id,
            'type' => 'required|in:fixed,percent',
            'value' => 'required|numeric',
            'usage_limit' => 'nullable|integer',
            'expires_at' => 'nullable|date',
        ]);

        $validated['expires_at'] = $validated['expires_at']
        ? Carbon::parse($validated['expires_at'])
        : null;

        $coupon->update($validated);
        return redirect()->back()->with('success', 'Coupon updated successfully!');
    }

    public function destroy(HotelCoupon $coupon)
    {
        $coupon->delete();
        return redirect()->back()->with('success', 'Coupon deleted successfully!');
    }
}
