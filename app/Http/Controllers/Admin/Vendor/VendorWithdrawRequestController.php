<?php

namespace App\Http\Controllers\Admin\Vendor;

use App\Http\Controllers\Controller;
use App\Livewire\WithdrawRequest\WithdrawRequest;
use App\Models\VendorWallet;
use App\Models\VendorWalletTransaction;
use App\Models\VendorWithdrawRequest;
use App\Services\ActivityLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class VendorWithdrawRequestController extends Controller
{
    //

    public function index(){

        $requests=VendorWithdrawRequest::with('vendor')->latest()->paginate(20);
        return view('admin.vendor.vendor_withdraw_requests.index',compact('requests'));
    }

    public function updateWithdrawStatus(Request $request, $id)
    {
        $withdraw = VendorWithdrawRequest::findOrFail($id);
        $vendorWallet = VendorWallet::where('vendor_id', $withdraw->vendor_id)->first();

        // dd($withdraw);
        if ($request->status == 'approved') {
            $vendorWallet->pending_balance -= $withdraw->amount;
            $vendorWallet->total_withdrawn += $withdraw->amount;

            VendorWalletTransaction::create([
                'vendor_id' => $withdraw->vendor_id,
                'type' => 'debit',
                'amount' => $withdraw->amount,
                'description' => 'Withdrawal approved'
            ]);
        } elseif ($request->status == 'rejected') {
            $vendorWallet->pending_balance -= $withdraw->amount;
            $vendorWallet->available_balance += $withdraw->amount;
        }

        $vendorWallet->save();
        $withdraw->status = $request->status;
        $withdraw->note = $request->note;
        $withdraw->save();


        $currentDateTime = Carbon::now();
        $formattedDateTime = $currentDateTime->toDateTimeString(); // 'Y-m-d H:i:s'
        ActivityLogger::log( 'Update Vndor Withdraw Status', Auth::guard('admin')->user()->name . " at {$formattedDateTime}");


        return back()->with('success', 'Withdrawal status updated');
    }

}