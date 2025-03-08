<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WithdrawalRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WithdrawRequestController extends Controller
{
    public function createWithdrawalRequest(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1',
        ]);

        WithdrawalRequest::create([
            'vendor_id' => Auth::guard('admin')->id,
            'amount' => $request->amount,
            'status' => 'pending',
        ]);

        return redirect()->back()->with('success', 'Withdrawal request submitted.');
    }

    public function withdrawalRequests()
    {
        $requests = Auth::user()->withdrawalRequests;
        return view('vendor.withdrawal_requests', compact('requests'));
    }

    
}