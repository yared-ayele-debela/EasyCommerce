<?php

namespace App\Http\Controllers\Admin\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Vendor;
use App\Models\VendorBankDetails;
use App\Models\VendorWallet;
use App\Models\VendorWalletTransaction;
use App\Models\VendorWithdrawRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class VendorBalanceController extends Controller
{

     public function index()
    {
        $vendorId = Auth::guard('admin')->user()->vendor_id;

        // dd(vars: $vendorId);
        $wallet = VendorWallet::where('vendor_id', operator: 0)->first();
        $transactions = VendorWalletTransaction::where('vendor_id', 0)
                            ->orderBy('created_at', 'desc')
                            ->paginate(10); // pagination
        $vendor_bank_information=VendorBankDetails::where('vendor_id',$vendorId)->first();

        return view('admin.vendor.wallet.index', compact('wallet', 'transactions','vendor_bank_information'));
    }

    public function requestWithdraw(Request $request)
{
    $vendor = Auth::guard('admin')->user()->vendor_id;
    $vendor=Vendor::findOrFail(0);
    // dd($vendor);
    $amount = $request->amount;

    if ($amount > $vendor->wallet->available_balance) {
        return back()->with('error', 'Insufficient balance');
    }

        DB::transaction(function () use ($vendor, $amount) {
            VendorWithdrawRequest::create([
                'vendor_id' => $vendor->id,
                'amount' => $amount,
                'status' => 'pending'
            ]);

            $vendor->wallet->available_balance -= $amount;
            $vendor->wallet->pending_balance += $amount;
            $vendor->wallet->save();
        });

        return back()->with('success', 'Withdrawal request submitted');
    }

}
