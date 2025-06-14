<?php

namespace App\Http\Controllers\Admin\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Vendor;
use App\Models\VendorBankDetails;
use App\Models\VendorWallet;
use App\Models\VendorWalletTransaction;
use App\Models\VendorWithdrawRequest;
use App\Models\WithdrawSetting;
use App\Services\ActivityLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class VendorBalanceController extends Controller
{

     public function index()
    {
        $vendorId = Auth::guard('admin')->user()->vendor_id;

        $vendor= Vendor::with('vendorBank')->findOrFail($vendorId);
        // dd(vars: $vendor);
        $wallet = VendorWallet::where('vendor_id', operator: $vendorId)->first();
        $transactions = VendorWalletTransaction::where('vendor_id', $vendorId)
                            ->orderBy('created_at', 'desc')
                            ->paginate(10); // pagination
        $vendor_bank_information=VendorBankDetails::where('vendor_id',$vendorId)->first();

        $withdrawSetting=WithdrawSetting::first();
        return view('admin.vendor.wallet.index', compact('wallet','withdrawSetting', 'transactions','vendor_bank_information', 'vendor'));
    }

    public function requestWithdraw(Request $request)
{
    $vendor = Auth::guard('admin')->user()->vendor_id;
    $vendor=Vendor::findOrFail($vendor);
    // dd($vendor);
    $withdrawSetting=WithdrawSetting::first();
    $amount = $request->amount;
    if($amount > $withdrawSetting->amount){
        return back()->with('error', 'Minimum withdrawal amount is ' . $withdrawSetting->amount);
    }

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


        $currentDateTime = Carbon::now();
        $formattedDateTime = $currentDateTime->toDateTimeString(); // 'Y-m-d H:i:s'
        ActivityLogger::log( 'Request Withdraw', Auth::guard('admin')->user()->name . " at {$formattedDateTime}");

        });

        return back()->with('success', 'Withdrawal request submitted');
    }

}
