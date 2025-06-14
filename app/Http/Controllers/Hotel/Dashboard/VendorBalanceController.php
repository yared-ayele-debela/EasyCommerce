<?php

namespace App\Http\Controllers\Hotel\Dashboard;

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
    //
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
        return view( 'Hotel.dashboard.wallet.index', compact('wallet','withdrawSetting', 'transactions','vendor_bank_information', 'vendor'));
    }
}
