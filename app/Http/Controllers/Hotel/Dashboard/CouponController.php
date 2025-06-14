<?php

namespace App\Http\Controllers\Hotel\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\HotelCoupon;
use App\Services\ActivityLogger;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CouponController extends Controller
{

      public function __construct()
    {
        $this->middleware('admin.permission:view_hotel_coupon')->only('index');
        $this->middleware('admin.permission:add_hotel_coupon')->only('store');
        $this->middleware('admin.permission:edit_hotel_coupon')->only(methods: 'update');
        $this->middleware('admin.permission:delete_hotel_coupon')->only('destroy');
    }
    
    public function index()
    {
        $adminType = Auth::guard('admin')->user()->type;
        if($adminType==="Super Admin"){
            $coupons = HotelCoupon::latest()->get();
        }else{
            $coupons = HotelCoupon::where('admin_id',Auth::guard('admin')->user()->id)->latest()->get();
        }
        return view('Hotel.dashboard.coupon.index', compact('coupons'));
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

          $currentDateTime = Carbon::now();
        $formattedDateTime = $currentDateTime->toDateTimeString(); // 'Y-m-d H:i:s'
        ActivityLogger::log('Add Coupon', Auth::guard('admin')->user()->name . " at {$formattedDateTime}");


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

         $currentDateTime = Carbon::now();
        $formattedDateTime = $currentDateTime->toDateTimeString(); // 'Y-m-d H:i:s'
        ActivityLogger::log('Update Coupon', Auth::guard('admin')->user()->name . " at {$formattedDateTime}");

        return redirect()->back()->with('success', 'Coupon updated successfully!');
    }

    public function destroy(HotelCoupon $coupon)
    {
        $coupon->delete();
         $currentDateTime = Carbon::now();
        $formattedDateTime = $currentDateTime->toDateTimeString(); // 'Y-m-d H:i:s'
        ActivityLogger::log( 'Delete Coupon', Auth::guard('admin')->user()->name . " at {$formattedDateTime}");

        return redirect()->back()->with('success', 'Coupon deleted successfully!');
    }
}