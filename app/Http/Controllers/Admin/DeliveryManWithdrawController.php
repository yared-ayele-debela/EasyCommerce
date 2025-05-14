<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DeliveryMan;
use App\Models\DeliveryManCommission;
use App\Models\DeliveryManWithdrawRequest;
use Illuminate\Http\Request;

class DeliveryManWithdrawController extends Controller
{
    public function index()
    {
        $withdrawals = DeliveryManWithdrawRequest::with('deliveryMan')->latest()->paginate(10);
        return view('admin.delivery_men_withdraw_request.index', compact('withdrawals'));
    }

    public function approve($id)
    {

        $request = DeliveryManWithdrawRequest::findOrFail($id);
        $request->status = 'approved';
        $request->approved_at = now();
        $request->save();

        $withdrawAmount = $request->amount;
        $deliveryManId = $request->delivery_man_id;
        $deliveryMan= DeliveryMan::findOrFail($deliveryManId);
        $deliveryMan->total_earn = $deliveryMan->total_earn - $withdrawAmount;
        $deliveryMan->save();
        // dd($request);
        return back()->with('success', 'Withdrawal approved.');
    }

    public function reject($id)
    {
        $withdrawal = DeliveryManWithdrawRequest::findOrFail($id);
        $withdrawal->status = 'rejected';
        $withdrawal->save();

        return back()->with('error', 'Withdrawal rejected.');
    }
    //
    public function approveWithdraw($id)
    {
        $request = DeliveryManWithdrawRequest::findOrFail($id);
        $request->status = 'approved';
        $request->approved_at = now();
        $request->save();

        // Mark commissions as withdrawn
        DeliveryManCommission::where('delivery_man_id', $request->delivery_man_id)
            ->where('status', 'earned')
            ->orderBy('created_at')
            ->limit(ceil($request->amount)) // logic for how to sum amount
            ->update(['status' => 'withdrawn']);

        // Notify delivery man...
        return back()->with('success', 'Withdrawal approved.');
    }
}