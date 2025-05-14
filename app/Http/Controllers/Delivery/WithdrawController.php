<?php

namespace App\Http\Controllers\Delivery;

use App\Http\Controllers\Controller;
use App\Models\DeliveryMan;
use App\Models\DeliveryManCommission;
use App\Models\DeliveryManWithdrawRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WithdrawController extends Controller
{
    //
    public function requestWithdraw(Request $request)
    {
        $user = Auth::guard('deliverymen')->user();

        $men=DeliveryMan::where('id',$user->id)->first();

        $available = $men->total_earn;

            // dd($available);
        if ($available < $request->amount) {
            return back()->with('error', 'Insufficient balance.');
        }

        // dd($available);
        DeliveryManWithdrawRequest::create([
            'delivery_man_id' => $user->id,
            'amount' => $request->amount,
            'status' => 'pending'
        ]);

        return back()->with('success', 'Withdraw request submitted.');
    }
}